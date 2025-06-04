<?php

namespace App\Services\Usuario;

use App\Helpers\DataHelper;
use App\Helpers\GeralHelper;
use App\Helpers\UuidHelper;
use App\Models\UsuarioEmpresaModel;
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
      
        $arrayEmpresa = [];

        if (count($dados['public-key-empresa']) == 0) {
            $arrayEmpresa[] = ['uuid_empresa' => $dados['public-key-empresa']];

        } else {

            foreach ($dados['public-key-empresa'] as $chave => $valorUuidEmpresa) {
                $arrayEmpresa[] = ['uuid_empresa' => $valorUuidEmpresa];
            }

        };

        $uuidHelper = new UuidHelper();

        $arrayRetornoUuidHelper = [];

        foreach ($arrayEmpresa as $valorUuidEmpresa) {
            $publicKeyEmpresa = $valorUuidEmpresa['uuid_empresa'];

            $retornoUuidHelper = $uuidHelper->enviaUuidBuscaDados('tbl_empresa', $publicKeyEmpresa);
            
            if (empty($retornoUuidHelper)) {
                return ['status' => 1, 'mensagem' => 'Número de ID não permitido.', 'alert' => 1];
            } 

            $arrayRetornoUuidHelper[] = ['id' => $retornoUuidHelper['id']];

        }

        foreach ($arrayRetornoUuidHelper as $valor) {
            $dadosVincularUsuarioEmpresa = [
                'id_empresa' => $valor['id']

            ];
        }

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

        foreach ($arrayRetornoUuidHelper as $valor) {
            $dadosVincularUsuarioEmpresa = [
                'id_empresa' => $valor['id'],
                'id_usuario' => $retornoIdUsuario,
                'created_at' => $dataHelper['data_hora_banco']
            ];

            $retornoIdUsuarioEmpresa = $usuarioVinculo->vincularUsuarioEmpresa($dadosVincularUsuarioEmpresa);

            if (!$retornoIdUsuarioEmpresa) {
                return ['status' => 1, 'msg' => 'Não foi possível vincular o usuário à empresa selecionada.', 'alert' => 1];
            }
        }

        return ['status' => 0, 'msg' => "Usuário $nome $sobrenome cadastrado com sucesso.", 'alert' => 0, 'redirecionar' => 'apps/administracao/usuarios/'];

    }

    public function atualizarUsuario(array $dados) {

        $publicKeyUsuario = $dados['public-key'];
        $nome = trim($dados['nome']);
        $sobrenome = trim($dados['sobrenome']);
        $email = trim($dados['email']);
        $emailValido = GeralHelper::regexValidaEmail($email);
        $dataHelper = DataHelper::getDataHoraSistema();   

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
      
        $arrayEmpresa = [];

        if (count($dados['public-key-empresa']) == 0) {
            $arrayEmpresa[] = ['uuid_empresa' => $dados['public-key-empresa']];

        } else {

            foreach ($dados['public-key-empresa'] as $valorUuidEmpresa) {
                $arrayEmpresa[] = ['uuid_empresa' => $valorUuidEmpresa];
            }

        };

        $uuidHelper = new UuidHelper();
        $retornoUuidHelperUsuario = $uuidHelper->enviaUuidBuscaDados('tbl_usuario', $publicKeyUsuario);
        $idUsuario = $retornoUuidHelperUsuario['id'];

        $arrayIdEmpresaFront = [];

        foreach ($arrayEmpresa as $valorUuidEmpresa) {
            $publicKeyEmpresa = $valorUuidEmpresa['uuid_empresa'];

            $retornoUuidHelper = $uuidHelper->enviaUuidBuscaDados('tbl_empresa', $publicKeyEmpresa);
            
            if (empty($retornoUuidHelper)) {
                return ['status' => 1, 'mensagem' => 'Identificação da empresa não encontrado.', 'alert' => 1];
            } 

            $arrayIdEmpresaFront[] = $retornoUuidHelper['id'];

        }

        $usuarioEmpresa = new UsuarioEmpresaModel();
        $dadosUsuarioEmpresaBanco = $usuarioEmpresa->selecionarEmpresaUsuario($idUsuario);

        $arrayIdEmpresaBanco = [];

        foreach ($dadosUsuarioEmpresaBanco as $valor) {
            $arrayIdEmpresaBanco[] = $valor['id'];
        }

        $arrayIdEmpresaRemover = [];
        $arrayIdEmpresaAdicionar = [];

        foreach ($arrayIdEmpresaBanco as $idEmpresaBanco) {

            if (!in_array($idEmpresaBanco, $arrayIdEmpresaFront)) {
                $arrayIdEmpresaRemover[] = ['id' => $idEmpresaBanco];
            } 
        }

        foreach ($arrayIdEmpresaFront as $idEmpresaFront) {

            if (!in_array($idEmpresaFront, $arrayIdEmpresaBanco)) {
                $arrayIdEmpresaAdicionar[] = ['id' => $idEmpresaFront];
            } 
            
        }

        $dataHelper = DataHelper::getDataHoraSistema();     

        $dadosEnviar = [
            'id' => $idUsuario,
            'email' => $email,
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'updated_at' => $dataHelper['data_hora_banco']
        ];

        $usuarioModel = new UsuarioModels();
        $retornoIdUsuario = $usuarioModel->atualizarUsuario($dadosEnviar);

        if (!$retornoIdUsuario) {
            return ['status' => 1, 'msg' => 'Não foi possível atualizar o usuario.', 'alert' => 1];
        }

        $usuarioVinculo = new UsuarioVinculoModel();

        if (!empty($arrayIdEmpresaRemover)) {
            foreach ($arrayIdEmpresaRemover as $valor) {
                $dadosVinculoEmpresaRemover = [
                    'id_empresa' => $valor['id'],
                    'id_usuario' => $idUsuario
                ];

                $usuarioVinculo = new UsuarioVinculoModel();
                $retornoUsuarioVinculoRemover = $usuarioVinculo->desvincularUsuarioEmpresa($dadosVinculoEmpresaRemover);

                if ($retornoUsuarioVinculoRemover == 0) {
                    return ['status' => 1, 'msg' => 'Não foi possível desvincular o usuário da empresa selecionada.', 'alert' => 1];
                }
            }
        }

        if (!empty($arrayIdEmpresaAdicionar)) {
            foreach ($arrayIdEmpresaAdicionar as $valor) {
                $dadosVinculoEmpresaAdicionar = [
                    'id_empresa' => $valor['id'],
                    'id_usuario' => $idUsuario,
                    'created_at' => $dataHelper['data_hora_banco']
                ];

                $usuarioVinculo = new UsuarioVinculoModel();
                $retornoIdUsuarioEmpresa = $usuarioVinculo->vincularUsuarioEmpresa($dadosVinculoEmpresaAdicionar);


                if (!$retornoIdUsuarioEmpresa) {
                    return ['status' => 1, 'msg' => 'Não foi possível vincular o usuário à empresa selecionada.', 'alert' => 1];
                }
            }
        }

        return ['status' => 0, 'msg' => "Usuário $nome $sobrenome atualizado com sucesso.", 'alert' => 0, 'redirecionar' => 'apps/administracao/usuarios/'];

    }
}