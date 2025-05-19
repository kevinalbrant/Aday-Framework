<?php declare(strict_types=1);

namespace Core;

use Exception;
use App\Config;

/**
 * View
 * 
 * PHP version 8.0
 */
class View{

    /**
     * Render a view file
     * 
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     * 
     * @return void
     */
    public static function render(string $view, array $args = []):void {
        extract($args, EXTR_SKIP);

        $file = "../App/Views/$view";

        if(is_readable($file)) {
            require $file;
        }else{
            throw new Exception("$file not found", 500);
        }
    }

    /**
     * Render a view template using twig
     * 
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     * 
     * @return void
     */
    public static function renderTemplate(string $template, array $args = []):void {
        static $twig = null;

        if ($twig === null) {
            if (Config::CREATE_CACHE) {
                $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) ."/App/Views");
                $twig = new \Twig\Environment($loader, [
                    'cache' => dirname(__DIR__) .'/Cache'
                ]);
            }else{
                $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) ."/App/Views");
                $twig = new \Twig\Environment($loader);
            }
        }

        echo $twig->render($template, $args);
    }
}