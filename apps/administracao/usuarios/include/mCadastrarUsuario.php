<?php

use App\Controllers\StatusEquipamentoCalibracaoController;
include_once '../../../../config/base.php';

?>

<div>
    <form class="form-container" id="form-cadastrar-usuario">
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="font-1-s" for="nome">Nome<em>*</em></label><br>
                <input class="form-control" type="text" name="nome" id="nome" required>
            </div>
            <div class="col-md-6">
                <label class="font-1-s" for="sobrenome">Sobrenome <em>*</em></label><br>
                <input class="form-control" type="text" name="sobrenome" id="sobrenome" required>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <label class="font-1-s" for="email">E-mail<em>*</em></label><br>
                <input class="form-control" type="email" name="email" id="email" required>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label class="font-1-s" for="senha">Senha <em>*</em></label><br>
                <input class="form-control" type="password" name="senha" id="senha" required>
            </div>
        </div>
    </form>
</div>

<script src="<?= BASE_URL ?>/js/ajaxModalTabela.js"></script>
<script>

    ajaxControllerModalAcao(null, '.modal-body-cadastrar', '#form-cadastrar-usuario', 'Usuario', 'cadastrar', baseUrl);

</script>