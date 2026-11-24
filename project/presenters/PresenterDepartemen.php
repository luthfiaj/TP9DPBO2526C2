
<?php

require_once __DIR__ . '/KontrakPresenterDepartemen.php';
require_once __DIR__ . '/../models/KontrakModelDepartemen.php';
require_once __DIR__ . '/../models/Departemen.php';
require_once __DIR__ . '/../views/KontrakViewDepartemen.php';

class PresenterDepartemen implements KontrakPresenterDepartemen {

    private KontrakModelDepartemen $model;
    private KontrakViewDepartemen $view;

    public function __construct(
        KontrakModelDepartemen $model,
        KontrakViewDepartemen $view
    ) {
        $this->model = $model;
        $this->view = $view;
    }

    // Helper untuk membuat baris HTML
    private function buildRowHtml(
        int $no,
        Departemen $departemen
    ): string {

        $id = $departemen->getId();

        $nama = htmlspecialchars(
            $departemen->getNamaDepartemen(),
            ENT_QUOTES,
            'UTF-8'
        );

        $deskripsi = htmlspecialchars(
            $departemen->getDeskripsi(),
            ENT_QUOTES,
            'UTF-8'
        );

        $lokasi = htmlspecialchars(
            $departemen->getLokasi(),
            ENT_QUOTES,
            'UTF-8'
        );

        return "
        <tr>
            <td>{$no}</td>
            <td><strong>{$nama}</strong></td>
            <td>{$deskripsi}</td>
            <td>{$lokasi}</td>
            <td>
                <a href='departemen.php?screen=edit&id={$id}'
                   class='btn btn-edit'>
                    Edit
                </a>

                <form method='POST'
                      action='departemen.php'
                      style='display:inline;'
                      onsubmit=\"return confirm('Hapus departemen ini?')\">

                    <input type='hidden' name='action' value='hapus'>
                    <input type='hidden' name='id' value='{$id}'>

                    <button type='submit' class='btn btn-delete'>
                        Hapus
                    </button>
                </form>
            </td>
        </tr>";
    }

    // READ: Menampilkan seluruh departemen
    public function tampilkanDepartemen(): string {

        $listDepartemen = $this->model->getAllDepartemen();

        $totalDepartemen = count($listDepartemen);

        $rowsHtml = '';

        if (empty($listDepartemen)) {

            $rowsHtml = "
            <tr>
                <td colspan='5' style='text-align:center;'>
                    Belum ada data departemen.
                </td>
            </tr>";

        } else {

            $no = 1;

            foreach ($listDepartemen as $departemen) {
                $rowsHtml .= $this->buildRowHtml(
                    $no,
                    $departemen
                );

                $no++;
            }
        }

        return $this->view->renderDaftar(
            $rowsHtml,
            $totalDepartemen
        );
    }

    // Menampilkan form tambah atau edit
    public function tampilkanFormDepartemen(
        ?int $id = null
    ): string {

        if ($id !== null) {

            $departemen = $this->model->getDepartemenById($id);

            if ($departemen === null) {
                header("Location: departemen.php");
                exit();
            }

            $formData = [
                'id' => $departemen->getId(),
                'nama_departemen' => $departemen->getNamaDepartemen(),
                'deskripsi' => $departemen->getDeskripsi(),
                'lokasi' => $departemen->getLokasi()
            ];

            return $this->view->renderForm(
                "Ubah Data Departemen",
                "ubah",
                $formData
            );
        }

        return $this->view->renderForm(
            "Tambah Departemen",
            "tambah",
            []
        );
    }

    // CREATE
    public function tambahDepartemen(
        string $namaDepartemen,
        string $deskripsi,
        string $lokasi
    ): void {

        $this->validasiData(
            $namaDepartemen,
            $deskripsi,
            $lokasi
        );

        $this->model->addDepartemen(
            $namaDepartemen,
            $deskripsi,
            $lokasi
        );

        header("Location: departemen.php");
        exit();
    }

    // UPDATE
    public function ubahDepartemen(
        int $id,
        string $namaDepartemen,
        string $deskripsi,
        string $lokasi
    ): void {

        if ($id <= 0) {
            throw new InvalidArgumentException("ID tidak valid.");
        }

        $this->validasiData(
            $namaDepartemen,
            $deskripsi,
            $lokasi
        );

        $this->model->updateDepartemen(
            $id,
            $namaDepartemen,
            $deskripsi,
            $lokasi
        );

        header("Location: departemen.php");
        exit();
    }

    // DELETE
    public function hapusDepartemen(int $id): void {

        if ($id <= 0) {
            throw new InvalidArgumentException("ID tidak valid.");
        }

        $this->model->deleteDepartemen($id);

        header("Location: departemen.php");
        exit();
    }

    // Validasi input
    private function validasiData(
        string $nama,
        string $deskripsi,
        string $lokasi
    ): void {

        if (
            trim($nama) === '' ||
            trim($deskripsi) === '' ||
            trim($lokasi) === ''
        ) {
            throw new InvalidArgumentException(
                "Semua field wajib diisi."
            );
        }
    }
}
?>
