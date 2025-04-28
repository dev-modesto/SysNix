<?php
namespace App\Services;

use App\Models\StatusModels;

class StatusService {

    public static function consultarStatusUsoEquipamento($con, $idStatus) {

        if(is_numeric($idStatus)) {
            $dadosStatusUsoEquipamento = StatusModels::consultaStatusUsoEquipamento($con, $idStatus);
            $dados = ['msg' => 'Dados válidos.', 'dados' => $dadosStatusUsoEquipamento, 'alert' => 0];
            return $dados ;

        } else {
            $mensagem = ['msg' => 'Valor invalido!', 'alert' => 1];
            return $mensagem;
        }

    }
}