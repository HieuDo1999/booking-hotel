<?php
/**
 * Created by PhpStorm.
 * User: JreamOQ ( jreamoq@gmail.com )
 * Date: 12/10/20
 * Time: 14:23
 */
namespace App\Http\Middleware;

use Closure;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(is_multi_language()){
            $lang = $request->get('lang', '');
            if(!session_id()){
                session_start();
            }

            if(!empty($lang)){
                $langs = get_languages();
                if(!empty($langs)){
                    if(in_array($lang, $langs)){
                        $_SESSION['language'] = $lang;
                    }
                }
            }else{
                $currentSectionLang = '';
                if(isset($_SESSION['language'])){
                    $currentSectionLang = $_SESSION['language'];
                }else{
                    if(isset($_COOKIE['language'])){
                        $currentSectionLang = $_COOKIE['language'];
                    }
                }
                $langs = get_languages();
                if(empty($currentSectionLang)){
                    if(!empty($langs)){
                        $_SESSION['language'] = $langs[0];
                    }
                }else{
                    if(!empty($langs)){
                        if(!in_array($currentSectionLang, $langs)){
                            if(isset($_SESSION['language'])){
                                unset($_SESSION['language']);
                            }
                        }else {
                            $_SESSION['language'] = $currentSectionLang;
                        }
                    }
                }
            }

            if(isset($_SESSION['language'])){
                $language = $_SESSION['language'];
                setcookie("language", $language);
            }else{
                $lang_option = get_option('site_language', '');
                if(empty($lang_option)){
                    $lang_option = config('app.locale');
                }
                $language = $lang_option;
            }
        }else{
            $lang_option = get_option('site_language', '');
            if(empty($lang_option)){
                $lang_option = config('app.locale');
            }
            $language = $lang_option;
        }

        app()->setLocale($language);

        return $next($request);
    }
}