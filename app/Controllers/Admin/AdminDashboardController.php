<?php

require_once __DIR__ . '/../../Repositories/BukuRepository.php';
require_once __DIR__ . '/../../Repositories/PeminjamanRepository.php';

class AdminDashboardController
{
    private BukuRepository $bukuRepository;
    private PeminjamanRepository $peminjamanRepository;

    public function __construct(PDO $pdo)
    {
        $this->bukuRepository = new BukuRepository($pdo);
        $this->peminjamanRepository = new PeminjamanRepository($pdo);
    }

    public function index(): void
    {
        $totalKoleksi = $this->bukuRepository->totalStok();

        $totalDipinjam =
            $this->peminjamanRepository->totalDipinjam();

        $totalHabis =
            $this->bukuRepository->totalHabis();

        $laporanPeminjaman =
            $this->peminjamanRepository->laporanPeminjaman();

        require __DIR__ . '/../../../views/admin/dashboard.php';
    }
}