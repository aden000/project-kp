<nav class="navbar sticky-top navbar-expand-sm navbar-light shadow" style="background-color: lightgreen;">
    <a class="navbar-brand" href="<?= route_to('home'); ?>"><img style="padding-top: 0px; height: 50px;" src="<?= base_url('assets/logo.png'); ?>" alt="DISPERTAPAHORBUN"></a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav my-2 mt-lg-2 mr-auto">
            <?php $uri = current_url(true); ?>
            <li class="nav-item <?= $uri->getSegment(1) == '' ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= route_to('home'); ?>">Home</a>
            </li>
            <li class="nav-item <?= $uri->getSegment(1) == 'about' ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= route_to('about'); ?>">Tentang</a>
            </li>
        </ul>
        <form id="searchForm" action="<?= route_to('home'); ?>" method="get">
            <div class="form-inline my-2 my-lg-0 my-auto">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Masukan pencarian" aria-label="Recipient's username" name="search" id="search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary ml-0 my-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
                <?php if (session('whoLoggedIn')) { ?>
                    <a href="<?= route_to('admin.artikel'); ?>" class="btn btn-outline-success ml-auto my-sm-0">Dashboard</a>
                <?php } else { ?>
                    <button type="button" class="btn btn-outline-success ml-auto my-sm-0" data-toggle="modal" data-target="#modalLoginId"><i class="fa fa-sign-in"></i> Login</button>
                <?php } ?>
            </div>
        </form>

    </div>
</nav>