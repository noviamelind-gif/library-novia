<?php require __DIR__ . '/../../layouts/header.php'; ?>
<?php require __DIR__ . '/../../layouts/sidebar_admin.php'; ?>

<div class="main-content">

    <!-- HEADER -->
    <?php
    $topbarTitle    = 'Halo, ' . ($_SESSION['user']['nama'] ?? 'Admin') . '!';
    $topbarSubtitle = 'Semua koleksi buku kampus dalam satu tempat 🎀';
    require __DIR__ . '/../../layouts/topbar.php';
    ?>   

    <div class="content">

        <div class="mb-4">
            <div class="page-title">
                Tambah Buku
            </div>

            <div class="page-description">
                Tambahkan data buku baru ke dalam perpustakaan 
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">

                <h5 class="mb-4">
                    Informasi Buku 
                </h5>

                <form
                    method="POST"
                    action="/library/public/admin/buku"
                >

                    <div class="mb-3">
                        <label class="form-label">
                            Judul Buku
                        </label>

                        <input
                            type="text"
                            name="judul"
                            class="form-control"
                            placeholder="Masukkan judul buku"
                            required
                        >
                    </div>


                    <div class="mb-3">
                        <label class="form-label">
                            Penulis
                        </label>

                        <input
                            type="text"
                            name="penulis"
                            class="form-control"
                            placeholder="Masukkan nama penulis"
                            required
                        >
                    </div>


                    <div class="mb-3">
                        <label class="form-label">
                            Penerbit
                        </label>

                        <input
                            type="text"
                            name="penerbit"
                            class="form-control"
                            placeholder="Masukkan nama penerbit"
                            required
                        >
                    </div>


                    <div class="mb-3">
                        <label class="form-label">
                            Tahun Terbit
                        </label>

                        <input
                            type="number"
                            name="tahun_terbit"
                            class="form-control"
                            placeholder="Contoh: 2024"
                            required
                        >
                    </div>


                    <div class="mb-3">
                        <label class="form-label">
                            Stok
                        </label>

                        <input
                            type="number"
                            name="stok"
                            class="form-control"
                            placeholder="Masukkan jumlah stok"
                            min="0"
                            required
                        >
                    </div>


                    <div class="mb-4">
                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select"
                            required
                        >
                            <option value="tersedia">
                                Tersedia
                            </option>

                            <option value="tidak tersedia">
                                Tidak Tersedia
                            </option>
                        </select>
                    </div>


                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-pink"
                        >
                            Simpan Buku
                        </button>

                        <a
                            href="/library/public/admin/buku"
                            class="btn btn-outline-secondary"
                        >
                            Batal
                        </a>

                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>