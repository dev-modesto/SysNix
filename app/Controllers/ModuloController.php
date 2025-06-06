<?php

namespace App\Controllers;

use App\Helpers\UuidHelper;
use App\Models\ModuloModel;
use App\Services\Modulo\ModuloService;

class ModuloController
{

    public static function retornarModuloCaminho(string $nomePasta) {

        $moduloModel = new ModuloModel();
        $arrayDadosModulo = $moduloModel->selecionarModuloCaminho($nomePasta);

        return $arrayDadosModulo;

    }

    public static function selecionar() {
        $modulo = new ModuloModel();
        $dadosReturn = $modulo->selecionarModulos();
        return $dadosReturn;
    }

    public static function selecionaModuloUuid($uuidModulo) {
        $uuidHelper = new UuidHelper();
        $dadosUuidHelper = $uuidHelper->enviaUuidBuscaDados('tbl_modulo', $uuidModulo);

        return $dadosUuidHelper;
    }

    public static function cadastrar(array $dados) {

        $moduloService = new ModuloService();
        $dadosModuloService = $moduloService->cadastrarModulo($dados);

        return $dadosModuloService;
    }

    public static function atualizar($dados) {
        $moduloService = new ModuloService();
        $dadosModuloService = $moduloService->atualizarModulo($dados);

        return $dadosModuloService;
    }

}