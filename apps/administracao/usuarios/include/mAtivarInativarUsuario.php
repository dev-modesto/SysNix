<?php

use App\Helpers\UuidHelper;

include_once '../../../../app/config/config.php';

    if(isset($_POST['click-acao-modal'])){
        $uuidPublic = $_POST['idPrincipal'];

        $uuidHelper = new UuidHelper();
        $retornoUuidHelperUsuario = $uuidHelper->enviaUuidBuscaDados('tbl_usuario', $uuidPublic);

        switch ($retornoUuidHelperUsuario['status']) {
            case 'ativo':
                $condicaoMensagem = 'inativar';
                break;
            
            case 'inativo':
                $condicaoMensagem = 'ativar';
                break;
            
            default:
                $condicaoMensagem = 'inativar';
                break;
        };
    } 
?>

<div>
    <form class="form-container" id="form-ativar-desativar-usuario">
        <p>
            Você tem certeza que deseja <strong><?= $condicaoMensagem ?></strong> o usuário? <br>
        </p>
    </form>
</div>

<script>
    ajaxControllerModalAcao(<?= json_encode($uuidPublic) ?>, '.modal-body-alerta', '#form-ativar-desativar-usuario', 'Usuario', 'ativarInativar', baseUrl);
</script>