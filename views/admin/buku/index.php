<?php require __DIR__ . '/../../layouts/header.php'; ?>

<?php require __DIR__ . '/../../layouts/sidebar_admin.php'; ?>

<div class="main-content">

    <!-- HEADER -->
    <?php
    $topbarTitle    = 'Halo, ' . ($_SESSION['user']['nama'] ?? 'Admin') . '!';
    $topbarSubtitle = 'Semua koleksi buku kampus dalam satu tempat 🎀';
    require __DIR__ . '/../../layouts/topbar.php';
    ?>


    <!-- CONTENT -->
    <div class="content">

            <?php if (isset($error)): ?>

            <div class="alert alert-danger">
                ⚠️ <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>


        <?php if (isset($_GET['deleted'])): ?>

            <div class="alert alert-success">
                Data buku berhasil dihapus.
            </div>

        <?php endif; ?>

        <!-- JUDUL HALAMAN -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <div class="page-title">
                     Daftar Buku
                </div>

                <div class="page-description">
                    Kelola data buku perpustakaan dengan mudah dan rapi 
                </div>

            </div>


            <a
                href="/library/public/admin/buku/create"
                class="btn btn-pink"
            >
                ＋ Tambah Buku
            </a>

        </div>

        <?php if (isset($_SESSION['success'])): ?>

        <div class="alert alert-success">
            ♡ <?= htmlspecialchars($_SESSION['success']) ?>
        </div>

        <?php unset($_SESSION['success']); ?>

    <?php endif; ?>

        <?php if (!empty($_GET['search'])): ?>

            <div class="search-summary">

                <span>
                    <?= count($buku) ?> buku cocok dengan
                    &ldquo;<?= htmlspecialchars($_GET['search']) ?>&rdquo;
                </span>

                <a href="/library/public/admin/buku">Tampilkan semua</a>

            </div>

        <?php endif; ?>

        <!-- CARD TABEL -->
        <div class="card">

            <div class="card-body">

                <!-- HEADER TABEL -->
                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>
                        <h5 class="mb-1">
                            Koleksi Buku 
                        </h5>

                        <small class="text-muted">
                            Daftar buku yang tersedia di perpustakaan
                        </small>

                    </div>

                </div>


                <!-- TABEL -->
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
                                <th>Aksi</th>
                            </tr>

                        </thead>


                        <tbody>

                        <?php if (empty($buku)): ?>

                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center py-4"
                                >
                                    <?php if (!empty($_GET['search'])): ?>

                                        Tidak ada buku yang cocok. Coba kata kunci lain,
                                        misalnya nama penulis atau tahun terbit.

                                    <?php else: ?>

                                        Belum ada data buku 

                                    <?php endif; ?>
                                </td>

                            </tr>

                        <?php else: ?>


                            <?php foreach ($buku as $item): ?>

                                <tr>

                                    <!-- ID -->
                                    <td>
                                        <?= htmlspecialchars($item['id']) ?>
                                    </td>


                                    <!-- JUDUL -->
                                    <td>

                                        <strong>
                                            <?= htmlspecialchars($item['judul']) ?>
                                        </strong>

                                    </td>


                                    <!-- PENULIS -->
                                    <td>
                                        <?= htmlspecialchars($item['penulis']) ?>
                                    </td>


                                    <!-- PENERBIT -->
                                    <td>
                                        <?= htmlspecialchars($item['penerbit']) ?>
                                    </td>


                                    <!-- TAHUN -->
                                    <td>
                                        <?= htmlspecialchars($item['tahun_terbit']) ?>
                                    </td>


                                    <!-- STOK -->
                                    <td>

                                        <span class="fw-semibold">
                                            <?= htmlspecialchars($item['stok']) ?>
                                        </span>

                                    </td>


                                    <!-- STATUS -->
                                    <td>

                                        <?php if ($item['stok'] > 0): ?>

                                            <span class="badge-tersedia">
                                                Tersedia
                                            </span>

                                        <?php else: ?>

                                            <span class="badge-tidak-tersedia">
                                                Tidak tersedia
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- AKSI -->
                                    <td>

                                        <div class="d-flex gap-1">

                                            <a
                                                href="/library/public/admin/buku/<?= $item['id'] ?>/edit"
                                                class="btn btn-sm btn-outline-secondary"
                                            >
                                                Edit
                                            </a>


                                            <a
                                                href="/library/public/admin/buku/<?= $item['id'] ?>/delete"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Yakin ingin menghapus buku ini?')"
                                            >
                                                Hapus
                                            </a>

                                        </div>

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