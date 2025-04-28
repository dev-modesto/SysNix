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