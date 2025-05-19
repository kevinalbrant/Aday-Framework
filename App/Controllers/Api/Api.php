<?php declare(strict_types= 1);

namespace App\Controllers\Api;

use App\Models\User;

/**
 * API Controller
 * 
 * PHP version 8.0
 */
class Api extends \Core\Controller {

    private $method;

    public function before(): void {
        header("Content-Type: application/json");
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Show the index page
     * 
     * @return void
     */
    public function indexAction(): void {
        if (method_exists($this, $this->method)) {
            $this->{$this->method}();
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }

    /**
     * Handle User Informations
     */
    public function userAction(): void {
        echo json_encode(User::getUsers());
    }

    /**
     * Handle GET requests
     * 
     * @return void
     */
    public function get(): void {
        $response = ["message" => "GET request successful", "data" => ["Test" => "Hello World"]];
        echo json_encode($response);
    }

    /**
     * Handle POST requests
     * 
     * @return void
     */
    public function post(): void {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            echo json_encode(['message' => 'POST request successful', 'received' => $data]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid POST data']);
        }
    }

    /**
     * Handle PUT requests
     * 
     * @return void
     */
    public function put(): void {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            echo json_encode(['message' => 'PUT request successful', 'updated' => $data]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid PUT data']);
        }
    }

    /**
     * Handle DELETE requests
     * 
     * @return void
     */
    public function delete(): void {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['id'])) {
            echo json_encode(['message' => 'DELETE request successful', 'deleted_id' => $data['id']]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid DELETE data']);
        }
    }
}
