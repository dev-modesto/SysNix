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

    public function consultar($dados) {
        $query = "SELECT * FROM tbl_token WHERE token = :token AND codigo_verificacao = :codigo_verificacao";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":token", $dados['token']);
        $stmt->bindValue(":codigo_verificacao", $dados['codigo_verificacao']);

        if($stmt->execute()){
            $dadosReturn = $stmt->fetch(PDO::FETCH_ASSOC);
            $mensagem = ['status' => 0, 'dados' => $dadosReturn];

        } else {
            $mensagem = ['status' => 1, 'msg' => 'Ocorreu um erro ao cadastrar a token.'];
        }

        return $mensagem;
    }

    public function atualizar($dados) {
        $query = "UPDATE tbl_token SET usado = 'sim' WHERE id = :id_token";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id_token", $dados['id_token']);

        if($stmt->execute()){
            $linhasAfetadas = $stmt->rowCount();
            $mensagem = ['status' => 0, 'linhas_afetadas' => $linhasAfetadas, 'msg' => 'Token salvacom sucesso.'];

        } else {
            $mensagem = ['status' => 1, 'msg' => 'Ocorreu um erro ao atualizar a token.'];
        }

        return $mensagem;
    }

    public function atualizarAcessoLoginUsuarioToken($dados) {
        $query = "UPDATE tbl_usuario SET primeiro_acesso = 'nao', status = 'ativo', updated_at = :updated_at WHERE email = :email";
        $stmt = $this->pdo->prepare($query);

        foreach ($dados as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }

        if($stmt->execute()){
            $linhasAfetadas = $stmt->rowCount();
            $mensagem = ['status' => 0, 'linhas_afetadas' => $linhasAfetadas, 'msg' => 'Token salva e acesso do usuário atualizado com sucesso.'];

        } else {
            $mensagem = ['status' => 1, 'msg' => 'Ocorreu um erro ao atualizar o acesso do usuário após a validação da token.'];
        }

        return $mensagem;
    }
}

