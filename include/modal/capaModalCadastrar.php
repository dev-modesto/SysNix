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
?>
<style>

.modal-body {
    position: relative;
    min-height: 100px;
    height: 100%;
}

.modal-loader {
    display: flex;
    position: absolute;
    z-index: 999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255,255,255,1);
    justify-content: center;
    align-items: center;
}

.loader-conteudo {
    border: 8px solid #f3f3f3;
    border-top: 8px solid var(--color-t1);
    border-radius: 50%;
    width: 70px;
    height: 70px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}


</style>

