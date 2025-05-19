<?php

namespace App\Models;

use App\Config\Connection;
use PDO;

class ModuloModel
{

    protected PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::getInstance();
    }

    public function selecionarModulos() {
        $query = "SELECT * FROM tbl_modulo";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Selecionar e retornar informações do modulo atual através do nome da pasta na url
     *
     * @param string $nomePasta informar o nome da pasta referente ao modulo atual
     * @return void
     */
    public function selecionarModuloCaminho(string $nomePasta) {
        $query = "SELECT * FROM tbl_modulo WHERE caminho = :caminho";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":caminho", $nomePasta);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}