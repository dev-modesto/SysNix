function abrirModal(idModal, urlModal) {
    $.ajax({
        url: urlModal,
        method: 'GET',
        success: function (html) {
            $(`#${idModal}`).remove();
            $('body').append(html);
            $(`#${idModal}`).modal('show');
        },
        error: function () {
            alert("Erro ao carregar modal.");
        }
    });
}

function fecharModal(idModal, urlModal) {
    $.ajax({
        url: urlModal,
        method: 'GET',
        success: function () {
            $(`#${idModal}`).modal('hide');
        },
        error: function () {
            alert("Erro ao fechar modal.");
        }
    });
}