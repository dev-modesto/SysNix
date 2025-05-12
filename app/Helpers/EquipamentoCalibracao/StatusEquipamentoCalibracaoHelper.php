<?php

namespace App\Helpers\EquipamentoCalibracao;

use App\Models\StatusEquipamentoCalibracaoModel;

class StatusEquipamentoCalibracaoHelper
{

    public static function totalStatusEquipamentoCalibracao() {

        $statusEquipamentoCalibracaoModel = new StatusEquipamentoCalibracaoModel();
        $dadosContagemStatusUso = $statusEquipamentoCalibracaoModel->consultarContagemStatusUso();
        $dadosContagemStatusFuncional = $statusEquipamentoCalibracaoModel->consultarContagemStatusFuncional();
        $dadosContagemStatusVencendo = $statusEquipamentoCalibracaoModel->consultarContagemDinamica(1);
        $dadosContagemStatusVencido = $statusEquipamentoCalibracaoModel->consultarContagemDinamica(null, 1);

        $dadosFuncional = [];
        $dadosUso = [];

        foreach ($dadosContagemStatusFuncional as $valor) {
            $id = $valor['id_status_funcional'];
            $dadosFuncional[$id] = [
                'nome' => $valor['nome'],
                'cor' => $valor['cor'],
                'total' => (int)$valor['total']
            ];
        }

        foreach ($dadosContagemStatusUso as $valor) {
            $id = $valor['id_status_uso'];
            $dadosUso[$id] = [
                'nome' => $valor['nome'],
                'cor' => $valor['cor'],
                'total' => (int)$valor['total']
            ];
        }

        // totais status funcional
        $totalOperacional = $dadosFuncional[1]['total'] ?? 0;
        $totalDefeito = $dadosFuncional[2]['total'] ?? 0;

        // total status uso
        $totalEmUso = $dadosUso[1]['total'] ?? 0;
        $totalDisponivel = $dadosUso[2]['total'] ?? 0;
        $totalCalibracao = $dadosUso[3]['total'] ?? 0;
        $totalPerda = $dadosUso[4]['total'] ?? 0;
        $totalForaUso = $dadosUso[5]['total'] ?? 0;
        $totalEquipamentos = $totalEmUso + $totalDisponivel + $totalCalibracao + $totalPerda + $totalForaUso;
        $totalVencendo = $dadosContagemStatusVencendo[0]['total'] ?? 0;
        $totalVencido = $dadosContagemStatusVencido[0]['total'] ?? 0;

        return [
            'totais' =>
                [
                    'total_equipamentos' => $totalEquipamentos,
                    'total_operacional' => $totalOperacional,
                    'total_defeito' => $totalDefeito,
                    'total_em_uso' => $totalEmUso,
                    'total_disponivel' => $totalDisponivel,
                    'total_em_calibracao' => $totalCalibracao,
                    'total_perda' => $totalPerda,
                    'total_fora_uso' => $totalForaUso,
                    'total_vencendo' => $totalVencendo,
                    'total_vencido' => $totalVencido
                ],
        ];

    }

}