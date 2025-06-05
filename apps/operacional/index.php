<?php

use App\Controllers\ModuloController;
use App\Controllers\PermissaoViewController;
use App\Helpers\MensagemHelper;

include_once '../../app/config/config.php';
include SEGURANCA;
include ARQUIVO_CONEXAO;

$nomePasta = basename(__DIR__);
$arrayDadosModulo = ModuloController::retornarModuloCaminho($nomePasta);
$nomeModulo = $arrayDadosModulo['nome'];
$moduloPagina = $nomeModulo;

$arrayDadosViewsPermissoes = PermissaoViewController::retornarViewsPermitidasModulo($_SESSION['id_usuario'], $nomePasta);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($moduloPagina) == '' ? '-' : $moduloPagina ?> | SysNix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet" integrity="sha384-2vMryTPZxTZDZ3GnMBDVQV8OtmoutdrfJxnDTg0bVam9mZhi7Zr3J1+lkVFRr71f" crossorigin="anonymous">
    
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/global/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/cor.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/fonts.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/sidebar/sidebar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/navbar/navbar-top.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/pre-loader.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/componentes/componentes.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0"/>

    <!-- fonts google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>

    <style>
        .container-msg {
            margin: 15px 0;
            padding: 0px 40px;
            margin-top: 90px;
        }

        .breadcrumb {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 15px 0;
            margin-top: 0px;
            padding: 0px 40px;
            grid-area: breadcrumb;
        }
        .breadcrumb a {
            color: #007BFF;
            text-decoration: none;
            margin-right: 5px;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .breadcrumb span {
            color: #555;
            font-size: 1.375rem;
            font-weight: 500;
        }

        .font-1-s {
            color:var(--color-a8)
        }

    </style>
<body>

<?php
    include BASE_PATH . '/include/preLoad/preLoad.php';
    include BASE_PATH . '/include/sidebar/sidebar.php';
?>

<div id="container-msg" class="container-msg"></div>

<div class="breadcrumb">
    <span><?= $moduloPagina ?></span>
    <!-- <a href="usuarios.php">Usuários</a> &gt;
    <a href="usuarios.php">Usuários</a> &gt; -->
</div>

<div class="conteudo">

    <div class="container-principal">
        <?php
            include BASE_PATH . '/include/viewsModulo/viewsModulo.php';
        ?>
    </div>

</div>

<div class="container-copyright">
    <p class="font-1-s">© <?= $anoAtual ?> · Sysnix · Todos os direitos reservados </p>
    <p class="font-1-s">Desenvolvido por <a href="https://devmodesto.com.br" target="_blank" rel="noopener noreferrer" class="font-1-s peso-medio">devModesto</a></p>
</div>

<!-- importação scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<script src="<?= BASE_URL ?>/js/preLoader.js"></script>
<script src="<?= BASE_URL ?>/js/menu.js"></script>
<script src="<?= BASE_URL ?>/js/modalLoader.js"></script>

</body>