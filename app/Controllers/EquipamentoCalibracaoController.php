<?php

namespace App\Controllers;

use App\Helpers\UuidHelper;
use App\Models\EquipamentoCalibracaoModel;
use App\Services\EmailService;
use App\Services\EquipamentoCalibracaoService;

class EquipamentoCalibracaoController
{

    public static function selecionar($filtroDiasCalibracao = null) {
        $equipamento = new EquipamentoCalibracaoModel();
        $dadosReturn = $equipamento->selecionar($filtroDiasCalibracao);
        return $dadosReturn;
    }

    public function cadastrar($dadosReceber) {

        $equipamento = new EquipamentoCalibracaoService();
        $dadosReturn = $equipamento->cadastrarEquipamento($dadosReceber);

        return $dadosReturn;

    }

    public function atualizar() {

    }

    public function remover($dados) {
        
        $uuidEquipamento = $dados['public-key'];
        $uuidHelper = new UuidHelper();
        $retornoUuidHelper = $uuidHelper->enviaIdBuscaUuid('tbl_equipamento_calibracao', $uuidEquipamento);
        $retornoId = $retornoUuidHelper['id'];
        $nomeIdentificadorEquipamento = $retornoUuidHelper['nome_identificador'];

        if (empty($retornoId)) {
            return ['status' => 1, 'msg' => 'Equipamento não localizado.', 'alert' => 1];
        } 

        $equipamentoRemover = new EquipamentoCalibracaoModel();
        $returnRemover = $equipamentoRemover->removerEquipamento($retornoId);

        if(!$returnRemover) {
            return ['status' => 0, 'msg' => "Não foi possível remover o equipamento '$nomeIdentificadorEquipamento'", 'alert' => 1, 'redirecionar' => 'apps/operacional/calibracaoEquipamentos'];
        }

        return ['status' => 0, 'msg' => "O equipamento '$nomeIdentificadorEquipamento' foi deletado com sucesso.", 'alert' => 0, 'redirecionar' => 'apps/operacional/calibracaoEquipamentos'];

    }

    public static function enviarEmailAlertaEquipamentoController($destinatarioEmail, $destinatarioNome, $dados) {
        $emailService = new EmailService();

        return $emailService->enviarEmailAlertaEquipamentosCalibracao($destinatarioEmail, $destinatarioNome, $dados);

    }
}