<?php

class AuthMiddleware
{
    public static function requireLogin(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /library/public/login');
            exit;
        }
    }

    // Halaman home sesuai role
    public static function homeUrl(): string
    {
        return ($_SESSION['user']['role'] ?? '') === 'admin'
            ? '/library/public/admin/dashboard'
            : '/library/public/user/dashboard';
    }

    // Hanya admin. User yang nyasar dialihkan ke dashboard-nya sendiri.
    public static function requireAdmin(): void
    {
        self::requireLogin();

        if ($_SESSION['user']['role'] !== 'admin') {
            header('Location: ' . self::homeUrl());
            exit;
        }
    }

    // Hanya user. Admin yang nyasar dialihkan ke dashboard admin.
    public static function requireUser(): void
    {
        self::requireLogin();

        if ($_SESSION['user']['role'] !== 'user') {
            header('Location: ' . self::homeUrl());
            exit;
        }
    }
}
