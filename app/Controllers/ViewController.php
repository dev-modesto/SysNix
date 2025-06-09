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

    public static function remover($dados) {

        $uuidEquipamento = $dados['public-key'];
        $uuidHelper = new UuidHelper();
        $retornoUuidHelper = $uuidHelper->enviaUuidBuscaDados('tbl_tela', $uuidEquipamento);
        $retornoId = $retornoUuidHelper['id'];
        $nome = $retornoUuidHelper['nome'];

        if (empty($retornoId)) {
            return ['status' => 1, 'msg' => 'Tela não localizada.', 'alert' => 1];
        } 

        $viewModel = new ViewModel();
        $returnRemover = $viewModel->removerTela($retornoId);

        if(!$returnRemover) {
            return ['status' => 0, 'msg' => "Não foi possível remover a tela <strong>$nome</strong>", 'alert' => 1, 'redirecionar' => 'apps/administracao/gestaoModulos/'];
        }

        return ['status' => 0, 'msg' => "A tela <strong>$nome</strong> foi deletada com sucesso.", 'alert' => 0, 'redirecionar' => 'apps/administracao/gestaoModulos/'];
    }

    public static function selecionarTelasSemVinculoModulo() {

        $viewModel = new ViewModel();
        $dadosReturn = $viewModel->selecionarTelasSemVinculoModulo();

        return $dadosReturn;
    }

}