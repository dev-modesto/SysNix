<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_SESSION['uuid'])){

        $idUsuario = $_SESSION['idUsuario'];
        $uuidUsuario = $_SESSION['uuid'];
        $email = $_SESSION['email'];
        $nomeUsuario = $_SESSION['nome'];
        $sobrenomeUsuario = $_SESSION['sobrenome'];
        $nomeCompletoUsuario = "$nomeUsuario $sobrenomeUsuario";

    }

    if(empty($_SESSION)) {
        header('location: ' . BASE_URL . '/login/index.php');
    }