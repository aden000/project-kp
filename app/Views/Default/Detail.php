<?= $this->extend('Template/Template'); ?>

<?php

helper('form');

use CodeIgniter\I18n\Time; ?>
<?= $this->section('content'); ?>
<?php if (session('message')) { ?>
    <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
<?php } ?>
<div class="row mx-4" style="padding-top: 20px; padding-bottom: 20px; margin-bottom: 10px;">
    <div class="col shadow-sm border border-dark" style="padding-top: 10px; background-color: #fff;">
        <div class="row">
            <div class="col-1">
                <a href="<?= route_to('home'); ?>" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i></a>
            </div>
            <div class="col-11">
                <h4 class="mt-1"><?= $detail['judul_artikel']; ?></h4>
                <cite><small> Post: <?= Time::parse($detail['created_at'])->toLocalizedString('d MMM yyyy'); ?> | Last update: <?= Time::parse($detail['updated_at'])->toLocalizedString('d MMM yyyy'); ?> | Kategori: <?= $detail['nama_kategori']; ?> | By: <?= $detail['nama_user']; ?> </small></cite>
            </div>
        </div>

        <img src="<?php echo base_url('assets/artikel/img/' . $detail['id_artikel'] . '/' . $detail['link_gambar']); ?>" style="width: 100%;" alt="ImageThumbnail<?= $detail['id_artikel'] ?>" class="img-thumbnail d-block mt-2 mb-3">
        <p>
            <?= $detail['isi_artikel']; ?>
        </p>
        <hr>
        <div class="container-fluid mb-3">
            <div class="row">
                <div class="col">
                    <h6>Bagikan: </h6>
                    <a name="sharefb" id="sharefb" target="_blank" class="btn btn-primary" href="https://www.facebook.com/sharer/sharer.php?href=<?= esc(current_url()); ?>" role="button"><i class="fa fa-facebook"></i> Share</a>
                    <!-- <div class="fb-share-button" data-href="<?= current_url(); ?>" data-layout="button_count" data-size="large">
                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Bagikan</a>
                    </div> -->

                </div>
            </div>
        </div>
        <?php if (env('enableComment')) : ?>
            <hr>
            <?= $komentar; ?>
            <hr>
            <div class="container mb-3">
                <div class="row">
                    <div class="col shadow-sm border border-dark">
                        <?= form_open_multipart(route_to('handle.comment'), ['id' => 'formKomentar']); ?>
                        <?php csrf_field(); ?>

                        <h5 class="mt-2">Tinggalkan komentar!</h5>
                        <div class="alert alert-info fade" role="alert" id="alertInfo">
                            <button type="button" class="close" id="btnCloseAlert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong></strong>
                        </div>

                        <div class="form-group">
                            <label for="">Namamu:</label>
                            <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Namamu yang akan tampil di komentar" required>
                        </div>
                        <div class="form-group">
                            <label for="komentar">Isi Komentar</label>
                            <textarea class="form-control" name="komentar" id="komentar" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="emailKomentar">E-mail</label>
                            <input type="email" class="form-control" name="emailKomentar" id="emailKomentar" aria-describedby="emailKomentarID" placeholder="Masukan E-mail anda" required>
                            <small id="emailKomentarID" class="form-text text-muted">Kami akan gunakan email untuk mengidentifikasi anda adalah robot atau bukan</small>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="setujuKomentar" id="setujuKomentar" value="setujuKomentar" required>
                                Anda setuju dengan persyaratan penggunaan dan penggunaan data komentar, perlu diketahui komentar tidak dapat diubah maupun dihapus, hubungi admin jika ingin menghapus komentar
                            </label>
                        </div>
                        <input type="hidden" name="refID" id="refID" value="0">
                        <?php $uri = current_url(true); ?>
                        <input type="hidden" name="slug" value="<?= $uri->getSegment(2); ?>">
                        <button type="submit" class="btn btn-primary float-right mb-3">Post Komentar</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection(); ?>