<?php

require_once __DIR__ . '/../../Repositories/BukuRepository.php';

class UserBukuController
{
    private BukuRepository $repository;

    public function __construct(PDO $pdo)
    {
        $this->repository = new BukuRepository($pdo);
    }

    public function index(): void
    {
        $keyword = trim($_GET['search'] ?? '');

        $buku = $keyword !== ''
            ? $this->repository->search($keyword)
            : $this->repository->all();

        require __DIR__ . '/../../../views/user/buku/index.php';
    }
}
