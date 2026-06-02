<?php


/**
 * Database constants from environment
 */
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: '');


function adminUrl($path = '')
{
    $host = getenv('BASE_URL') ?: "http://localhost/";
    $baseUrl = rtrim($host, '/') . '/' . ltrim($path, '/');
    return $baseUrl;
}

function baseImageUrl($path = '')
{
    // Make sure this matches your actual directory structure
    $host = adminUrl('storage/images/');
    return rtrim($host, '/') . '/' . ltrim($path, '/');
}

function imageUrl($path = '')
{
    // Make sure this matches your actual directory structure
    $host = 'storage/images/';
    return rtrim($host, '/') . '/' . ltrim($path, '/');
}



function baseUrl($url = NULL)
{
    $base_url = getenv('BASE_URL') ?: 'http://localhost';
    if ($url != null) {
        return rtrim($base_url, '/') . '/' . ltrim($url, '/');
    } else {
        return $base_url;
    }
}

function route(string $name, $params = [])
{
    return \App\Core\Route::getUrl($name, $params);
}

function views($url = NULL)
{
    $base_url = (getenv('BASE_URL') ?: 'http://localhost') . '/app/views/';
    if ($url != null) {
        return rtrim($base_url, '/') . '/' . ltrim($url, '/') . ".php";
    } else {
        return $base_url;
    }
}

// Helper



