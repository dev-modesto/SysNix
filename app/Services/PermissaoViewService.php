<?php
namespace App\Services;

use App\Models\ModuloModel;
use App\Models\PermissaoViewModel;
use App\Models\ViewModel;

include_once BASE_PATH . '/vendor/autoload.php';

class PermissaoViewService
{
    public function verficarPermissaoViewsModulo (int $idUsuario, string $nomePasta) {
        $moduloModel = new ModuloModel();
        $dadosModulo = $moduloModel->selecionarModuloCaminho($nomePasta);

        if (!empty($dadosModulo)) {

            $idModulo = $dadosModulo['id'];
            $nomeModulo = $dadosModulo['nome'];
            $statusModulo = $dadosModulo['status'];
            $caminhoModulo = $dadosModulo['caminho'];

            // consultando as views do tipo tela do modulo em especifico
            $viewsModulo = new ViewModel();
            $dadosViewsModuloTela = $viewsModulo->selecionarViewsModulo($idModulo,'tela');
            $arrayDadosTela = [];

            if (!empty($dadosViewsModuloTela)) {
                        
                foreach ($dadosViewsModuloTela as $chave => $valor) {
                    $arrayDadosTela[] = $valor;
                }
            }

            // consultando as views do tipo submodulo do modulo em especifico
            $dadosViewsModuloSubmodulo = $viewsModulo->selecionarViewsModulo($idModulo,'submodulo');
            $arrayDadosSubmodulo = [];

            if (!empty($dadosViewsModuloSubmodulo)) {
                        
                foreach ($dadosViewsModuloSubmodulo as $chave => $valor) {
                    $arrayDadosSubmodulo[] = $valor;
                }
            }

            $viewsModulo = array_merge($arrayDadosTela, $arrayDadosSubmodulo);

            // consultando as permissões do usuario ou grupo à tela ou submodulo
            $telasPermissoes = [];

            if (!empty($viewsModulo)) {
                
                foreach ($viewsModulo as $chave => $valor) {
                    $idView = $valor['id_view'];
                    $tipoView = $valor['tipo_view'];
                    $nome_view = $valor['nome_view'];

                    $idGrupo = null;

                    $dadosEnviarPermissaoView = [
                        'id_modulo' => $idModulo,
                        'id_view' => $idView,
                        'tipo_view' => $tipoView,
                        'id_grupo' => $idGrupo,
                        'id_usuario' => $idUsuario
                    ];

                    $permissaoViewModel = new PermissaoViewModel();
                    $dadosViewsPermitidas = $permissaoViewModel->selecionarPermissaoViewsModulo($dadosEnviarPermissaoView);

                    if (!empty($dadosViewsPermitidas)) {
                        $viewsPermissoes[] = $dadosViewsPermitidas;
                    }
                }
            
            } else {
                $viewsPermissoes = ['status' => 1, 'msg' => 'Nenhuma view cadastrada para este modulo'];
            }

            if (empty($viewsPermissoes)) {
                $viewsPermissoes = ['status' => 1, 'msg' => 'Usuário não possui nenhuma permissão para as views deste modulo.'];
            }

            return $viewsPermissoes;

        } else {
            return ['status' => 1, 'msg' => 'Módulo não cadastrado ou não encontrado.'];
        }
    }

}