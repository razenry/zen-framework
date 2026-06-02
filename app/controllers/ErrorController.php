<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\App;

class ErrorController extends Controller
{
    public function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        $data['title'] = '404 - Page Not Found';
        App::Layout('main', 'errors/404', $data);
    }

    public function serverError(\Throwable $exception = null)
    {
        header("HTTP/1.1 500 Internal Server Error");
        $data['title'] = '500 - Internal Server Error';
        $data['exception'] = $exception;
        
        // If layout fails for some reason (e.g. view not found), fallback to simple echo
        try {
            App::Layout('main', 'errors/500', $data);
        } catch (\Exception $e) {
            echo "<h1>500 Internal Server Error</h1>";
            if (getenv('APP_DEBUG') === 'true') {
                echo "<p>" . $exception->getMessage() . "</p>";
            }
        }
    }
}
