<?php
/*
 | Header halaman.
 | Sebelum me-require file ini, halaman boleh mengisi:
 |   $topbarTitle    -> sapaan besar di kiri
 |   $topbarSubtitle -> keterangan kecil di bawahnya
 */

$hari = [
    'Sunday'    => 'Minggu',
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu',
];

$bulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret',      4 => 'April',
    5 => 'Mei',     6 => 'Juni',     7 => 'Juli',       8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
];

$tanggalIni = $hari[date('l')] . ', ' . date('j') . ' ' . $bulan[(int) date('n')] . ' ' . date('Y');

// Data pengguna yang sedang login (nama diambil dari saat registrasi)
$topbarUser = $_SESSION['user'] ?? [];
$namaUser   = $topbarUser['nama'] ?? 'Pengguna';
$isAdmin    = ($topbarUser['role'] ?? '') === 'admin';
$roleLabel  = $isAdmin ? 'Petugas perpustakaan' : 'Anggota perpustakaan';
$rolePrefix = $isAdmin ? 'admin' : 'user';
$bukuUrl    = '/library/public/' . $rolePrefix . '/buku';
$inisial    = mb_strtoupper(mb_substr($namaUser, 0, 1));
?>

<div class="topbar">

    <div>

        <div class="topbar-title">
            <?= htmlspecialchars($topbarTitle ?? 'Selamat datang kembali!') ?>
        </div>

        <div class="topbar-subtitle">
            <?= htmlspecialchars($topbarSubtitle ?? 'Ini ringkasan Perpustakaan Kampus hari ini 🎀') ?>
        </div>

    </div>


    <div class="topbar-side">

        <!-- Pencarian buku -->
        <form
            method="GET"
            action="<?= $bukuUrl ?>"
            class="topbar-search"
            role="search"
        >

            <label class="search-icon" for="topbar-search-input">🔍</label>

            <input
                id="topbar-search-input"
                type="search"
                name="search"
                placeholder="Cari judul, penulis, penerbit, tahun, status..."
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                autocomplete="off"
            >

            <?php if (!empty($_GET['search'])): ?>

                <a
                    href="<?= $bukuUrl ?>"
                    class="search-reset"
                    title="Hapus pencarian"
                >
                    ✕
                </a>

            <?php endif; ?>

            <button type="submit">Cari</button>

        </form>

        <div class="topbar-user">

            <div>
                <div class="user-name"><?= htmlspecialchars($namaUser) ?></div>
                <div class="user-role"><?= $roleLabel ?></div>
            </div>

            <div class="topbar-avatar"><?= htmlspecialchars($inisial) ?></div>

        </div>

         <div class="topbar-meta">

            <span>
                <span class="meta-icon">🗓</span>
                <?= $tanggalIni ?>
            </span>

        </div>
        
    </div>

</div>
