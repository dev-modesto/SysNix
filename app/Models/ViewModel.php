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

    public function selecionarViewsModulo(string $tipoView, $idModulo = null, $idView = null) {
        $where = "WHERE 1=1";

        if ($idModulo) {
            $where .= " AND vm.id_modulo = :id_modulo";
        }

        if ($idView) {
            $where .= " AND vm.id_view = :id_view";
        }

        if ($tipoView) {
            $where .= " AND vm.tipo_view = :tipo_view";
        }

        $query = 
            "SELECT 
                vm.id,
                vm.id_modulo,
                m.nome as nome_modulo,
                m.caminho as caminho_modulo,
                vm.id_view,
                vm.tipo_view as tipo_view,
                t.nome as nome_view,
                t.icone,
                t.caminho as caminho_view,
                t.status
            FROM tbl_view_modulo vm
            INNER JOIN tbl_tela t ON (vm.id_view = t.id)
            INNER JOIN tbl_modulo m ON (vm.id_modulo = m.id)
            $where
        ";

        $stmt = $this->pdo->prepare($query);

        if ($idModulo) {
            $stmt->bindValue(":id_modulo", $idModulo);
        }

        if ($idView) {
            $stmt->bindValue(":id_view", $idView);
        }

        if ($tipoView) {
            $stmt->bindValue(":tipo_view", $tipoView);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Selecionar e retornar informações do modulo atual através do nome da pasta na url
     *
     * @param string $nomePasta informar o nome da pasta referente ao modulo atual
     * @return void
     */
    public function selecionarViewTelaCaminho(string $nomePasta) {
        $query = "SELECT * FROM tbl_tela WHERE caminho = :caminho";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":caminho", $nomePasta);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function selecionarTelas() {
        $query = "SELECT * FROM tbl_tela";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function cadastrarTela($dados) {

        $query = 
            "INSERT INTO tbl_tela (
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

    public function atualizarTela($dados) {
        $id = $dados['id'];
        unset($dados['id']);

        $campos = [];

        foreach ($dados as $coluna => $valor) {
            $campos[] = "{$coluna} = :{$coluna}";
        }

        $query = "UPDATE tbl_tela SET " . implode(',', $campos) . " WHERE id = :id";

        $stmt = $this->pdo->prepare($query);
        $dados['id'] = $id;

        foreach ($dados as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }

        return $stmt->execute();
    }

    public function removerTela($id) {

        $query = "DELETE FROM tbl_tela WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
        
    }

}