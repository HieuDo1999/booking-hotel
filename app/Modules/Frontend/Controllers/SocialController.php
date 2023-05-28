<?php
/**
 * Created by PhpStorm.
 * User: Jream
 * Date: 5/12/2020
 * Time: 11:33 PM
 */

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\RoleUser;
use Validator, Redirect, Response, File;
use Socialite;
use App\Models\User;

class SocialController extends Controller
{
    private function makeSocialDriver($provider)
    {
        switch ($provider) {
            case 'facebook':
                $config = [
                    'client_id' => config('services.facebook.client_id'),
                    'client_secret' => config('services.facebook.client_secret'),
                    'redirect' => config('services.facebook.redirect')
                ];
                $socialProvider = \Laravel\Socialite\Two\FacebookProvider::class;
                break;
            case 'google':
                $config = [
                    'client_id' => config('services.google.client_id'),
                    'client_secret' => config('services.google.client_secret'),
                    'redirect' => config('services.google.redirect')
                ];
                $socialProvider = \Laravel\Socialite\Two\GoogleProvider::class;
                break;
        }

        return Socialite::buildProvider(
            $socialProvider,
            $config
        );
    }

    public function redirect($provider)
    {
        $providerSocial = $this->makeSocialDriver($provider);
        return $providerSocial->redirect();
    }

    public function callback($provider)
    {
        $getInfo = $this->makeSocialDriver($provider)->user();
        $user = $this->createUser($getInfo, $provider);
        auth()->login($user);
        return redirect()->to('/');
    }

    function createUser($getInfo, $provider)
    {
        $user = User::query()->where('provider_id', $getInfo->id)->first();
        if (!$user) {
            $fileContents = file_get_contents($getInfo->getAvatar());
            $year = date('Y');
            $month = date('m');
            $date = date('d');
            $path_only = storage_path() . '/app/public/' . $year . '/' . $month . '/' . $date;
            if (!File::isDirectory($path_only)) {
                File::makeDirectory($path_only, 0777, true, true);
            }
            $path = $path_only . '/' . $getInfo->id . '_avatar.jpg';
            File::put($path, $fileContents);

            $user = User::query()->create([
                'first_name' => $getInfo->name,
                'email' => $getInfo->email ?? 'abc@gmail.com',
                'provider' => $provider,
                'provider_id' => $getInfo->id
            ]);

            $media_insert = [
                'media_title' => $getInfo->id . '_avatar',
                'media_name' => $getInfo->id . '_avatar',
                'media_url' => asset('storage/' . $year . '/' . $month . '/' . $date) . '/' . $getInfo->id . '_avatar.jpg',
                'media_path' => $path,
                'media_size' => 1000,
                'media_type' => 'jpg',
                'media_description' => $getInfo->id . '_avatar',
                'author' => $user['id'],
            ];
            $media = Media::query()->create($media_insert);
            $user->update(['avatar' => $media['id']]);
            RoleUser::query()->create([
                'role_id' => 3,
                'user_id' => $user['id'],
            ]);
        }
        return $user;
    }
}