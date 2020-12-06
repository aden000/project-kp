<?= $this->extend('Template/TemplateAdmin'); ?>
<?= $this->section('content'); ?>
<?php if (session('message')) : ?>
    <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
<?php endif; ?>
<div class="row mx-3 my-4">
    <div class="col shadow-sm border border-dark pt-2 pb-2">
        <h4 class="mb-3"><i class="fa fa-user"></i> Selamat datang, <?= $user['nama_user']; ?></h4>
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h3 class="card-title"><?= count($allArtikel); ?></h3>
                        <p class="card-text">Artikel yang telah dibuat</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h3 class="card-title"><?= count($pubArtikel); ?></h3>
                        <p class="card-text">Artikel yang telah dipublikasikan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <h3 class="card-title"><?= count($allKategori); ?></h3>
                        <p class="card-text">Banyaknya kategori</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h3 class="card-title"><?= count($allGaleri); ?></h3>
                        <p class="card-text">Gambar pada slider galeri</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-md-2">
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h3 class="card-title"><?= count($allDokumen); ?></h3>
                        <p class="card-text">Total dokumen</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-dark">
                    <div class="card-body">
                        <h3 class="card-title"><?= count($totalUser); ?></h3>
                        <p class="card-text">Total user terdaftar</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-warning">
                    <div class="card-body">
                        <h3 class="card-title"><?= count($fullAccessUser); ?></h3>
                        <p class="card-text">User dengan role Full Akses</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h3 class="card-title"><?= count($postOnlyUser); ?></h3>
                        <p class="card-text">User dengan role Hanya Posting</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-md-2">
            <div class="col-md-3 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h3 class="card-title"><?= count($docOnlyUser); ?></h3>
                        <p class="card-text">User dengan role Hanya Dokumen</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>