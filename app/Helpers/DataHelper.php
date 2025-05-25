<?php

namespace App\Helpers;
use DateTime;

class DataHelper
{
    public static function getDataHoraSistema():array
    {
        $date = new DateTime();

        $anoAtual = $date->format('Y');
        $dataSistemaBanco = $date->format('Y-m-d');
        $dataSistemaPtBr = $date->format('d/m/Y');
        $hora = $date->format('H:i:s');
        $dataHoraSistema = "$dataSistemaBanco $hora";

        return [
            'ano' => $anoAtual,
            'data_banco' => $dataSistemaBanco,
            'data_ptbr' => $dataSistemaPtBr,
            'hora' => $hora,
            'data_hora_banco' => $dataHoraSistema
        ];
    }

    /**
     * Converter o formato da data
     * 
     * @param [type] $data
     * @return array [data_ptbr, data_banco]
     */
    public static function converterData($data):array
    {

        $date = new DateTime($data);

        return [
            'data_ptbr' => $date->format('d/m/Y'),
            'data_banco' => $date->format('Y-m-d')
        ];
    }
}