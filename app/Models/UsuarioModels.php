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
            COUNT(id_usuario) acesso_empresa
            FROM tbl_usuario u
            INNER JOIN tbl_usuario_empresa ue ON (ue.id_usuario = u.id)
            INNER JOIN tbl_empresa e ON(e.id = ue.id_empresa) 
            WHERE u.email = :email
        ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);

        if($stmt->execute()){
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dados;
        };
    }

}