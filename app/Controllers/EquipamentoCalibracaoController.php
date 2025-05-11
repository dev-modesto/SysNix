<?php

namespace App\Controllers;

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

    public function remover() {
        
    }

    public static function enviarEmailAlertaEquipamentoController($destinatarioEmail, $destinatarioNome, $dados) {
        $emailService = new EmailService();

        return $emailService->enviarEmailAlertaEquipamentosCalibracao($destinatarioEmail, $destinatarioNome, $dados);

    }
}