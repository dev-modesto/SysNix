<?php

namespace App\Controllers;

use App\Helpers\UuidHelper;
use App\Models\ViewModel;
use App\Services\View\ViewService;

class ViewController
{

    public static function retornarViewTelaController(string $nomePasta) {

        $viewModel = new ViewModel();
        $dadosReturn = $viewModel->selecionarViewTelaCaminho($nomePasta);

        return $dadosReturn;

    }

    public static function selecionar() {
        $viewModel = new ViewModel();
        $dadosReturn = $viewModel->selecionarTelas();
        return $dadosReturn;
    }

    public static function selecionaTelaUuid($uuid) {
        $uuidHelper = new UuidHelper();
        $dadosUuidHelper = $uuidHelper->enviaUuidBuscaDados('tbl_tela', $uuid);

        return $dadosUuidHelper;
    }

    public static function cadastrar(array $dados) {

        $viewService = new ViewService();
        $dadosReturnCadastro = $viewService->cadastrarTela($dados);

        return $dadosReturnCadastro;
    }

    public static function atualizar($dados) {
        $viewService = new ViewService();
        $dadosReturnCadastro = $viewService->atualizarTela($dados);

        return $dadosReturnCadastro;
    }

}