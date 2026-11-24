
<?php

interface KontrakViewDepartemen {

    public function renderDaftar(
        string $rowsHtml,
        int $total
    ): string;

    public function renderForm(
        string $judul,
        string $action,
        array $data = []
    ): string;
}
?>
