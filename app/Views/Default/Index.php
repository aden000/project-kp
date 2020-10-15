<?= $this->extend('Template/Template'); ?>

<?= $this->section('content'); ?>
<?php

use CodeIgniter\I18n\Time; ?>

<div class="row mx-4" style="padding-top: 20px; padding-bottom: 20px; margin-bottom: 10px;">
    <div class="col">
        <?php if (session('message')) { ?>
            <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
        <?php } ?>
        <?php if (!$artikel) :; ?>
            <h6 class="text-center">Maaf, Artikel tidak ditemukan...</h6>
            <p class="text-center">Cobalah mengganti keyword yang lain</p>
        <?php endif; ?>
        <?php foreach ($artikel as $a) : ?>
            <a style="color: inherit; text-decoration: none;" href="<?= route_to('detail.artikel', $a['slug']); ?>">
                <div class="row border border-dark shadow-sm" style="padding-top: 10px; padding-bottom: 10px; margin-bottom: 10px; height:auto; background-color: #fff;">
                    <div class="col-sm-auto">
                        <img src="<?= base_url('assets/artikel/img/' . $a['id_artikel'] . '/' . $a['link_gambar']); ?>" class="thumbimage">
                    </div>
                    <div class="col d-block">
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
<?= $this->endSection(); ?>