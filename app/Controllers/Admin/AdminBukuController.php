<?php

require_once __DIR__ . '/../../Repositories/BukuRepository.php';
require_once __DIR__ . '/../../Services/BukuService.php';

class AdminBukuController
{
    private BukuRepository $repository;
    private BukuService $service;

    public function __construct(PDO $pdo)
{
    $this->repository = new BukuRepository($pdo);

    $this->service = new BukuService(
        $this->repository
    );
}

    public function index(): void
    {
        $keyword = trim($_GET['search'] ?? '');

        if ($keyword !== '') {
            $buku = $this->repository->search($keyword);
        } else {
            $buku = $this->repository->all();
        }

        require __DIR__ . '/../../../views/admin/buku/index.php';
    }
    
    public function create(): void
    {
        require __DIR__ . '/../../../views/admin/buku/create.php';
    }

    public function store(): void
    {
        $data = [
            'judul' => $_POST['judul'],
            'penulis' => $_POST['penulis'],
            'penerbit' => $_POST['penerbit'],
            'tahun_terbit' => $_POST['tahun_terbit'],
            'stok' => $_POST['stok'],
            'status' => $_POST['status']
        ];

        $this->repository->create($data);

        $_SESSION['success'] = 'Data buku berhasil ditambahkan.';

        header('Location: /library/public/admin/buku');
        exit;
    }

    public function edit(int $id): void
    {
        $buku = $this->repository->find($id);

        if (!$buku) {
            die('Data buku tidak ditemukan.');
        }

        require __DIR__ . '/../../../views/admin/buku/edit.php';
    }

    public function update(int $id): void
    {
        $data = [
            'judul' => $_POST['judul'],
            'penulis' => $_POST['penulis'],
            'penerbit' => $_POST['penerbit'],
            'tahun_terbit' => $_POST['tahun_terbit'],
            'stok' => $_POST['stok'],
            'status' => $_POST['status']
        ];

        $this->repository->update($id, $data);

        $_SESSION['success'] = 'Data buku berhasil diperbarui.';

        header('Location: /library/public/admin/buku');
        exit;
    }

    public function delete(int $id): void
    {
        try {

            $this->service->hapus($id);

            header(
                'Location: /library/public/admin/buku?deleted=1'
            );
            exit;

        } catch (Exception $e) {

            $error = $e->getMessage();

            $keyword = $_GET['search'] ?? '';

            if ($keyword !== '') {
                $buku = $this->repository->search($keyword);
            } else {
                $buku = $this->repository->all();
            }

            require __DIR__ . '/../../../views/admin/buku/index.php';
        }
    }
}