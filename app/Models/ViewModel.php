<?php

namespace App\Models;

use App\Config\Connection;
use PDO;

class ViewModel
{

    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    public function selecionarViewsModulo(string $tipoView, $idModulo = null, $idView = null) {
        $where = "WHERE 1=1";

        if ($idModulo) {
            $where .= " AND vm.id_modulo = :id_modulo";
        }

        if ($idView) {
            $where .= " AND vm.id_view = :id_view";
        }

        if ($tipoView) {
            $where .= " AND vm.tipo_view = :tipo_view";
        }

        $query = 
            "SELECT 
                vm.id,
                vm.id_modulo,
                m.nome as nome_modulo,
                m.caminho as caminho_modulo,
                vm.id_view,
                vm.tipo_view as tipo_view,
                t.nome as nome_view,
                t.icone,
                t.caminho as caminho_view,
                t.status
            FROM tbl_view_modulo vm
            INNER JOIN tbl_tela t ON (vm.id_view = t.id)
            INNER JOIN tbl_modulo m ON (vm.id_modulo = m.id)
            $where
        ";

        $stmt = $this->pdo->prepare($query);

        if ($idModulo) {
            $stmt->bindValue(":id_modulo", $idModulo);
        }

        if ($idView) {
            $stmt->bindValue(":id_view", $idView);
        }

        if ($tipoView) {
            $stmt->bindValue(":tipo_view", $tipoView);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Selecionar e retornar informações do modulo atual através do nome da pasta na url
     *
     * @param string $nomePasta informar o nome da pasta referente ao modulo atual
     * @return void
     */
    public function selecionarViewTelaCaminho(string $nomePasta) {
        $query = "SELECT * FROM tbl_tela WHERE caminho = :caminho";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":caminho", $nomePasta);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}