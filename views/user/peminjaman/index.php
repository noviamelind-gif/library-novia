<?php require __DIR__ . '/../../layouts/header.php'; ?>

<?php require __DIR__ . '/../../layouts/sidebar_user.php'; ?>

<div class="main-content">

    <!-- HEADER -->
    <?php
    $topbarTitle    = 'Halo, ' . ($_SESSION['user']['nama'] ?? 'Pengguna') . '!';
    $topbarSubtitle = 'Pinjam buku favoritmu hari ini 🎀';
    require __DIR__ . '/../../layouts/topbar.php';
    ?>

    <!-- CONTENT -->
    <div class="content">

        <div class="mb-4">
            <div class="page-title">Peminjaman Buku</div>
            <div class="page-description">
                Pinjam buku perpustakaan dengan mudah ♡
            </div>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">♡ Peminjaman buku berhasil disimpan.</div>
        <?php endif; ?>


        <!-- FORM PEMINJAMAN -->
        <div class="card mb-4">
            <div class="card-body p-4">

                <h5 class="mb-4">Form Peminjaman</h5>

                <form method="POST" action="/library/public/user/peminjaman">

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="form-label">NIM Mahasiswa</label>
                            <input
                                type="text"
                                name="nim"
                                class="form-control"
                                placeholder="Masukkan NIM"
                                value="<?= htmlspecialchars($_SESSION['nim'] ?? '') ?>"
                                <?= !empty($_SESSION['nim']) ? 'readonly' : 'required' ?>
                            >
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pilih Buku</label>
                            <select name="buku_id" class="form-select" required>
                                <option value="">-- Pilih buku --</option>
                                <?php foreach ($daftarBuku as $b): ?>
                                    <option
                                        value="<?= $b['id'] ?>"
                                        <?= $b['stok'] <= 0 ? 'disabled' : '' ?>
                                    >
                                        <?= htmlspecialchars($b['judul']) ?>
                                        <?= $b['stok'] <= 0 ? '(habis)' : '(stok ' . (int) $b['stok'] . ')' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal Peminjaman</label>
                            <input
                                type="date"
                                name="tanggal_pinjam"
                                class="form-control"
                                value="<?= date('Y-m-d') ?>"
                                required
                            >
                        </div>

                    </div>

                    <button type="submit" class="btn btn-pink">
                        ♡ Simpan Peminjaman
                    </button>

                </form>

            </div>
        </div>


        <!-- RIWAYAT PEMINJAMAN -->
        <div class="card">
            <div class="card-body p-4">

                <div class="mb-3">
                    <h5 class="mb-1">Riwayat Peminjaman Kamu</h5>
                    <small class="text-muted">Semua transaksi peminjaman bukumu</small>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php if (empty($peminjaman)): ?>

                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    Kamu belum punya transaksi peminjaman ♡
                                </td>
                            </tr>

                        <?php else: ?>

                            <?php foreach ($peminjaman as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['id']) ?></td>
                                    <td><strong><?= htmlspecialchars($item['judul']) ?></strong></td>
                                    <td><?= htmlspecialchars($item['tanggal_pinjam']) ?></td>
                                    <td>
                                        <?php if ($item['tanggal_kembali']): ?>
                                            <?= htmlspecialchars($item['tanggal_kembali']) ?>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item['status_peminjaman'] === 'dipinjam'): ?>
                                            <span class="badge-tersedia">Dipinjam</span>
                                        <?php else: ?>
                                            <span class="badge-tidak-tersedia">Dikembalikan</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php endif; ?>

                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>

</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
