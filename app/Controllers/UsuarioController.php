<?php

namespace App\Controllers;

use App\Helpers\UuidHelper;
use App\Models\UsuarioModels;
use App\Services\Usuario\UsuarioService;

class UsuarioController
{

    public static function selecionar($idEmpresa = null) {
        $dadosIdEmpresa = $idEmpresa;
        
        $UsuarioModel = new UsuarioModels();
        $dadosUsuarioModel = $UsuarioModel->selecionar($dadosIdEmpresa);

        return $dadosUsuarioModel;
    }

    public static function cadastrar(array $dados) {

        $usuarioService = new UsuarioService();
        $dadosUsuarioService = $usuarioService->cadastrarUsuario($dados);

        return $dadosUsuarioService;
    }

    public static function selecionarUsuarioUuid($uuidUsuario) {
        $uuidHelper = new UuidHelper();
        $dadosUuidHelper = $uuidHelper->enviaUuidBuscaDados('tbl_usuario', $uuidUsuario);

        return $dadosUuidHelper;
    }

    public static function atualizar($dados) {
        $usuarioService = new UsuarioService();
        $dadosUsuarioService = $usuarioService->atualizarUsuario($dados);

        return $dadosUsuarioService;
    }

    public static function ativarInativar($dados) {
        $usuarioService = new UsuarioService();
        $dadosUsuarioService = $usuarioService->ativarInativarUsuario($dados);

        return $dadosUsuarioService;
    }

}