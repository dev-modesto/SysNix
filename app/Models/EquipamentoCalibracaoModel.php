<?php

namespace App\Models;
use App\Config\Connection;
use PDO;
use PDOException;

class EquipamentoCalibracaoModel
{
    protected PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::getInstance();
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function selecionar($filtroDiasCalibracao = null) {
        $where = 'WHERE 1=1';
    
        if (!empty($filtroDiasCalibracao)) {
            $where .= " AND DATEDIFF(dt_calibracao_previsao, CURRENT_DATE()) <= :dias";
        }

        $query = 
        "SELECT
            e.id,
            e.uuid,
            e.nome_identificador,
            e.descricao,
            e.modelo,
            e.fabricante,
            e.serie,
            e.resolucao,
            e.faixa_uso,
            e.dt_ultima_calibracao,
            e.numero_certificado,
            e.dt_calibracao_previsao,
            e.ei_15a25_n,
            e.ei_2a8,
            e.ei_15a25,
            e.created_at,
			f.nome as nome_status_funcional, 
            f.cor as cor_status_funcional,
            u.nome as nome_status_uso, 
            u.cor as cor_status_uso,
            DATEDIFF(dt_calibracao_previsao, CURRENT_DATE()) AS dias_calibracao_previsao,
            CASE
            WHEN (DATEDIFF(dt_calibracao_previsao, CURRENT_DATE())) <= 0 THEN 'Vencido'
            WHEN (DATEDIFF(dt_calibracao_previsao, CURRENT_DATE())) <= 30 THEN 'Vencendo'
            ELSE 'Dentro do prazo'
            END AS situacao_dt_calibracao 
        FROM tbl_equipamento_calibracao e 
        INNER JOIN tbl_status_funcional f ON (f.id = e.id_status_funcional)
        INNER JOIN tbl_status_uso u ON (u.id = e.id_status_uso)
        $where 
		ORDER BY dias_calibracao_previsao
        ";
        $stmt = $this->pdo->prepare($query);

        if (!empty($filtroDiasCalibracao)) {
            $stmt->bindValue(':dias', $filtroDiasCalibracao, PDO::PARAM_INT);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrar($dados) {
        $query = 
            "INSERT INTO tbl_equipamento_calibracao
            (
                uuid,
                nome_identificador,
                descricao,
                modelo,
                fabricante,
                serie,
                resolucao,
                faixa_uso,
                dt_ultima_calibracao,
                numero_certificado,
                dt_calibracao_previsao,
                ei_15a25_n,
                ei_2a8,
                ei_15a25,
                created_at,
                id_status_funcional,
                id_status_uso
            ) VALUES(
                :uuid,
                :nome_identificador, 
                :descricao, 
                :modelo, 
                :fabricante, 
                :serie, 
                :resolucao, 
                :faixa_uso, 
                :dt_ultima_calibracao, 
                :numero_certificado, 
                :dt_calibracao_previsao, 
                :ei_15a25_n, 
                :ei_2a8, 
                :ei_15a25, 
                :created_at,
                :id_status_funcional, 
                :id_status_uso
            )
        ";

        $stmt = $this->pdo->prepare($query);

        foreach ($dados as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function removerEquipamento($id) {
        $query = "DELETE FROM tbl_equipamento_calibracao WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function atualizar($id, $dados) {

        $set = [];

        foreach ($dados as $chave => $valor) {
            $set[] = "$chave = :$chave";
        }

        $colunasValores = implode(',', $set);

        $query = "UPDATE tbl_equipamento_calibracao SET $colunasValores WHERE id = :id";
        $stmt = $this->pdo->prepare($query);

        foreach ($dados as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }

        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function importar($dados) {

        $query = 
            "INSERT INTO tbl_equipamento_calibracao
            (
                uuid,
                nome_identificador,
                descricao,
                modelo,
                fabricante,
                serie,
                resolucao,
                faixa_uso,
                dt_ultima_calibracao,
                numero_certificado,
                dt_calibracao_previsao,
                ei_15a25_n,
                ei_2a8,
                ei_15a25,
                created_at,
                updated_at,
                id_status_funcional,
                id_status_uso

            ) VALUES(
                :uuid,
                :nome_identificador, 
                :descricao, 
                :modelo, 
                :fabricante, 
                :serie, 
                :resolucao, 
                :faixa_uso, 
                :dt_ultima_calibracao, 
                :numero_certificado, 
                :dt_calibracao_previsao, 
                :ei_15a25_n, 
                :ei_2a8, 
                :ei_15a25, 
                :created_at,
                :updated_at,
                :id_status_funcional, 
                :id_status_uso
            )
        ";

        $stmt = $this->pdo->prepare($query);

        foreach ($dados as $linha) {
            foreach ($linha as $chave => $valor) {
                $stmt->bindValue(":$chave", $valor);
            }
            $stmt->execute();
        }
        return $this->pdo->lastInsertId();

    }
}