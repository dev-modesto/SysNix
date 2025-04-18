<?php
namespace App\Controllers;

use App\Services\AlthUserService;
use App\Services\EmailService;

class AuthController {
    public static function salvarTokenBancoController($con, $dataHoraSistema, $idUsuario) {

        $tokenCodigo = tokenCodigo();
        $token = $tokenCodigo['token'];
        $codigo = $tokenCodigo['codigo'];
        $usado = 'nao';
    
        $validade = date('Y-m-d H:i:s', strtotime('+10 minutes'));
    
        $sql = "INSERT INTO tbl_token(id_usuario,token,codigo_verificacao,usado,created_at,validade) values(?,?,?,?,?,?)";
        $sqlPrepare = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($sqlPrepare, "isisss", $idUsuario, $token, $codigo, $usado, $dataHoraSistema, $validade);
        
        if(mysqli_stmt_execute($sqlPrepare)) {
            $mensagem = [
                'alert' => 0, 
                'status' => 'sucesso', 
                'text' => 'Token salva com sucesso.',
                'token' => $token,
                'codigo' => $codigo
            ];
    
        } else {
            $mensagem = ['alert' => 1, 'status' => 'erro', 'text' => 'Erro ao salvar token.'];
        }
    
        return $mensagem;
    }

    public static function enviarEmailController($destinatarioEmail, $destinatarioNome, $codigo) {
        $emailService = new EmailService();

        return $emailService->enviarCodigoAutenticacaoService($destinatarioEmail, $destinatarioNome, $codigo);

    }

    public static function consultaLoginController($con, $dataHoraSistema, $emailLogin, $senhaLogin) {
        return $althUserService = AlthUserService::consultaLoginService($con, $dataHoraSistema, $emailLogin, $senhaLogin);
    }

    public static function validaTokenController($con, $dataHoraSistema, $token, $codigo) {
        return $validaToken = AlthUserService::validaCodigoAutenticacaoService($con, $dataHoraSistema, $token, $codigo);
    }

}