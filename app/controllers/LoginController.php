<?php

namespace Formacom\controllers;

use Formacom\Core\Controller;
use Formacom\Models\User;


class LoginController extends Controller
{
    public function index(...$params)
    {

        $this->view("home");
    }
    public function login(...$params)
    {
        if (isset($_POST["username"])) {
            $user = User::where("username", $_POST["username"])->first();
            if ($user && password_verify($_POST["password"], $user->password)) {
                session_start();
                $_SESSION["user_id"] = $user->user_id;
                $_SESSION["username"] = $user->username;
                header("Location: " . base_url() . "admin");
            } else {
                $error = "User or pass incorrect";
                $this->view("home", [$error]);
            }
            exit();
        } else {
            header("Location: " . base_url() . "login");
        }
    }

    public function register(...$params)
    {
        $this->view("register");
    }

    public function logout()
    {
        // Start the session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Clear all session variables
        $_SESSION = [];

        // If a session cookie exists, destroy it
        if (isset($_COOKIE[session_name()])) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();

        // Clear any custom cookies that might be set for auth
        if (isset($_COOKIE['user_id'])) {
            setcookie('user_id', '', time() - 3600, '/');
        }
        
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        if (isset($_COOKIE['user_session'])) {
            setcookie('user_session', '', time() - 3600, '/');
        }

        // Redirect to login page
        header('Location: ' . base_url() . 'login');
        exit;
    }
}
