<?php

namespace App\Services\View;

use App\Helpers\DataHelper;
use App\Helpers\GeralHelper;
use App\Helpers\UuidHelper;
use App\Models\ViewModel;

class ViewService
{
    public function cadastrarTela(array $dados) {

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

        $viewModel = new ViewModel();
        $retornoIdCadastro = $viewModel->cadastrarTela($dadosEnviar);

        if (!$retornoIdCadastro) {
            return ['status' => 1, 'msg' => 'Não foi possível cadastrar a tela.', 'alert' => 1];
        }

        return ['status' => 0, 'msg' => "Tela $nome cadastrado com sucesso.", 'alert' => 0, 'redirecionar' => 'apps/administracao/gestaoModulos/'];

    }

    public function atualizarTela(array $dados) {

        $publicKeyTela = $dados['public-key'];
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
        $retornoUuidHelper = $uuidHelper->enviaUuidBuscaDados('tbl_tela', $publicKeyTela);
        $idRetornoUuid = $retornoUuidHelper['id'];
        
        $dataHelper = DataHelper::getDataHoraSistema();     

        $dadosEnviar = [
            'id' => $idRetornoUuid,
            'nome' => $nome,
            'icone' => $icone,
            'caminho' => $caminho,
            'updated_at' => $dataHelper['data_hora_banco']
        ];

        $viewModel = new ViewModel();
        $retornoIdUpdate = $viewModel->atualizarTela($dadosEnviar);

        if (!$retornoIdUpdate) {
            return ['status' => 1, 'msg' => 'Não foi possível atualizar a tela.', 'alert' => 1];
        }

        return ['status' => 0, 'msg' => "Tela $nome atualizada com sucesso.", 'alert' => 0, 'redirecionar' => 'apps/administracao/gestaoModulos/'];

    }
}