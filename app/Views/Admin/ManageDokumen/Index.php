<?= $this->extend('Template/TemplateAdmin'); ?>
<?= $this->section('content'); ?>
<?php helper('form');
if (session('message')) : ?>
    <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
<?php endif; ?>
<div class="row mx-4">
    <div class="col-12 shadow-sm border border-dark" style="margin-top: 20px; padding-top: 15px; padding-bottom: 15px;">
        <h4>Kelola Dokumen</h4>
        <button type="button" class="btn btn-info mb-2" data-toggle="modal" data-target="#modelTambahDokumen">
            <i class="fa fa-plus"></i> Tambahkan Dokumen
        </button>
        <div class="table-responsive">
            <table class="table table-hover table-sm" id="tabelArtikel">
                <thead>
                    <tr>
                        <th>Urutan ke-</th>
                        <th>Nama Dokumen</th>
                        <th>Created At</th>
                        <th>Uploaded By</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $num = 1;
                    foreach ($dokumen as $g) : ?>
                        <tr>
                            <td scope="row" style="vertical-align: middle;"><?php echo $num++; ?></td>
                            <td style="vertical-align: middle;">
                                <?= $g['nama_dokumen'] ?>
                            </td>
                            <td style="vertical-align: middle;">
                                <?= $g['created_at'] ?>
                            </td>
                            <td style="vertical-align: middle;">
                            <?= $g['nama_user'] ?>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="my-auto">
                                    <a target="_blank" href="<?= base_url('assets/dokumen/' . $g['file_dokumen']); ?>">
                                        <button title="Download" type="button" class="btn btn-outline-success btnHapusDokumen"><i class="fa fa-download"></i> Download</button>
                                    </a>
                                    <button title="Hapus Dokumen" type="button" class="btn btn-outline-danger btnHapusDokumen" data-id="<?= $g['id_dokumen']; ?>" data-toggle="modal" data-target="#modelHapusDokumen<?= $g['id_dokumen']; ?>"><i class="fa fa-trash-o"></i> Hapus</button>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modelTambahDokumen" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Dokumen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart(route_to('admin.dokumen.add.process')); ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group">
                        <div class="input-group">
                            <h6>Nama Dokumen</h6>
                            <input type="text" class="form-control-file border" name="namaDokumen" id="namaDokumen" placeholder="Nama Dokumen" aria-describedby="fileHelpId" required>
                        </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <h6>File Dokumen (.PDF, .DOC, .DOCX)</h6>
                        <input type="file" accept=".pdf, .doc, .docx" class="form-control-file border" name="fileDokumen" id="fileDokumen" placeholder="Upload dokumen disini" aria-describedby="fileHelpId" required>
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

<?php foreach ($dokumen as $g) : ?>
    <div class="modal fade" id="modelHapusDokumen<?= $g['id_dokumen']; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Dokumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open(route_to('admin.dokumen.delete.process')); ?>
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <h4>Apakah anda yakin untuk menghapus dokumen ini?</h4>
                    Dokumen : 
                    <a target="_blank" href="<?= base_url('assets/dokumen/' . $g['file_dokumen']); ?>">
                        <?= $g['nama_dokumen']?>
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batalkan</button>
                    <button type="submit" value="simpanBos" class="btn btn-primary"><i class="fa fa-save"></i> Konfirmasi dan Hapus</button>
                </div>
                <input type="hidden" name="id" id="id" value="<?= $g['id_dokumen']; ?>">
                <?= form_close(); ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?= $this->endSection(); ?>