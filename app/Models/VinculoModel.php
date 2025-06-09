<?php

namespace App\Models;

use App\Config\Connection;
use PDO;

class VinculoModel
{

    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }


    public function cadastrarVinculoViewModulo($dados) {
        $query = 
            "INSERT INTO tbl_view_modulo(
                id_modulo,
                id_view,
                tipo_view,
                created_at
            ) VALUES (
                :id_modulo,
                :id_view,
                :tipo_view,
                :created_at
            )
        ";

        $stmt = $this->pdo->prepare($query);

        foreach ($dados as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }

        $stmt->execute();
        return $this->pdo->lastInsertId();

    }
    
}