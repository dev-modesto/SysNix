<?php

namespace App\Services\Modulo;

use App\Helpers\DataHelper;
use App\Helpers\GeralHelper;
use App\Helpers\UuidHelper;
use App\Models\ModuloModel;

class ModuloService
{
    public function cadastrarModulo(array $dados) {

        $uuid = GeralHelper::genUuid();
        $nome = trim($dados['nome']);
        $icone = trim($dados['icone']);
        $caminho = trim($dados['caminho']);
        $status = 'ativo';

        $camposVazios = array_filter($dados, function($valor) {
            return empty($valor);
        });

        if (!empty($camposVazios)) {
            $retorno = array_keys($camposVazios);
            return ['status' => 1, 'dados' => $retorno, 'msg' => 'Todos os campos precisam ser preenchidos corretamente.', 'alert' => 1];
        } 
        
        $dataHelper = DataHelper::getDataHoraSistema();     

        $dadosEnviar = [
            'uuid' => $uuid,
            'nome' => $nome,
            'icone' => $icone,
            'caminho' => $caminho,
            'status' => $status,
            'created_at' => $dataHelper['data_hora_banco'],
            'updated_at' => $dataHelper['data_hora_banco']
        ];

        $moduloModel = new ModuloModel();
        $retornoIdCadastro = $moduloModel->cadastrarModulo($dadosEnviar);

        if (!$retornoIdCadastro) {
            return ['status' => 1, 'msg' => 'Não foi possível cadastrar o módulo.', 'alert' => 1];
        }

        return ['status' => 0, 'msg' => "Módulo $nome cadastrado com sucesso.", 'alert' => 0, 'redirecionar' => 'apps/administracao/gestaoModulos/'];

    }

    public function atualizarModulo(array $dados) {

        $publicKeyModulo = $dados['public-key'];
        $nome = trim($dados['nome']);
        $icone = trim($dados['icone']);
        $caminho = trim($dados['caminho']);

        $camposVazios = array_filter($dados, function($valor) {
            return empty($valor);
        });

        if (!empty($camposVazios)) {
            $retorno = array_keys($camposVazios);
            return ['status' => 1, 'dados' => $retorno, 'msg' => 'Todos os campos precisam ser preenchidos corretamente.', 'alert' => 1];
        } 

        $uuidHelper = new UuidHelper();
        $retornoUuidHelper = $uuidHelper->enviaUuidBuscaDados('tbl_modulo', $publicKeyModulo);
        $idModulo = $retornoUuidHelper['id'];
        
        $dataHelper = DataHelper::getDataHoraSistema();     

        $dadosEnviar = [
            'id' => $idModulo,
            'nome' => $nome,
            'icone' => $icone,
            'caminho' => $caminho,
            'updated_at' => $dataHelper['data_hora_banco']
        ];

        $moduloModel = new ModuloModel();
        $retornoIdUpdate = $moduloModel->atualizarModulo($dadosEnviar);

        if (!$retornoIdUpdate) {
            return ['status' => 1, 'msg' => 'Não foi possível atualizar o módulo.', 'alert' => 1];
        }

        return ['status' => 0, 'msg' => "Módulo $nome atualizado com sucesso.", 'alert' => 0, 'redirecionar' => 'apps/administracao/gestaoModulos/'];

    }
}