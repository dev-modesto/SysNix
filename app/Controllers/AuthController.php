<?php
namespace App\Controllers;

use App\Helpers\MensagemHelper;
use App\Helpers\SessionHelper;
use App\Helpers\UuidHelper;
use App\Models\TokenModel;
use App\Models\UsuarioEmpresaModel;
use App\Services\AlthUserService;
use App\Services\EmailService;

class AuthController {
    public static function salvarTokenBancoController($dados) {

        $tokenModel = new TokenModel();
        $return = $tokenModel->inserir($dados);

        return $return;
    }

    public static function enviarEmailController($destinatarioEmail, $destinatarioNome, $codigo) {
        $emailService = new EmailService();

        return $emailService->enviarCodigoAutenticacaoService($destinatarioEmail, $destinatarioNome, $codigo);

    }

    public static function validarToken($dados) {
        return $validaToken = AlthUserService::validarCodigoAutenticacao($dados);
    }

    public function consultar($dados) {
        $dadosReturn = AlthUserService::consultar($dados);
        $dadosReturn = array_merge($dadosReturn, ['msgHtml' => MensagemHelper::mensagemAlertaHtml($dadosReturn['msg'], $dadosReturn['alert'])]);
        return $dadosReturn;

    }

    public function validarEmpresaSelecionada($dados) {
        $uuidEmpresa = $dados['empresa-login'];

        $uuidHelper = new UuidHelper();
        $retornoIdEmpresa = $uuidHelper->enviaIdBuscaUuid('tbl_empresa', $uuidEmpresa);

        if (!empty($retornoIdEmpresa)) {
            
            $sessaoHelper = SessionHelper::dadosSessao();
            $usuarioEmpresa = new UsuarioEmpresaModel();
            $dadosUsuarioEmpresa = $usuarioEmpresa->selecionarEmpresaUsuario($sessaoHelper['id_usuario'], $retornoIdEmpresa);

            if (!empty($dadosUsuarioEmpresa)) {
                $_SESSION['id_empresa'] = $dadosUsuarioEmpresa['id'];
                $_SESSION['uuid_empresa'] = $dadosUsuarioEmpresa['uuid'];
                $_SESSION['nome_legal'] = $dadosUsuarioEmpresa['nome_legal'];
                $dadosReturn = ['status' => 0, 'msg' => 'Credenciais da empresa validada.', 'alert' => 0, 'redirecionar' => 'app/'];
                
            } else {
                $dadosReturn = ['status' => 1, 'msg' => 'Empresa não localizada.', 'alert' => 1];
            }
            
        } else {
            $dadosReturn = ['status' => 1, 'msg' => 'Empresa não localizada.', 'alert' => 1];
        }
        
        $dadosReturn = array_merge($dadosReturn, ['msgHtml' => MensagemHelper::mensagemAlertaHtml($dadosReturn['msg'], $dadosReturn['alert'])]);
        return $dadosReturn;
    }

}