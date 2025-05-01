<?php

namespace App\Controllers;

use App\Models\EquipamentoCalibracaoModels;
use App\Services\EquipamentoCalibracaoService;

class EquipamentoCalibrabracaoController
{

    public static function selecionar() {
        $equipamento = new EquipamentoCalibracaoModels();
        $dadosReturn = $equipamento->selecionar();
        return $dadosReturn;
    }

    public function cadastrar($dadosReceber) {

        $equipamento = new EquipamentoCalibracaoService();
        $dadosReturn = $equipamento->cadastrarEquipamento($dadosReceber);

        return $dadosReturn;

    }

    public function atualizar() {

    }

    public function remover() {
        
    }
}