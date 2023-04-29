<?php

use App\Core\Request;
use App\Core\View;
use App\Helpers\URL;

?>
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div>Buat Baru Data Kategori</div>
                    <div>
                        <a href="<?= URL::path('/categories') ?>" class="btn btn-sm btn-danger fw-bold">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <?php if (!empty($errors)) : ?>
                        <div class="alert alert-danger">
                            <ul class="m-0">
                                <?php foreach ($errors as $error) : ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="-" value="<?= request()->post('nama') ?>">
                        <label for="nama">Nama Kategori</label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary fw-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>