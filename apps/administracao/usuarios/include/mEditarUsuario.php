<?php

use App\Controllers\Empresa\EmpresaController;
use App\Controllers\UsuarioController;
use App\Controllers\UsuarioEmpresaController;

include_once '../../../../config/base.php';

    if(isset($_POST['click-acao-modal'])){
        $uuidPublic = $_POST['idPrincipal'];

        $dadosUsuario = UsuarioController::selecionarUsuarioUuid($uuidPublic);

        if (empty($dadosUsuario)) {
            echo <<<HTML
                <div>
                    <p>Dados para edição não encontrados.</p>
                </div>
            HTML;
            die();
        }   

        $idUsuario = $dadosUsuario['id'];
        $email = $dadosUsuario['email'];
        $nome = $dadosUsuario['nome'];
        $sobrenome = $dadosUsuario['sobrenome'];

        $dadosEmpresaUsuarioBanco = UsuarioEmpresaController::buscarEmpresasUsuario($idUsuario);

    } 


?>

<div>
    <form class="form-container" id="form-editar-usuario">
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="font-1-s" for="nome">Nome<em>*</em></label><br>
                <input class="form-control" type="text" name="nome" id="nome" value="<?= $nome ?>" required>
            </div>
            <div class="col-md-6">
                <label class="font-1-s" for="sobrenome">Sobrenome <em>*</em></label><br>
                <input class="form-control" type="text" name="sobrenome" id="sobrenome" value="<?= $sobrenome ?>" required>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <label class="font-1-s" for="email">E-mail<em>*</em></label><br>
                <input class="form-control" type="email" name="email" id="email" value="<?= $email ?>" required>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <label class="font-1-s" for="empresa">Empresa <em>*</em></label><br>
            <select class="form-select js-example-basic-multiple" name="public-key-empresa[]" id="empresa" multiple="multiple" required>
                <?php

                    $dadosEmpresaUsuarioBanco = UsuarioEmpresaController::buscarEmpresasUsuario($idUsuario);

                    foreach ($dadosEmpresaUsuarioBanco as $chave => $valor) {
                        $idEmpresaBanco = $valor['id'];
                        $uuidEmpresaBanco = $valor['uuid'];
                    }

                    $uuidsEmpresasUsuario = [];

                    foreach ($dadosEmpresaUsuarioBanco as $empresa) {
                        $uuidsEmpresasUsuario[] = $empresa['uuid'];
                    }

                    $dadosEmpresas = EmpresaController::buscarEmpresas();

                    foreach ($dadosEmpresas as $empresa) {
                        $uuid = $empresa['uuid'];
                        $nome = $empresa['nome_fantasia'];
                        $selected = in_array($uuid, $uuidsEmpresasUsuario) ? 'selected' : '';

                        echo <<<HTML
                            <option value="$uuid" $selected>$nome</option>
                        HTML;
                    }
                    
                ?>
            </select>                                        
        </div>
    </form>
</div>

<script src="<?= BASE_URL ?>/js/ajaxModalTabela.js"></script>
<script>

    ajaxControllerModalAcao(<?= json_encode($uuidPublic) ?>, '.modal-body-editar', '#form-editar-usuario', 'Usuario', 'atualizar', baseUrl);

</script>