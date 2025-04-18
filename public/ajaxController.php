<?php

use App\Controllers\AuthController;

require_once '../config/base.php';
include BASE_PATH . '/include/funcoes/geral/mensagem.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'];

    switch($acao) {
        case 'login-usuario':
            $emailUsuario = $_POST['email-login'];
            $senhaUsuario = $_POST['senha-login'];
            $dadosRetorno = AuthController::consultaLoginController($con,$dataHoraSistema,$emailUsuario,$senhaUsuario);

            if ($dadosRetorno['alert'] == 0) {
                $mensagem = ['msg' => $dadosRetorno['msg'], 'alert' => 0, 'redirecionar' => $dadosRetorno['redirecionar']];
                $mensagem = array_merge($mensagem, ['msgHtml' => mensagemAlertaHtml($mensagem['msg'], $mensagem['alert'])]);
                header('Content-Type: application/json');
                echo json_encode($mensagem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                die();

            } else {
                $mensagem = ['msg' => $dadosRetorno['msg'], 'alert' => 1];
                $mensagem = array_merge($mensagem, ['msgHtml' => mensagemAlertaHtml($mensagem['msg'], $mensagem['alert'])]);
                header('Content-Type: application/json');
                echo json_encode($mensagem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                die();
            }

            break;

        case 'valida-token':
            
            if(session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (isset($_POST['codigo-autenticacao'])) {
                $codigo = $_POST['codigo-autenticacao'];

                if ($codigo !== '') {

                    if (is_numeric($codigo)) {
                        $codigo = intval($codigo);

                        if (strlen($codigo) < 6) {
                            $mensagem = ['msg' => 'O código deve conter 6 dígitos.', 'alert' => 1];
                            $mensagem = array_merge($mensagem, ['msgHtml' => mensagemAlertaHtml($mensagem['msg'], $mensagem['alert'])]);
                            header('Content-Type: application/json');
                            echo json_encode($mensagem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                            die();
                        }
                        
                        $token = $_SESSION['token'];
                        $dadosRetorno = AuthController::validaTokenController($con, $dataHoraSistema, $token, $codigo);

                        if ($dadosRetorno['alert'] == 0) {
                            $mensagem = ['msg' => $dadosRetorno['msg'], 'alert' => 0, 'redirecionar' => 'redirecionar para a aplicacao'];
                            header('Content-Type: application/json');
                            echo json_encode($mensagem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

                        } else {
                            $mensagem = ['msg' => $dadosRetorno['msg'], 'alert' => 1, 'redirecionar' => 'autenticacao/'];
                            $mensagem = array_merge($mensagem, ['msgHtml' => mensagemAlertaHtml($dadosRetorno['msg'], $dadosRetorno['alert'])]);
                            // $mensagem = array_merge(['msgHtml' => mensagemAlertaHtml($mensagem['msg'], $mensagem['alert'])]);
                            header('Content-Type: application/json');
                            echo json_encode($mensagem);
                        }


                    } else {
                        $mensagem = ['msg' => 'O código deve conter apenas números.', 'alert' => 1];
                        $mensagem = array_merge($mensagem, ['msgHtml' => mensagemAlertaHtml($mensagem['msg'], $mensagem['alert'])]);
                        header('Content-Type: application/json');
                        echo json_encode($mensagem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                        die();

                    }

                } else {
                    $mensagem = ['msg' => 'Informe o código de autenticação', 'alert' => 1];
                    $mensagem = array_merge($mensagem, ['msgHtml' => mensagemAlertaHtml($mensagem['msg'], $mensagem['alert'])]);
                    header('Content-Type: application/json');
                    echo json_encode($mensagem);
                }
            
            } else {
                // nenhum post realziadoo..
            }

            break;

        default:
    }
}