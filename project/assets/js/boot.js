BASE = $('link[rel="base"]').attr('href');

//DELETE/LOGOUT/STATUS
$(function() {
    $('.button_action').on("click", function() {
        var Prevent = $(this);
        var DelId = $(this).attr('id');
        var RelTitle = $(this).attr('rel');
        var Callback = $(this).attr('callback');
        var Callback_action = $(this).attr('callback_action');
        swal({
                title: RelTitle,
                text: "Você não será capaz de recuperar novamente!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim",
                closeOnConfirm: false
            },
            function() {
                $.post(Callback + '/' + Callback_action, {
                        callback: Callback,
                        callback_action: Callback_action,
                        del_id: DelId
                    },
                    function(data) {
                        if (data.error) {
                            swal("", data.error, data.type)
                        } else {
                            swal({
                                    title: "",
                                    text: data.success,
                                    type: "success",
                                    confirmButtonClass: "btn-success",
                                    closeOnButtonText: "Ok",
                                    closeOnConfirm: true
                                },
                                function() {
                                    location.reload();
                                });
                        }
                    }, 'json');
            });
    });
});

// CREATE/UPDATE
$('#form').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);

    form.ajaxSubmit({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form,
        dataType: 'json',
        beforeSend: function() {
            form.find('.form_load').fadeIn(1000);
        },
        success: function(data) {
            if (data.success) {
                toastr.success(data.success, "", {
                    "closeButton": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000"
                });

                form.find('.form_load').fadeOut(1000);

                //REDIRECIONA
                if (data.redirect) {
                    window.setTimeout(function() {
                        window.location.href = data.redirect;
                    }, 5100);
                }

            } else {
                toastr.error(data.error, "", {
                    "closeButton": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000"
                });
                form.find('.form_load').fadeOut(1000);
            }
        }
    });
});

// FILTRAR PESQUISA DE IMOVEIS
$('#form_filter').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);

    form.ajaxSubmit({
        url: form.attr('action'),
        data: form,
        dataType: 'json',
        beforeSend: function() {
            form.find('.form_load').fadeIn(1000);
        },
        success: function(data) {
            if (data.success) {
                form.find('.form_load').fadeOut(1000);
                //REDIRECIONA
                if (data.redirect) {
                    window.setTimeout(function() {
                        window.location.href = BASE + data.redirect;
                    }, 50);
                }

            } else {
                toastr.error(data.error, "", {
                    "closeButton": true,
                    "positionClass": "toast-top-right",
                    "progressBar": true,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000"
                });
                form.find('.form_load').fadeOut(1000);
            }
        }
    });
});

// upload de image
$(document).ready(function(e) {
    // Função para visualização da imagem após a validação
    $(function() {
        $("#img").change(function() {
            var file = this.files[0];
            var imagefile = file.type;
            var match = ["image/jpeg", "image/png", "image/jpg"];
            if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                $('#previewing').attr('src', '../../img/img.jpg');
                swal("", "Selecione uma imagem válida!", "error");
                return false;
            } else {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    function imageIsLoaded(e) {
        $("#img").css("color", "green");
        $('#previewing').attr('src', e.target.result);
    };
});