<?php

require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../app/Controllers/AuthController.php';

require_once __DIR__ . '/../app/Controllers/Admin/AdminDashboardController.php';
require_once __DIR__ . '/../app/Controllers/Admin/AdminBukuController.php';
require_once __DIR__ . '/../app/Controllers/Admin/AdminAnggotaController.php';

require_once __DIR__ . '/../app/Controllers/User/UserDashboardController.php';
require_once __DIR__ . '/../app/Controllers/User/UserBukuController.php';
require_once __DIR__ . '/../app/Controllers/User/UserPeminjamanController.php';

require_once __DIR__ . '/../app/Middleware/AuthMiddleware.php';


// ==========================================================
// AMBIL URL DAN METHOD REQUEST
// ==========================================================

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$base = '/library/public';


// ==========================================================
// BUAT CONTROLLER
// ==========================================================

$authController = new AuthController($pdo);

// Admin
$adminDashboardController = new AdminDashboardController($pdo);
$adminBukuController      = new AdminBukuController($pdo);
$adminAnggotaController   = new AdminAnggotaController($pdo);

// User
$userDashboardController  = new UserDashboardController($pdo);
$userBukuController       = new UserBukuController($pdo);
$userPeminjamanController = new UserPeminjamanController($pdo);


// ==========================================================
// AUTH (umum)
// ==========================================================

if ($method === 'GET' && $uri === "$base/register") {
    $authController->showRegister();
    exit;
}

if ($method === 'POST' && $uri === "$base/register") {
    $authController->register();
    exit;
}

if ($method === 'GET' && $uri === "$base/login") {
    $authController->showLogin();
    exit;
}

if ($method === 'POST' && $uri === "$base/login") {
    $authController->login();
    exit;
}

if ($method === 'GET' && $uri === "$base/logout") {
    $authController->logout();
    exit;
}


// ==========================================================
// HOME -> arahkan sesuai role
// ==========================================================

if ($method === 'GET' && ($uri === "$base/" || $uri === $base)) {
    AuthMiddleware::requireLogin();

    header('Location: ' . AuthMiddleware::homeUrl());
    exit;
}


// ==========================================================
// ================  ROUTE ADMIN  (/admin/...)  =============
// ==========================================================

// GET /admin/dashboard
if ($method === 'GET' && $uri === "$base/admin/dashboard") {
    AuthMiddleware::requireAdmin();

    $adminDashboardController->index();
    exit;
}


// ---------- Data Buku (CRUD) ----------

// GET /admin/buku
if ($method === 'GET' && $uri === "$base/admin/buku") {
    AuthMiddleware::requireAdmin();

    $adminBukuController->index();
    exit;
}

// GET /admin/buku/create
if ($method === 'GET' && $uri === "$base/admin/buku/create") {
    AuthMiddleware::requireAdmin();

    $adminBukuController->create();
    exit;
}

// POST /admin/buku
if ($method === 'POST' && $uri === "$base/admin/buku") {
    AuthMiddleware::requireAdmin();

    $adminBukuController->store();
    exit;
}

// GET /admin/buku/{id}/edit
if (
    $method === 'GET' &&
    preg_match('#^/library/public/admin/buku/(\d+)/edit$#', $uri, $matches)
) {
    AuthMiddleware::requireAdmin();

    $adminBukuController->edit((int) $matches[1]);
    exit;
}

// POST /admin/buku/{id}
if (
    $method === 'POST' &&
    preg_match('#^/library/public/admin/buku/(\d+)$#', $uri, $matches)
) {
    AuthMiddleware::requireAdmin();

    $adminBukuController->update((int) $matches[1]);
    exit;
}

// GET /admin/buku/{id}/delete
if (
    $method === 'GET' &&
    preg_match('#^/library/public/admin/buku/(\d+)/delete$#', $uri, $matches)
) {
    AuthMiddleware::requireAdmin();

    $adminBukuController->delete((int) $matches[1]);
    exit;
}


// ---------- Data Anggota ----------

// GET /admin/anggota
if ($method === 'GET' && $uri === "$base/admin/anggota") {
    AuthMiddleware::requireAdmin();

    $adminAnggotaController->index();
    exit;
}


// ==========================================================
// ================  ROUTE USER  (/user/...)  ===============
// ==========================================================

// GET /user/dashboard
if ($method === 'GET' && $uri === "$base/user/dashboard") {
    AuthMiddleware::requireUser();

    $userDashboardController->index();
    exit;
}


// ---------- Data Buku (hanya lihat) ----------

// GET /user/buku
if ($method === 'GET' && $uri === "$base/user/buku") {
    AuthMiddleware::requireUser();

    $userBukuController->index();
    exit;
}


// ---------- Peminjaman ----------

// GET /user/peminjaman
if ($method === 'GET' && $uri === "$base/user/peminjaman") {
    AuthMiddleware::requireUser();

    $userPeminjamanController->index();
    exit;
}

// POST /user/peminjaman
if ($method === 'POST' && $uri === "$base/user/peminjaman") {
    AuthMiddleware::requireUser();

    $userPeminjamanController->store();
    exit;
}


// ---------- Pengembalian ----------

// GET /user/pengembalian
if ($method === 'GET' && $uri === "$base/user/pengembalian") {
    AuthMiddleware::requireUser();

    $userPeminjamanController->pengembalian();
    exit;
}

// GET /user/pengembalian/{id}
if (
    $method === 'GET' &&
    preg_match('#^/library/public/user/pengembalian/(\d+)$#', $uri, $matches)
) {
    AuthMiddleware::requireUser();

    $userPeminjamanController->returnForm((int) $matches[1]);
    exit;
}

// POST /user/pengembalian/{id}
if (
    $method === 'POST' &&
    preg_match('#^/library/public/user/pengembalian/(\d+)$#', $uri, $matches)
) {
    AuthMiddleware::requireUser();

    $userPeminjamanController->returnBook((int) $matches[1]);
    exit;
}


// ==========================================================
// HALAMAN TIDAK DITEMUKAN
// ==========================================================

http_response_code(404);

echo "Halaman tidak ditemukan.";
