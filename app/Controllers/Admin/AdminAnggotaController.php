<?php

require_once __DIR__ . '/../../Repositories/UserRepository.php';

class AdminAnggotaController
{
    private UserRepository $repository;

    public function __construct(PDO $pdo)
    {
        $this->repository = new UserRepository($pdo);
    }

    public function index(): void
    {
        $anggota = $this->repository->allAnggota();

        require __DIR__ . '/../../../views/admin/anggota/index.php';
    }
}
