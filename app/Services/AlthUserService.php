<?php

namespace App\Services;
use App\Controllers\AuthController;
use App\Config\Connection;
use App\Models\UsuarioModels;
use App\Helpers\GeralHelper;
use App\Helpers\DataHelper;

class AlthUserService {

    public static function consultar($dados) {

        $email = GeralHelper::removerCaracteresInput($dados['email-login']);
        $senha = GeralHelper::removerCaracteresInput($dados['senha-login']);
        
        if(GeralHelper::regexValidaEmail($email)) {

            $usuarioModels = new UsuarioModels();
            $dados = $usuarioModels->selecionarCriterio($email);

            if (!empty($dados)) {

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

                        $idUsuario = $idUsuario;
                        $geraToken = GeralHelper::tokenCodigo();
                        $token = $geraToken['token'];
                        $codigo = $geraToken['codigo'];
                        $usado = 'nao';
                        $arrayDatas = DataHelper::getDataHoraSistema();
                        $dataHoraSistema = $arrayDatas['data_hora_banco'];
                        $validade = date('Y-m-d H:i:s', strtotime('+10 minutes'));

                        $dadosCompletoSalvarToken = 
                            [
                                'id_usuario' => $idUsuario,
                                'token' => $token,
                                'codigo_verificacao' => $codigo,
                                'usado' => $usado,
                                'created_at' => $dataHoraSistema,
                                'validade' => $validade
                            ]
                        ;

                        $salvarTokenBanco = AuthController::salvarTokenBancoController($dadosCompletoSalvarToken);

                        if ($salvarTokenBanco['status'] == 0) {

                            $_SESSION['token'] = $salvarTokenBanco['token'];

                            $enviarEmail = AuthController::enviarEmailController($email,"$nome $sobrenome", $salvarTokenBanco['codigo']);

                            if ($enviarEmail) {
                                // email enviado devemos redirecionar...
                                $mensagem = ['status' => 0, 'msg' => 'redirecionar para index de autenticação', 'alert' => 0, 'redirecionar' => 'autenticacao/'];
                                // header("location: " . BASE_URL . "/autenticacao/index.php");
                                // $mensagem = array_merge($mensagem, ['msgHtml' => mensagemAlertaHtml($mensagem['msg'], $mensagem['alert'])]);

                            } else {
                                $mensagem = ['status' => 0, 'msg' => 'Ocorreu um erro a enviar o email.', 'alert' => 1];
                            }

                        } else {
                            $mensagem = ['status' => 0, 'msg' => 'Não foi possível salvar a token.', 'alert' => 1];
                        }

                        return $mensagem;

                    } elseif ($status === 'ativo') {
                        // verificar tentativas login

                        if($tentativasLogin > 3) {  
                            $mensagem = ['status' => 0, 'msg' => 'Tentativas de login excedidas. Tente novamente em: 3 minutos.', 'alert' => 1];
                            return $mensagem;
                        }

                        $mensagem = ['status' => 0, 'msg' => 'Login concedido.', 'alert' => 0, 'redirecionar' => 'app/'];
                        return $mensagem;

                    } else {
                        // exibir alerta isuario sem acesso ao sistema.
                        $mensagem = ['status' => 0, 'msg' => 'Usuário <strong>sem acesso </strong> ao sistema.', 'alert' => 1];
                        return $mensagem;
                    }

                } else {
                    $mensagem = ['status' => 0, 'msg' => 'Usuário ou senha incorreta', 'alert' => 1];
                    return $mensagem;
                }

            } else {
                $mensagem = ['status' => 0, 'msg' => 'Usuário ou senha incorreta', 'alert' => 1];
                return $mensagem;
            }
    
        } else {
            $mensagem = ['status' => 0, 'msg' => 'Email inválido. Favor, insira um email válido.', 'alert' => 1];
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
                            $email = $_SESSION['email'];
                            $sqlUpdateUsuario = "UPDATE tbl_usuario SET primeiro_acesso = 'nao', status = 'ativo', updated_at = '$dataHoraSistema' WHERE email = '$email'";

                            if(mysqli_query($con, $sqlUpdateUsuario)) {
                                if(mysqli_affected_rows($con) > 0) { 
                                    $mensagem = ['msg' => 'Código válido.', 'alert' => 0];

                                } else {
                                    $mensagem = ['msg' => 'Não foi possível prosseguir com sua validação.', 'alert' => 1];
                                }

                            } else {
                                $mensagem = ['msg' => 'Ocorreu um erro. Não foi possível validar o codigo de autenticação.', 'alert' => 1];
                            }

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