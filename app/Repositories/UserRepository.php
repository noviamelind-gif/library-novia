<?php

class UserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Semua anggota dari tabel `anggota`, terbaru di atas
    public function allAnggota(): array
    {
        $sql = "
            SELECT id, nim, nama
            FROM anggota
            ORDER BY id DESC
        ";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // NIM yang tersimpan permanen untuk akun user (null jika belum ada)
    public function findNimByUserId(int $userId): ?string
    {
        $stmt = $this->pdo->prepare("SELECT nim FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);

        $nim = $stmt->fetchColumn();

        return ($nim !== false && $nim !== null && $nim !== '') ? (string) $nim : null;
    }

    // Apakah NIM sudah dipakai akun user lain?
    public function nimDipakaiUserLain(string $nim, int $userId): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM users WHERE nim = :nim AND id <> :id"
        );
        $stmt->execute(['nim' => $nim, 'id' => $userId]);

        return (int) $stmt->fetchColumn() > 0;
    }

    // Simpan NIM ke akun user + pastikan tercatat di tabel `anggota`
    public function simpanNim(int $userId, string $nama, string $nim): void
    {
        $stmt = $this->pdo->prepare("UPDATE users SET nim = :nim WHERE id = :id");
        $stmt->execute(['nim' => $nim, 'id' => $userId]);

        $stmt = $this->pdo->prepare(
            "INSERT IGNORE INTO anggota (nim, nama) VALUES (:nim, :nama)"
        );
        $stmt->execute(['nim' => $nim, 'nama' => $nama]);
    }
}
