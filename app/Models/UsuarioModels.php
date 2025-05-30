<?php
namespace App\Models;
use App\Config\Connection;
use PDO;

class UsuarioModels
{

    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    public function selecionarCriterio($email) {
        $query = 
            "SELECT 
                u.id,
                u.uuid,
                u.email,
                u.nome,
                u.sobrenome,
                u.senha,
                u.primeiro_acesso,
                u.tentativas_login,
                u.status,
                (SELECT COUNT(*) FROM tbl_usuario_empresa WHERE id_usuario = u.id) AS acesso_empresa
            FROM tbl_usuario u
            WHERE u.email = :email
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);

        if($stmt->execute()){
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dados;
        };
    }

    public function cadastrarUsuario($dados) {
        $query = 
            "INSERT INTO tbl_usuario 
            (
                uuid,
                email,
                nome,
                sobrenome,
                senha,
                primeiro_acesso,
                tentativas_login,
                status,
                created_at,
                updated_at
            ) VALUES (
                :uuid, 
                :email, 
                :nome, 
                :sobrenome, 
                :senha, 
                :primeiro_acesso, 
                :tentativas_login, 
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

}