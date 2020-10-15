$(document).ready(function () {
    $('.btnEdit').on('click', function () {
        var idk = $(this).data("id")
        $.ajax({
            type: "post",
            url: "/admin/kategori/ajax",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                "id": idk,
                "type": "getkategoribyid"
            },
            dataType: "html",
            success: function (response) {
                $("#idkEdit").val(idk);
                $('#namakategoriedit').val(response);
            }
        });
    });

    $('.btnHapus').on('click', function () {
        var idk = $(this).data("id")
        $.ajax({
            type: "post",
            url: "/admin/kategori/ajax",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                "id": idk,
                "type": "getkategoribyid"
            },
            dataType: "html",
            success: function (response) {

                $("#idkHapus").val(idk);
                $(".isi").html(
                    '<h6>Mohon konfirmasi Kategori yang akan dihapus:</h6>' +
                    '<p>' +
                    'Nama Kategori : ' + response + '<br>' +
                    '</p>'
                );
            }
        });
    });

    $('.komentarEdit').click(function (e) {
        e.preventDefault();
        var idkomentar = $(this).data('id');
        $('.modal-title').text('Edit Komentar');

        $.ajax({
            type: "post",
            url: "/admin/artikel/comment/ajax",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                "idkomentar": idkomentar,
                "type": "KomentarEdit"
            },
            dataType: "html",
            success: function (response) {
                $('.modal-body').html(response);
                // console.log(response);
            }
        });
    });

    $('.btnUserEdit').click(function (e) { 
        e.preventDefault();
        var idUser = $(this).data('id');

        $.ajax({
            type: "post",
            url: "/admin/user/ajax",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                'getUserInfo': true,
                'secret': 'xo12esadsas12s',
                'id': idUser
            },
            dataType: "json",
            success: function (response) {
                $('#idEUser').val(response.id_user);
                $('#frmEUsername').val(response.username);
                $('#frmENama').val(response.nama_user);
                $('#frmEAccess').val(response.role);
            }
        });
    });

    $('.btnUserHapus').click(function (e) { 
        var id = $(this).data('id');
        e.preventDefault();
        
        $.ajax({
            type: "post",
            url: "/admin/user/ajax",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                'getUserInfo': true,
                'secret': 'xo12esadsas12s',
                'id': id
            },
            dataType: "json",
            success: function (response) {
                $('#NamaUser').text(response.nama_user);
                $('#idUser').val(response.id_user);
            }
        });
    });
});

$(function () {
    const jdul = $('.flash-data').data('judul');
    const msg = $('.flash-data').data('msg');
    const role = $('.flash-data').data('role');
    if (jdul && msg && role) {
        Swal.fire(
            jdul,
            msg,
            role
        );
    } else if (msg && role) {
        Swal.fire(
            'Pesan dari server',
            msg,
            role
        );
    } else if (msg) {
        Swal.fire(
            'Pesan dari server',
            msg,
            'info'
        );
    }
})

$(function () {
    $('[data-toggle="popover"]').popover()
})