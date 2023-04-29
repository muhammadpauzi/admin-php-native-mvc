<?php

use App\Core\View;
use App\Helpers\Date;
use App\Helpers\URL;

?>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div>Data Kategori</div>
                    <div>
                        <a href="<?= URL::path('/categories/create') ?>" class="btn btn-sm btn-primary fw-bold">Buat Baru</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <table id="datatable-simple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Created at</th>
                            <th data-sortable="false"></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Created at</th>
                            <th data-sortable="false"></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $no = 0;
                        ?>
                        <?php foreach ($categories as $category) : ?>
                            <tr>
                                <td><?= ++$no; ?></td>
                                <td><?= $category['nama']; ?></td>
                                <td><?= Date::format(date: $category['created_at']) ?></td>
                                <td>
                                    <a href="<?= URL::path('/categories/' . $category['id'] . '/edit') ?>" class="badge text-bg-primary border-0">edit</a>
                                    <form action="<?= URL::path("/categories/" . $category['id']) ?>" method="post" class="d-inline-block">
                                        <button class="badge text-bg-danger border-0">hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php View::loadSection('scripts'); ?>
<script>
    window.addEventListener('DOMContentLoaded', event => {
        // Simple-DataTables
        // https://github.com/fiduswriter/Simple-DataTables/wiki

        const datatablesSimple = document.getElementById('datatable-simple');
        if (datatablesSimple) {
            new simpleDatatables.DataTable(datatablesSimple);
        }
    });
</script>
<?php View::endSection(); ?>