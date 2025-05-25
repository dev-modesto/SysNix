<?php

use App\Controllers\EquipamentoCalibracaoController;
use App\Controllers\StatusEquipamentoCalibracaoController;

    include_once '../../../../config/base.php';

    if(isset($_POST['click-acao-modal'])){
        $uuidPublic = $_POST['idPrincipal'];
        $dadosEquipamentoCalibracao = EquipamentoCalibracaoController::selecionarDadosEquipamentoCalibracaoUuid($uuidPublic);

        if (empty($dadosEquipamentoCalibracao)) {
            echo <<<HTML
                <div>
                    <p>Dados para edição não encontrados.</p>
                </div>
            HTML;
            die();
        }

        $nomeIdentificador = $dadosEquipamentoCalibracao['nome_identificador'];
        $descricao = $dadosEquipamentoCalibracao['descricao'];
        $modelo = $dadosEquipamentoCalibracao['modelo'];
        $fabricante = $dadosEquipamentoCalibracao['fabricante'];
        $serie = $dadosEquipamentoCalibracao['serie'];
        $resolucao = $dadosEquipamentoCalibracao['resolucao'];
        $faixaUso = $dadosEquipamentoCalibracao['faixa_uso'];
        $dtUltimaCalibracao = $dadosEquipamentoCalibracao['dt_ultima_calibracao'];
        $numeroCertificado = $dadosEquipamentoCalibracao['numero_certificado'];
        $dtCalibracaoPrevisao = $dadosEquipamentoCalibracao['dt_calibracao_previsao'];
        $ei15a25n = $dadosEquipamentoCalibracao['ei_15a25_n'];
        $ei2a8 = $dadosEquipamentoCalibracao['ei_2a8'];
        $ei15a25 = $dadosEquipamentoCalibracao['ei_15a25'];
        $idStatusFuncionalBanco = $dadosEquipamentoCalibracao['id_status_funcional'];
        $idStatusUsoBanco = $dadosEquipamentoCalibracao['id_status_uso'];

        $retornarStatusUso = StatusEquipamentoCalibracaoController::retornarStatusUsoPorFuncionalId($idStatusFuncionalBanco);
        $dadosStatusUso = $retornarStatusUso['dados'];

        if (empty($dadosStatusUso)) {
            echo <<<HTML
                <div>
                    <p>Alguns dados não foram encontrados. Não é será possível prosseguir.</p>
                </div>
            HTML;
            die();
        }
    } 

?>

