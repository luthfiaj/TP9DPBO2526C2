
<?php

require_once __DIR__ . '/Departemen.php';

interface KontrakModelDepartemen {

    public function getAllDepartemen(): array;

    public function getDepartemenById(int $id): ?Departemen;

    public function addDepartemen(
        string $namaDepartemen,
        string $deskripsi,
        string $lokasi
    ): void;

    public function updateDepartemen(
        int $id,
        string $namaDepartemen,
        string $deskripsi,
        string $lokasi
    ): void;

    public function deleteDepartemen(int $id): void;
}
?>
