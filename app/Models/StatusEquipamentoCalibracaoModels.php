<?php
namespace App\Models;
use App\Config\Connection;
use PDO;

class StatusEquipamentoCalibracaoModel {

    protected PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::getInstance();
    }

    public function selecionarId($id):array {
        $query = 
        "SELECT 
                u.id,
                u.nome,
                u.cor
            FROM tbl_index_status_equipamento_calibracao i
            INNER JOIN tbl_status_uso u ON (u.id = i.id_status_uso)
            WHERE id_status_funcional = :id
        ";

        $stmt = $this->pdo->prepare($query);    
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

}
