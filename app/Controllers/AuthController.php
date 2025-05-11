<?php
namespace App\Controllers;

use App\Helpers\MensagemHelper;
use App\Models\TokenModel;
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

}