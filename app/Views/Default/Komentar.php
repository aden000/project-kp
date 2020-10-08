<?php

use CodeIgniter\I18n\Time; ?>
<div class="row mb-2">
    <div style="width: 1px; background-color: gray">
    </div>
    <div class="col" id="komentarSection">
        <h6><?= $komentar['nama_komentar']; ?></h6>
        <cite><small><?= Time::parse($komentar['created_at'])->toLocalizedString('d MMM yyyy / hh:mm:ss'); ?></small></cite>
        <p><?= $komentar['isi_komentar']; ?></p>
        <a class="reply badge badge-primary" href="#formKomentar" id="<?= $komentar['id_komentar']; ?>">Balas</a>
    </div>
</div>