<?php

namespace App\Controllers;

use App\Models\StatusEquipamentoCalibracaoModel;

class StatusEquipamentoCalibracaoController
{

    public static function selecionarId($dados) {

        $id = $dados['id'];

        if(intval($id)) {
            $equipamento = new StatusEquipamentoCalibracaoModel();
            $dados = $equipamento->selecionarId($id);
            $dadosReturn = ['status' => 0, 'dados' => $dados];

        } else {
            $dadosReturn = ['status' => 1, 'mensagem' => 'Número de ID não permitido.', 'alert' => 1];
        }
        
        return $dadosReturn;
    }
    
}