<?php

namespace App\Controllers;

use App\Models\UsuarioEmpresaModel;

class UsuarioEmpresaController
{

    public static function buscarEmpresasUsuario($idUsuario) {
        $usuarioEmpresa = new UsuarioEmpresaModel();
        $dadosUsuarioEmpresa = $usuarioEmpresa->selecionarEmpresaUsuario($idUsuario);

        return $dadosUsuarioEmpresa;
    }
}