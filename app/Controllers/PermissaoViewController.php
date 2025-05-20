<?php

namespace App\Controllers;
use App\Services\PermissaoViewService;

class PermissaoViewController
{

    public static function retornarViewsPermitidasModulo(string $idUsuario, string $nomePasta) {

        $viewService = new PermissaoViewService();
        $arrayDadosViewsPermissoes = $viewService->verficarPermissaoViewsModulo($idUsuario, $nomePasta);

        return $arrayDadosViewsPermissoes;

    }

}