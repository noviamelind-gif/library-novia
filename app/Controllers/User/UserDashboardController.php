<?php

require_once __DIR__ . '/../../Repositories/BukuRepository.php';
require_once __DIR__ . '/../../Repositories/PeminjamanRepository.php';
require_once __DIR__ . '/../../Repositories/UserRepository.php';

class UserDashboardController
{
    private BukuRepository $bukuRepository;
    private PeminjamanRepository $peminjamanRepository;

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->bukuRepository = new BukuRepository($pdo);
        $this->peminjamanRepository = new PeminjamanRepository($pdo);
    }

    public function index(): void
    {
        $totalKoleksi = $this->bukuRepository->totalStok();
        $totalHabis   = $this->bukuRepository->totalHabis();

        if (empty($_SESSION['nim']) && isset($_SESSION['user']['id'])) {
            $nimDb = (new UserRepository($this->pdo))->findNimByUserId((int) $_SESSION['user']['id']);
            if ($nimDb !== null) {
                $_SESSION['nim'] = $nimDb;
            }
        }

        $nim = $_SESSION['nim'] ?? null;

        $pinjamanAktif = $nim
            ? $this->peminjamanRepository->allAktifByNim($nim)
            : [];

        $totalDipinjam = count($pinjamanAktif);

        require __DIR__ . '/../../../views/user/dashboard.php';
    }
}
