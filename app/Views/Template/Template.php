<!doctype html>
<html lang="en">

<head>
  <title><?= $judul ?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= base_url() . '/assets/css/customcss.css'; ?>">
</head>

<body style="background-color: #eee;">
  <?= $this->include('Template/Navbar'); ?>
  <?= $this->renderSection('content'); ?>
  <div class="container">

    <!-- Button trigger modal -->
    <!-- In Template/Navbar -->

    <!-- Modal -->
    <div class="modal fade" id="modalLoginId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Login</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="<?= route_to('admin.login.process'); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="modal-body">
              <div class="form-group">
                <label for="user">Username</label>
                <input type="text" name="user" id="user" class="form-control" placeholder="Username" aria-describedby="usernameHelpId">
                <small id="usernameHelpId" class="text-muted">Masukan Username anda</small>
              </div>
              <div class="form-group">
                <label for="pass">Password</label>
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Password">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="loginPlease" class="btn btn-primary" value="Login"><i class="fa fa-sign-in"></i> Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
  <?= $this->include('Template/Footer'); ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.3.5/dist/sweetalert2.all.min.js"></script>
  <script src="<?= base_url('/assets/js/main.js'); ?>"></script>

</body>

</html>