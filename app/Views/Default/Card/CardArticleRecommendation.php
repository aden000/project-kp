<?php

use CodeIgniter\I18n\Time; ?>
<a style="color: inherit; text-decoration: none;" href="<?= route_to('detail.artikel', $r['slug']); ?>">
    <!-- <div class="row border border-dark shadow-sm m-lg-2 p-2" style="margin-bottom: 10px; height:auto; background-color: #fff;">
        <div class="col-sm-auto d-block">
            <img src="<?= base_url('assets/artikel/img/' . $r['id_artikel'] . '/' . $r['link_gambar']); ?>" style="max-width: 100%; height: auto;">
        </div>
        <div class="col d-block ml-3 ml-sm-0 ml-lg-0  section-heading">
            <span>
                <h6><?= $r['judul_artikel']; ?></h6><cite><small><?= Time::parse($r['created_at'])->toLocalizedString('d MMMM yyyy'); ?> | Kategori: <?= $r['nama_kategori']; ?> | By: <?= $r['nama_user']; ?></small></cite>
            </span>
            <p><?= substr(strip_tags($r['isi_artikel']), 0, 50) . '... '; ?><br><strong>Read More</strong></p>
        </div>
    </div> -->
    <div class="card row m-lg-2 p-2 mb-2">
        <img class="card-img-top img-fluid w-100 thumbimage" src="<?= base_url('assets/artikel/img/' . $r['id_artikel'] . '/' . $r['link_gambar']); ?>" alt="Card image cap">
        <div class="card-body section-heading">
            <h5 class="card-title"><?= $r['judul_artikel']; ?></h5>
            <cite><small><?= Time::parse($r['created_at'])->toLocalizedString('d MMMM yyyy'); ?> | Kategori: <?= $r['nama_kategori']; ?> | By: <?= $r['nama_user']; ?></small></cite>
            <p class="card-text">
                <?= substr(strip_tags($r['isi_artikel']), 0, 50) . '... '; ?><br><strong>Read More</strong>
            </p>
        </div>
    </div>
</a>