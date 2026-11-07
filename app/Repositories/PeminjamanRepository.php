<?php

class PeminjamanRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function all(): array
    {
        $sql = "
            SELECT
                p.*,
                b.judul
            FROM peminjaman p
            JOIN buku b ON p.buku_id = b.id
            ORDER BY p.id DESC
        ";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "
            SELECT *
            FROM peminjaman
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ?: null;
    }

    public function countAktifByNim(string $nim): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM peminjaman
            WHERE nim = :nim
            AND status_peminjaman = 'dipinjam'
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'nim' => $nim
        ]);

        return (int) $stmt->fetchColumn();
    }

    public function create(array $data): bool
    {
        $sql = "
            INSERT INTO peminjaman
            (
                nim,
                buku_id,
                tanggal_pinjam,
                status_peminjaman
            )
            VALUES
            (
                :nim,
                :buku_id,
                :tanggal_pinjam,
                :status_peminjaman
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nim' => $data['nim'],
            'buku_id' => $data['buku_id'],
            'tanggal_pinjam' => $data['tanggal_pinjam'],
            'status_peminjaman' => $data['status_peminjaman']
        ]);
    }

    public function allAktif(): array
    {
        $sql = "
            SELECT
                p.*,
                b.judul
            FROM peminjaman p
            JOIN buku b ON p.buku_id = b.id
            WHERE p.status_peminjaman = 'dipinjam'
            ORDER BY p.id DESC
        ";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function returnBook(
        int $id,
        string $tanggalKembali
    ): bool {

        $sql = "
            UPDATE peminjaman
            SET
                tanggal_kembali = :tanggal_kembali,
                status_peminjaman = 'dikembalikan'
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'tanggal_kembali' => $tanggalKembali
        ]);
    }

    public function findWithBook(int $id): ?array
    {
        $sql = "
            SELECT
                p.*,
                b.judul
            FROM peminjaman p
            JOIN buku b ON p.buku_id = b.id
            WHERE p.id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ?: null;
    }

    public function totalDipinjam(): int
{
    $sql = "
        SELECT COUNT(*)
        FROM peminjaman
        WHERE status_peminjaman = 'dipinjam'
    ";

    return (int) $this->pdo->query($sql)->fetchColumn();
    }

    public function laporanPeminjaman(): array
    {
        $sql = "
            SELECT
                p.nim,
                b.judul,
                p.tanggal_pinjam
            FROM peminjaman p
            JOIN buku b ON p.buku_id = b.id
            ORDER BY p.tanggal_pinjam DESC, p.id DESC
        ";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allByNim(string $nim): array
    {
        $sql = "
            SELECT p.*, b.judul
            FROM peminjaman p
            JOIN buku b ON p.buku_id = b.id
            WHERE p.nim = :nim
            ORDER BY p.id DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nim' => $nim]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allAktifByNim(string $nim): array
    {
        $sql = "
            SELECT p.*, b.judul
            FROM peminjaman p
            JOIN buku b ON p.buku_id = b.id
            WHERE p.nim = :nim
            AND p.status_peminjaman = 'dipinjam'
            ORDER BY p.id DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nim' => $nim]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
