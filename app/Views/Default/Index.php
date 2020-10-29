<?= $this->extend('Template/Template'); ?>

<?= $this->section('content'); ?>
<?php

use CodeIgniter\I18n\Time; ?>

<div class="container">
    <div class="row mx-4" style="padding-top: 20px; padding-bottom: 20px; margin-bottom: 10px;">
        <div class="col">
            <?php if (session('message')) { ?>
                <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
            <?php } ?>
            <?php if (!$artikel && isset($_GET['search'])) :; ?>
                <div class="row section-heading">
                    <div class="col">
                        <hgroup>
                            <h5>Maaf, Artikel tidak ditemukan...</h6>
                                <h6>Cobalah mengganti keyword yang lain</h6>
                        </hgroup>
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
                        <h5>Pencarian: <?= $_GET['search']; ?></h5>
                    <?php else : ?>
                        <h5>Artikel Terbaru</h5>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php foreach ($artikel as $a) : ?>
                <a style="color: inherit; text-decoration: none;" href="<?= route_to('detail.artikel', $a['slug']); ?>">
                    <div class="row border border-dark shadow-sm" style="padding-top: 10px; padding-bottom: 10px; margin-bottom: 10px; height:auto; background-color: #fff;">
                        <div class="col-sm-auto d-block">
                            <img src="<?= base_url('assets/artikel/img/' . $a['id_artikel'] . '/' . $a['link_gambar']); ?>" class="thumbimage">
                        </div>
                        <div class="col d-block ml-3 ml-sm-0 ml-lg-0 section-heading">
                            <span>
                                <h6><?= $a['judul_artikel']; ?></h6><cite><small><?= Time::parse($a['created_at'])->toLocalizedString('d MMMM yyyy'); ?> | Kategori: <?= $a['nama_kategori']; ?> | By: <?= $a['nama_user']; ?></small></cite>
                            </span>
                            <p><?= substr(strip_tags($a['isi_artikel']), 0, 130) . '... '; ?><br><strong>Read More</strong></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>