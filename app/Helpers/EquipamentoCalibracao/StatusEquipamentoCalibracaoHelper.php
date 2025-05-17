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
        $dadosContagemStatusDentroPrazo = $statusEquipamentoCalibracaoModel->consultarContagemDinamica(null, null, 1);

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
        $totalDentroPrazo = $dadosContagemStatusDentroPrazo[0]['total'] ?? 0;

        return [
            'totais' => [
                'total_equipamentos' => [
                    'total' => $totalEquipamentos
                ],

                'total_operacional' => [
                    'total' => $totalOperacional,
                    'cor' => $dadosFuncional[1]['cor'] ?? '#cccccc'
                ],
                'total_defeito' => [
                    'total' => $totalDefeito,
                    'cor' => $dadosFuncional[2]['cor'] ?? '#cccccc'
                ],

                'total_em_uso' => [
                    'total' => $totalEmUso,
                    'cor' => $dadosUso[1]['cor'] ?? '#cccccc'
                ],
                'total_disponivel' => [
                    'total' => $totalDisponivel,
                    'cor' => $dadosUso[2]['cor'] ?? '#cccccc'
                ],
                'total_em_calibracao' => [
                    'total' => $totalCalibracao,
                    'cor' => $dadosUso[3]['cor'] ?? '#cccccc'
                ],
                'total_perda' => [
                    'total' => $totalPerda,
                    'cor' => $dadosUso[4]['cor'] ?? '#cccccc'
                ],
                'total_fora_uso' => [
                    'total' => $totalForaUso,
                    'cor' => $dadosUso[5]['cor'] ?? '#cccccc'
                ],

                'total_vencendo' => [
                    'total' => $totalVencendo,
                    'cor' => '#FFCC00'
                ],
                'total_vencido' => [
                    'total' => $totalVencido,
                    'cor' => '#FF0000'
                ],
                'total_dentro_prazo' => [
                    'total' => $totalDentroPrazo,
                    'cor' => '#FF0000'
                ]
            ],
            'status-uso-grafico' => [
                'status-uso-nomes' => [$dadosUso[1]['nome'], $dadosUso[2]['nome'], $dadosUso[3]['nome'], $dadosUso[4]['nome'], $dadosUso[5]['nome']],
                'status-uso-total' => [$dadosUso[1]['total'], $dadosUso[2]['total'], $dadosUso[3]['total'], $dadosUso[4]['total'], $dadosUso[5]['total']],
                'status-uso-cores' => [$dadosUso[1]['cor'], $dadosUso[2]['cor'], $dadosUso[3]['cor'], $dadosUso[4]['cor'], $dadosUso[5]['cor']],
            ]
        ];


    }

}