<?php

require_once __DIR__ . '/../Repositories/BukuRepository.php';

class BukuService
{
    private BukuRepository $bukuRepository;

    public function __construct(BukuRepository $bukuRepository)
    {
        $this->bukuRepository = $bukuRepository;
    }

    public function hapus(int $id): void
    {
        $buku = $this->bukuRepository->find($id);

        if (!$buku) {
            throw new Exception(
                "Data buku tidak ditemukan."
            );
        }

        if ($this->bukuRepository->hasPeminjaman($id)) {
            throw new Exception(
                "Buku tidak dapat dihapus karena memiliki transaksi peminjaman."
            );
        }

        $this->bukuRepository->delete($id);
    }
}