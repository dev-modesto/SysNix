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

function abrirModalAcao(botaoClick, classIdTabela, idDataPesquisa, urlCaminho, classClickTrue, classModal, idModal) {
    $(document).ready(function () {

        $(document).on('click', botaoClick, function (e) {
            e.preventDefault();
            var idPrincipal = $(this).closest(classIdTabela).data(idDataPesquisa);

            $.ajax({
                type: "POST",
                url: urlCaminho,
                data: {
                    [classClickTrue]: true,
                    idPrincipal: idPrincipal,
                },
                beforeSend: function() {
                    $(classModal).html('<p>Carregando informações...</p>');
                    $(idModal).modal('show');
                },
                success: function (response) {
                    $(classModal).html(response);
                }
            });
        });

    });
}

abrirModalAcao('.icone-acao-excluir', 'tr', 'key-public', 'include/mExcluirEquipamentoCalibracao.php', 'click-excluir', '.modal-body-excluir', '#modal-excluir');