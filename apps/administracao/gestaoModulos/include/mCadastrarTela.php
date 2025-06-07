<?php

include_once '../../../../config/base.php';

?>

<div>
    <form class="form-container" id="form-cadastrar-tela">
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="font-1-s" for="nome">Nome<em>*</em></label><br>
                <input class="form-control" type="text" name="nome" id="nome" required>
            </div>
            <div class="col-md-6">
                <label class="font-1-s" for="icone">ícone <em>*</em></label><br>
                <input class="form-control" type="text" name="icone" id="icone" required>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <label class="font-1-s" for="caminho">Caminho<em>*</em></label><br>
                <input class="form-control" type="caminho" name="caminho" id="caminho" required>
            </div>
        </div>
    </form>
</div>

<script src="<?= BASE_URL ?>/js/ajaxModalTabela.js"></script>
<script>

    ajaxControllerModalAcao(null, '.modal-body-cadastrar', '#form-cadastrar-tela', 'View', 'cadastrar', baseUrl);

</script>