<div>
    <form class="form-container" id="form-editar-equipamento-calibracao">

        <ul class="nav nav-underline">
            <li class="nav-item" role="presentation">
                <button class="nav-link nav-modal active" id="informacoes-iniciais" data-bs-toggle="tab" data-bs-target="#informacoes-iniciais-pane" type="button" role="tab" aria-controls="informacoes-iniciais-pane" aria-selected="true">Geral</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link nav-modal" id="especificidade" data-bs-toggle="tab" data-bs-target="#especificidade-pane" type="button" role="tab" aria-controls="especificidade-pane" aria-selected="true">Especificidade</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link nav-modal" id="erro-incerteza" data-bs-toggle="tab" data-bs-target="#erro-incerteza-pane" type="button" role="tab" aria-controls="erro-incerteza-pane" aria-selected="false">Erro e Incerteza</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link nav-modal" id="status" data-bs-toggle="tab" data-bs-target="#status-pane" type="button" role="tab" aria-controls="status-pane" aria-selected="false">Status</button>
            </li>
        </ul>
        <br>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="informacoes-iniciais-pane" role="tabpanel" aria-labelledby="informacoes-iniciais" tabindex="0">
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="font-1-s" for="nome-identificador">Nome identificador <em>*</em></label><br>
                        <input class="form-control" type="text" name="nome-identificador" id="nome-identificador" value="<?= $nomeIdentificador ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="font-1-s" for="descricao">Descrição <em>*</em></label><br>
                        <input class="form-control" type="text" name="descricao" id="descricao" value="<?= $descricao ?>" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-4">
                        <label class="font-1-s" for="modelo">Modelo <em>*</em></label><br>
                        <input class="form-control" type="text" name="modelo" id="modelo" value="<?= $modelo ?>" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="font-1-s" for="fabricante">Fabricante <em>*</em></label><br>
                        <input class="form-control" type="text" name="fabricante" id="fabricante" value="<?= $fabricante ?>" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="font-1-s" for="numero-serie">Número de série <em>*</em></label><br>
                        <input class="form-control" type="text" name="numero-serie" id="numero-serie" value="<?= $serie ?>" required>
                    </div>
        
                </div>
            </div>

            <div class="tab-pane fade" id="especificidade-pane" role="tabpanel" aria-labelledby="especificidade" tabindex="0">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="font-1-s" for="resolucao">Resolução <em>*</em></label><br>
                        <input class="form-control" type="text" name="resolucao" id="resolucao" value="<?= $resolucao ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="font-1-s" for="faixa-uso">Faixa de uso <em>*</em></label><br>
                        <input class="form-control" type="text" name="faixa-uso" id="faixa-uso" value="<?= $faixaUso ?>" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <label class="font-1-s" for="data-ultima-calibracao">Data última calibração <em>*</em></label><br>
                        <input class="form-control" type="date" name="data-ultima-calibracao" id="data-ultima-calibracao" value="<?= $dtUltimaCalibracao ?>">
                    </div>
                    <div class="col-md-3 mb-4">
                        <label class="font-1-s" for="data-previsao-calibracao">Data previsão calibração <em>*</em></label><br>
                        <input class="form-control" type="date" name="data-previsao-calibracao" id="data-previsao-calibracao" value="<?= $dtCalibracaoPrevisao ?>">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="font-1-s" for="numero-certificado">Nº Certificado <em>*</em></label>
                        <input class="form-control" type="text" name="numero-certificado" id="numero-certificado" value="<?= $numeroCertificado ?>" required>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="erro-incerteza-pane" role="tabpanel" aria-labelledby="erro-incerteza" tabindex="0">
                <div class="row mb-4">
                    <div class="col-md-4 mb-4">
                        <label class="font-1-s" for="ei-15a25-n">-15° a -25° <em>*</em></label><br>
                        <input class="form-control" type="text" name="ei-15a25-n" id="ei-15a25-n" value="<?= $ei15a25n ?>" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="font-1-s" for="ei-2a8">2° a 8° <em>*</em></label><br>
                        <input class="form-control" type="text" name="ei-2a8" id="ei-2a8" value="<?= $ei2a8 ?>" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label class="font-1-s" for="ei-15a25">15° a 25° <em>*</em></label><br>
                        <input class="form-control" type="text" name="ei-15a25" id="ei-15a25" value="<?= $ei15a25 ?>" required>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="status-pane" role="tabpanel" aria-labelledby="status" tabindex="0">

                <div class="row mb-4">
                    <div class="col-md-6 mb-4">
                        <label class="font-1-s" for="status-funcional">Status funcional <em>*</em></label><br>
                        <select class="form-select select-status-funcional" name="public-key-status-funcional" id="status-funcional" required>
                            <option value="" selected>Escolha um status</option>
                            <?php
                                $dadosStatusEquipamentoFuncional = StatusEquipamentoCalibracaoController::bucarStatusFuncional();

                                $selected = '';
                                foreach ($dadosStatusEquipamentoFuncional as $valor) {
                                    $idStatusFuncional = $valor['id_status_funcional'];
                                    $uuidStatusFuncional = $valor['uuid'];
                                    $nomeStatusFuncional = $valor['nome'];

                                    $selected = $idStatusFuncionalBanco === $idStatusFuncional ? 'selected' : '';
                                    echo <<<HTML
                                            <option value="{$uuidStatusFuncional}" {$selected} >{$nomeStatusFuncional}</option>
                                    HTML;
                                }
                            ?>
                        </select>                                        
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label class="font-1-s" for="status-uso">Status de uso <em>*</em></label><br>
                        <select class="form-select select-status-uso" name="public-key-status-uso" id="status-uso">
                            <option value="" selected>Escolha um status funcional</option>
                            <?php
                                

                                $selected = '';
                                foreach ($dadosStatusUso as $valor) {
                                    $idStatusUso = $valor['id'];
                                    $uuidStatusUso = $valor['public_key_return'];
                                    $nomeStatusUso = $valor['nome'];

                                    $selected = $idStatusUsoBanco === $idStatusUso ? 'selected' : '';
                  
                                    echo <<<HTML
                                            <option value="{$uuidStatusUso}" {$selected} >{$nomeStatusUso}</option>
                                    HTML;
                                }
                            ?>
                        </select>                                        
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="<?= BASE_URL ?>/js/ajaxModalTabela.js"></script>
<script>

    $(document).off('change', '.select-status-funcional').on('change', '.select-status-funcional', function () {

        let $statusFuncional = $(this);
        let publicKey = $statusFuncional.val();

        if (publicKey == '') {
            $('.select-status-uso').attr('disabled', true);
            $('.select-status-uso').html('<option value="" selected>Escolha um status funcional</option>');
            return;
        }

        $('.select-status-uso').attr('disabled', false);

        htmlString = '';

        $.ajax({
            type: "POST",
            url: `${baseUrl}/public/ajaxController.php`,
            data: {
                'public-key':publicKey,
                'controller':'StatusEquipamentoCalibracao',
                'acao':'retornarStatusUso'
            },
            success: function (response) {

                if (response.data.status !== 0) {
                    $('.select-status-uso').html('<option value="">Erro ao carregar os dados</option>');
                    $('.select-status-uso').attr('disabled', true);
                    return;
                }

                const dados = response.data.dados;
                dados.forEach(function (item){
                    htmlString += `<option value="${item.public_key_return}">${item.nome}</option>`;
                });

                $('.select-status-uso').html(htmlString);

            },
            error: function(response) {
                $('.select-status-uso').html('<option value="">Erro ao carregar os dados</option>');
            }
        });

        $('.select-status-uso').html(htmlString);

    });

    ajaxControllerModalAcao(<?= json_encode($uuidPublic) ?>, '#form-editar-equipamento-calibracao', 'EquipamentoCalibracao', 'atualizar', baseUrl);
</script>


</script>



