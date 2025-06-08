<?php

use App\Helpers\UuidHelper;

include_once '../../../../app/config/config.php';

    if(isset($_POST['click-excluir'])){
        $uuidPublic = $_POST['idPrincipal'];
        
        $uuidHelper = new UuidHelper();
        $dadosReturn = $uuidHelper->enviaUuidBuscaDados('tbl_tela', $uuidPublic);

        if (empty($dadosReturn)) {
            echo <<<HTML
                <div>
                    <p>Dados para exclusão não encontrados.</p>
                </div>
            HTML;
            die();
        }   

        $nomeTela = $dadosReturn['nome'];

    } 
?>

<div>
    <p>
        Você tem certeza que deseja remover a tela <strong><?= $nomeTela ?></strong> ?<br>
    </p>
</div>

<script src="<?= BASE_URL ?>/js/ajaxModalTabela.js"></script>

<script>
    ajaxModalTabelaAcaoExcluir(<?= json_encode($uuidPublic)?>, 'View', 'remover', baseUrl);
</script>