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
        $query = "SELECT * FROM tbl_modulo ORDER BY nome asc";
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

    public function cadastrarModulo($dados) {

        $query = 
            "INSERT INTO tbl_modulo (
                uuid,
                nome,
                icone,
                caminho,
                status,
                created_at,
                updated_at
            ) VALUES (
                :uuid,
                :nome,
                :icone,
                :caminho,
                :status,
                :created_at,
                :updated_at
            )
        ";

        $stmt = $this->pdo->prepare($query);

        foreach ($dados as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }
        $stmt->execute();
        return $this->pdo->lastInsertId();

    }

    public function atualizarModulo($dados) {
        $id = $dados['id'];
        unset($dados['id']);

        $campos = [];

        foreach ($dados as $coluna => $valor) {
            $campos[] = "{$coluna} = :{$coluna}";
        }

        $query = "UPDATE tbl_modulo SET " . implode(',', $campos) . " WHERE id = :id";

        $stmt = $this->pdo->prepare($query);
        $dados['id'] = $id;

        foreach ($dados as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }

        return $stmt->execute();
    }

}