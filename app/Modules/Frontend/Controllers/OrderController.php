<?php
/**
 * Created by PhpStorm.
 * User: JreamOQ ( jreamoq@gmail.com )
 * Date: 12/21/20
 * Time: 13:00
 */

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = OrderService::inst();
    }

    public function paymentChecking(Request $request)
    {
        $order_token = $request->get('order_token');
        $status = $request->get('status');

        $response = $this->service->paymentChecking($order_token, $status);

        if ($response && ($response['payment_status'] == 1)) {
            return redirect(route('complete-order') . "?" . http_build_query(['order_token' => $order_token]));
        } else {
            return redirect(url('checkout'))->with([
                'message' => $response['message'],
                'order_token' => $order_token,
                'payment_failed' => 1,
            ]);
        }
    }

    public function completeOrder(Request $request)
    {
        $response = $this->service->completeOrderChecking($request);
        $view = apply_filter('gmz_complete_order_view', 'Frontend::page.complete-order', $response);
        return view($view, $response);
    }

    public function checkoutAction(Request $request)
    {
        // "first_name" => "Hieu"
        // "last_name" => "Trong"
        // "email" => "admin_realestate@fabbi.com.vn"
        // "phone" => "2123232"
        // "address" => "Truc Ninh"
        // "country" => "4"
        // "city" => "Nam Dinh"
        // "postcode" => null
        // "note" => null
        // "payment_method" => "submit_form"
        // "agree" => "1"
        // "_token" => "hN9Qh1anpbo58dXo3JaQ4mSQH7RpaJn5uzale2cm"
        $cart = \Cart::inst()->getCart();
        $cart['name'] = $request->first_name . $request->last_name;
        $cart['_token'] = $request->_token;
        $cart['note'] = $request->note;
        
        $checkout = $this->service->checkOut($request);
        // dd($checkout);
        $payment = $this->payment($cart, $checkout);
        $res = [
            "status" => true,
            "redirect" => $payment,
        ];
        return response()->json($res);
    }

    public function checkoutView()
    {
        $order_data = NULL;

        if (session()->has('payment_failed') && (session('payment_failed') == 1)) {

            $order_token = \session('order_token');
            $order_data = $this->service->unsuccessfulPaymentProcessing($order_token);
        }
        $cart = \Cart::inst()->getCart();

        return view('Frontend::page.checkout')->with('order_data', $order_data);
    }

    public function payment($cart, $checkout)
    {
        $vnp_TxnRef = $checkout['order_id']; //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $cart['total'] ?? 0; // Số tiền thanh toán
        $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = 'VNBANK'; //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => "J2IBXEFP",
            "vnp_Amount" => $cart['total'],
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD: " . $cart['name'] . ' ' . $cart['note'],
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $checkout['redirect'],
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate"=> date('YmdHis',strtotime('+15 minutes',strtotime(date("YmdHis"))))
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html" . "?" . $query;
        $vnp_HashSecret = "GQQDHQNVGCRFUAWPHBEIRSZLNXJDIMIW";
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return ($vnp_Url);
    }

}