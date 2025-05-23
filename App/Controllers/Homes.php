<?php declare(strict_types= 1);

namespace App\Controllers;

use \Core\View;
use App\Controllers\Auths;


/**
 * Home Controller
 * 
 * PHP version 8.0
 */
class Homes extends \Core\Controller{

    /**
     * Show the index page
     * 
     * @return void
     */
    public function indexAction():void {
        
        if(isset($_POST['username']) && isset($_POST['password'])) {
            if(Auths::authLogin($_POST['username'], $_POST['password'])) {
                echo "logged in";

                echo $_SESSION['user']->getId();
            }
        }

        View::renderTemplate('base.html.twig', [
            
        ]);
    }
}