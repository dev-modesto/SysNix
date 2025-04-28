<?php
    include_once '../../../config/base.php';
?>

<div class="modal modal-lg fade" id="mCadastrarEquipamentoCalibracao" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="mCadastrarEquipamentoCalibracao" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar Equipamento de Calibração</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="form-container" method="post" action="">

                    <ul class="nav nav-underline">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link nav-modal " id="informacoes-iniciais" data-bs-toggle="tab" data-bs-target="#informacoes-iniciais-pane" type="button" role="tab" aria-controls="informacoes-iniciais-pane" aria-selected="true">Geral</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link nav-modal" id="especificidade" data-bs-toggle="tab" data-bs-target="#especificidade-pane" type="button" role="tab" aria-controls="especificidade-pane" aria-selected="true">Especificidade</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link nav-modal" id="erro-incerteza" data-bs-toggle="tab" data-bs-target="#erro-incerteza-pane" type="button" role="tab" aria-controls="erro-incerteza-pane" aria-selected="false">Erro e Incerteza</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link nav-modal active" id="status" data-bs-toggle="tab" data-bs-target="#status-pane" type="button" role="tab" aria-controls="status-pane" aria-selected="false">Status</button>
                        </li>
                    </ul>
                    <br>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show " id="informacoes-iniciais-pane" role="tabpanel" aria-labelledby="informacoes-iniciais" tabindex="0">
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="font-1-s" for="nome-identificador">Nome identificador <em>*</em></label><br>
                                    <input class="form-control" type="text" name="nome-identificador" id="nome-identificador" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-1-s" for="descricao">Descrição <em>*</em></label><br>
                                    <input class="form-control" type="text" name="descricao" id="descricao" required>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-4">
                                    <label class="font-1-s" for="modelo">Modelo <em>*</em></label><br>
                                    <input class="form-control" type="text" name="modelo" id="modelo" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="font-1-s" for="fabricante">Fabricante <em>*</em></label><br>
                                    <input class="form-control" type="text" name="fabricante" id="fabricante" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="font-1-s" for="numero-serie">Número de série <em>*</em></label><br>
                                    <input class="form-control" type="text" name="numero-serie" id="numero-serie" required>
                                </div>
                    
                            </div>
                        </div>

                        <div class="tab-pane fade" id="especificidade-pane" role="tabpanel" aria-labelledby="especificidade" tabindex="0">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="font-1-s" for="resolucao">Resolução <em>*</em></label><br>
                                    <input class="form-control" type="text" name="resolucao" id="resolucao" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-1-s" for="faixa-uso">Faixa de uso <em>*</em></label><br>
                                    <input class="form-control" type="text" name="faixa-uso" id="faixa-uso" required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-3 mb-4">
                                    <label class="font-1-s" for="data-ultima-calibracao">Data última calibração <em>*</em></label><br>
                                    <input class="form-control" type="date" name="data-ultima-calibracao" id="data-ultima-calibracao">
                                </div>
                                <div class="col-md-3 mb-4">
                                    <label class="font-1-s" for="data-previsao-calibracao">Data previsão calibração <em>*</em></label><br>
                                    <input class="form-control" type="date" name="data-previsao-calibracao" id="data-previsao-calibracao">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="font-1-s" for="numero-certificado">Nº Certificado <em>*</em></label>
                                    <input class="form-control" type="text" name="numero-certificado" id="numero-certificado" required>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="erro-incerteza-pane" role="tabpanel" aria-labelledby="erro-incerteza" tabindex="0">
                            <div class="row mb-4">
                                <div class="col-md-4 mb-4">
                                    <label class="font-1-s" for="ei-15a25-n">-15° a -25° <em>*</em></label><br>
                                    <input class="form-control" type="text" name="ei-15a25-n" id="ei-15a25-n" required>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="font-1-s" for="ei-2a8">2° a 8° <em>*</em></label><br>
                                    <input class="form-control" type="text" name="ei-2a8" id="ei-2a8" required>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="font-1-s" for="ei-15a25">15° a 25° <em>*</em></label><br>
                                    <input class="form-control" type="text" name="ei-15a25" id="ei-15a25" required>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show active" id="status-pane" role="tabpanel" aria-labelledby="status" tabindex="0">

                            <div class="row mb-4">
                                <div class="col-md-6 mb-4">
                                    <label class="font-1-s" for="status-funcional">Status funcional <em>*</em></label><br>
                                    <select class="form-select" name="id-status-funcional" id="status-funcional">
                                        <option value="" selected>Escolha um status</option>
                                        <?php

                                            $sqlStatusFuncional = "SELECT * FROM tbl_status_funcional";
                                            $query = mysqli_query($con, $sqlStatusFuncional);
                                            
                                            if ($query) {
                                                $dadosStatusFuncional = mysqli_fetch_all($query, MYSQLI_ASSOC);

                                                foreach ($dadosStatusFuncional as $valor) {
                                                    $idStatusFuncional = $valor['id'];
                                                    $nome = $valor['nome'];
                                                    ?>
                                                        <option value="<?= $idStatusFuncional ?>"><?= $nome ?></option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>                                        
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <label class="font-1-s" for="status-uso">Status de uso <em>*</em></label><br>
                                    <select class="form-select" name="id-status-uso" id="status-uso" disabled>
                                        <option value="" selected>Escolha um status funcional</option>
                                    </select>                                        
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer form-container-button">
                        <button type="button" class="col btn btn-secondary btn-modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
                        <button class='col btn btn-primary cadastrar' type="submit">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    $('#status-funcional').on('change', function () {
        idStatusFuncional = $('#status-funcional').val();

        if (idStatusFuncional !== '') {
            $('#status-uso').attr('disabled', false);

            htmlString = '';

            $.ajax({
                type: "POST",
                url: "../../public/ajaxController.php",
                data: {
                    'acao':'cStatus-uso-equipamento',
                    'id-status':idStatusFuncional
                },
                success: function (response) {

                    if(response.alert == 0) {
                        
                        response.dados.forEach(function (item){
                            htmlString += `<option value="${item.id}">${item.nome}</option>`;
                        });
                        
                        $('#status-uso').html(htmlString);

                    } else {
                        $('#status-uso').html('<option value="">Erro ao carregar os dados</option>');
                        $('#status-uso').attr('disabled', true);
                    }

                },
                error: function(response) {
                    $('#status-uso').html('<option value="">Erro ao carregar os dados</option>');
                }
            });

            $('#status-uso').html(htmlString);
            
        } else {
            $('#status-uso').attr('disabled', true);
            $('#status-uso').html('<option value="" selected>Escolha um status funcional</option>');
        }

    });

</script>