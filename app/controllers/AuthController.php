<?php
require_once __DIR__ . '/../models/Auth.php';

class AuthController {
    private $auth;

    public function __construct($connection)
    {
        $this->auth = new Auth($connection);
    }

    public function login()
    {
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->auth->getAdminByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header('Location: ?page=indexA');
                exit();
            } else {
                die('Username atau password salah');
            }
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        
        header('Location: ?page=login');
        exit();
    }
}