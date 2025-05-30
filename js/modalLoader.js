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

function abrirModalEditarExcluir(botaoClick, classIdTabela, urlCaminho, classClickTrue, classBody, idModal, tamanhoModal, textoTituloModal) {

    $(document).on('click', botaoClick, function (e) {
        e.preventDefault();
        let idPrincipal = $(this).closest(classIdTabela).data('key-public');

        if (botaoClick) {
            let tipoModal = $(this).data('tipo-modal');

            if (tipoModal == 'modal-editar') {
                var capaModal = '/include/modal/capaModalEditar.php';
            }

            if (tipoModal == 'modal-excluir') {
                var capaModal = '/include/modal/capaModalExcluir.php';
            }
        }

        $.ajax({
            type: "POST",
            url: baseUrl + capaModal,
            data: {
                'abrir-modal':true
            },
            success: function (response) {
                $('.carregar-modal').html(response);    
                let elementoTituloModal = $('.modal-title');
                $('.modal-componente').addClass(tamanhoModal);

                $.ajax({
                    type: "POST",
                    url: urlCaminho,
                    data: {
                        [classClickTrue]: true,
                        idPrincipal: idPrincipal,
                    },
                    beforeSend: function() {
                        let modeloSpinners = spinners();
                        let htmlString = modeloSpinners['modelo-1-cor1'];
                        $(elementoTituloModal).html(htmlString);
                        $(classBody).html('<p>Carregando informações...</p>');
                        $(idModal).modal('show');
                    },
                    success: function (response) {
                        $(classBody).html(response);
                        $(elementoTituloModal).html(textoTituloModal);
                    }
                });
            }
        });
    });
}

function abrirModalCadastrar(urlCaminho, classBody, idModal, tamanhoModal, textoTituloModal) {

    $.ajax({
        type: "POST",
        url: baseUrl + '/include/modal/capaModalCadastrar.php',
        data: {
            'abrir-modal':true
        },
        success: function (response) {
            $('.carregar-modal').html(response);    
            let elementoTituloModal = $('.modal-title');
            $('.modal-componente').addClass(tamanhoModal);

            $.ajax({
                type: "POST",
                url: urlCaminho,
                beforeSend: function() {
                    let modeloSpinners = spinners();
                    let htmlString = modeloSpinners['modelo-1-cor1'];
                    $(elementoTituloModal).html(htmlString);
                    $(classBody).html('<p>Carregando informações...</p>');
                    $(idModal).modal('show');
                
                },
                success: function (response) {
                    $(classBody).html(response);
                    $(elementoTituloModal).html(textoTituloModal);
                }
            });
        }
    });
}

$(document).ready(function () {

    $(document).on('click', '[data-bs-dismiss="modal"]', function () {
        this.blur();
    });

    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.carregar-modal').html('');

        if (document.activeElement && $(this).has(document.activeElement).length > 0) {
            document.activeElement.blur();
        }
        
        $(this).find('.modal-dialog').removeClass('modal-sm modal-md modal-lg modal-xl');

    });

    abrirModalEditarExcluir('.icone-acao-excluir-equipamento-calibracao', 'tr', 'include/mExcluirEquipamentoCalibracao.php', 'click-excluir', '.modal-body-excluir', '#modal-excluir', 'modal-md', '-');
    abrirModalEditarExcluir('.icone-acao-editar-equipamento-calibracao', 'tr', 'include/mEditarEquipamentoCalibracao.php', 'click-acao-modal', '.modal-body-editar', '#modal-editar', 'modal-lg', 'Editar equipamento de calibração');
    abrirModalEditarExcluir('.icone-acao-editar-usuario', 'tr', 'include/mEditarUsuario.php', 'click-acao-modal', '.modal-body-editar', '#modal-editar', 'modal-lg', 'Editar usuário');
});