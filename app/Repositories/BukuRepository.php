<?php

class BukuRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function all(): array
    {
        $sql = "SELECT * FROM buku ORDER BY id DESC";

        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM buku WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        $buku = $stmt->fetch(PDO::FETCH_ASSOC);

        return $buku ?: null;
    }

    public function create(array $data): bool
    {
        $sql = "
            INSERT INTO buku
            (judul, penulis, penerbit, tahun_terbit, stok, status)
            VALUES
            (:judul, :penulis, :penerbit, :tahun_terbit, :stok, :status)
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'judul' => $data['judul'],
            'penulis' => $data['penulis'],
            'penerbit' => $data['penerbit'],
            'tahun_terbit' => $data['tahun_terbit'],
            'stok' => $data['stok'],
            'status' => $data['status']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "
            UPDATE buku SET
                judul = :judul,
                penulis = :penulis,
                penerbit = :penerbit,
                tahun_terbit = :tahun_terbit,
                stok = :stok,
                status = :status
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'judul' => $data['judul'],
            'penulis' => $data['penulis'],
            'penerbit' => $data['penerbit'],
            'tahun_terbit' => $data['tahun_terbit'],
            'stok' => $data['stok'],
            'status' => $data['status']
        ]);
    }

    public function updateStok(int $id, int $stok): bool
    {
        $sql = "
            UPDATE buku
            SET stok = :stok
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'stok' => $stok
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM buku WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    
    private array $kolomPencarian = [
        'id',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
        'status',
    ];

    public function search(string $keyword): array
    {
        $keyword = trim($keyword);

        if ($keyword === '') {
            return $this->all();
        }

        $kataKunci = preg_split('/\s+/', $keyword);

        $kondisi = [];
        $params  = [];

        foreach ($kataKunci as $i => $kata) {

            $param = 'kata' . $i;

            $perKolom = [];

            foreach ($this->kolomPencarian as $kolom) {
                $perKolom[] = "CAST($kolom AS CHAR) LIKE :$param";
            }

            $kondisi[] = '(' . implode(' OR ', $perKolom) . ')';

            $params[$param] = '%' . $kata . '%';
        }

        $sql = "
            SELECT *
            FROM buku
            WHERE " . implode(' AND ', $kondisi) . "
            ORDER BY id DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totalStok(): int
    {
        $sql = "SELECT COALESCE(SUM(stok), 0) FROM buku";
        return (int) $this->pdo->query($sql)->fetchColumn();
    }

    public function totalHabis(): int
    {
        $sql = "SELECT COUNT(*) FROM buku WHERE stok = 0";
        return (int) $this->pdo->query($sql)->fetchColumn();
    }

    public function hasPeminjaman(int $bukuId): bool
    {
        $sql = "
            SELECT COUNT(*)
            FROM peminjaman
            WHERE buku_id = :buku_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'buku_id' => $bukuId
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }
}