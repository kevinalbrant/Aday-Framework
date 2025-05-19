<?php declare(strict_types= 1);

namespace App\Controllers;

use App\Models\Auth;
use App\Config;

/**
 * Authenfication controller
 *
 * PHP version 8.0
 */
class Auths{

    /**
     * Authenfication if the user data is right
     * 
     * @param string $username
     * @param string $password
     *
     * @return boolean
     * @static
     */
    public static function authLogin(string $username, string $password):bool {
        $loginAttempts = Auth::checkLoginAttempts(static::getIPAdress());
        if (!is_array($loginAttempts)) {
            $loginAttempts = ['attempts' => 0];
        }
        if ($loginAttempts['attempts'] <= 3) {
            $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
            $password = hash('sha512', Config::PASSWORD_PEPPER_START . $password . Config::PASSWORD_PEPPER_END);

            $user = Auth::getUser($username, $password);

            if ( isset($user['user_ID']) ) {
                $_SESSION['user_ID'] = $user['user_ID'];

                Auth::deleteCookie($user['user_ID']);

                static::setCookie($username, $password);

                session_regenerate_id();

                return true;
            } else {
                Auth::registerLoginAttempt(static::getIPAdress());
                //TO-DO Fehlermeldungen anzeigen
                echo "Login falsch";
            }
            
        } else {
            //TO-DO Fehlermeldungen anzeigen
            echo "Login nicht möglich";
        }
        return false;
    }

    /**
     * Authenfication if the user is logged in
     *
     * @return boolean
     * @static
     */
    public static function authLoggedIn():bool {
        $cookieData = Auth::testCookie($_COOKIE['hashLogin']);

        if ($cookieData['count'] != 0 && $cookieData != NULL) {
            $_SESSION['user_ID'] = $cookieData['user_ID'];
            return true;
        }else if ($cookieData['count'] == 0){
            static::authLogout();
        }

        return false;
    }

    /**
     * Log the user out
     * 
     * @return void
     * @static
     */
    public static function authLogout():void {

        if ($_SESSION['user_ID']) {
            Auth::deleteCookie($_SESSION['user_ID']);
        }
        
        session_destroy();

        if( isset($_COOKIE['hashLogin']) ){
            setcookie('hashLogin', "", -3600, "/");
        }
        header("Location: /logins");
    }

    /**
     * Sets the cookie for the browser
     * 
     * @param string $username
     * @param string $password
     * 
     * @return void
     * @static
     */
    private static function setCookie(string $username, string $password):void {
        $username = static::createSalt() . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . static::createSalt();
        $password = static::createSalt() . htmlspecialchars($password, ENT_QUOTES, 'UTF-8') . static::createSalt();

        $hash = hash('sha512', $username . $password);

        Auth::addCookie($hash);

        setcookie('hashLogin', "", -3600, "/");

        setcookie('hashLogin', $hash, time()+604800, '/', "", Config::DOMAIN_SSL);
        
    }

    /**
     * Get IP-Adress from the user
     * 
     * @return string
     * @static
     */
    private static function getIPAdress():string {
        if (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = null;
        }
    
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = null;
        }
    
        return $ip;
    }

    /**
     * Create a random String
     * 
     * @return string
     * @static
     */
    private static function createSalt():string {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#.-,!$%&/()=?`><';
        $charactersLength = strlen($characters);
        $salt = '';
        for ($i = 0; $i < 20; $i++) {
            $salt .= $characters[rand(0, $charactersLength - 1)];
        }
        return $salt;
    }
}