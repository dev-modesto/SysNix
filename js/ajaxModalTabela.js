function ajaxModalTabelaAcaoExcluir(publickey, controller, acao, baseUrl) {

    $(document).ready(function () {

        $('.btn-modal-excluir').on('click', function (e) {
            e.preventDefault();

            const dados = {
                'public-key':publickey,
                'controller':controller,
                'acao':acao
            };

            $.ajax({
                type: "POST",
                url: `${baseUrl}/public/ajaxController.php`,
                data: dados,
                success: function (response) {
                    window.location.href = `${baseUrl}/${response.data.redirecionar}?msg=${encodeURIComponent(response.data.msg)}&alert=${response.data.alert}`;
                }
            });
        });

    });
}
