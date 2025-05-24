<?php
include_once '../../../../app/config/config.php';

    if(isset($_POST['click-excluir'])){
        $uuidPublic = $_POST['idPrincipal'];
        // pesquisar informações completas para retornar como personalização na mensagem
    } 
?>

<div>
    <p>
        <strong>Você tem certeza que deseja remover?</strong> <br>
    </p>
</div>

<script src="<?= BASE_URL ?>/js/ajaxModalTabela.js"></script>

<script>
    ajaxModalTabelaAcaoExcluir(<?= json_encode($uuidPublic)?>, 'EquipamentoCalibracao', 'remover', baseUrl);
</script>