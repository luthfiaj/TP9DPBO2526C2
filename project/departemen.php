
<?php

require_once __DIR__ . '/models/TabelDepartemen.php';
require_once __DIR__ . '/views/ViewDepartemen.php';
require_once __DIR__ . '/presenters/PresenterDepartemen.php';

// Dependency Injection
$model = new TabelDepartemen(
    'localhost',
    'mvp_kandidat_db',
    'root',
    ''
);

$view = new ViewDepartemen();

$presenter = new PresenterDepartemen(
    $model,
    $view
);

// Mengambil input string dengan aman
$postString = static function (string $key): string {
    $value = $_POST[$key] ?? '';

    return is_string($value) ? trim($value) : '';
};

// Menangani request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    try {

        if ($action === 'tambah') {

            $presenter->tambahDepartemen(
                $postString('nama_departemen'),
                $postString('deskripsi'),
                $postString('lokasi')
            );

        } elseif ($action === 'ubah') {

            $id = filter_var(
                $_POST['id'] ?? null,
                FILTER_VALIDATE_INT
            );

            if ($id === false || $id === null || $id <= 0) {
                throw new InvalidArgumentException("ID tidak valid.");
            }

            $presenter->ubahDepartemen(
                $id,
                $postString('nama_departemen'),
                $postString('deskripsi'),
                $postString('lokasi')
            );

        } elseif ($action === 'hapus') {

            $id = filter_var(
                $_POST['id'] ?? null,
                FILTER_VALIDATE_INT
            );

            if ($id === false || $id === null || $id <= 0) {
                throw new InvalidArgumentException("ID tidak valid.");
            }

            $presenter->hapusDepartemen($id);

        } else {

            header("Location: departemen.php");
            exit();
        }

    } catch (InvalidArgumentException $e) {

        http_response_code(422);

        echo "Input tidak valid: " .
             htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');

        echo "<br><a href='departemen.php'>Kembali</a>";

    } catch (Throwable $e) {

        error_log($e->getMessage());

        http_response_code(500);

        echo "Terjadi kesalahan pada sistem.";
        echo "<br><a href='departemen.php'>Kembali</a>";
    }

    exit();

} else {

    // Menangani request GET
    $screen = $_GET['screen'] ?? 'list';

    if ($screen === 'add') {

        echo $presenter->tampilkanFormDepartemen();

    } elseif ($screen === 'edit' && isset($_GET['id'])) {

        $id = filter_var(
            $_GET['id'],
            FILTER_VALIDATE_INT
        );

        if ($id === false || $id === null || $id <= 0) {
            header("Location: departemen.php");
            exit();
        }

        echo $presenter->tampilkanFormDepartemen($id);

    } else {

        echo $presenter->tampilkanDepartemen();
    }
}
?>
