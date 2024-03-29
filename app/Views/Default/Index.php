<?= $this->extend('Template/Template'); ?>

<?= $this->section('content'); ?>
<?php

use CodeIgniter\I18n\Time; ?>

<div class="container">
    <?php if (!empty($galeri)) : ?>
        <div class="row mx-4" style="margin-bottom: 5px;">
            <div id="carouselGaleriDispertapaHorbun" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php $no = 0;
                    foreach ($galeri as $g) : ?>
                        <li data-target="#carouselGaleriDispertapaHorbun" data-slide-to="<?= $no; ?>" <?= $no == 0 ? 'class="active"' : ''; ?>></li>
                    <?php $no++;
                    endforeach; ?>
                </ol>
                <div class="carousel-inner text-center" style=" width:100%; height: auto !important;">
                    <?php $no = 1;
                    foreach ($galeri as $g) : ?>
                        <div class="carousel-item imgcontainer <?= $no == 1 ? "active" : ""; ?>">
                            <img class="img-fluid w-100" src="<?= base_url('assets/img/slide') . '/' . $g['nama_gambar']; ?>" alt="slide <?= $no; ?>">
                            <div class="centered">
                                <h2 style="font-size: 4vmin;"><?= $greetings; ?></h2>
                            </div>
                        </div>
                    <?php $no++;
                    endforeach; ?>
                </div>
                <a class="carousel-control-prev" href="#carouselGaleriDispertapaHorbun" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselGaleriDispertapaHorbun" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    <?php endif; ?>
    <div class="row mx-4" style="padding-top: 20px; margin-bottom: 10px;">
        <div class="col">
            <?php if (session('message')) { ?>
                <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
            <?php } ?>
            <?php if (!$artikel && isset($_GET['search'])) :; ?>
                <div class="row section-heading">
                    <div class="col">
                        <hgroup class="mr-auto" style="width: fit-content;">
                            <h5>Maaf, Artikel tidak ditemukan...</h6>
                                <h6>Cobalah mengganti keyword yang lain</h6>
                        </hgroup>
                        <form id="searchForm" action="<?= route_to('home'); ?>" method="get">
                            <div style="float: right;">
                                <div class="input-group w-auto">
                                    <input type="text" class="form-control" placeholder="Masukan pencarian" aria-label="Recipient's username" name="search" id="search">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary ml-0 my-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php elseif (!$artikel && !(isset($_GET['search']))) : ?>
                <div class="row section-heading">
                    <div class="col">
                        <hgroup>
                            <h5>Maaf, Website ini belum memiliki artikel</h6>
                                <h6>Jika anda adalah admin, silahkan membuat / publikasikan artikel pada dashboard admin</h6>
                        </hgroup>
                    </div>
                </div>
            <?php else : ?>
                <div class="section-heading row">
                    <?php if (isset($_GET['search'])) : ?>
                        <h5 class="mr-auto">Pencarian: <?= $_GET['search']; ?></h5>
                    <?php else : ?>
                        <h5 class="mr-auto">Artikel Terbaru</h5>
                    <?php endif; ?>
                    <form id="searchForm" action="<?= route_to('home'); ?>" method="get">
                        <div style="float: right;">
                            <div class="input-group w-auto">
                                <input type="text" class="form-control" placeholder="Masukan pencarian" aria-label="Recipient's username" name="search" id="search">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary ml-0 my-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
            <?php foreach ($artikel as $a) : ?>
                <a style="color: inherit; text-decoration: none;" href="<?= route_to('detail.artikel', $a['slug']); ?>">
                    <div class="row mb-2">
                        <div class="card col-sm-12">
                            <div class="row card-body">
                                <img class="col-sm-3 mb-2 thumbimage w-100" src="<?= base_url('assets/artikel/img/' . $a['id_artikel'] . '/' . $a['link_gambar']); ?>" alt="<?= $a['slug']; ?>" />
                                <div class="col-sm-9">
                                    <h5 class="card-title"><?= $a['judul_artikel']; ?></h5>
                                    <p class="card-text section-heading">
                                        <span><cite><small><?= Time::parse($a['created_at'])->toLocalizedString('d MMMM yyyy'); ?> | Kategori: <?= $a['nama_kategori']; ?> | By: <?= $a['nama_user']; ?></small></cite></span>
                                    <p>
                                        <?= substr(strip_tags($a['isi_artikel']), 0, 130) . '... '; ?><br><strong>Read More</strong>
                                    </p>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row mx-2">
        <div class="col">
            <?= $pager->links('bootstrap', 'bootstrap_pagination') ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>