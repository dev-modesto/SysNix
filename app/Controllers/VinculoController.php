<?php

namespace App\Controllers;

use App\Services\VinculoService;

class VinculoController
{

    public static function cadastrar(array $dados) {

        $vinculoService = new VinculoService();
        $dadosReturn = $vinculoService->cadastrarVinculoViewModulo($dados);

        return $dadosReturn;
    }

}