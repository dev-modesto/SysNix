<?php

namespace App\Services;

use App\Helpers\DataHelper;
use App\Models\EquipamentoCalibracaoModels;

include BASE_PATH . '/include/funcoes/geral/geral.php'; 

class EquipamentoCalibracaoService
{

    public function cadastrarEquipamento($dados) {
        $nomeIdentificador = removerCaracteresInput($dados['nome-identificador']);
        $descricao =  $dados['descricao'];
        $modelo =  $dados['modelo'];
        $fabricante =  $dados['fabricante'];
        $numeroSerie = $dados['numero-serie'];
        $resolucao =  $dados['resolucao'];
        $faixaUso =  $dados['faixa-uso'];
        $dataUltimaCalibracao = $dados['data-ultima-calibracao'];
        $dataPrevisaoCalibracao = $dados['data-previsao-calibracao'];
        $numeroCertificado =  $dados['numero-certificado'];
        $ei15a25n =  $dados['ei-15a25-n'];
        $ei2a8 =  $dados['ei-2a8'];
        $ei15a25 =  $dados['ei-15a25'];
        $idStatusFuncional =  $dados['id-status-funcional'];
        $idStatusUso = $dados['id-status-uso'];
        $idStatusUso = 2;

        $camposVazios = array_filter($dados, function($valor) {
            return empty($valor);
        });
        
        if (!empty($camposVazios)) {
            $retorno = array_keys($camposVazios);
            $retorno = ['status' => 1, 'msg' => 'Todos os campos precisam ser preenchidos corretamente.', 'dados' => $retorno];

        } else {
            $dataHelper = DataHelper::getDataHoraSistema();

            $dadosTratados = [
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
                'id_status_funcional' => $idStatusFuncional,
                'id_status_uso' => $idStatusUso
            ];
           
            $cadastrarEquipamentos = new EquipamentoCalibracaoModels();
            $retorno = $cadastrarEquipamentos->cadastrar($dadosTratados);
        }

        return $retorno;
    }
}