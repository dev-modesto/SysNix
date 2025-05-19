<?php

use App\Models\ModuloModel;

$nomeUsuario = 'Gabriel Modesto';

$moduloModel = new ModuloModel();
$dadosModulos = $moduloModel->selecionarModulos();

?>

<body class="body-conteudo">
<header class="header">
    <div class="principal-container-header">
        <div class="container-header-esquerda">
            <div class="container-botao-menu">
                <div class="botao-menu">
                    <span class="material-symbols-rounded"> keyboard_arrow_left</span>
                </div>
            </div>
            
            <div class="container-titulo-cabecalho">
                <!-- <h1 class="font-1-xxl-1 peso-semi-bold"><?= isset($tituloPagina) == '' ? '-' : $tituloPagina ?></h1> -->
            </div>
        </div>

        <div class="container-usuario-logado">
            <div class="usuario-info">
                <div class="usuario-logado-texto">
                    <p><?= $nomeUsuario ?></p> 
                    <span>Administrador</span>
                </div>
                <div class="usuario-logado-icodown">
                    <span class="material-symbols-rounded ico-icodown">keyboard_arrow_down</span>
                </div>
                <div class="usuario-logado-dropdown">
                    <ul class="dropwdown-logado" class="font-2-xs">
                        <li><a href="<?= BASE_URL ?>/app/administracao/perfil/index.php"><span class="material-symbols-rounded">account_circle</span>Meu perfil</a></li>
                        <li><a href="<?=BASE_URL?>/app/Config/logoff.php"><span class="material-symbols-rounded">logout</span>Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<nav class="container-sidebar">
    <div class="logo sidebar">
        <a href="<?= BASE_URL . "/apps/home/"?>"><img class="img-logo" src="<?=BASE_URL?>/assets/img/logo/logo-full-white.svg" data-logoMax="<?=BASE_URL?>/assets/img/logo/logo-full-white.svg" data-logoMin="<?=BASE_URL?>/assets/img/logo/logo-min-white.svg" alt="" ></a>
    </div>

    <ul class="sidebar-itens">
        <?php 
            if (!empty($dadosModulos)) {

                $baseUrl = BASE_URL;

                foreach ($dadosModulos as $chave => $valor) {

                    $idModulo = $valor['id'];
                    $nome = $valor['nome'];
                    $icone = $valor['icone'];
                    $caminho = $valor['caminho'];
                    $status = $valor['status'];

                    echo <<<PHP
                            <li class=""><a href="$baseUrl/apps/$caminho/" class="font-1-s"><span class="material-symbols-rounded">$icone</span><p class="texto-nav">$nome</p></a></li>
                    PHP;
                }

            } 
        ?>
    </ul>
</nav>

