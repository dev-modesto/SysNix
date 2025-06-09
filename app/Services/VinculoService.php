<?php

namespace App\Services;

use App\Helpers\DataHelper;
use App\Helpers\UuidHelper;
use App\Models\VinculoModel;

class VinculoService
{

    public function cadastrarVinculoViewModulo($dados) {

        $publicKeyModulo = $dados['public-key-modulo'];
        $arrayPublicKeyTela = $dados['array-public-key-tela'];

        $camposVazios = array_filter($dados, function($valor) {
            return empty($valor);
        });

        if (!empty($camposVazios)) {
            $retorno = array_keys($camposVazios);
            return ['status' => 1, 'dados' => $retorno, 'msg' => 'Todos os campos precisam ser preenchidos corretamente.', 'alert' => 1];
        }

        $uuidHelper = new UuidHelper();
        $retornoUuidHelper = $uuidHelper->enviaUuidBuscaDados('tbl_modulo', $publicKeyModulo);
        $idModulo = $retornoUuidHelper['id'];

        $arrayIdView = [];

        foreach ($arrayPublicKeyTela as $valor) {
            $publicKeyTela = $valor;

            $retornoUuidHelperTela = $uuidHelper->enviaUuidBuscaDados('tbl_tela', $publicKeyTela);
            $arrayIdView[] = $retornoUuidHelperTela['id'];
        }
        
        $dataHelper = DataHelper::getDataHoraSistema();     


        foreach ($arrayIdView as $idView) {

            $dadosEnviar = [
                'id_modulo' => $idModulo,
                'id_view' => $idView,
                'tipo_view' => 'tela',
                'created_at' => $dataHelper['data_hora_banco']
            ];

            $vinculoModel = new VinculoModel();
            $retornoIdCadastro = $vinculoModel->cadastrarVinculoViewModulo($dadosEnviar);

            if (!$retornoIdCadastro) {
                return ['status' => 1, 'msg' => 'Não foi possível vincular a view ao modulo.', 'alert' => 1];
            }

        }

        return ['status' => 0, 'msg' => "View vinculada com sucesso.", 'alert' => 0, 'redirecionar' => 'apps/administracao/vinculos/'];

    }
}