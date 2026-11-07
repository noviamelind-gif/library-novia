<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
require_once __DIR__ . '/icons.php';
$base = '/library/public/user';
?>

<div class="sidebar">

    <!-- Papan nama -->
    <div class="sidebar-brand">
        <span class="spark spark-1">✦</span>
        <span class="spark spark-2">✦</span>
        <span class="spark spark-3">✦</span>
        <span class="spark spark-4">✦</span>
        <div class="brand-title">Library<br>Girls</div>
        <div class="brand-eyebrow">Welcome to Library</div>
    </div>

    <!-- Navigasi USER -->
    <nav class="sidebar-nav">

        <a href="<?= $base ?>/dashboard"
           class="sidebar-menu <?= strpos($uri, $base . '/dashboard') === 0 ? 'active' : '' ?>">
            <span class="menu-icon"><?= sidebar_icon('home') ?></span>
            <span>Dashboard</span>
        </a>

        <a href="<?= $base ?>/buku"
           class="sidebar-menu <?= strpos($uri, $base . '/buku') === 0 ? 'active' : '' ?>">
            <span class="menu-icon"><?= sidebar_icon('search') ?></span>
            <span>Data Buku</span>
        </a>

        <a href="<?= $base ?>/peminjaman"
           class="sidebar-menu <?= strpos($uri, $base . '/peminjaman') === 0 ? 'active' : '' ?>">
            <span class="menu-icon"><?= sidebar_icon('send') ?></span>
            <span>Peminjaman</span>
        </a>

        <a href="<?= $base ?>/pengembalian"
           class="sidebar-menu <?= strpos($uri, $base . '/pengembalian') === 0 ? 'active' : '' ?>">
            <span class="menu-icon"><?= sidebar_icon('mail') ?></span>
            <span>Pengembalian</span>
        </a>

        <div class="sidebar-divider"></div>

        <a href="/library/public/logout" class="sidebar-menu logout-menu">
            <span class="menu-icon"><?= sidebar_icon('heart') ?></span>
            <span>Logout</span>
        </a>

    </nav>

    <div class="sidebar-note">
        <div class="note-title">Tips hari ini</div>
        <div class="note-text">
            Kembalikan buku tepat waktu ya, supaya teman lain juga bisa
            membacanya.
        </div>
    </div>

    <div class="sidebar-decoration">— ʚɞ —</div>

</div>
