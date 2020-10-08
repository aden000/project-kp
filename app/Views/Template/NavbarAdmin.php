<?php

use App\Models\UserModel; ?>
<nav class="navbar sticky-top navbar-expand-sm navbar-light shadow" style="background-color: lightgreen;">
    <a class="navbar-brand" href="<?= route_to('home'); ?>"><img style="padding-top: 0px; height: 50px;" src="<?= base_url('assets/logo.png'); ?>" alt="DISPERTAPAHORBUN"></a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <?php $uri = current_url(true); ?>
            <li class="nav-item <?= $uri->getSegment(2) == 'artikel' ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= route_to('admin.artikel'); ?>">Manage Artikel</a>
            </li>
            <li class="nav-item <?= $uri->getSegment(2) == 'kategori' ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= route_to('admin.kategori'); ?>">Manage Kategori</a>
            </li>
        </ul>
        <nav class="my-2 my-lg-0">
            <div class="dropdown">
                <button class="btn btn-outline-success dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php $a = new UserModel();
                    $a = $a->find(session()->get('whoLoggedIn'));  ?>
                    <i class="fa fa-user"></i> <?= $a['nama_user']; ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="triggerId">
                    <a class="dropdown-item" href="#">Manage User</a>
                    <a class="dropdown-item" href="#">Ganti Password</a>
                    <div class="dropdown-divider"></div>
                    <form action="<?= route_to('admin.logout.process'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <button type="submit" name="logoutPlease" class="dropdown-item" value="Logout"><i class="fa fa-sign-out"></i> Logout</button>
                    </form>
                </div>
            </div>
        </nav>
    </div>
</nav>