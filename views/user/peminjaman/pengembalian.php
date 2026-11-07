<?php require __DIR__ . '/../../layouts/header.php'; ?>

<?php require __DIR__ . '/../../layouts/sidebar_user.php'; ?>

<div class="main-content">

    <!-- HEADER -->
    <?php
    $topbarTitle    = 'Halo, ' . ($_SESSION['user']['nama'] ?? 'Pengguna') . '!';
    $topbarSubtitle = 'Kembalikan buku tepat waktu ya 🎀';
    require __DIR__ . '/../../layouts/topbar.php';
    ?>

    <!-- CONTENT -->
    <div class="content">

        <div class="mb-4">
            <div class="page-title">Pengembalian Buku</div>
            <div class="page-description">
                Daftar buku yang sedang kamu pinjam dan perlu dikembalikan ♡
            </div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['returned'])): ?>
            <div class="alert alert-success">♡ Buku berhasil dikembalikan.</div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body p-4">

                <div class="mb-3">
                    <h5 class="mb-1">Daftar Buku yang Dipinjam</h5>
                    <small class="text-muted">
                        Pilih buku yang ingin kamu kembalikan.
                    </small>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php if (empty($peminjaman)): ?>

                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    Tidak ada buku yang sedang kamu pinjam ♡
                                </td>
                            </tr>

                        <?php else: ?>

                            <?php foreach ($peminjaman as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['id']) ?></td>
                                    <td><strong><?= htmlspecialchars($item['judul']) ?></strong></td>
                                    <td><?= htmlspecialchars($item['tanggal_pinjam']) ?></td>
                                    <td><span class="badge-tersedia">Dipinjam</span></td>
                                    <td>
                                        <a
                                            href="/library/public/user/pengembalian/<?= $item['id'] ?>"
                                            class="btn btn-sm btn-pink"
                                        >
                                            ↩ Kembalikan
                                        </a>
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
