<?php
namespace App\Helpers;

class GeralHelper 
{
    public static function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    /**
     * Função para gerar uma token de 32 bites/64 caracteres e gerar um codigo de 6 digitos
     *
     * @return void
     */
    public static function tokenCodigo() {
        $token = random_bytes(32);
        $token = bin2hex($token);
        $codigoSeisDigitos = random_int(100000, 999999);
        return ['token' =>  $token, 'codigo' => $codigoSeisDigitos];
    }

    public static function regexValidaEmail(string $email) {
        $regexEmail = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match($regexEmail, $email) ? true : false;
    }

    public static function removerCaracteresInput(string $valor) {
        $valor = trim($valor);
        $valor = stripslashes($valor);
        $valor = htmlspecialchars($valor);
        return $valor;
    }

}