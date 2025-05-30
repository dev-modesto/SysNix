<?php

namespace App\Controllers;

use App\Services\Usuario\UsuarioService;

class UsuarioController
{

    public static function cadastrar(array $dados) {

        $usuarioService = new UsuarioService();
        $dadosUsuarioService = $usuarioService->cadastrarUsuario($dados);

        return $dadosUsuarioService;
    }

}