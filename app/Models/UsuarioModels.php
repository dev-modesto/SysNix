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
        $query = "SELECT * FROM tbl_usuario WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':email', $email);

        if($stmt->execute()){
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dados;
        };
    }

}