$(document).ready(function () {
    $('.btnEdit').on('click', function () {
        var idk = $(this).data("id")
        $.ajax({
            type: "post",
            url: "/admin/ajax",
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
            url: "/admin/ajax",
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

    $('.btnUserResetPass').click(function (e) { 
        e.preventDefault();
        var id = $(this).data('id');

        Swal.fire({
            title: 'Reset password?',
            html: '<b>PERINGATAN</b><br>' + 
                    'Anda tidak dapat membatalkan aksi ini setelah menekan tombol <b>YA</b>',
            icon: 'question',
            showDenyButton: true,
            confirmButtonText: 'Ya',
            denyButtonText: `Batalkan`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                //Swal.fire('Saved!', '', 'success')
                $.ajax({
                    type: "post",
                    url: "/admin/user/ajax",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        'getUserResetPassword': true,
                        'secret': '3u4tnuj23eqk',
                        'id': id
                    },
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({
                            'title': 'Reset Password berhasil!',
                            'html': `Harap catat password ini, dan segera ubah pada user yang bersangkutan` + 
                                    `<br>Password: <b>` + response.newpass + `</b>`,
                            'icon': 'success'
                        });
                    }
                });
                
            } else if (result.isDenied) {
              Swal.fire('Perubahan password dibatalkan', '', 'info')
            }
        });
    });

    $('.togglepublish').click(function (e) { 
        e.preventDefault();

        var bhis = this;
        
        var id = $(this).data('id');
        console.log(id);

        Swal.fire({
            title: 'Jalankan Aksi?',
            html: '<b>PERINGATAN</b><br>' + 
                    'Anda tidak dapat membatalkan aksi ini setelah menekan tombol <b>YA</b>',
            icon: 'question',
            showDenyButton: true,
            confirmButtonText: 'Ya',
            denyButtonText: `Tidak`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                //Swal.fire('Saved!', '', 'success')
                $.ajax({
                    type: "post",
                    url: "/admin/ajax",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        'type': "gettogglepublish",
                        'secret': 'usaojdn1dwq12e3',
                        'id': id
                    },
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({
                            'title': response.judul,
                            'icon': 'success'
                        });
            
                        if(response.published){
                            $(bhis).children('i').removeClass('fa-eye');
                            $(bhis).children('i').addClass('fa-eye-slash');
                            $(bhis).get(0).lastChild.nodeValue = " Batal Terbitkan"
                        } else {
                            $(bhis).children('i').removeClass('fa-eye-slash');
                            $(bhis).children('i').addClass('fa-eye');
                            $(bhis).get(0).lastChild.nodeValue = " Terbitkan";
                        }
                    }
                });
                
            } else if (result.isDenied) {
              Swal.fire('Aksi dibatalkan', '', 'info')
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