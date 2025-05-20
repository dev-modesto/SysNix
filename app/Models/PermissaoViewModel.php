<?php

namespace App\Models;

use App\Config\Connection;
use PDO;

class PermissaoViewModel
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    /**
     * Selecionar e retonar views permitidas ao usuario ou grupo referente ao modulo
     *
     * @param array $dados - ['id_modulo', 'id_view', 'tipo_view', 'id_grupo' = null, 'id_usuario' = null]
     * @return void
     */
    public function selecionarPermissaoViewsModulo(array $dados) {

        $where = '';

        if (!empty($dados['id_grupo'])) {
            $where = "AND id_grupo = :id_grupo";
        } 

        if ($dados['tipo_view'] === 'tela') {
            $colunaJoin = 't'; 
            $innerJoin = "INNER JOIN tbl_tela t ON (pvm.id_view = t.id)"; 
        } 

        if ($dados['tipo_view'] === 'submodulo') {
            $colunaJoin = 's'; 
            $innerJoin = "INNER JOIN tbl_submodulo s ON (pvm.id_view = s.id)"; 
        } 

        $query = 
            "SELECT 
                pvm.id_modulo,
                m.nome as nome_modulo,
                m.caminho as caminho_modulo,
                pvm.id_view,
                :tipo_view as tipo_view,
                $colunaJoin.nome as nome_view,
                $colunaJoin.icone as icone_view,
                $colunaJoin.caminho as caminho_view,
                $colunaJoin.status
            FROM tbl_permissao_view_modulo pvm
            $innerJoin
            INNER JOIN tbl_modulo m ON (pvm.id_modulo = m.id)
            WHERE pvm.id_modulo = :id_modulo
            AND pvm.id_view = :id_view
            AND pvm.tipo_view = :tipo_view
            $where 
            AND pvm.id_usuario = :id_usuario
            AND $colunaJoin.status = 'ativo'
        ";

        $stmt = $this->pdo->prepare($query);

        foreach ($dados as $chave => $valor) {
            $stmt->bindValue(":$chave", $valor);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    
    }

}