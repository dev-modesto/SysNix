<?php

use App\Controllers\StatusEquipamentoCalibracaoController;

    include_once '../../../../config/base.php';
?>

<style>

.container-importar {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border: 1px solid var(--color-a3);
    padding: 20px;
    margin-bottom: 20px;
}

.container-importar-text-icon span {
    font-size: 3rem;
}

.container-importar label {
    border: 1px solid var(--color-a4);
    border-radius: .3rem;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    width: 300px;
    height: 68px;
    cursor: pointer;
}

.container-importar label:hover {
    background-color: var(--color-a2);
    transition: all .3s;
}

.modelo-importar {
    border: 1px solid var(--color-a4);
    border-radius: .3rem;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    width: 300px;
    height: 68px;
    cursor: pointer;
}

.container-importar-input {
    display: flex;
    justify-content: center;
    padding: 10px 0px;
}

.container-importar-input.hidden,
.arquivo-importar-carregado.hidden {
    display: none;
}

.container-importar input {
    display: none;
}
.container-importar-text-icon {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

}

.arquivo-importar-carregado {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px solid var(--color-a4);
    border-radius: .3rem;
    padding: 5px 10px;
    width: 300px;
    height: 38px;
    margin-top: 10px;
    margin-bottom: 10px;
}

.remover-arquivo-importar {
    transition: all .3s;
    cursor: pointer;
}

.remover-arquivo-importar:hover {
    color: var(--color-a-red4);
    transition: all .3s;
}

</style>

<div>
    <form class="form-container" id="form-importar-equipamento-calibracao" enctype="multipart/form-data">

        <div class="container-importar">
            <div class="container-importar-text-icon">
                <span class="material-symbols-rounded icone">upload</span>
            </div>
            <div class="container-importar-input">
                <label class="font-1-s label-input-importar" for="importar-equipamento-calibracao">Click para escolher o arquivo</label><br>
                <input class="form-control input-importar" type="file" name="importar-equipamento-calibracao" id="importar-equipamento-calibracao" required>
            </div>
            <div class="container-importar-input">
                <a href="include/modelo_plano_calibracao.xlsx" class="font-1-s modelo-importar" download>Baixar o modelo</a><br>
            </div>
            <div class="arquivo-importar-carregado hidden">
                <p class="nome-arquivo-importar"></p>
                <span class="material-symbols-rounded icone remover-arquivo-importar">close</span>
            </div>
            <p class="font-1-s"><em>*</em>Arquivos suportados .xlsx</p>
        </div>
    </form>
</div>

<script src="<?= BASE_URL ?>/js/ajaxModalTabela.js"></script>
<script>

    ajaxControllerModalAcao(null, '.modal-body-cadastrar', '#form-importar-equipamento-calibracao', 'EquipamentoCalibracao', 'importar', baseUrl);

    $('.input-importar').on('change', function () {
        let files = this.files;

        if (files[0].name) {
            $('.nome-arquivo-importar').text(files[0].name);
            $('.container-importar-input').addClass('hidden');
            $('.arquivo-importar-carregado').removeClass('hidden');

        } else {
            console.log('nenhum arquivo encontradoo');
        }
    });

    $('.remover-arquivo-importar').click(function (e) { 
        e.preventDefault();
        $('.input-importar').val('');
        $('.nome-arquivo-importar').text('');
        $('.arquivo-importar-carregado').addClass('hidden');
        $('.container-importar-input').removeClass('hidden');
    });

</script>