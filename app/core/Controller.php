<?php

namespace App\Core;

class Controller
{
    public function view($view, $data = [])
    {
        // Menyusun path tampilan dengan benar
        $viewPath = 'app/views/' . $view . '.php';

        // Memastikan file tampilan ada sebelum dimuat
        if (file_exists($viewPath)) {
            require_once $viewPath;
            return $data;
        } else {
            throw new \Exception("View file '$view' not found.");
        }
    }

    public function model($model)
    {
        // Menyusun path model dengan benar
        $modelPath = 'app/models/' . $model . '.php';

        // Memastikan file model ada sebelum dimuat
        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $model;
        } else {
            throw new \Exception("Model file '$model' not found.");
        }
    }

    /**
     * Redirects the user to a specific URL
     * 
     * @param string $url The URL to redirect to
     */
    protected function redirect($url)
    {
        // If the URL is just a path (e.g. '/login'), we can make it absolute or just pass it to header
        // For best compatibility we just prepend base_url if it starts with '/'
        if (strpos($url, '/') === 0) {
            $url = baseUrl($url);
        }
        
        header("Location: " . $url);
        exit;
    }
}
