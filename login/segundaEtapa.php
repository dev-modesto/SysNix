<?php

use App\Controllers\UsuarioEmpresaController;

require_once '../app/Config/config.php';
include SEGURANCA;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresa | SysNix</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/global/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/cor.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/fonts.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/login/login.css">

    <!-- fonts google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>

<div class="conteudo-login">
    <div class="container-login empresa">
        <div>
            <div class="container-img">
                <a href=""><img src="<?= BASE_URL ?>/assets/img/logo/logo-full-color.svg" alt="logo"></a>
            </div>
            <div class="container-empresa-login">
                <form id="form-login-segunda-etapa" class="container-formulario">
                    <div class="mb-0">
                        <label class="font-1-s peso-medio" for="email-login">Empresa</label>
                        <div class="container-input-empresa-login">
                            <select class="form-select font-1-s peso-normal" id="empresa-login" name="empresa-login">
                                <?php
                                    $dadosEmpresaUsuario = UsuarioEmpresaController::buscarEmpresasUsuario($idUsuario);

                                    foreach ($dadosEmpresaUsuario as $chave => $valor) {
                                        echo <<<HTML
                                            <option value="{$valor['uuid']}">{$valor['nome_legal']}</option>
                                        HTML;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="">
                        <button class="btn-entrar font-1-s peso-semi-bold" type="submit">CONFIRMAR ENTRADA</button>
                    </div>
                    <div id="container-msg">
                    </div>
                </form>
            </div>
        </div>
        <div class="rodape-login">
            <p class="font-1-s" >© <?= $anoAtual ?> · Desenvolvido por <strong>devModesto</strong></p>
        </div>
    </div>
</div>

</body>
</html>

<!-- importação scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<script>

    $(document).ready(function () {

        $('#form-login-segunda-etapa').submit(function (e) { 
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('controller','Auth');
            formData.append('acao','validarEmpresaSelecionada');

            $.ajax({
                type: "POST",
                url: "../public/ajaxController.php",
                data: formData,
                processData: false,
                contentType: false,
                
                beforeSend: function () {
                    const btnHtmlString = '<svg width="24" height="24" stroke="#45D7C6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><circle cx="12" cy="12" r="9.5" fill="none" stroke-width="3" stroke-linecap="round"><animate attributeName="stroke-dasharray" dur="1.5s" calcMode="spline" values="0 150;42 150;42 150;42 150" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/><animate attributeName="stroke-dashoffset" dur="1.5s" calcMode="spline" values="0;-16;-59;-59" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/></circle><animateTransform attributeName="transform" type="rotate" dur="2s" values="0 12 12;360 12 12" repeatCount="indefinite"/></g></svg>';
                    $('.btn-entrar').html(btnHtmlString);
                    $('.btn-entrar').prop('disabled', true);
                },
                success: function (response) {
                    const btnHtmlString = 'CONFIRMAR ENTRADA';
                    $('.btn-entrar').html(btnHtmlString);

                    if ((response.data.status) == 0) {
                        window.location.href = '../' + response.data.redirecionar;
                        $('.btn-entrar').prop('disabled', false);
                        $('#senha-login').val('');
                        $('#email-login').val('');

                    } else {
                        $('.btn-entrar').prop('disabled', false);
                        $('#container-msg').html(response.data.msgHtml);
                    }
                }
            });
        });
    });

</script>