<?= $this->extend('Template/Template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-">

        </div>
        <div class="col-4 bg-secondary text-white">
            <div class="row">
                <div class="col">
                    <form action="<?= route_to('admin_login_process'); ?>" method="post">
                        <div class="form-group">
                            <label for="user">Username</label>
                            <input type="text" name="user" id="user" class="form-control" placeholder="Username anda" aria-describedby="usernameHelpId">
                            <small id="usernameHelpId" class="text-muted">Masukan Username anda</small>
                        </div>
                        <div class="form-group">
                            <label for="pass">Password</label>
                            <input type="password" class="form-control" name="pass" id="pass" placeholder="Password">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-auto">

        </div>
    </div>
</div>
<?= $this->endSection(); ?>