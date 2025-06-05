<?php

namespace App\Controllers;

use App\Models\ModuloModel;

class ModuloController
{

    public static function retornarModuloCaminho(string $nomePasta) {

        $moduloModel = new ModuloModel();
        $arrayDadosModulo = $moduloModel->selecionarModuloCaminho($nomePasta);

        return $arrayDadosModulo;

    }

}