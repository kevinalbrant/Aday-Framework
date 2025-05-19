<?php

/**
 * Vendor
 */
require_once dirname(__DIR__) . '/Vendor/autoload.php';

session_start();

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Set the Content Security Policy header
 */
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'self'; style-src 'self'; img-src 'self';");

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Homes', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{action}/');
$router->add('{controller}/', ['controller' => '{controller}', 'action' => 'index']);
$router->add('{controller}', ['controller' => '{controller}', 'action' => 'index']);
$router->add('{controller}/{id:\d+}/{action}');

/**
 * API Routes
 */
$router->add('v1/{controller}/{action}', ['namespace' => 'Api']);
$router->add('v1/{controller}/', ['namespace' => 'Api', 'controller' => '{controller}', 'action' => 'index']);
$router->add('v1/{controller}', ['namespace' => 'Api', 'controller' => '{controller}', 'action' => 'index']);

$router->dispatch($_SERVER['QUERY_STRING']);