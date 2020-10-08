$(document).ready(function () {
    $('#alertInfo').hide();
    $('.reply').click(function (e) {
        e.preventDefault();
        var nama = $(this).siblings('h6').text()
        var idk = $(this).attr('id');
        $('.row').find('#komentarSection').css('background-color', '');
        $(this).parent('.col').css('background-color', 'aqua');
        $('#alertInfo').show();
        $('#alertInfo').addClass('show');
        $('#alertInfo strong').text('Anda sedang membalas komentar: ' + nama);
        $('#refID').val(idk);
    });
    $('#btnCloseAlert').click(function (e) {
        $(this).parent('.alert').removeClass('show');
        $('.row').find('#komentarSection').css('background-color', '');
        $('#alertInfo').hide();
        $('#refID').val(0);
    });

    $('#searchForm').submit(function (e) {
        if ($.trim($('#search').val()) === "") {
            e.preventDefault();
            Swal.fire(
                'Pesan dari server',
                'Mohon masukan keyword pencarian sebelum submit',
                'info'
            )
        }

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
});