$(function () {
    $('.date').mask('00/00/0000');
    $('.time').mask('00:00:00');
    $('.cep').mask('00000-000');
    $('.cpf').mask('000.000.000-00');
    $('.money').mask('000.000.000.000,00');

    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

    $('.phone').mask(SPMaskBehavior, spOptions);
});

$(document).on('click', '#btn_tela1', function () {
    if (validarTela1()) {
        $("#tela2").removeClass("hidden");
        $("#tela1").addClass("hidden");
    }
});

$(document).on('click', '#btn_tela2', function () {
    $("#tela1").removeClass("hidden");
    $("#tela2").addClass("hidden");
});

$(document).on('change', '#form-register #tipo', function () {
    var tipo = $(this).val();
    if (tipo == "associado") {
        $("#form-associado").removeClass("hidden");
    } else {
        $("#form-associado").addClass("hidden");
    }
});

function validarTela1() {
    var valido = true;
    $("#div-errors").html("").addClass("hidden");

    if ($("#form-register #name").val().trim() == "") {
        valido = false;
        $("#div-errors").append("<li>Nome é obrigatório.</li>");
    }

    if ($("#form-register #email").val().trim() == "") {
        valido = false;
        $("#div-errors").append("<li>Email é obrigatório.</li>");
    }

    if ($("#form-register #password").val().trim() == "") {
        valido = false;
        $("#div-errors").append("<li>Senha é obrigatório.</li>");
    }

    if ($("#form-register #password_confirmation").val().trim() == "") {
        valido = false;
        $("#div-errors").append("<li>Confirmar senha é obrigatório.</li>");
    }

    if ($("#form-register #tipo").val().trim() == "") {
        valido = false;
        $("#div-errors").append("<li>Selecionar um perfil é obrigatório.</li>");
    }

    if (!valido) {
        $("#div-errors").removeClass("hidden");
    }

    return valido;
}
