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
            $this->redirect(route('home'));
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
            $this->redirect(route('home'));
        }

        $_SESSION['error'] = 'Invalid email or password.';
        $this->redirect(route('login'));
    }

    public function register()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect(route('home'));
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
            $this->redirect(route('register'));
        }

        $existingUser = User::where('email', '=', $email)->first();
        if ($existingUser) {
            $_SESSION['error'] = 'Email is already taken.';
            $this->redirect(route('register'));
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        if ($user) {
            $_SESSION['success'] = 'Registration successful! Please login.';
            $this->redirect(route('login'));
        }

        $_SESSION['error'] = 'Failed to register. Please try again.';
        $this->redirect(route('register'));
    }

    public function logout()
    {
        session_destroy();
        session_start();
        $_SESSION['success'] = 'You have been logged out.';
        $this->redirect(route('login'));
    }
}
