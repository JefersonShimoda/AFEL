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
