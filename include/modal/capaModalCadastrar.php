<?php
    if (!isset($_POST['abrir-modal'])) {
        return;
    }

    echo <<<HTML
        <!-- capa modal -->
        <div class="modal fade modal-componente" id="modal-cadastrar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-cadastrar" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body modal-body-cadastrar">
                    </div>

                    <div class="modal-footer excluir form-container-button">
                        <button class="col btn btn-secondary btn-modal-cancelar" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class='col btn btn-primary btn-submit-modal cadastrar' type="submit">Cadastrar</button>
                    </div>
                    
                </div>
            </div>
        </div>
    HTML;


