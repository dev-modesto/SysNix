<?php
    include '../config/base.php';
    include BASE_PATH . '/include/funcoes/geral/mensagem.php';

    if(session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if ($_SESSION['token'] === null) {
        header('location: ../login/');
        die();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticação | SysNix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/global/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/cor.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/fonts.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/login/login.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/autenticacao/autenticacao.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0"/>

    <!-- fonts google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>

<div class="conteudo-autenticacao">
    <div class="container-autenticacao">
        <div>
            <a href="<?= BASE_URL ?>/login/" class="container-btn-voltar" style="">
                <span style="font-size: 2rem" class="icon-voltar material-symbols-rounded">arrow_back_ios</span>
            </a>
            <h1 class="font-3-x peso-semi-bold">Código de autenticação</h1>
            <p style="margin-bottom: 40px;" class="font-1-s peso-normal">Enviamos um código de verificação de seis dígitos para o e-mail <strong><?= $_SESSION['email']?></strong></p>
            <form class="container-formulario autenticacao">
                <div class="mb-0">
                    <div class="">
                        <input class="font-1-s peso-normal" type="text" name="codigo-autenticacao" id="codigo-autenticacao" placeholder="Informe o código de seis dígitos" required>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="" class="btn-reenviar-codigo font-1-s" style="pointer-events: none; opacity: 0.6;">Reenviar código em ()</a>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn-verificar font-1-s peso-semi-bold" disabled type="submit">VERIFICAR</button>
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
<script src="<?= BASE_URL ?>/vendor/igorescobar/jquery-mask-plugin/src/jquery.mask.js"></script>

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


    function qntCaracteresCodigoAutenticacao(quantidade) {
        if((quantidade) <= 5) {
            $('.btn-verificar').prop('disabled', true);

        } else {
            $('.btn-verificar').prop('disabled', false);
        }
    }

    $('#codigo-autenticacao').mask('000000');

    $('#codigo-autenticacao').keyup(function (e) { 
        var codigoAutenticacao = $('#codigo-autenticacao').val();
        var caracteresCodigoAutenticacao = codigoAutenticacao.length;
        qntCaracteresCodigoAutenticacao(caracteresCodigoAutenticacao);
    });


    $('.autenticacao').submit(function (e) { 
        e.preventDefault();
        const codigoAutenticacao = $('#codigo-autenticacao').val();

        $.ajax({
            type: "POST",
            url: "../public/ajaxControllere.php",
            data: {
                'acao':'valida-token',
                'codigo-autenticacao':codigoAutenticacao
            },
        
            beforeSend: function () {
                const btnHtmlString = '<svg width="24" height="24" stroke="#45D7C6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g><circle cx="12" cy="12" r="9.5" fill="none" stroke-width="3" stroke-linecap="round"><animate attributeName="stroke-dasharray" dur="1.5s" calcMode="spline" values="0 150;42 150;42 150;42 150" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/><animate attributeName="stroke-dashoffset" dur="1.5s" calcMode="spline" values="0;-16;-59;-59" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/></circle><animateTransform attributeName="transform" type="rotate" dur="2s" values="0 12 12;360 12 12" repeatCount="indefinite"/></g></svg>';
                $('.btn-verificar').html(btnHtmlString);
                $('.btn-verificar').prop('disabled', true);
            },
            success: function (response) {
                const btnHtmlString = 'VERIFICAR';
                $('.btn-verificar').html(btnHtmlString);
                $('.btn-verificar').prop('disabled', false);
                
                if ((response.alert) == 0) {
                    window.location.href = '../' + response.redirecionar;
                    
                } else {
                    $('#container-msg').html(response.msgHtml);
                }
            }
        });

    });

</script>