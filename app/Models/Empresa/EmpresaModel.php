<?php

namespace App\Models\Empresa;

use App\Config\Connection;
use PDO;

class EmpresaModel
{

    protected PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::getInstance();
    }

    public function consultarEmpresas() {
        $query = "SELECT * FROM tbl_empresa";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}