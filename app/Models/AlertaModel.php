<?php

namespace App\Models;
use App\Config\Connection;
use PDO;

class AlertaModel 
{
    protected PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::getInstance();
    }

    public function consultarAlertaUsuario() {

        $query = 
            "SELECT 
                a.id,
                a.canal,
                u.id as id_usuario,
                u.uuid,
                u.email,
                u.nome,
                u.sobrenome
            FROM tbl_usuario_alerta a
            INNER JOIN tbl_usuario u ON (a.id_usuario = u.id) 
            WHERE u.status = 'ativo'
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consultarNotificacaoEquipamentoUsuario($idEquipamento, $numeroCertificado, $idUsuario, $dtCalibracaoPrevisao, $canalAlerta) {
        
        $query = 
            "SELECT 
                *
            from tbl_alerta_calibracao
            WHERE 1=1 
            AND id_equipamento = :id_equipamento
            AND numero_certificado = :numero_certificado
            AND id_usuario = :id_usuario
            AND dt_calibracao_previsao = :dt_calibracao_previsao
            AND canal = :canal
        ";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue(':id_equipamento', $idEquipamento);
        $stmt->bindValue(':numero_certificado', $numeroCertificado);
        $stmt->bindValue(':id_usuario', $idUsuario);
        $stmt->bindValue(':dt_calibracao_previsao', $dtCalibracaoPrevisao);
        $stmt->bindValue(':canal', $canalAlerta);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inserirAlertaCalibracaoEquipamento($dados) {

        $query = 
            "INSERT INTO tbl_alerta_calibracao(
                id_equipamento, 
                numero_certificado, 
                id_usuario, 
                dt_calibracao_previsao, 
                canal, 
                visto, 
                id_tbl_origem, 
                created_at
                ) 
            VALUES(
                :id_equipamento,
                :numero_certificado,
                :id_usuario,
                :dt_calibracao_previsao,
                :canal,
                :visto,
                :id_tbl_origem,
                :created_at
            )
        ";
        
        $stmt = $this->pdo->prepare($query);

        foreach ($dados as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }

        if($stmt->execute()) {

            $mensagem [] = 
                [
                    'status' => 0, 
                    'msg' => 'Alertas de equipamentos salvo com sucesso!'
                ]
            ;

        } else {
            $mensagem = ['status' => 1, 'msg' => 'Ocorreu um erro ao salvar os alertas.', 'alert' => 1];
        };

        return $mensagem;

    }
}