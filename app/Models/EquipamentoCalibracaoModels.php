<?php

namespace App\Models;
use App\Config\Connection;
use PDO;

class EquipamentoCalibracaoModels
{
    protected PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::getInstance();
    }

    public function selecionar() {
        $query = "SELECT * FROM tbl_equipamento_calibracao";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrar($dados) {
        $query = 
            "INSERT INTO tbl_equipamento_calibracao
            (
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

        if($stmt->execute()) {
            $mensagem = ['status' => 0, 'msg' => 'Equipamento cadastrado com sucesso.', 'alert' => 0];

        } else {
            $mensagem = ['status' => 1, 'msg' => 'Ocorreu um erro ao cadastrar o equipamento.', 'alert' => 1];
        };

        return $mensagem;

    }
}