<?php

use App\Helpers\UuidHelper;

include_once '../../../../config/base.php';

    if(isset($_POST['click-acao-modal'])){
        $uuidPublic = $_POST['idPrincipal'];

        $uuidHelper = new UuidHelper();
        $dadosReturn = $uuidHelper->enviaUuidBuscaDados('tbl_tela', $uuidPublic);

        if (empty($dadosReturn)) {
            echo <<<HTML
                <div>
                    <p>Dados para edição não encontrados.</p>
                </div>
            HTML;
            die();
        }   

        $nome = $dadosReturn['nome'];
        $icone = $dadosReturn['icone'];
        $caminho = $dadosReturn['caminho'];

    } 
?>

<div>
    <form class="form-container" id="form-editar-tela">
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="font-1-s" for="nome">Nome<em>*</em></label><br>
                <input class="form-control" type="text" name="nome" id="nome" value="<?= $nome ?>" required>
            </div>
            <div class="col-md-6">
                <label class="font-1-s" for="icone">ícone <em>*</em></label><br>
                <input class="form-control" type="text" name="icone" id="icone" value="<?= $icone ?>" required>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <label class="font-1-s" for="caminho">Caminho<em>*</em></label><br>
                <input class="form-control" type="caminho" name="caminho" id="caminho" value="<?= $caminho ?>" required>
            </div>
        </div>
    </form>
</div>

<script src="<?= BASE_URL ?>/js/ajaxModalTabela.js"></script>
<script>

    ajaxControllerModalAcao(<?= json_encode($uuidPublic) ?>, '.modal-body-editar', '#form-editar-tela', 'View', 'atualizar', baseUrl);

</script>