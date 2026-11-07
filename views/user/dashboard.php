<?php require __DIR__ . '/../layouts/header.php'; ?>

<?php require __DIR__ . '/../layouts/sidebar_user.php'; ?>

<div class="main-content">

    <!-- TOPBAR -->
    <?php
    $topbarTitle    = 'Halo, ' . ($_SESSION['user']['nama'] ?? 'Pengguna') . '!';
    $topbarSubtitle = 'Temukan buku yang kamu sukai hari ini 🎀';
    require __DIR__ . '/../layouts/topbar.php';
    ?>

    <!-- CONTENT -->
    <div class="content">

        <div class="mb-4">
            <div class="page-title">Dashboard</div>
            <div class="page-description">
                Selamat datang di Sistem Perpustakaan Kampus ♡
            </div>
        </div>

        <!-- STATISTIK -->
        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="dashboard-icon">📚</div>
                        <div class="dashboard-label">Jumlah Koleksi Buku</div>
                        <div class="dashboard-number"><?= $totalKoleksi ?></div>
                        <div class="dashboard-info">Total stok buku yang tersedia</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="dashboard-icon">📖</div>
                        <div class="dashboard-label">Buku Yang Kamu Pinjam</div>
                        <div class="dashboard-number"><?= $totalDipinjam ?></div>
                        <div class="dashboard-info">Maksimal 3 buku dalam waktu bersamaan</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="dashboard-icon">💔</div>
                        <div class="dashboard-label">Buku Habis</div>
                        <div class="dashboard-number"><?= $totalHabis ?></div>
                        <div class="dashboard-info">Buku dengan stok 0</div>
                    </div>
                </div>
            </div>

        </div>

        <!-- PINJAMAN AKTIF -->
        <div class="card">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="mb-1">Pinjaman Kamu Saat Ini</h5>
                        <small class="text-muted">Buku yang belum dikembalikan</small>
                    </div>

                    <a href="/library/public/user/peminjaman" class="btn btn-pink">
                        + Pinjam Buku
                    </a>
                </div>

                <?php if (empty($pinjamanAktif)): ?>

                    <div class="text-center py-5">
                        <div style="font-size:40px;">📚</div>
                        <p class="text-muted mt-2">
                            Kamu belum meminjam buku apa pun.
                        </p>
                    </div>

                <?php else: ?>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Buku</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($pinjamanAktif as $data): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= htmlspecialchars($data['judul']) ?></strong></td>
                                        <td><?= htmlspecialchars($data['tanggal_pinjam']) ?></td>
                                        <td>
                                            <a
                                                href="/library/public/user/pengembalian/<?= $data['id'] ?>"
                                                class="btn btn-sm btn-pink"
                                            >
                                                ↩ Kembalikan
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php endif; ?>

            </div>
        </div>

    </div>

</div>


<style>

.dashboard-card {
    border: none;
    border-radius: 18px;
    background: #ffffff;
    transition: 0.2s;
}

.dashboard-card:hover {
    transform: translateY(-3px);
}

.dashboard-icon {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    background: #fce4ec;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 15px;
}

.dashboard-label {
    color: #a17b89;
    font-size: 14px;
    margin-bottom: 5px;
}

.dashboard-number {
    color: #d96c9d;
    font-size: 32px;
    font-weight: bold;
}

.dashboard-info {
    color: #b99aa6;
    font-size: 12px;
    margin-top: 5px;
}

</style>


<?php require __DIR__ . '/../layouts/footer.php'; ?>
