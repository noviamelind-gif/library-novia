<?php require __DIR__ . '/../../layouts/header.php'; ?>

<?php require __DIR__ . '/../../layouts/sidebar_admin.php'; ?>

<div class="main-content">

    <!-- HEADER -->
    <?php
    $topbarTitle    = 'Halo, ' . ($_SESSION['user']['nama'] ?? 'Admin') . '!';
    $topbarSubtitle = 'Daftar anggota yang terdaftar di perpustakaan 🎀';
    require __DIR__ . '/../../layouts/topbar.php';
    ?>

    <!-- CONTENT -->
    <div class="content">

        <div class="mb-4">
            <div class="page-title">Data Anggota</div>
            <div class="page-description">
                Daftar anggota perpustakaan (data tabel anggota)
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="mb-3">
                    <h5 class="mb-1">Anggota Perpustakaan</h5>
                    <small class="text-muted">
                        Total <?= count($anggota) ?> anggota
                    </small>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php if (empty($anggota)): ?>

                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    Belum ada anggota yang terdaftar !
                                </td>
                            </tr>

                        <?php else: ?>

                            <?php $no = 1; foreach ($anggota as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($item['nim']) ?></td>
                                    <td><strong><?= htmlspecialchars($item['nama']) ?></strong></td>
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
