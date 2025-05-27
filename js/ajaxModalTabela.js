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

function ajaxControllerModalAcao(publickey = null, formSubmit, controller, acao, baseUrl) {

    $(document).ready(function () {

        $(document).on('submit', `${formSubmit}`, function (e) {
            e.preventDefault();

            if (!this.checkValidity()) {
                this.reportValidity();
                return;
            }

            const formData = new FormData(this);
            formData.append('controller', controller)
            formData.append('acao',acao);

            if (publickey) {
                formData.append('public-key', publickey);
            }

            $.ajax({
                type: "POST",
                url: `${baseUrl}/public/ajaxController.php`,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    window.location.href = `${baseUrl}/${response.data.redirecionar}?msg=${encodeURIComponent(response.data.msg)}&alert=${response.data.alert}`;
                }
            });
        });

        $(document).on('click', '.btn-submit-modal', function () {
            $(`${formSubmit}`).trigger('submit');
        });

    });
}