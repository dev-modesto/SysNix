<?php

namespace App\Helpers;

class SessionHelper
{

    public static function dadosSessao() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        };

        $dadosSessao = [
            'id_usuario' => $_SESSION['id_usuario'] ?? null,
            'uuid' => $_SESSION['uuid'] ?? null,
            'email' => $_SESSION['email'] ?? null,
            'nome' => $_SESSION['nome'] ?? null,
            'sobrenome' => $_SESSION['sobrenome'] ?? null,
            'nome_completo' => $_SESSION['nome_completo'] ?? null
        ];

        return $dadosSessao;
    }
}