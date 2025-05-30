<?php

namespace App\Services\Usuario;

use App\Helpers\DataHelper;
use App\Helpers\GeralHelper;
use App\Helpers\UuidHelper;
use App\Models\UsuarioModels;
use App\Models\UsuarioVinculo\UsuarioVinculoModel;

class UsuarioService
{

    public function cadastrarUsuario(array $dados) {

        $uuid = GeralHelper::genUuid();
        $nome = trim($dados['nome']);
        $sobrenome = trim($dados['sobrenome']);
        $email = trim($dados['email']);
        $emailValido = GeralHelper::regexValidaEmail($email);

        $camposVazios = array_filter($dados, function($valor) {
            return empty($valor);
        });

        if (!empty($camposVazios)) {
            $retorno = array_keys($camposVazios);
            return ['status' => 1, 'dados' => $retorno, 'msg' => 'Todos os campos precisam ser preenchidos corretamente.', 'alert' => 1];
        } 
        
        if (!$emailValido) {
            return ['status' => 1, 'mensagem' => 'E-mail inválido para cadastro.', 'alert' => 1];
        }

        $publicKeyEmpresa = $dados['public-key-empresa'];

        $uuidHelper = new UuidHelper();
        $retornoUuidHelper = $uuidHelper->enviaUuidBuscaDados('tbl_empresa', $publicKeyEmpresa);

        if (empty($retornoUuidHelper)) {
            return ['status' => 1, 'mensagem' => 'Número de ID não permitido.', 'alert' => 1];
        } 

        $retornoIdEmpresa = $retornoUuidHelper['id'];

        $senha = $dados['senha'];
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $status = 'validar';
        $primeiroAcesso = 'sim';
        $tentativasLogin = 0;
        
        $dataHelper = DataHelper::getDataHoraSistema();     

        $dadosEnviar = [
            'uuid' => $uuid,
            'email' => $email,
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'senha' => $senhaHash,
            'primeiro_acesso' => $primeiroAcesso,
            'tentativas_login' => $tentativasLogin,
            'status' => $status,
            'created_at' => $dataHelper['data_hora_banco'],
            'updated_at' => $dataHelper['data_hora_banco']
        ];

        $usuarioModel = new UsuarioModels();
        $retornoIdUsuario = $usuarioModel->cadastrarUsuario($dadosEnviar);

        if (!$retornoIdUsuario) {
            return ['status' => 1, 'msg' => 'Não foi possível cadastrar o usuario.', 'alert' => 1];
        }

        $usuarioVinculo = new UsuarioVinculoModel();
        $dadosVincularUsuarioEmpresa = [
            'id_empresa' => $retornoIdEmpresa,
            'id_usuario' => $retornoIdUsuario,
            'created_at' => $dataHelper['data_hora_banco']
        ];
        $retornoIdUsuarioEmpresa = $usuarioVinculo->vincularUsuarioEmpresa($dadosVincularUsuarioEmpresa);

        if (!$retornoIdUsuarioEmpresa) {
            return ['status' => 1, 'msg' => 'Não foi possível vincular o usuário à empresa selecionada.', 'alert' => 1];
        }

        return ['status' => 0, 'msg' => "Usuário $nome $sobrenome cadastrado com sucesso.", 'alert' => 0, 'redirecionar' => 'apps/administracao/usuarios/'];

    }
}