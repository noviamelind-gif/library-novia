<?php require __DIR__ . '/../../layouts/header.php'; ?>

<?php require __DIR__ . '/../../layouts/sidebar_user.php'; ?>

<div class="main-content">

    <!-- HEADER -->
    <?php
    $topbarTitle    = 'Halo, ' . ($_SESSION['user']['nama'] ?? 'Pengguna') . '!';
    $topbarSubtitle = 'Proses pengembalian bukumu 🎀';
    require __DIR__ . '/../../layouts/topbar.php';
    ?>

    <!-- CONTENT -->
    <div class="content">

        <div class="mb-4">
            <div class="page-title">Pengembalian Buku</div>
            <div class="page-description">Konfirmasi pengembalian buku yang kamu pinjam ♡</div>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body p-4">

                <h5 class="mb-4">Informasi Pengembalian</h5>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">NIM Mahasiswa</label>
                        <input type="text" class="form-control"
                               value="<?= htmlspecialchars($peminjaman['nim']) ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">ID Peminjaman</label>
                        <input type="text" class="form-control"
                               value="<?= htmlspecialchars($peminjaman['id']) ?>" readonly>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Buku</label>
                        <input type="text" class="form-control"
                               value="<?= htmlspecialchars($peminjaman['judul']) ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Peminjaman</label>
                        <input type="text" class="form-control"
                               value="<?= htmlspecialchars($peminjaman['tanggal_pinjam']) ?>" readonly>
                    </div>
                </div>

                <form method="POST"
                      action="/library/public/user/pengembalian/<?= (int) $peminjaman['id'] ?>">

                    <div class="mb-4">
                        <label class="form-label">Tanggal Pengembalian</label>
                        <input
                            type="date"
                            name="tanggal_kembali"
                            class="form-control"
                            value="<?= date('Y-m-d') ?>"
                            required
                        >
                        <small class="text-muted">
                            Tanggal pengembalian tidak boleh sebelum tanggal peminjaman.
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-pink">♡ Simpan Pengembalian</button>
                        <a href="/library/public/user/pengembalian"
                           class="btn btn-outline-secondary">Batal</a>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
