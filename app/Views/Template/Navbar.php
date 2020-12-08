<nav class="navbar sticky-top navbar-expand-md navbar-light shadow" style="background-color: lightgreen;">
    <a class="navbar-brand" href="<?= route_to('home'); ?>"><img style="padding-top: 0px; height: 50px;" src="<?= base_url('assets/logo.png'); ?>" alt="DISPERTAPAHORBUN"></a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav my-2 mt-lg-2 mr-auto">
            <?php $uri = current_url(true); ?>
            <li class="nav-item <?= $uri->getSegment(1) == '' ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= route_to('home'); ?>">Home</a>
            </li>
            <li class="nav-item <?= $uri->getSegment(1) == 'document' ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= route_to('document'); ?>">Dokumen</a>
            </li>
            <li class="nav-item <?= $uri->getSegment(1) == 'about' ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= route_to('about'); ?>">Tentang</a>
            </li>
        </ul>
        <div class="my-auto">
            <?php if (session('whoLoggedIn')) { ?>
                <div class="dropdown">
                    <button class="btn btn-outline-success dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i> <?= $a['nama_user']; ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                        <a class="dropdown-item" href="<?= route_to('admin.dashboard'); ?>">Dashboard Admin</a>
                        <!-- <a class="dropdown-item" href="#">Ganti Password</a> -->
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#gantiPass">
                            Ganti Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="<?= route_to('admin.logout.process'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <button type="submit" name="logoutPlease" class="dropdown-item" value="Logout"><i class="fa fa-sign-out"></i> Logout</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>
<?php if (session('whoLoggedIn')) { ?>
    <div class="modal fade" id="gantiPass" tabindex="-1" role="dialog" aria-labelledby="modelGantiPass" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= route_to('admin.user.changepass'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <?php if ($a['role'] == 1) : ?>
                            <a role="button" data-container="body" data-toggle="popover" title="Mengenai Lupa Password" data-content="Harap hubungi Admin untuk mereset password anda" data-placement="right" data-trigger="focus" href="#" tabindex="0">Lupa password?</a>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="curpass">Password saat ini</label>
                            <input type="password" class="form-control" name="curpass" id="curpass" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="newpass">Password baru</label>
                            <input type="password" class="form-control" name="newpass" id="newpass" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="newpassconfirm">Ulangi password baru</label>
                            <input type="password" class="form-control" name="newpassconfirm" id="newpassconfirm" placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan dan Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>