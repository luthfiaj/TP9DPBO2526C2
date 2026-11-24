
<?php

class Departemen {
    private int $id;
    private string $namaDepartemen;
    private string $deskripsi;
    private string $lokasi;

    public function __construct(
        int $id,
        string $namaDepartemen,
        string $deskripsi,
        string $lokasi
    ) {
        $this->id = $id;
        $this->namaDepartemen = $namaDepartemen;
        $this->deskripsi = $deskripsi;
        $this->lokasi = $lokasi;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNamaDepartemen(): string {
        return $this->namaDepartemen;
    }

    public function getDeskripsi(): string {
        return $this->deskripsi;
    }

    public function getLokasi(): string {
        return $this->lokasi;
    }
}
?>
