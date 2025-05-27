<?php

namespace App\Controllers;

use App\Helpers\UuidHelper;
use App\Models\StatusEquipamentoCalibracaoModel;

class StatusEquipamentoCalibracaoController
{

    public static function retornarStatusUso($dados) {

        $publicKey = $dados['public-key'];
        
        $uuidHelper = new UuidHelper();
        $retornoUuidHelper = $uuidHelper->enviaUuidBuscaDados('tbl_status_funcional', $publicKey);

        if (empty($retornoUuidHelper)) {
            return ['status' => 1, 'mensagem' => 'Número de ID não permitido.', 'alert' => 1];
        } 

        $retornoId = $retornoUuidHelper['id'];
        $equipamento = new StatusEquipamentoCalibracaoModel();
        $dados = $equipamento->consultarStatusUsoPorFuncional($retornoId);

        $dadosArrayReturn = [];

        foreach ($dados as $valor) {
            $uuidStatus = $valor['uuid'];
            $nomeStatus = $valor['nome'];
            $dadosArrayReturn[] = ['public_key_return' => $uuidStatus, 'nome' => $nomeStatus];
        }

        return ['status' => 0, 'dados' => $dadosArrayReturn];
    }

    /**
     * retornar dados de status de uso informando o id do status funcional
     *
     * @param [array] $idStatusFuncional
     * @return void
     */
    public static function retornarStatusUsoPorFuncionalId($idStatusFuncional) {

        $equipamento = new StatusEquipamentoCalibracaoModel();
        $dados = $equipamento->consultarStatusUsoPorFuncional($idStatusFuncional);

        $dadosArrayReturn = [];

        foreach ($dados as $valor) {
            $idStatus = $valor['id'];
            $uuidStatus = $valor['uuid'];
            $nomeStatus = $valor['nome'];
            $dadosArrayReturn[] = ['id' => $idStatus, 'public_key_return' => $uuidStatus, 'nome' => $nomeStatus];
        }

        return ['status' => 0, 'dados' => $dadosArrayReturn];
    }

    public static function bucarStatusFuncional() {
        $statusFuncionalModel = new StatusEquipamentoCalibracaoModel();
        $dadosStatusFuncional = $statusFuncionalModel->consultarContagemStatusFuncional();
        return $dadosStatusFuncional;
    }
    
}