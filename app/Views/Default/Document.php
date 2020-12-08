<?= $this->extend('Template/Template'); ?>

<?= $this->section('content'); ?>

<?php if (session('message')) : ?>
    <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
<?php endif; ?>

<div class="row mx-4">
    <div class="col col-lg-12" style="margin-top: 15px; margin-bottom: 15px">
        <div class="row section-heading">
            <h4>Dokumen Website</h4>
        </div>
    </div>
    <div class="col-10 shadow-sm border border-dark dokumen">
        <h4>Dokumen</h4>
        <div class="table-responsive">
            <table class="table table-hover table-sm" id="tabelArtikel">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Dokumen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $num = 1;
                    foreach ($doc as $g) : ?>
                        <tr>
                            <td scope="row" style="vertical-align: middle;"><?php echo $num++; ?></td>
                            <td style="vertical-align: middle;">
                                <?= $g['nama_dokumen'] ?>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="my-auto">
                                    <a target="_blank" href="<?= base_url('assets/dokumen/' . $g['file_dokumen']); ?>">
                                        <button title="Download" type="button" class="btn btn-outline-success btnHapusDokumen"><i class="fa fa-download"></i> Download</button>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>