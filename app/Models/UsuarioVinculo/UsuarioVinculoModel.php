<?php

namespace App\Models\UsuarioVinculo;
use App\Config\Connection;
use PDO;

class UsuarioVinculoModel
{

    protected PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::getInstance();
    }

    public function vincularUsuarioEmpresa(array $dados) {

        $query = 
            "INSERT INTO tbl_usuario_empresa
            (
                id_empresa, 
                id_usuario, 
                created_at
            ) VALUES (
                :id_empresa,
                :id_usuario,
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

    public function desvincularUsuarioEmpresa(array $dados) {
        $query = 
            "DELETE  
            FROM 
                tbl_usuario_empresa
            WHERE
                id_empresa = :id_empresa AND id_usuario = :id_usuario  
        ";

        $stmt = $this->pdo->prepare($query);

        foreach ($dados as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }
        $stmt->execute();

        return $stmt->rowCount();
    }

}