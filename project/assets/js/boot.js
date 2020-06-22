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
            if (data.filter.length > 0) {
                console.log(data.filter);
                form.find('.form_load').fadeOut(1000);
                $('#result-filter').html('');


                var book = '';
                $.each(data.filter, function(index, value) {

                    book += '<div class="col-md-3"><div class="card mb-4">';
                    book += "<img class=\"card-img-top\" src=\"" + BASE + "assets/uploads/book/" + value.book_img + "\" alt=\"\">";
                    book += '<div class="card-body text-center">';
                    book += '<h5 class="card-title">';
                    book += "<a href=\"" + BASE + "painel/livros/update/" + value.book_url + "\">" + value.book_title + "</a>";
                    book += '</h5>';

                    book += '<div class="content mb-3">';
                    book += "<span class=\"text-secondary d-block\"><b>Autor: </b>" + value.book_author + "</span>";
                    book += "<span class=\"text-secondary d-block\"><b>Editora: </b>" + value.book_publishing + "</span>";
                    book += "<span class=\"text-secondary d-block\"><b>Lançamento: </b>" + value.book_launch + "</span>";
                    book += "<span class=\"text-secondary d-block\"><b>Quant: </b>" + value.book_amount + "</span>";
                    book += '</div>';

                    book += "<a href=\"" + BASE + "painel/livros/update/" + value.book_url + "\" class=\"btn badge badge-primary\">Editar</a> <span class=\"btn badge badge-danger button_action\" rel=\"Deseja excluir?\" callback=\"livros\" callback_action=\"delete\" id=\"book_id\" title=\"Excluir Livro\">Excluir</span>";

                    book += '</div>'
                    book += '</div></div>';

                });

                $('#result-filter').html(book);

            } else {
                $('#result-filter').html("<div class=\"col-md-12 text-center\"><div class=\"alert alert-warning\" role=\"alert\">Nenhum <strong>livro</strong> encontrado, refaça sua pesquisa!</div></div>");
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