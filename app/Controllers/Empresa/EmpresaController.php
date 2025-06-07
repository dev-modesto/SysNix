<?php

namespace App\Controllers\Empresa;

use App\Models\Empresa\EmpresaModel;

class EmpresaController
{

    public static function buscarEmpresas() {
        $empresaModel = new EmpresaModel();
        $dadosConsultarEmpresa = $empresaModel->consultarEmpresas();
        return $dadosConsultarEmpresa;
    }
}

