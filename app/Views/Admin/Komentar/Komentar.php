<?php

use CodeIgniter\I18n\Time; ?>
<div class="row mb-2">
    <div style="width: 1px; background-color: gray">
    </div>
    <div class="col" id="komentarSection">
        <h6><?= $komentar['nama_komentar']; ?></h6>
        <cite><small><?= Time::parse($komentar['created_at'])->toLocalizedString('d MMM yyyy / hh:mm:ss'); ?></small></cite>
        <p><?= $komentar['isi_komentar']; ?></p>
    </div>
    <div style="width: max-content;">
        <a class="btn btn-outline-info komentarEdit" data-toggle="modal" data-target="#KomentarEdit" data-id="<?= $komentar['id_komentar']; ?>"><i class="fa fa-pencil"></i> Edit</a>
        <a class="btn btn-outline-danger komentarDelete" data-id="<?= $komentar['id_komentar']; ?>"><i class="fa fa-trash-o"></i> Delete</a>
    </div>
</div>