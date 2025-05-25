<?php

namespace App\Services;

use App\Helpers\DataHelper;
use App\Helpers\GeralHelper;
use App\Helpers\UuidHelper;
use App\Models\EquipamentoCalibracaoModel;

include BASE_PATH . '/include/funcoes/geral/geral.php'; 

class EquipamentoCalibracaoService
{

    public function cadastrarEquipamento($dados) {
        $nomeIdentificador = removerCaracteresInput($dados['nome-identificador']);
        $descricao = $dados['descricao'];
        $modelo = $dados['modelo'];
        $fabricante = $dados['fabricante'];
        $numeroSerie = $dados['numero-serie'];
        $resolucao = $dados['resolucao'];
        $faixaUso = $dados['faixa-uso'];
        $dataUltimaCalibracao = $dados['data-ultima-calibracao'];
        $dataPrevisaoCalibracao = $dados['data-previsao-calibracao'];
        $numeroCertificado = $dados['numero-certificado'];
        $ei15a25n = $dados['ei-15a25-n'];
        $ei2a8 = $dados['ei-2a8'];
        $ei15a25 = $dados['ei-15a25'];
        $publicKeyStatusFuncional = $dados['public-key-status-funcional'];
        $publicKeyStatusUso = $dados['public-key-status-uso'];

        $uuidHelper = new UuidHelper();
        $retornoUuidHelperStatusFuncional = $uuidHelper->enviaUuidBuscaDados('tbl_status_funcional', $publicKeyStatusFuncional);
        $retornoUuidHelperStatusUso = $uuidHelper->enviaUuidBuscaDados('tbl_status_uso', $publicKeyStatusUso);

        if (empty($retornoUuidHelperStatusFuncional)) {
            return ['status' => 1, 'mensagem' => 'Status funcional não encontrado.', 'alert' => 1];
        } 

        if (empty($retornoUuidHelperStatusUso)) {
            return ['status' => 1, 'mensagem' => 'Status uso não encontrado.', 'alert' => 1];
        } 

        $retornoIdStatusFuncional = $retornoUuidHelperStatusFuncional['id'];
        $retornoIdStatusUso = $retornoUuidHelperStatusUso['id'];

        $camposVazios = array_filter($dados, function($valor) {
            return empty($valor);
        });
        
        if (!empty($camposVazios)) {
            $retorno = array_keys($camposVazios);
            return ['status' => 1, 'dados' => $retorno, 'msg' => 'Todos os campos precisam ser preenchidos corretamente.', 'alert' => 1];
        } 
        
        $dataHelper = DataHelper::getDataHoraSistema();
        $genUuid = GeralHelper::genUuid();

        $dadosTratados = [
            'uuid' => $genUuid,
            'nome_identificador' => $nomeIdentificador,
            'descricao' => $descricao,
            'modelo' => $modelo,
            'fabricante' => $fabricante,
            'serie' => $numeroSerie,
            'resolucao' => $resolucao,
            'faixa_uso' => $faixaUso,
            'dt_ultima_calibracao' => $dataUltimaCalibracao,
            'numero_certificado' => $numeroCertificado,
            'dt_calibracao_previsao' => $dataPrevisaoCalibracao,
            'ei_15a25_n' => $ei15a25n,
            'ei_2a8' => $ei2a8,
            'ei_15a25' => $ei15a25,
            'created_at' => $dataHelper['data_hora_banco'],
            'id_status_funcional' => $retornoIdStatusFuncional,
            'id_status_uso' => $retornoIdStatusUso
        ];
        
        $cadastrarEquipamentos = new EquipamentoCalibracaoModel();
        $retorno = $cadastrarEquipamentos->cadastrar($dadosTratados);

        if (!$retorno) {
            return ['status' => 1, 'msg' => 'Não foi possível cadastrar o equipamento.', 'alert' => 1];
        }

        return ['status' => 0, 'msg' => "Equipamento $nomeIdentificador cadastrado com sucesso.", 'alert' => 0, 'redirecionar' => 'apps/operacional/calibracaoEquipamentos/'];
    

    }

    public function atualizarEquipamento($dados) {

        $publicKey = $dados['public-key'];

        $uuidHelper = new UuidHelper();
        $retornoUuidHelper = $uuidHelper->enviaUuidBuscaDados('tbl_equipamento_calibracao', $publicKey);
        $idEquipamento = $retornoUuidHelper['id'];

        $retornoUuidHelperStatusFuncional = $uuidHelper->enviaUuidBuscaDados('tbl_status_funcional', $dados['public-key-status-funcional']);
        $idStatusFuncional = $retornoUuidHelperStatusFuncional['id'];

        $retornoUuidHelperStatusUso = $uuidHelper->enviaUuidBuscaDados('tbl_status_uso', $dados['public-key-status-uso']);
        $idStatusUso = $retornoUuidHelperStatusUso['id'];

        $nomeIdentificador = removerCaracteresInput($dados['nome-identificador']);

        $dataHelper = DataHelper::getDataHoraSistema();
        $dadosAtualizar = [
            'nome_identificador' => $nomeIdentificador,
            'descricao' => $dados['descricao'],
            'modelo' => $dados['modelo'],
            'fabricante' => $dados['fabricante'],
            'serie' => $dados['numero-serie'],
            'resolucao' => $dados['resolucao'],
            'faixa_uso' => $dados['faixa-uso'],
            'dt_ultima_calibracao' => $dados['data-ultima-calibracao'],
            'numero_certificado' => $dados['numero-certificado'],
            'dt_calibracao_previsao' => $dados['data-previsao-calibracao'],
            'ei_15a25_n' => $dados['ei-15a25-n'],
            'ei_2a8' => $dados['ei-2a8'],
            'ei_15a25' => $dados['ei-15a25'],
            'updated_at' => $dataHelper['data_hora_banco'],
            'id_status_funcional' => $idStatusFuncional,
            'id_status_uso' => $idStatusUso,
        ];

        $cadastrarEquipamentos = new EquipamentoCalibracaoModel();
        $retorno = $cadastrarEquipamentos->atualizar($idEquipamento, $dadosAtualizar);

        if ($retorno == 0) {
            return ['status' => 1, 'msg' => 'Não foi possível atualizar o equipamento.', 'alert' => 1, 'redirecionar' => 'apps/operacional/calibracaoEquipamentos/'];
        }

        return ['status' => 0, 'msg' => "Equipamento $nomeIdentificador atualizado com sucesso.", 'alert' => 0, 'redirecionar' => 'apps/operacional/calibracaoEquipamentos/'];
        
    }
}