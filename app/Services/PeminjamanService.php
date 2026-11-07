<?php

require_once __DIR__ . '/../Exceptions/BukuTidakTersediaException.php';
require_once __DIR__ . '/../Exceptions/BatasPeminjamanException.php';
require_once __DIR__ . '/../Exceptions/BukuTidakDitemukanException.php';
require_once __DIR__ . '/../Exceptions/PeminjamanTidakDitemukanException.php';

require_once __DIR__ . '/../Repositories/BukuRepository.php';
require_once __DIR__ . '/../Repositories/PeminjamanRepository.php';

require_once __DIR__ . '/ValidationService.php';
require_once __DIR__ . '/LoggingService.php';


class PeminjamanService
{
    private BukuRepository $bukuRepository;
    private PeminjamanRepository $peminjamanRepository;
    private LoggingService $loggingService;


    public function __construct(
    BukuRepository $bukuRepository,
    PeminjamanRepository $peminjamanRepository,
    LoggingService $loggingService
) {
    $this->bukuRepository = $bukuRepository;
    $this->peminjamanRepository = $peminjamanRepository;
    $this->loggingService = $loggingService;
}

    // Peminjaman Buku
    public function pinjam(
        string $nim,
        int $bukuId,
        string $tanggalPinjam
    ): void {

        // 1. Validasi NIM
        ValidationService::validateNim($nim);

        // 2. Validasi ID Buku
        ValidationService::validateBukuId($bukuId);

        // 3. Validasi tanggal peminjaman
        ValidationService::validateTanggal(
            $tanggalPinjam,
            'Tanggal peminjaman'
        );

        // 4. Cari buku
        $buku = $this->bukuRepository->find($bukuId);

        if (!$buku) {
            throw new BukuTidakDitemukanException(
                "Data buku tidak ditemukan."
            );
        }

        // 5. Cek stok buku
        if ($buku['stok'] <= 0) {
            throw new BukuTidakTersediaException(
                "Buku tidak tersedia."
            );
        }

        // 6. Cek jumlah buku yang sedang dipinjam mahasiswa
        $jumlahPinjaman =
            $this->peminjamanRepository->countAktifByNim($nim);

        if ($jumlahPinjaman >= 3) {
            throw new BatasPeminjamanException(
                "Mahasiswa telah mencapai batas maksimal peminjaman."
            );
        }

        // 7. Simpan transaksi peminjaman
        $this->peminjamanRepository->create([
            'nim' => $nim,
            'buku_id' => $bukuId,
            'tanggal_pinjam' => $tanggalPinjam,
            'status_peminjaman' => 'dipinjam'
        ]);

        // 8. Kurangi stok buku
        $this->bukuRepository->updateStok(
            $bukuId,
            $buku['stok'] - 1
        );

        // 9. Catat log
        $this->loggingService->log(
            "PEMINJAMAN - NIM: {$nim}, Buku ID: {$bukuId}"
        );
    }


    // Pengembalian Buku
    public function kembalikan(
        int $peminjamanId,
        string $tanggalKembali
    ): void {

        // 1. Validasi ID peminjaman
        if ($peminjamanId <= 0) {
            throw new InvalidArgumentException(
                "ID peminjaman tidak valid."
            );
        }

        // 2. Validasi tanggal pengembalian
        ValidationService::validateTanggal(
            $tanggalKembali,
            'Tanggal pengembalian'
        );

        // 3. Cari transaksi peminjaman
        $peminjaman =
            $this->peminjamanRepository->find($peminjamanId);

        if (!$peminjaman) {
            throw new PeminjamanTidakDitemukanException(
                "Transaksi peminjaman tidak ditemukan."
            );
        }

        // 4. Cek apakah transaksi masih berstatus dipinjam
        if ($peminjaman['status_peminjaman'] !== 'dipinjam') {
            throw new InvalidArgumentException(
                "Buku sudah dikembalikan."
            );
        }

        // 5. Validasi tanggal pengembalian
        ValidationService::validateTanggalKembali(
            $peminjaman['tanggal_pinjam'],
            $tanggalKembali
        );

        // 6. Cari buku
        $buku =
            $this->bukuRepository->find(
                $peminjaman['buku_id']
            );

        if (!$buku) {
            throw new BukuTidakDitemukanException(
                "Data buku tidak ditemukan."
            );
        }

        // 7. Update transaksi menjadi dikembalikan
        $this->peminjamanRepository->returnBook(
            $peminjamanId,
            $tanggalKembali
        );

        // 8. Tambah stok buku
        $this->bukuRepository->updateStok(
            $buku['id'],
            $buku['stok'] + 1
        );

        // 9. Catat log
        $this->loggingService->log(
            "PENGEMBALIAN - Peminjaman ID: {$peminjamanId}, Buku ID: {$buku['id']}"
        );
    }
}