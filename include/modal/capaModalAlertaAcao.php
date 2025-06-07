<?php
    if (!isset($_POST['abrir-modal'])) {
        return;
    }

    echo <<<HTML
        <!-- capa modal -->
        <div class="modal fade modal-componente" id="modal-alerta-acao" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-alerta-acao" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body body-alerta-modal modal-body-alerta">
                    </div>

                    <div class="modal-footer geral form-container-button">
                        <button class="col btn btn-secondary btn-modal-cancelar" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="col btn btn-submit-modal btn-modal-alerta-acao">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    HTML;   