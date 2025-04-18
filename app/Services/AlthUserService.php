<?php

namespace App\Services;
use App\Controllers\AuthController;
use mysqli;

require_once '../config/base.php';

include BASE_PATH . '/include/funcoes/geral/geral.php';
include BASE_PATH . '/include/funcoes/dbQueries/geral.php';

class AlthUserService {

    public static function consultaLoginService($con, $dataHoraSistema, $emailLogin, $senhaLogin) {
        $email = removerCaracteresInput($emailLogin);
        $senha = removerCaracteresInput($senhaLogin);
    
        if(regexValidaEmail($email)) {
    
            $sql = "SELECT * FROM tbl_usuario WHERE email = ?";
            $sqlPrepare = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($sqlPrepare,'s', $email);
            
            if(mysqli_stmt_execute($sqlPrepare)) {
                $returnConsulta = mysqli_stmt_get_result($sqlPrepare);
    
                if (mysqli_num_rows($returnConsulta)) {
                
                    $dados = mysqli_fetch_assoc($returnConsulta);
                    $idUsuario = $dados['id'];
                    $uuid = $dados['uuid'];
                    $email = $dados['email'];
                    $nome = $dados['nome'];
                    $sobrenome = $dados['sobrenome'];
                    $senhaBanco = $dados['senha'];
                    $primeiroAcesso = $dados['primeiro_acesso'];
                    $tentativasLogin = $dados['tentativas_login'];
                    $status = $dados['status'];
    
                    if(password_verify($senha, $senhaBanco)) {
                        // ok, senha correta. Faremos agora outras verificações...
                        
                        session_start();
                        $_SESSION['idUsuario'] = $idUsuario;
                        $_SESSION['uuid'] = $uuid;
                        $_SESSION['email'] = $email;
                        $_SESSION['nome'] = $nome;
                        $_SESSION['sobrenome'] = $sobrenome;
    
    
                        if ($primeiroAcesso === 'sim' && $status === 'validar') {
                            $salvarTokenBanco = AuthController::salvarTokenBancoController($con, $dataHoraSistema, $idUsuario);
    
                            if ($salvarTokenBanco['alert'] == 0) {

                                $_SESSION['token'] = $salvarTokenBanco['token'];
    
                                $enviarEmail = AuthController::enviarEmailController($email,"$nome $sobrenome", $salvarTokenBanco['codigo']);
    
                                if ($enviarEmail) {
                                    // email enviado devemos redirecionar...
                                    $mensagem = ['msg' => 'redirecionar para index de autenticação', 'alert' => 0, 'redirecionar' => 'autenticacao/'];
                                    // header("location: " . BASE_URL . "/autenticacao/index.php");
    
                                } else {
                                    $mensagem = ['msg' => 'Ocorreu um erro a enviar o email.', 'alert' => 1];
                                }
    
                            } else {
                                $mensagem = ['msg' => 'Não foi possível salvar a token.', 'alert' => 1];
                            }

                            return $mensagem;
    
                        } elseif ($status === 'ativo') {
                            // verificar tentativas login
    
                            if($tentativasLogin > 3) {  
                                $mensagem = ['msg' => 'Tentativas de login excedidas. Tente novamente em: 3 minutos.', 'alert' => 1];
                                return $mensagem;
                            }

                            $mensagem = ['msg' => 'Login concedido.', 'alert' => 0, 'redirecionar' => 'app/'];
                            return $mensagem;
    
                        } else {
                            // exibir alerta isuario sem acesso ao sistema.
                            $mensagem = ['msg' => 'Usuário <strong>sem acesso </strong> ao sistema.', 'alert' => 1];
                            return $mensagem;
                        }

                    } else {
                        $mensagem = ['msg' => 'Usuário ou senha incorreta', 'alert' => 1];
                        return $mensagem;
                    }
    
                } else {
                    $mensagem = ['msg' => 'Usuário ou senha incorreta', 'alert' => 1];
                    return $mensagem;
                }
    
            } else {
                $mensagem = ['msg' => 'Ocorreu um erro. Não foi possível realizar o login.', 'alert' => 1];
                return $mensagem;
            }
    
        } else {
            $mensagem = ['msg' => 'Email inválido. Favor, insira um email válido.', 'alert' => 1];
            return $mensagem;
        }
    }

    public static function validaCodigoAutenticacaoService($con, $dataHoraSistema, string $token, int $codigo) {     
        
        $sql = "SELECT * FROM tbl_token WHERE token = ? AND codigo_verificacao = ?";
        $sqlPrepare = mysqli_prepare($con, $sql);

        mysqli_stmt_bind_param($sqlPrepare, 'si', $token, $codigo);
        
        if(mysqli_stmt_execute($sqlPrepare)) {
            $result = mysqli_stmt_get_result($sqlPrepare);

            if(mysqli_num_rows($result) > 0) {
                $dados = mysqli_fetch_assoc($result);
                $idCodigo = $dados['id'];

                if($dataHoraSistema < $dados['validade'] && $dados['usado'] === 'nao') {

                    $sqlUpdateUsoCodigo = "UPDATE tbl_token SET usado = 'sim' WHERE id = $idCodigo";

                    if(mysqli_query($con, $sqlUpdateUsoCodigo)) {
                        if(mysqli_affected_rows($con) > 0) {
                            $mensagem = ['msg' => 'Código válido.', 'alert' => 0];

                        } else {
                            $mensagem = ['msg' => 'Não foi possível validar o codigo de autenticação.', 'alert' => 1];
                        }

                    } else {
                        $mensagem = ['msg' => 'Ocorreu um erro. Não foi possível validar o codigo de autenticação.', 'alert' => 1];
                    };

                } else {
                    $mensagem = ['msg' => 'Código expirado. Reenvie novamente.', 'alert' => 1];
                }

            } else {
                $mensagem = ['msg' => 'Código inválido.', 'alert' => 1];
            }
    
            return $mensagem;
        }
    }
}