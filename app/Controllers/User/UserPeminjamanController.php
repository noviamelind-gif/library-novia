<?php

require_once __DIR__ . '/../../Repositories/BukuRepository.php';
require_once __DIR__ . '/../../Repositories/PeminjamanRepository.php';
require_once __DIR__ . '/../../Repositories/UserRepository.php';
require_once __DIR__ . '/../../Services/PeminjamanService.php';
require_once __DIR__ . '/../../Services/LoggingService.php';

class UserPeminjamanController
{
    private PeminjamanService $service;
    private PeminjamanRepository $peminjamanRepository;
    private BukuRepository $bukuRepository;
    private UserRepository $userRepository;

    public function __construct(PDO $pdo)
    {
        $this->userRepository = new UserRepository($pdo);
        $this->bukuRepository = new BukuRepository($pdo);
        $this->peminjamanRepository = new PeminjamanRepository($pdo);

        $this->service = new PeminjamanService(
            $this->bukuRepository,
            $this->peminjamanRepository,
            new LoggingService()
        );
    }

    // ---------------- PEMINJAMAN ----------------

    // Pastikan $_SESSION['nim'] terisi dari database (mis. sesi lama sebelum fix)
    private function syncNimSession(): void
    {
        if (empty($_SESSION['nim']) && isset($_SESSION['user']['id'])) {
            $nim = $this->userRepository->findNimByUserId((int) $_SESSION['user']['id']);
            if ($nim !== null) {
                $_SESSION['nim'] = $nim;
            }
        }
    }

    public function index(): void
    {
        $this->syncNimSession();

        $nim = $_SESSION['nim'] ?? '';

        $daftarBuku = $this->bukuRepository->all();

        $peminjaman = $nim !== ''
            ? $this->peminjamanRepository->allByNim($nim)
            : [];

        require __DIR__ . '/../../../views/user/peminjaman/index.php';
    }

    public function store(): void
    {
        $this->syncNimSession();

        // Jika NIM sudah tersimpan di akun, pakai itu (tidak bisa diganti-ganti)
        $nim = $_SESSION['nim'] ?? trim($_POST['nim'] ?? '');
        $userId = (int) $_SESSION['user']['id'];

        try {

            if (empty($_SESSION['nim']) && $this->userRepository->nimDipakaiUserLain($nim, $userId)) {
                throw new InvalidArgumentException("NIM sudah digunakan oleh akun lain.");
            }

            $this->service->pinjam(
                $nim,
                (int) ($_POST['buku_id'] ?? 0),
                $_POST['tanggal_pinjam'] ?? ''
            );

            // Simpan NIM permanen di akun (database), bukan hanya di sesi
            if (empty($_SESSION['nim'])) {
                $this->userRepository->simpanNim($userId, $_SESSION['user']['nama'], $nim);
            }

            $_SESSION['nim'] = $nim;

            header('Location: /library/public/user/peminjaman?success=1');
            exit;

        } catch (Exception $e) {

            $error = $e->getMessage();

            $daftarBuku = $this->bukuRepository->all();

            $peminjaman = ($_SESSION['nim'] ?? '') !== ''
                ? $this->peminjamanRepository->allByNim($_SESSION['nim'])
                : [];

            require __DIR__ . '/../../../views/user/peminjaman/index.php';
        }
    }

    // ---------------- PENGEMBALIAN ----------------

    public function pengembalian(?string $error = null): void
    {
        $this->syncNimSession();

        $nim = $_SESSION['nim'] ?? '';

        $peminjaman = $nim !== ''
            ? $this->peminjamanRepository->allAktifByNim($nim)
            : [];

        require __DIR__ . '/../../../views/user/peminjaman/pengembalian.php';
    }

    public function returnForm(int $id): void
    {
        $peminjaman = $this->findMilikSendiri($id);

        if (!$peminjaman) {
            $this->pengembalian('Transaksi peminjaman tidak ditemukan.');
            return;
        }

        if ($peminjaman['status_peminjaman'] !== 'dipinjam') {
            $this->pengembalian('Buku sudah dikembalikan.');
            return;
        }

        require __DIR__ . '/../../../views/user/peminjaman/return.php';
    }

    public function returnBook(int $id): void
    {
        $peminjaman = $this->findMilikSendiri($id);

        if (!$peminjaman) {
            $this->pengembalian('Transaksi peminjaman tidak ditemukan.');
            return;
        }

        try {

            $this->service->kembalikan(
                $id,
                $_POST['tanggal_kembali'] ?? ''
            );

            header('Location: /library/public/user/pengembalian?returned=1');
            exit;

        } catch (Exception $e) {

            $error = $e->getMessage();

            require __DIR__ . '/../../../views/user/peminjaman/return.php';
        }
    }

    // Pastikan transaksi benar-benar milik user yang login (berdasarkan NIM)
    private function findMilikSendiri(int $id): ?array
    {
        $nim = $_SESSION['nim'] ?? '';

        if ($nim === '') {
            return null;
        }

        $data = $this->peminjamanRepository->findWithBook($id);

        if (!$data || $data['nim'] !== $nim) {
            return null;
        }

        return $data;
    }
}
