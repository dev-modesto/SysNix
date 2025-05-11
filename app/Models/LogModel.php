<?php

namespace App\Models;
use App\Config\Connection;
use PDO;

class LogModel 
{
    protected PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::getInstance();
    }

    public function inserirLogCronjobEquipamentoCalibracao($dados){

        $query = 
            "INSERT INTO tbl_log_cronjob_alerta_calibracao
                (
                    id_usuario,
                    canal,
                    status_cronjob,
                    mensagem,
                    created_at
                ) 
            VALUES 
                (
                    :id_usuario, 
                    :canal, 
                    :status_cronjob, 
                    :mensagem, 
                    :created_at
                )
        ";

        $stmt = $this->pdo->prepare($query);

        foreach ($dados as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }

        if($stmt->execute()) {

            $mensagem = 
                [
                    'status' => 0, 
                    'msg' => 'Logs salvo com sucesso!',
                ]
            ;

        } else {
            $mensagem = ['status' => 1, 'msg' => 'Ocorreu um erro ao salvar o log dos equipamentos.'];
        };

        return $mensagem;

    }

}
