<?php

namespace App\Services;
use App\Controllers\AuthController;
use App\Config\Connection;
use App\Controllers\UsuarioEmpresaController;
use App\Models\UsuarioModels;
use App\Helpers\GeralHelper;
use App\Helpers\DataHelper;
use App\Helpers\MensagemHelper;
use App\Models\TokenModel;

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
                $acessoEmpresa = $dados['acesso_empresa'];

                if(password_verify($senha, $senhaBanco)) {
                    // ok, senha correta. Faremos agora outras verificações...
                    
                    session_start();
                    $_SESSION['id_usuario'] = $idUsuario;
                    $_SESSION['uuid'] = $uuid;
                    $_SESSION['email'] = $email;
                    $_SESSION['nome'] = $nome;
                    $_SESSION['sobrenome'] = $sobrenome;
                    $_SESSION['nome_completo'] = "$nome $sobrenome";

                    $dadosBuscarEmpresasUsuario = UsuarioEmpresaController::buscarEmpresasUsuario($idUsuario);

                    if(!empty($dadosBuscarEmpresasUsuario)) {
                        
                        if ($primeiroAcesso === 'sim' && $status === 'validar') {

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

                                } else {
                                    $mensagem = ['status' => 0, 'msg' => 'Ocorreu um erro a enviar o email.', 'alert' => 1];
                                }

                            } else {
                                $mensagem = ['status' => 0, 'msg' => 'Não foi possível salvar a token.', 'alert' => 1];
                            }

                            return $mensagem;

                        } elseif ($status === 'ativo') {
                            if($tentativasLogin > 3) {  
                                $mensagem = ['status' => 0, 'msg' => 'Tentativas de login excedidas. Tente novamente em: 3 minutos.', 'alert' => 1];
                                return $mensagem;
                            }

                            if ($acessoEmpresa === 1) {
                                $_SESSION['id_empresa'] = $dadosBuscarEmpresasUsuario[0]['id'];    
                                $_SESSION['uuid_empresa'] = $dadosBuscarEmpresasUsuario[0]['uuid'];    
                                $_SESSION['nome_fantasia_empresa'] = $dadosBuscarEmpresasUsuario[0]['nome_fantasia'];
                                $mensagem = ['status' => 0, 'msg' => 'Login concedido.', 'alert' => 0, 'redirecionar' => 'app/'];
                            } 
                            
                            if ($acessoEmpresa > 1) {
                                $mensagem = ['status' => 0, 'msg' => 'Login concedido.', 'alert' => 0, 'redirecionar' => 'login/segundaEtapa.php'];
                            } 
                            
                            return $mensagem;

                        } else {
                            $mensagem = ['status' => 0, 'msg' => 'Usuário <strong>sem acesso </strong> ao sistema.', 'alert' => 1];
                            return $mensagem;
                        }

                    } else {
                        $mensagem = ['status' => 0, 'msg' => 'Empresa inativa. Usuário <strong>sem acesso </strong> ao sistema.', 'alert' => 1];
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

    public static function validarCodigoAutenticacao($dados) {

        $codigo = $_POST['codigo-autenticacao'];

        if ($codigo !== '') {

            if (is_numeric($codigo)) {
                $codigo = intval($codigo);

                if (strlen($codigo) < 6) {
                    $mensagem = ['status' => 1, 'msg' => 'O código deve conter 6 dígitos.', 'alert' => 1];
                    $mensagem = array_merge($mensagem, ['msgHtml' => MensagemHelper::mensagemAlertaHtml($mensagem['msg'], $mensagem['alert'])]);
                    header('Content-Type: application/json');
                    echo json_encode($mensagem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    die();
                }

                if(session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
        
                $token = $_SESSION['token'];
                $dadosEnviarConsultaToken = ['token' => $token, 'codigo_verificacao' => $codigo];

                $tokenModel = new TokenModel();
                $arrayRetorno = $tokenModel->consultar($dadosEnviarConsultaToken);

                if($arrayRetorno['status'] == 0) {
                    $dadosRetorno = $arrayRetorno['dados'];

                    if(!empty($dadosRetorno)) {
                        $dataHelper = DataHelper::getDataHoraSistema();
                        $dataHoraSistema = $dataHelper['data_hora_banco'];

                        if($dataHoraSistema < $dadosRetorno['validade'] && $dadosRetorno['usado'] === 'nao') {

                            $idToken = ['id_token' => $dadosRetorno['id']];
                            $returnAtualizar = $tokenModel->atualizar($idToken);

                            if ($returnAtualizar['linhas_afetadas'] == 1) {
                                $dadosEnviarAtualizarAcesso = ['updated_at' => $dataHoraSistema, 'email' => $_SESSION['email']];
                                $returnAtualizarAcesso = $tokenModel->atualizarAcessoLoginUsuarioToken($dadosEnviarAtualizarAcesso);

                                if ($returnAtualizarAcesso['status'] === 0) {
                                    
                                    if ($returnAtualizarAcesso['linhas_afetadas'] == 1) {
                                        $_SESSION['token'] = null;
                                        $mensagem = ['status' => 0, 'redirecionar' => 'app/'];

                                    } else {
                                        $mensagem = ['status' => 1 , 'redirecionar' => 'autenticacao/', 'msgHtml' => MensagemHelper::mensagemAlertaHtml($returnAtualizarAcesso['msg'], 1)];
                                    }

                                } else {
                                    $mensagem = ['status' => 1 , 'redirecionar' => 'autenticacao/', 'msgHtml' => MensagemHelper::mensagemAlertaHtml($returnAtualizarAcesso['msg'], 1)];
                                }

                            } else {
                                $mensagem = ['status' => 1, 'msgHtml' => MensagemHelper::mensagemAlertaHtml('Não foi possível validar o código de autenticação.', 1)];
                            }
                        
                        } else {
                            $mensagem = ['status' => 1, 'msgHtml' => MensagemHelper::mensagemAlertaHtml('Código expirado. Reenvie novamente.', 1)];
                        }

                    } else {
                        $mensagem = ['status' => 1, 'msgHtml' => MensagemHelper::mensagemAlertaHtml('Código não encontrado.', 1)];
                    }
                }

                header('Content-Type: application/json');
                echo json_encode($mensagem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                die();

            } else {
                $mensagem = ['status' => 1, 'msgHtml' => MensagemHelper::mensagemAlertaHtml('O código deve conter apenas números.', 1)];
                header('Content-Type: application/json');
                echo json_encode($mensagem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                die();
            }

        } else {
            $mensagem = ['status' => 1, 'msgHtml' => MensagemHelper::mensagemAlertaHtml('Informe o código de autenticação.', 1)];
            header('Content-Type: application/json');
            echo json_encode($mensagem);
        }
    }
}