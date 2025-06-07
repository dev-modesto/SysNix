<?php

namespace App\Controllers;

use App\Models\ViewModel;

class ViewController
{

    public static function retornarViewTelaController(string $nomePasta) {

        $viewModel = new ViewModel();
        $dadosReturn = $viewModel->selecionarViewTelaCaminho($nomePasta);

        return $dadosReturn;

    }

}