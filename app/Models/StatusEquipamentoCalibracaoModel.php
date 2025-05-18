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

    public function consultarContagemDinamica($vencendo = null, $vencido = null, $dentroPrazo = null) {
        $where = 'WHERE 1=1';
    
        if ($vencendo == 1) {
            $where .= " AND DATEDIFF(e.dt_calibracao_previsao, current_date()) >= 0 AND DATEDIFF(e.dt_calibracao_previsao, current_date()) <= 30";
        }

        if ($vencido == 1) {
            $where .= " AND DATEDIFF(e.dt_calibracao_previsao, current_date()) < 0";
        }

        if ($dentroPrazo == 1) {
            $where .= " AND DATEDIFF(e.dt_calibracao_previsao, current_date()) > 30";
        }

        $query = 
            "SELECT COUNT(*) AS total
            FROM tbl_equipamento_calibracao e
            INNER JOIN tbl_status_funcional f ON (f.id = e.id_status_funcional)
            INNER JOIN tbl_status_uso u ON (u.id = e.id_status_uso)
            $where
        ";

        $stmt = $this->pdo->prepare($query);    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
