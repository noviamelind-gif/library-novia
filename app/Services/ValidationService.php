<?php

class ValidationService
{
    public static function validateNim(string $nim): void
    {
        if (trim($nim) === '') {
            throw new InvalidArgumentException(
                "NIM wajib diisi."
            );
        }

        if (!preg_match('/^[0-9]+$/', $nim)) {
            throw new InvalidArgumentException(
                "NIM hanya boleh berisi angka."
            );
        }
    }

    public static function validateBukuId($bukuId): void
    {
        if (!filter_var(
            $bukuId,
            FILTER_VALIDATE_INT
        ) || $bukuId <= 0) {

            throw new InvalidArgumentException(
                "ID Buku tidak valid."
            );
        }
    }

    public static function validateTanggal(
        string $tanggal,
        string $namaField
    ): void {

        $date = DateTime::createFromFormat(
            'Y-m-d',
            $tanggal
        );

        if (
            !$date ||
            $date->format('Y-m-d') !== $tanggal
        ) {

            throw new InvalidArgumentException(
                "$namaField tidak valid."
            );
        }
    }

    public static function validateTanggalKembali(
        string $tanggalPinjam,
        string $tanggalKembali
    ): void {

        self::validateTanggal(
            $tanggalKembali,
            'Tanggal pengembalian'
        );

        if ($tanggalKembali < $tanggalPinjam) {

            throw new InvalidArgumentException(
                "Tanggal pengembalian tidak boleh sebelum tanggal peminjaman."
            );
        }
    }
}