<?php
    include '../config/base.php';
    include BASE_PATH . '/include/funcoes/geral/mensagem.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SysNix</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/global/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/cor.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/fonts.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/login/login.css">

    <!-- fonts google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">  Raleway --> 
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>

<div class="conteudo-login">
    <div class="container-login">
        <div>
            <div class="container-img">
                <a href=""><img src="<?= BASE_URL ?>/assets/img/logo/logo-full-color.svg" alt="logo"></a>
            </div>
            <h1>Entrar</h1>
            <form id="form-login" class="container-formulario">
                <div class="mb-0">
                    <label class="font-1-s peso-medio" for="email-login">E-mail</label>
                    <div class="container-input-usuario">
                        <input class="font-1-s peso-normal" type="email" name="email-login" id="email-login" placeholder="Informe seu e-mail" required>
                        <span class="icone-login icone-matricula"></span>
                    </div>
                </div>
                <div class="">
                    <label class="font-1-s peso-medio" for="senha-login">Senha</label>
                    <div class="container-input-senha">
                        <span class="icone-login icone-senha"></span>
                        <input class="font-1-s" type="password" name="senha-login" id="senha-login" placeholder="Digite sua senha" required>
                        <span class="icone-login icone-ver-senha"></span>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="" class="font-1-s">Esqueci minha senha</a>
                </div>
                <div class="">
                    <button class="btn-entrar font-1-s peso-semi-bold" type="submit">ENTRAR</button>
                </div>
                <div id="container-msg">
                </div>
            </form>
        </div>
        <div class="rodape-login">
            <p class="font-1-s" >© <?= $anoAtual ?> · Desenvolvido por <strong>devModesto</strong></p>
        </div>
    </div>

</div>

</body>
</html>

<!-- importação scripts -->
<script src="<?= BASE_URL ?>/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>

    $('.icone-ver-senha').click(function (e) { 
        e.preventDefault();
        const inputSenha = $('#senha-login')[0];
        const iconVerSenha = $('.icone-ver-senha')[0];

        if (inputSenha.type === 'password') {
            inputSenha.type = 'text';
            iconVerSenha.classList.add('visible');

        } else {
            inputSenha.type = 'password';
            iconVerSenha.classList.remove('visible');
        }
    });


    $('#form-login').submit(function (e) { 
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('acao','login-usuario');

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
                const btnHtmlString = 'ENTRAR';
                $('.btn-entrar').html(btnHtmlString);
                
                if ((response.alert) == 0) {
                    window.location.href = '../' + response.redirecionar;
                    $('.btn-entrar').prop('disabled', false);
                    $('#senha-login').val('');
                    $('#email-login').val('');

                } else {
                    $('.btn-entrar').prop('disabled', false);
                    $('#container-msg').html(response.msgHtml);
                }
            }
        });

    });

</script>