<?php

class AuthController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function showRegister(): void
    {
        require __DIR__ . '/../../views/auth/register.php';
    }

    public function showLogin(): void
    {
        require __DIR__ . '/../../views/auth/login.php';
    }

    public function register(): void
    {
        $nama = trim($_POST['nama'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $konfirmasiPassword = $_POST['konfirmasi_password'] ?? '';

        if (
            $nama === '' ||
            $username === '' ||
            $email === '' ||
            $password === '' ||
            $konfirmasiPassword === ''
        ) {
            $error = 'Semua field wajib diisi.';
            require __DIR__ . '/../../views/auth/register.php';
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Format email tidak valid.';
            require __DIR__ . '/../../views/auth/register.php';
            return;
        }

        if ($password !== $konfirmasiPassword) {
            $error = 'Konfirmasi password tidak cocok.';
            require __DIR__ . '/../../views/auth/register.php';
            return;
        }

        if (strlen($password) < 6) {
            $error = 'Password minimal 6 karakter.';
            require __DIR__ . '/../../views/auth/register.php';
            return;
        }

        $check = $this->pdo->prepare(
            "SELECT id FROM users
            WHERE username = :username OR email = :email
            LIMIT 1"
        );

        $check->execute([
            'username' => $username,
            'email' => $email
        ]);

        if ($check->fetch()) {
            $error = 'Username atau email sudah digunakan.';
            require __DIR__ . '/../../views/auth/register.php';
            return;
        }

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $sql = "INSERT INTO users
                (nama, username, email, password, role)
                VALUES
                (:nama, :username, :email, :password, 'user')";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'nama' => $nama,
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword
        ]);

        header('Location: /library/public/login');
        exit;
    }

    public function login(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $error = 'Username dan password wajib diisi.';
            require __DIR__ . '/../../views/auth/login.php';
            return;
        }

        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'username' => $username
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            $error = 'Username atau password salah.';
            require __DIR__ . '/../../views/auth/login.php';
            return;
        }

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => $user['id'],
            'nama' => $user['nama'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        // Pulihkan NIM dari database agar riwayat pinjaman tetap muncul setelah login ulang
        if (!empty($user['nim'])) {
            $_SESSION['nim'] = $user['nim'];
        }

        if ($user['role'] === 'admin') {
            header('Location: /library/public/admin/dashboard');
        } else {
            header('Location: /library/public/user/dashboard');
        }

        exit;
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: /library/public/login');
        exit;
    }
}