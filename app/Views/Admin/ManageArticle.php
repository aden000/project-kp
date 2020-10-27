<?= $this->extend('Template/TemplateAdmin'); ?>

<?= $this->section('content'); ?>
<?php if (session('message')) : ?>
    <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
<?php endif; ?>
<div class="row mx-4">
    <div class="col-12 shadow-sm border border-dark" style="margin-top: 20px; padding-top: 15px; padding-bottom: 15px;">
        <h4>Kelola Artikel</h4>
        <a href="<?= route_to('admin.artikel.create'); ?>" class="btn btn-info" style="margin-bottom: 10px;"> <i class="fa fa-plus" aria-hidden="true"></i> Buat Artikel</a>
        <div class="table-responsive">
            <table class="table table-hover table-sm" id="tabelArtikel">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Dari</th>
                        <th>Judul</th>
                        <th>Preview Gambar</th>
                        <th>Isi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $num = 1;
                    foreach ($artikel as $a) : ?>
                        <tr>
                            <td scope="row" style="vertical-align: middle;"><?php echo $num++; ?></td>
                            <td style="vertical-align: middle;"><?php echo $a['nama_user']; ?></td>
                            <td style="vertical-align: middle;"><?php echo $a['judul_artikel']; ?></td>
                            <td style="vertical-align: middle;"><a target="_blank" href="<?= base_url('assets/artikel/img/' . $a['id_artikel'] . '/' . $a['link_gambar']); ?>"><img src="<?php echo base_url('assets/artikel/img/' . $a['id_artikel'] . '/' . $a['link_gambar']); ?>" style="width:100px; height:50px;" alt="ImageThumbnail<?= $a['id_artikel'] ?>" class="img img-thumbnail"></a></td>
                            <td style="vertical-align: middle;"><a href="<?= route_to('detail.artikel', $a['slug']); ?>" class="btn btn-outline-secondary"><i class="fa fa-newspaper-o"></i> Lihat artikel</a></td>
                            <td style="vertical-align: middle;">
                                <span class="my-auto">
                                    <a title="Edit Artikel" href=" <?= route_to('admin.artikel.edit', $a['id_artikel']); ?>" class="btn btn-outline-info"><i class="fa fa-pencil"></i> Edit</a>
                                    <!-- <a href="<?= route_to('admin.artikel.delete', $a['id_artikel']); ?>" class="btn btn-outline-danger"><i class="fa fa-trash-o"></i></a> -->
                                    <button title="Hapus Artikel" type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#modelId<?= $a['id_artikel']; ?>"><i class="fa fa-trash-o"></i> Hapus</button>
                                    <button class="btn btn-outline-success togglepublish" data-id="<?= $a['id_artikel']; ?>"><i class="fa fa-<?= $a['published_at'] == null ? 'eye' : 'eye-slash'; ?>"></i> <?= $a['published_at'] == null ? 'Terbitkan' : 'Batal Terbitkan'; ?></button>
                                    <?php if (env('enableComment')) : ?>
                                        <a title="Kelola Komentar" href="<?= route_to('admin.artikel.comment', $a['id_artikel']); ?>" class="btn btn-outline-success"><i class="fa fa-comments-o"></i></a>
                                    <?php endif; ?>
                                </span>
                            </td>
                        </tr>
                        <div class="modal fade" id="modelId<?= $a['id_artikel']; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId<?= $a['id_artikel']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Yakin menghapus?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Mohon konfirmasi Artikel yang akan dihapus:</h6>
                                        <p>
                                            Judul : <?= $a['judul_artikel']; ?> <br>
                                            Artikel oleh : <?= $a['username']; ?> <br>
                                            Preview Gambar : <br>
                                            <a target="_blank" href="<?= base_url('assets/artikel/img/' . $a['id_artikel'] . '/' . $a['link_gambar']); ?>">
                                                <img src="<?php echo base_url('assets/artikel/img/' . $a['id_artikel'] . '/' . $a['link_gambar']); ?>" style="width:200px" alt="ImageThumbnail<?= $a['id_artikel'] ?>" class="img-thumbnail">
                                            </a>
                                        </p>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                        <form action="<?= route_to('admin.artikel.delete.process', $a['id_artikel']); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash-o"></i> Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Button trigger modal -->


<!-- Modal -->


<?= $this->endSection(); ?>