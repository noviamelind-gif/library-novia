<?php require __DIR__ . '/../../layouts/header.php'; ?>

<?php require __DIR__ . '/../../layouts/sidebar_admin.php'; ?>

<div class="main-content">

    <!-- HEADER -->
    <?php
    $topbarTitle    = 'Ubah data buku';
    $topbarSubtitle = 'Perbarui informasi buku yang sudah tersimpan';
    require __DIR__ . '/../../layouts/topbar.php';
    ?>


    <!-- CONTENT -->
    <div class="content">

        <!-- JUDUL -->
        <div class="mb-4">

            <div class="page-title">
                Edit Buku
            </div>

            <div class="page-description">
                Perbarui informasi buku perpustakaan 
            </div>

        </div>


        <!-- FORM CARD -->
        <div class="card">

            <div class="card-body p-4">

                <h5 class="mb-4">
                    Informasi Buku 
                </h5>


                <form
                    method="POST"
                    action="/library/public/admin/buku/<?= $buku['id'] ?>"
                >

                    <!-- JUDUL -->
                    <div class="mb-3">

                        <label class="form-label">
                            Judul Buku
                        </label>

                        <input
                            type="text"
                            name="judul"
                            class="form-control"
                            value="<?= htmlspecialchars($buku['judul']) ?>"
                            required
                        >

                    </div>


                    <!-- PENULIS -->
                    <div class="mb-3">

                        <label class="form-label">
                            Penulis
                        </label>

                        <input
                            type="text"
                            name="penulis"
                            class="form-control"
                            value="<?= htmlspecialchars($buku['penulis']) ?>"
                            required
                        >

                    </div>


                    <!-- PENERBIT -->
                    <div class="mb-3">

                        <label class="form-label">
                            Penerbit
                        </label>

                        <input
                            type="text"
                            name="penerbit"
                            class="form-control"
                            value="<?= htmlspecialchars($buku['penerbit']) ?>"
                            required
                        >

                    </div>


                    <div class="row">

                        <!-- TAHUN -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tahun Terbit
                            </label>

                            <input
                                type="number"
                                name="tahun_terbit"
                                class="form-control"
                                value="<?= htmlspecialchars($buku['tahun_terbit']) ?>"
                                required
                            >

                        </div>


                        <!-- STOK -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Stok
                            </label>

                            <input
                                type="number"
                                name="stok"
                                class="form-control"
                                min="0"
                                value="<?= htmlspecialchars($buku['stok']) ?>"
                                required
                            >

                        </div>

                    </div>


                    <!-- STATUS -->
                    <div class="mb-4">

                        <label class="form-label">
                            Status Buku
                        </label>

                        <select
                            name="status"
                            class="form-select"
                            required
                        >

                            <option
                                value="tersedia"
                                <?= $buku['status'] === 'tersedia' ? 'selected' : '' ?>
                            >
                                Tersedia
                            </option>

                            <option
                                value="tidak tersedia"
                                <?= $buku['status'] === 'tidak tersedia' ? 'selected' : '' ?>
                            >
                                Tidak tersedia
                            </option>

                        </select>

                    </div>


                    <!-- BUTTON -->
                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-pink"
                        >
                            Simpan Perubahan
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