<?php require __DIR__ . '/../../layouts/header.php'; ?>

<?php require __DIR__ . '/../../layouts/sidebar_user.php'; ?>

<div class="main-content">

    <!-- HEADER -->
    <?php
    $topbarTitle    = 'Halo, ' . ($_SESSION['user']['nama'] ?? 'Pengguna') . '!';
    $topbarSubtitle = 'Semua koleksi buku kampus dalam satu tempat 🎀';
    require __DIR__ . '/../../layouts/topbar.php';
    ?>

    <!-- CONTENT -->
    <div class="content">

        <div class="mb-4">
            <div class="page-title">Daftar Buku</div>
            <div class="page-description">
                Lihat koleksi buku perpustakaan yang bisa kamu pinjam ♡
            </div>
        </div>

        <?php if (!empty($_GET['search'])): ?>

            <div class="search-summary">
                <span>
                    <?= count($buku) ?> buku cocok dengan
                    &ldquo;<?= htmlspecialchars($_GET['search']) ?>&rdquo;
                </span>
                <a href="/library/public/user/buku">Tampilkan semua</a>
            </div>

        <?php endif; ?>

        <div class="card">
            <div class="card-body">

                <div class="mb-3">
                    <h5 class="mb-1">Koleksi Buku</h5>
                    <small class="text-muted">
                        Daftar buku yang tersedia di perpustakaan
                    </small>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php if (empty($buku)): ?>

                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <?php if (!empty($_GET['search'])): ?>
                                        Tidak ada buku yang cocok. Coba kata kunci lain,
                                        misalnya nama penulis atau tahun terbit.
                                    <?php else: ?>
                                        Belum ada data buku ♡
                                    <?php endif; ?>
                                </td>
                            </tr>

                        <?php else: ?>

                            <?php foreach ($buku as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['id']) ?></td>
                                    <td><strong><?= htmlspecialchars($item['judul']) ?></strong></td>
                                    <td><?= htmlspecialchars($item['penulis']) ?></td>
                                    <td><?= htmlspecialchars($item['penerbit']) ?></td>
                                    <td><?= htmlspecialchars($item['tahun_terbit']) ?></td>
                                    <td><span class="fw-semibold"><?= htmlspecialchars($item['stok']) ?></span></td>
                                    <td>
                                        <?php if ($item['stok'] > 0): ?>
                                            <span class="badge-tersedia">Tersedia</span>
                                        <?php else: ?>
                                            <span class="badge-tidak-tersedia">Tidak tersedia</span>
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
