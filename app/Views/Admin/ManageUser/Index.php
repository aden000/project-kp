<?= $this->extend('Template/TemplateAdmin'); ?>
<?= $this->section('content'); ?>
<?php if (session('message')) : ?>
    <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
<?php endif; ?>
<div class="row border border-dark shadow-sm my-3 mx-4 pb-2">
    <div class="col">
        <h4 class="mt-3">Kelola User</h4>
        <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#modelAddUser">
            <i class="fa fa-plus"></i> Tambah User
        </button>

        <table class="table table-hover table-sm mt-2" id="tabelArtikel">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Tipe Akses</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($user as $u) : ?>
                    <tr>
                        <td style="vertical-align: middle;"><?= $no++; ?></td>
                        <td style="vertical-align: middle;"><?= $u['username']; ?></td>
                        <td style="vertical-align: middle;"><?= $u['nama_user']; ?></td>
                        <td style="vertical-align: middle;">
                            <?php
                                if ($u['role'] == 0) {
                                    echo 'Full Akses';
                                }
                                elseif ($u['role'] == 1) {
                                    echo 'Hanya Posting';
                                }
                                elseif ($u['role'] == 2) {
                                    echo 'Hanya Dokumen';
                                }
                            ?>
                        </td>
                        <td style="vertical-align: middle;">
                            <button type="button" class="btn btn-outline-info btnUserEdit" title="Edit User" data-toggle="modal" data-id="<?= $u['id_user']; ?>" data-target="#modelEditUser"><i class="fa fa-pencil"></i></button> |
                            <?php if ($u['id_user'] != session()->get('whoLoggedIn')) : ?>
                                <button type="button" class="btn btn-outline-danger btnUserHapus" title="Hapus User" data-toggle="modal" data-id="<?= $u['id_user']; ?>" data-target="#modelHapusUser"><i class="fa fa-trash-o"></i></button> |
                            <?php endif; ?>
                            <button type="button" class="btn btn-outline-warning btnUserResetPass" title="Reset Password" data-id="<?= $u['id_user']; ?>"><i class="fa fa-key"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="modelAddUser" tabindex="-1" role="dialog" aria-labelledby="modelAddUserId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= route_to('admin.user.create'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="frmUsername">Username</label>
                                <input type="text" class="form-control" name="frmUsername" id="frmUsername" aria-describedby="userHelp" placeholder="Masukan username" required>
                                <small id="userHelp" class="form-text text-muted">Username akan digunakan untuk login</small>
                            </div>
                            <div class="form-group">
                                <label for="frmNama">Nama User</label>
                                <input type="text" class="form-control" name="frmNama" id="frmNama" aria-describedby="helpNamaId" placeholder="Masukan Nama" required>
                                <small id="helpNamaId" class="form-text text-muted">Digunakan untuk ditampilkan ke postingan yang anda buat</small>
                            </div>
                            <div class="form-group">
                                <label for="frmPassword">Password</label>
                                <input type="password" class="form-control" name="frmPassword" id="frmPassword" placeholder="Masukan Password" required>
                            </div>
                            <div class="form-group">
                                <label for="frmAccess">Hak Akses</label>
                                <select class="custom-select" name="frmAccess" id="frmAccess">
                                    <option selected>Silahkan Pilih</option>
                                    <option value="0">Full Akses</option>
                                    <option value="1">Hanya Posting</option>
                                    <option value="2">Hanya Dokumen</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modelEditUser" tabindex="-1" role="dialog" aria-labelledby="modelEditUserId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= route_to('admin.user.edit'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="modal-body">
                            <input type="hidden" name="idEUser" id="idEUser">
                            <div class="form-group">
                                <label for="frmEUsername">Username</label>
                                <input type="text" class="form-control" name="frmEUsername" id="frmEUsername" aria-describedby="userHelp" placeholder="Masukan username" required>
                                <small id="userHelp" class="form-text text-muted">Username akan digunakan untuk login</small>
                            </div>
                            <div class="form-group">
                                <label for="frmENama">Nama User</label>
                                <input type="text" class="form-control" name="frmENama" id="frmENama" aria-describedby="helpNamaId" placeholder="Masukan Nama" required>
                                <small id="helpNamaId" class="form-text text-muted">Digunakan untuk ditampilkan ke postingan yang anda buat</small>
                            </div>
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <p><i class="fa fa-info-circle"></i> Untuk pengubahan Password, anda hanya bisa akses Reset Password (Icon bertanda <i class="fa fa-key"></i> ), dan user akan mengubahnya secara mandiri melalui fitur Ubah Password</p>
                            </div>
                            <div class="form-group">
                                <label for="frmEAccess">Hak Akses</label>
                                <select class="custom-select" name="frmEAccess" id="frmEAccess">
                                    <option>Silahkan Pilih</option>
                                    <option value="0">Full Akses</option>
                                    <option value="1">Hanya Posting</option>
                                    <option value="2">Hanya Dokumen</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modelHapusUser" tabindex="-1" role="dialog" aria-labelledby="modelHapusUserId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus User?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin untuk menghapus user:</p>
                        <strong>
                            <p id="NamaUser"></p>
                        </strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        <form action="<?= route_to('admin.user.delete'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="idUser" id="idUser">
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<?= $this->endSection(); ?>