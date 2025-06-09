<?php

use App\Controllers\ModuloController;
use App\Controllers\ViewController;

include_once '../../../../config/base.php';
    $dadosTelaSemVinculoModulo = ViewController::selecionarTelasSemVinculoModulo();

    if (empty($dadosTelaSemVinculoModulo)) {
        echo <<<HTML
                <div>
                    <p>Nenhuma view disponível para vincular aos modulos.</p>
                </div>
            HTML;
        die();
    }

?>

<style>

    .container-lista-telas {
        border-top: 1px solid var(--color-a3);
    }

    .container-info-tela {
        display: flex;
        min-height: 60px;
        border: 1px solid var(--color-a3);
        border-top: none;
    }
    .container-icone-tela {
        display: flex;
        justify-content: center;
        align-items: center;
        width: auto;
        padding: 10px;
    }

    .container-icone-tela span {
        background-color: var(--color-a1);
        padding: 5px;
        border: 1px solid var(--color-a3);
        border-radius: .3rem;
    }

    .container-info-tela-texto {
        width: 100%;
        padding: 10px 10px 10px 0px;
        align-items: start;
        display: flex;
        flex-direction: column;
    }

    .container-info-tela-texto p{
        text-align: left;
    }

    .container-info-tela-texto label {
        padding: 0px;
    }

    .container-info-tela-switch {
        display: flex;
        align-items: center;
        padding: 0px 10px;
    }

    .form-check-input {
        border: 1px solid var(--color-a4);
    }

</style>


<div>
    <form class="form-container" id="form-vincular-view-modulo">

        <div class="col-md-12 mb-4">
            <label class="font-1-s" for="modulo">Módulo vínculo <em>*</em></label><br>
            <select class="form-select select-modulo" name="public-key-modulo" id="modulo" required>
                <option value="" selected>Escolha um módulo</option>
                <?php

                    $allModulos = ModuloController::selecionar();

                    foreach ($allModulos as $valor) {
                        echo <<<HTML
                            <option value="{$valor['uuid']}">{$valor['nome']}</option>
                        HTML;
                    }
                    
                ?>
            </select>                                        
        </div>

        <div class="col-md-12">
            <div class="container-lista-telas">
                <?php
                    
                    foreach ($dadosTelaSemVinculoModulo as $chave => $valor) {
                        $uuidTela = $valor['uuid'];
                        $nomeTela = $valor['nome'];
                        $iconeTela = $valor['icone'];

                        echo <<<HTML

                            <div class="container-info-tela">
                                <div class="container-icone-tela">
                                    <span class="material-symbols-rounded icone-acao-ativar-inativar-modulo" data-tipo-modal="modal-alerta-acao">$iconeTela</span>
                                </div>
                                <div class="container-info-tela-texto">
                                    <label for="switch-$uuidTela"><strong>$nomeTela</strong></label>
                                    <p>Uma descricao qualquer da minha tela para explicar sobre isso...</p>
                                </div>
                                <div class="form-check form-switch container-info-tela-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="array-public-key-tela[]" value="$uuidTela" id="switch-$uuidTela">
                                </div>
                            </div>

                        HTML;
                    }
                ?>
             
            </div>
     
        </div>
    </form>
</div>

<script src="<?= BASE_URL ?>/js/ajaxModalTabela.js"></script>
<script>

    ajaxControllerModalAcao(null, '.modal-body-cadastrar', '#form-vincular-view-modulo', 'Vinculo', 'cadastrar', baseUrl);

</script>