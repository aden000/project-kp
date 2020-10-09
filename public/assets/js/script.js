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