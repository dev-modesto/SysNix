<?php
namespace App\Models;

class StatusModels {

    public static function consultaStatusUsoEquipamento($con, $idStatus) {
        $sql = 
        "SELECT 
                u.id,
                u.nome,
                u.cor
            FROM tbl_index_status_equipamento_calibracao i
            INNER JOIN tbl_status_uso u ON (u.id = i.id_status_uso)
            WHERE id_status_funcional = ?
        ";

        $sqlPrepare = mysqli_prepare($con, $sql);

        mysqli_stmt_bind_param($sqlPrepare, 'i', $idStatus);

        if(mysqli_stmt_execute($sqlPrepare)) {

            $result = mysqli_stmt_get_result($sqlPrepare);
            
            if ($result) {
                $dados = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $array = [];
        
                foreach ($dados as $valor) {
                    $id = $valor['id'];
                    $nome = $valor['nome'];
                    $array[] = ['id' => $id, 'nome' => $nome];
                }
        
                return $array;
            }

        }

        return [];
    }
}
