<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Auth extends Controller
{
    public function login()
    {
        include __DIR__ . '/../views/auth/login.php';
    }

    public function authenticate()
    {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $user = $this->call->database()->table('users')->where('username', $username)->get();

        if (!$user || !password_verify($password, $user['password'])) {
            header('Location: /auth/login?error=' . rawurlencode('Invalid username or password.'));
            exit;
        }

        $this->startSession();
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];
        header('Location: /products');
        exit;
    }

    public function register()
    {
        $formData = ['role' => 'user'];
        $errors = [];
        include __DIR__ . '/../views/auth/register.php';
    }

    public function store_user()
    {
        $formData = [
            'username' => trim((string) ($_POST['username'] ?? '')),
            'email' => trim((string) ($_POST['email'] ?? '')),
            'role' => (string) ($_POST['role'] ?? 'user'),
        ];
        $password = (string) ($_POST['password'] ?? '');
        $passwordConfirm = (string) ($_POST['password_confirm'] ?? '');
        $errors = [];

        if (!preg_match('/^[A-Za-z0-9_]{3,50}$/', $formData['username'])) {
            $errors[] = 'Username must contain 3-50 letters, numbers, or underscores.';
        }
        if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }
        if (strlen($password) < 6) {
            $errors[] = 'Password must contain at least 6 characters.';
        }
        if ($password !== $passwordConfirm) {
            $errors[] = 'Password confirmation does not match.';
        }
        if (!in_array($formData['role'], ['admin', 'user'], true)) {
            $errors[] = 'Please choose a valid account role.';
        }
        if ($errors) {
            include __DIR__ . '/../views/auth/register.php';
            return;
        }

        $db = $this->call->database();
        $existingUser = $db->table('users')->where('username', $formData['username'])->get();
        $existingEmail = $db->table('users')->where('email', $formData['email'])->get();
        if ($existingUser || $existingEmail) {
            $errors[] = 'Username or email address is already registered.';
            include __DIR__ . '/../views/auth/register.php';
            return;
        }

        $db->table('users')->insert([
            'username' => $formData['username'],
            'email' => $formData['email'],
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $formData['role'],
        ]);

        header('Location: /auth/login?success=' . rawurlencode('Registration successful. You can now log in.'));
        exit;
    }

    public function logout()
    {
        $this->startSession();

        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();

        header('Location: /auth/login?success=' . rawurlencode('You have been logged out.'));
        exit;
    }

    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_save_path(ROOT_DIR . 'runtime/sessions');
            session_start();
        }
    }
}
