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

    public function selecionarViewsModulo(int $idModulo, string $tipoView) {
        $query = 
            "SELECT 
                vm.id,
                vm.id_modulo,
                m.nome as nome_modulo,
                m.caminho as caminho_modulo,
                vm.id_view,
                :tipo_view as tipo_view,
                t.nome as nome_view,
                t.icone,
                t.caminho as caminho_view,
                t.status
            FROM tbl_view_modulo vm
            INNER JOIN tbl_tela t ON (vm.id_view = t.id)
            INNER JOIN tbl_modulo m ON (vm.id_modulo = m.id)
            WHERE vm.id_modulo = :id_modulo AND vm.tipo_view = :tipo_view
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id_modulo", $idModulo);
        $stmt->bindValue(":tipo_view", $tipoView);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}