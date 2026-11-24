
<?php

interface KontrakPresenterDepartemen {

    public function tampilkanDepartemen(): string;

    public function tampilkanFormDepartemen(?int $id = null): string;

    public function tambahDepartemen(
        string $namaDepartemen,
        string $deskripsi,
        string $lokasi
    ): void;

    public function ubahDepartemen(
        int $id,
        string $namaDepartemen,
        string $deskripsi,
        string $lokasi
    ): void;

    public function hapusDepartemen(int $id): void;
}
?>
