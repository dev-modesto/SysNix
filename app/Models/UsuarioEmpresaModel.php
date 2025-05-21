<?php

namespace App\Models;
use App\Config\Connection;
use PDO;

class UsuarioEmpresaModel
{

    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    public function selecionarEmpresaUsuario($idUsuario, $idEmpresa = null) {
        $where = "WHERE 1=1 AND ue.id_usuario = :id_usuario";

        if ($idEmpresa) {
            $where .= ' AND e.id = :id_empresa';
        }

        $query = 
            "SELECT 
            e.id,
            e.uuid,
            e.nome_legal,
            e.nome_fantasia,
            e.status
            FROM tbl_usuario_empresa ue
            INNER JOIN tbl_empresa e ON e.id = ue.id_empresa
            $where
            AND e.status = 'ativo';
        ";
        
        $stmt = $this->pdo->prepare($query);

        if ($idEmpresa) {
            $stmt->bindValue(':id_empresa', $idEmpresa);
        }

        $stmt->bindValue(':id_usuario', $idUsuario);
        $stmt->execute();

        if ($idEmpresa) {
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } else {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

}