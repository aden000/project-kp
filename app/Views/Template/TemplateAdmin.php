<!doctype html>
<html lang="en">

<head>
    <title><?= $judul; ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>

<body>
    <?= $this->include('Template/NavbarAdmin'); ?>
    <?= $this->renderSection('content'); ?>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.3.5/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url('/assets/js/script.js'); ?>"></script>
    <script src="<?= base_url('/assets/js/tinymce/tinymce.min.js'); ?>"></script>

    <script>
        var maxchara = 10000;
        $(document).ready(function() {
            $('#tabelArtikel').DataTable();

        });

        tinymce.init({
            selector: 'textarea#isiArtikel',
            menubar: '',
            plugins: 'link lists wordcount media code',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | numlist bullist | outdent indent | forecolor backcolor | link | media | code',
            custom_colors: true,
            media_live_embeds: true,
            height: "500",
            theme: 'silver',
            setup: function(editor) {
                editor.on('keydown', function(e) {
                    var wordcount = editor.plugins.wordcount;
                    if (wordcount.body.getCharacterCount() >= maxchara) {
                        e.preventDefault();
                        e.stopPropagation();
                        alert("Maksimal Karakter adalah 10000!");
                    }
                    //custom logic  
                });
            }
        });
    </script>
</body>

</html>