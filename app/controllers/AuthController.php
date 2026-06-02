<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\App;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: " . route('home'));
            exit;
        }
        $data['title'] = 'Login';
        App::Layout('main', 'auth/login', $data);
    }

    public function loginProcess()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::where('email', '=', $email)->first();

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['success'] = 'Welcome back, ' . $user->name . '!';
            header("Location: " . route('home'));
            exit;
        }

        $_SESSION['error'] = 'Invalid email or password.';
        header("Location: " . route('login'));
        exit;
    }

    public function register()
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: " . route('home'));
            exit;
        }
        $data['title'] = 'Register';
        App::Layout('main', 'auth/register', $data);
    }

    public function registerProcess()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['password_confirmation'] ?? '';

        if ($password !== $confirm) {
            $_SESSION['error'] = 'Passwords do not match.';
            header("Location: " . route('register'));
            exit;
        }

        $existingUser = User::where('email', '=', $email)->first();
        if ($existingUser) {
            $_SESSION['error'] = 'Email is already taken.';
            header("Location: " . route('register'));
            exit;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        if ($user) {
            $_SESSION['success'] = 'Registration successful! Please login.';
            header("Location: " . route('login'));
            exit;
        }

        $_SESSION['error'] = 'Failed to register. Please try again.';
        header("Location: " . route('register'));
        exit;
    }

    public function logout()
    {
        session_destroy();
        session_start();
        $_SESSION['success'] = 'You have been logged out.';
        header("Location: " . route('login'));
        exit;
    }
}
