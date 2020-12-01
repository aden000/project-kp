<?= $this->extend('Template/TemplateAdmin'); ?>
<?= $this->section('content'); ?>
<?php helper('form');
if (session('message')) : ?>
    <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
<?php endif; ?>
<div class="row mx-4">
    <div class="col-12 shadow-sm border border-dark" style="margin-top: 20px; padding-top: 15px; padding-bottom: 15px;">
        <h4>Kelola Galeri</h4>
        <button type="button" class="btn btn-info mb-2" data-toggle="modal" data-target="#modelTambahGaleri">
            <i class="fa fa-plus"></i> Tambahkan Galeri
        </button>
        <div class="table-responsive">
            <table class="table table-hover table-sm" id="tabelArtikel">
                <thead>
                    <tr>
                        <th>Urutan ke-</th>
                        <th>Preview Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $num = 1;
                    foreach ($galeri as $g) : ?>
                        <tr>
                            <td scope="row" style="vertical-align: middle;"><?php echo $num++; ?></td>
                            <td style="vertical-align: middle;">
                                <a target="_blank" href="<?= base_url('assets/img/slide/' . $g['nama_gambar']); ?>">
                                    <img src="<?php echo base_url('assets/img/slide/' . $g['nama_gambar']); ?>" style="width:100px; height:50px;" alt="Gambar<?= $g['id_galeri'] ?>" class="img img-thumbnail">
                                </a>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="my-auto">
                                    <button title="Hapus Gambar" type="button" class="btn btn-outline-danger btnHapusGaleri" data-id="<?= $g['id_galeri']; ?>" data-toggle="modal" data-target="#modelHapusGaleri<?= $g['id_galeri']; ?>"><i class="fa fa-trash-o"></i> Hapus</button>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modelTambahGaleri" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Galeri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart(route_to('admin.galeri.add.process')); ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <h6>File Gambar (.BMP, .PNG, .JPG/JPEG)</h6>
                        <input type="file" accept="image/png,image/bmp,image/jpeg" class="form-control-file border" name="namaGambar" id="namaGambar" placeholder="Upload gambar disini" aria-describedby="fileHelpId" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="submit" value="simpanBos" class="btn btn-primary"><i class="fa fa-save"></i> Upload dan Simpan</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<?php foreach ($galeri as $g) : ?>
    <div class="modal fade" id="modelHapusGaleri<?= $g['id_galeri']; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Galeri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open(route_to('admin.galeri.delete.process')); ?>
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <h4>Apakah anda yakin untuk menghapus galeri ini?</h4>
                    <a target="_blank" href="<?= base_url('assets/img/slide/' . $g['nama_gambar']); ?>">
                        <img src="<?php echo base_url('assets/img/slide/' . $g['nama_gambar']); ?>" style="width:200px; height:auto;" alt="Gambar<?= $g['id_galeri'] ?>" class="img img-thumbnail">
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batalkan</button>
                    <button type="submit" value="simpanBos" class="btn btn-primary"><i class="fa fa-save"></i> Konfirmasi dan Hapus</button>
                </div>
                <input type="hidden" name="id" id="id" value="<?= $g['id_galeri']; ?>">
                <?= form_close(); ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?= $this->endSection(); ?>