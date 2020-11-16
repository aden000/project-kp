<?= $this->extend('Template/Template'); ?>

<?= $this->section('content'); ?>
<?php if (session('message')) : ?>
    <div class="flash-data" data-judul="<?= session('message')['judul']; ?>" data-msg="<?= session('message')['msg']; ?>" data-role="<?= session('message')['role']; ?>"></div>
<?php endif; ?>
<div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Login</h5>
            <hr class="my-4">
            <form class="form-signin" action="<?= route_to('admin.login.process'); ?>" method="post">
              <?= csrf_field(); ?>
              <div class="form-label-group">
                <label for="user">Username</label>
                <input type="text" name="user" id="user" class="form-control" placeholder="Username" required autofocus>
              </div>

              <div class="form-label-group">
                <label for="pass">Password</label>
                <input type="password" name="pass" id="pass" class="form-control" placeholder="Password" required>
              </div>
              <hr class="my-4">
              <button class="btn btn-lg btn-primary btn-block text-uppercase" name="loginPlease" type="submit" value="Login">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?= $this->endSection(); ?>