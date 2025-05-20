<?php

namespace App\Models;

use App\Config\Connection;
use PDO;

class PermissaoModuloModel
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    /**
     * selecionar modulos permitidos do usuario
     *
     * @param array $dados [id_empresa, id_usuario]
     * @return void
     */
    public function selecionarModulosPermitidos(array $dados) {
        $query = 
            "SELECT 
                m.id,
                m.nome,
                m.icone,
                m.caminho,
                m.status
            FROM tbl_modulo m
            INNER JOIN tbl_permissao_modulo pm ON (pm.id_modulo = m.id)
            INNER JOIN tbl_modulo_empresa me ON(me.id_modulo = m.id)
            WHERE me.id_empresa = :id_empresa
            AND (
                    pm.id_usuario = :id_usuario
                    OR pm.id_grupo IN (
                    SELECT id_grupo FROM tbl_usuario_grupo WHERE id_usuario = :id_usuario
                )
        )";

        $stmt = $this->pdo->prepare($query);

        foreach ($dados as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}