<?= $this->extend('Template/TemplateAdmin'); ?>
<?= $this->section('content'); ?>
<?php if (session('message')) { ?>
    <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
<?php } ?>
<div class="container mt-4 px-2 py-2 border border-dark shadow-sm">
    <div class="row">
        <div style="width: max-content;" class="ml-3">
            <a href="<?= route_to('admin.artikel'); ?>" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i></a>
        </div>
        <div class="col align-self-center">
            <h5>Manage Komentar dari artikel: <?= $artikel['judul_artikel']; ?></h5>
            <a href="<?= route_to('detail.artikel', $artikel['slug']); ?>" class="btn btn-info"><i class="fa fa-eye"></i> Lihat Artikel</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <?= $komentar; ?>
        </div>
    </div>
    <div class="modal fade" id="KomentarEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= route_to('admin.artikel.comment.edit'); ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="modal-body">
                        Body
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info"><i class="fa fa-pencil"></i> Ubah</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->endSection(); ?>