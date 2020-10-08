<?= $this->extend('Template/TemplateAdmin'); ?>

<?= $this->section('content'); ?>
<?php if (session('message')) : ?>
    <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
<?php endif; ?>
<div class="row border border-dark shadow-sm my-3 mx-4 pb-2">
    <div class="col">
        <h4 class="my-2">Kelola Kategori</h4>
        <button type="button" class="btn btn-outline-info mb-2" data-toggle="modal" data-target="#modelCreate"><i class="fa fa-plus"></i> Tambah Kategori</button>
        <table class="table table-hover table-sm" id="tabelArtikel">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($kategori as $k) : ?>
                    <tr>
                        <td style="vertical-align: middle;"><?= $no++; ?></td>
                        <td style="vertical-align: middle;"><?= $k['nama_kategori']; ?></td>
                        <td style="vertical-align: middle;">
                            <button type="button" class="btn btn-outline-info btnEdit" data-toggle="modal" data-id="<?= $k['id_kategori']; ?>" data-target="#modelEdit"><i class="fa fa-pencil"></i></button> |
                            <button type="button" class="btn btn-outline-danger btnHapus" data-toggle="modal" data-id="<?= $k['id_kategori']; ?>" data-target="#modelHapus"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Button trigger modal -->
        <!-- Modal -->
        <div class="modal fade" id="modelCreate" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buat Kategori Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= route_to('admin.kategori.create.process'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="namakategori">Nama Kategori</label>
                                <input type="text" class="form-control" name="namakategori" id="namakategori" aria-describedby="helpnamakategori" placeholder="Nama Kategori">
                                <small id="helpnamakategori" class="form-text text-muted">Masukan nama kategori</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modelEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kategori</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= route_to('admin.kategori.edit.process'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="namakategoriedit">Nama Kategori</label>
                                <input type="hidden" name="idkEdit" id="idkEdit">
                                <input type="text" class="form-control" name="namakategoriedit" id="namakategoriedit" aria-describedby="helpnamakategori" placeholder="Nama Kategori">
                                <small id="helpnamakategori" class="form-text text-muted">Masukan nama kategori</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan dan Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modelHapus" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Kategori?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="isi">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form action="<?= route_to('admin.kategori.delete.process'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="idkHapus" id="idkHapus">
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>