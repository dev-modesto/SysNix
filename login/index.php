<?php
    include '../config/base.php';
    include BASE_PATH . '/include/funcoes/geral/mensagem.php';

    $msg = '';
    $alert = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include 'include/cLogin.php';
    }   

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
            <form class="container-formulario" action="" method="POST">
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
                <?php
                    mensagemAlertaSet($msg, $alert);
                ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

</script>