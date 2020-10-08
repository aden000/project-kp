<?= $this->extend('Template/TemplateAdmin'); ?>

<?= helper('form'); ?>
<?= $this->section('content'); ?>
<div class="row mx-3 my-4">
    <div class="col shadow-sm border border-dark pt-2">
        <div class="row">
            <div class="col-1">
                <a href="<?= route_to('admin.artikel'); ?>" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i></a>
            </div>
            <div class="col-11">
                <h4 class="mt-1">Edit Artikel</h4>
            </div>
        </div>
        <?php if ($errors) {
            foreach ($errors as $err) :
        ?>
                <div class="alert alert-warning alert-dismissible fade show shadow border" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Informasi</strong>
                    <p><?= $err; ?></p>
                </div>

                <script>
                    $(".alert").alert();
                </script>
        <?php
            endforeach;
        } ?>

        <?= form_open_multipart(route_to('admin.artikel.edit.process', $artikel['id_artikel'])); ?>
        <?= csrf_field(); ?>
        <div class="form-group mt-3">
            <h6 for="judulArtikel">Judul Artikel</h6>
            <input type="text" class="form-control" name="judulArtikel" id="judulArtikel" aria-describedby="judulHasilId" placeholder="Judul" value="<?= $artikel['judul_artikel']; ?>" required>
            <small id="judulHasilId" class="form-text text-muted">Gunakan judul yang tidak memancing keributan</small>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col">
                    <h6>Pilih Kategori</h6>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="kategoriSelect">Kategori</label>
                        </div>
                        <select class="custom-select" id="kategoriSelect" name="kategoriSelect">
                            <option selected>Pilih Kategori</option>
                            <?php foreach ($kategori as $k) : ?>
                                <option value="<?= $k['id_kategori']; ?>" <?= $artikel['id_kategori'] == $k['id_kategori'] ? 'selected' : ''; ?>><?= $k['nama_kategori']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <h6>File Gambar</h6>
                        <input type="file" class="form-control-file border" name="gambar" id="gambar" placeholder="Upload gambar disini" aria-describedby="fileHelpId">
                        <a target="_blank" href="<?= base_url('assets/artikel/img/' . $artikel['id_artikel'] . '/' . $artikel['link_gambar']); ?>" class="badge badge-info"><i class="fa fa-eye"></i> Lihat Gambar Sebelumnya</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <h6 for="isiArtikel">Isi Artikel</h6>
            <textarea class="form-control" name="isiArtikel" id="isiArtikel" rows="8"><?= $artikel['isi_artikel']; ?></textarea>
        </div>
        <div class="form-group text-center">
            <button type="submit" value="SimpanBos" class="btn btn-outline-success d-inline"><i class="fa fa-floppy-o"></i> Simpan & Update</button>
            <a href="<?= route_to('admin.artikel'); ?>" class="btn btn-outline-danger d-inline"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>