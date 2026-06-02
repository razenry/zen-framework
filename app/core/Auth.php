<?php

namespace App\Core;

class Auth
{
    /**
     * Cek apakah user sudah login
     *
     * @return bool
     */
    public static function check()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Dapatkan ID user yang sedang login
     *
     * @return int|null
     */
    public static function id()
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Dapatkan data user (nama dll) dari session
     *
     * @return array|string|null
     */
    public static function user()
    {
        // Secara default ini hanya mengembalikan nama, 
        // tapi di dunia nyata ini bisa mengembalikan object User dari database
        return $_SESSION['user_name'] ?? null;
    }

    /**
     * Login user secara manual (set session)
     */
    public static function login($id, $name = '')
    {
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
    }

    /**
     * Logout user
     */
    public static function logout()
    {
        session_destroy();
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
    }
}
