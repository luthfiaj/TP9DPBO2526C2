
<?php

require_once __DIR__ . '/KontrakViewDepartemen.php';

class ViewDepartemen implements KontrakViewDepartemen {

    // READ: Menampilkan daftar departemen
    public function renderDaftar(
        string $rowsHtml,
        int $total
    ): string {

        return <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Departemen</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #2563eb;
            color: white;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }

        .btn-add {
            background: #2563eb;
        }

        .btn-edit {
            background: #16a34a;
        }

        .btn-delete {
            background: #dc2626;
        }

        .btn-back {
            background: #64748b;
        }
    </style>
</head>

<body>
<div class="container">

    <h2>Manajemen Departemen</h2>

    <p>Total Departemen: {$total}</p>

    <a href="departemen.php?screen=add" class="btn btn-add">
        + Tambah Departemen
    </a>

    <a href="index.php" class="btn btn-back">
        Kembali ke Kandidat
    </a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Departemen</th>
                <th>Deskripsi</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            {$rowsHtml}
        </tbody>
    </table>

</div>
</body>
</html>
HTML;
    }

    // CREATE dan UPDATE: Menampilkan form
    public function renderForm(
        string $judul,
        string $action,
        array $data = []
    ): string {

        $judul = htmlspecialchars($judul, ENT_QUOTES, 'UTF-8');

        $nama = htmlspecialchars(
            (string)($data['nama_departemen'] ?? ''),
            ENT_QUOTES,
            'UTF-8'
        );

        $deskripsi = htmlspecialchars(
            (string)($data['deskripsi'] ?? ''),
            ENT_QUOTES,
            'UTF-8'
        );

        $lokasi = htmlspecialchars(
            (string)($data['lokasi'] ?? ''),
            ENT_QUOTES,
            'UTF-8'
        );

        $action = htmlspecialchars($action, ENT_QUOTES, 'UTF-8');

        $hiddenId = '';

        if (isset($data['id'])) {
            $id = (int)$data['id'];
            $hiddenId = "<input type='hidden' name='id' value='{$id}'>";
        }

        return <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$judul}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0 18px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            min-height: 100px;
        }

        button, a {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        button {
            background: #2563eb;
        }

        .back {
            background: #64748b;
        }
    </style>
</head>

<body>
<div class="container">

    <h2>{$judul}</h2>

    <form method="POST" action="departemen.php">

        <input type="hidden" name="action" value="{$action}">

        {$hiddenId}

        <label>Nama Departemen</label>
        <input
            type="text"
            name="nama_departemen"
            value="{$nama}"
            maxlength="100"
            required
        >

        <label>Deskripsi</label>
        <textarea name="deskripsi" required>{$deskripsi}</textarea>

        <label>Lokasi</label>
        <input
            type="text"
            name="lokasi"
            value="{$lokasi}"
            maxlength="100"
            required
        >

        <button type="submit">Simpan</button>

        <a href="departemen.php" class="back">Kembali</a>

    </form>

</div>
</body>
</html>
HTML;
    }
}
?>
