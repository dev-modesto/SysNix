<?php
    if (!isset($_POST['abrir-modal'])) {
        return;
    }

    echo <<<HTML
        <!-- capa modal -->
        <div class="modal fade modal-componente" id="modal-excluir" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-excluir" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-second">
                        <span class="icone-alerta-modal material-symbols-rounded">error</span>
                    </div>
            
                    <div class="modal-body body-alerta-modal modal-body-excluir">
                    </div>

                    <form class="was-validated form-container">
                        <div class="modal-footer excluir form-container-button">
                            <button class="col btn btn-secondary btn-modal-cancelar" type="button" data-bs-dismiss="modal">Cancelar</button>
                            <button class="col btn btn-modal-excluir">Excluir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    HTML;   