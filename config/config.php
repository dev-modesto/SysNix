<?php

    date_default_timezone_set('America/Sao_Paulo');
    $date = new DateTime();
    $anoAtual = date_format($date, 'Y');
    $dataSistemaBanco = date_format($date, 'Y-m-d');
    $dataSistemaPtBr = date_format($date, 'd/m/Y');
    $hora = date("H:i:s");
    $dataHoraSistema = "$dataSistemaBanco $hora";
    
    $caminhoProjetoLocal = "/sysnix";
    $protocolo = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';

    if ($host === 'localhost') {
        define('PASTA_CONFIG', $_SERVER['DOCUMENT_ROOT'] . $caminhoProjetoLocal . '/config');
        define('ARQUIVO_CONEXAO', PASTA_CONFIG . '/conexao.php');
        define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . $caminhoProjetoLocal);
        $caminhoProjeto = $caminhoProjetoLocal;
        
    } else {
        define('PASTA_CONFIG', $_SERVER['DOCUMENT_ROOT'] . '/config');
        define('ARQUIVO_CONEXAO', PASTA_CONFIG . '/conexao.php');
        define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
        $caminhoProjetoServer = '';
        $caminhoProjeto = $caminhoProjetoServer;
    }

    $url = $protocolo . $host . $caminhoProjeto;
    
    define('BASE_URL', $url);
    define('SEGURANCA', BASE_PATH . '/config/seguranca.php');