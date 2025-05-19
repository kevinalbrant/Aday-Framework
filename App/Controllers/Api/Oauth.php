<?php declare(strict_types= 1);

namespace App\Controllers\Api;

/**
 * OAuth API Controller
 * 
 * PHP version 8.0
 */
class Oauth extends \Core\Controller {

    public function before(): void {
        header("Content-Type: application/json");
    }

    /**
     * Show the index page
     * 
     * @return void
     */
    public function indexAction(): void {
        echo json_encode(["Hello WOLRD" => "Hello World"]);
    }
}
