<?php
namespace App\Models;
use App\Config\Connection;
use PDO;

class StatusEquipamentoCalibracaoModels {

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

    public function consultarContagemStatusFuncional() {

        $query = 
            "SELECT 
                f.id AS id_status_funcional, 
                f.nome,
                f.cor,
                count(c.id_status_funcional) as total 
            FROM tbl_status_funcional f
            LEFT JOIN tbl_equipamento_calibracao c ON (c.id_status_funcional = f.id)
            GROUP BY f.id
            ORDER BY f.id
        ";

        $stmt = $this->pdo->prepare($query);    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consultarContagemStatusUso() {

        $query = 
            "SELECT 
                u.id AS id_status_uso,
                u.nome,
                u.cor,
                COUNT(c.id_status_uso) AS total
            FROM tbl_status_uso u
            LEFT JOIN tbl_equipamento_calibracao c ON c.id_status_uso = u.id
            GROUP BY u.id
            ORDER BY u.id
        ";

        $stmt = $this->pdo->prepare($query);    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
