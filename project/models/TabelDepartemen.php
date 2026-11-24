
<?php

require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/KontrakModelDepartemen.php';

class TabelDepartemen extends DB implements KontrakModelDepartemen {

    public function __construct(
        string $host = "localhost",
        string $db_name = "mvp_kandidat_db",
        string $username = "root",
        string $password = ""
    ) {
        parent::__construct($host, $db_name, $username, $password);
    }

    private function mapRowToDepartemen(array $row): Departemen {
        return new Departemen(
            (int)$row['id'],
            $row['nama_departemen'],
            $row['deskripsi'],
            $row['lokasi']
        );
    }

    // READ: Mengambil seluruh departemen
    public function getAllDepartemen(): array {
        $query = "SELECT * FROM departemen ORDER BY id ASC";

        $this->executeQuery($query);
        $rows = $this->getAllResult();

        $list = [];

        foreach ($rows as $row) {
            $list[] = $this->mapRowToDepartemen($row);
        }

        return $list;
    }

    // READ: Mengambil departemen berdasarkan ID
    public function getDepartemenById(int $id): ?Departemen {
        $query = "SELECT * FROM departemen
                  WHERE id = :id LIMIT 1";

        $this->executeQuery($query, [
            ':id' => $id
        ]);

        $rows = $this->getAllResult();

        if (empty($rows)) {
            return null;
        }

        return $this->mapRowToDepartemen($rows[0]);
    }

    // CREATE: Menambahkan departemen
    public function addDepartemen(
        string $namaDepartemen,
        string $deskripsi,
        string $lokasi
    ): void {
        $query = "INSERT INTO departemen
                  (nama_departemen, deskripsi, lokasi)
                  VALUES
                  (:nama, :deskripsi, :lokasi)";

        $this->executeQuery($query, [
            ':nama' => $namaDepartemen,
            ':deskripsi' => $deskripsi,
            ':lokasi' => $lokasi
        ]);
    }

    // UPDATE: Memperbarui departemen
    public function updateDepartemen(
        int $id,
        string $namaDepartemen,
        string $deskripsi,
        string $lokasi
    ): void {
        $query = "UPDATE departemen SET
                  nama_departemen = :nama,
                  deskripsi = :deskripsi,
                  lokasi = :lokasi
                  WHERE id = :id";

        $this->executeQuery($query, [
            ':id' => $id,
            ':nama' => $namaDepartemen,
            ':deskripsi' => $deskripsi,
            ':lokasi' => $lokasi
        ]);
    }

    // DELETE: Menghapus departemen
    public function deleteDepartemen(int $id): void {
        $query = "DELETE FROM departemen WHERE id = :id";

        $this->executeQuery($query, [
            ':id' => $id
        ]);
    }
}
?>
