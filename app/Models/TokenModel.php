<?php
namespace App\Models;
use App\Config\Connection;
use PDO;


class TokenModel
{

    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    public function inserir($dados){

        $query = 
            "INSERT INTO tbl_token
                (
                    id_usuario,
                    token,
                    codigo_verificacao,
                    usado,
                    created_at,
                    validade
                ) 
            VALUES 
                (
                    :id_usuario, 
                    :token, 
                    :codigo_verificacao, 
                    :usado, 
                    :created_at, 
                    :validade
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
                    'msg' => 'Token salva com sucesso.',
                    'token' => $dados['token'],
                    'codigo' => $dados['codigo_verificacao'],
                    'alert' => 0 
                ]
            ;

        } else {
            $mensagem = ['status' => 1, 'msg' => 'Ocorreu um erro ao cadastrar a token.', 'alert' => 1];
        };

        return $mensagem;

    }
}

