<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once '../vendor/autoload.php';

class EmailService {

    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        $this->mailer->CharSet = 'UTF-8'; // garantir que o conteúdo do corpo do e-mail esteja com o charset correto

        // configurações basicas do servidor
        $this->mailer->isSMTP(); //define o uso de SMPT no envio
        $this->mailer->SMTPAuth = true; //Habilita a autenticação SMTP
        $this->mailer->Username   = 'gabrielmodesto.work@gmail.com';
        $this->mailer->Password   = 'ohzh hnti rcoa ctem'; //senha de app. Deve esta habilitada a verificação em duas etapas na conta do gmail
        $this->mailer->SMTPSecure = 'tls'; // Criptografia do envio SSL também é aceito
        
        // Informações específicadas pelo Google
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->Port = 587;

        // Remetente padrão
        $this->mailer->setFrom('gabrielmodesto.work@gmail.com', 'Gabriel Modesto');
        $this->mailer->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
    
    }

    public function enviarCodigoAutenticacaoService(string $destinatarioEmail, string $destinatarioNome, int $codigo) {
        try {
            $this->mailer->addAddress($destinatarioEmail, $destinatarioNome); // Endereço destinatário

            // Conteúdo da mensagem
            $this->mailer->Subject = 'Código de Autenticação';
            $this->mailer->Body = $this->gerarCorpoHtmlEmail($destinatarioNome, $codigo);
            $this->mailer->AltBody = "Olá, $destinatarioNome! Seu código de verificação é: $codigo";
            return $this->mailer->send();

        } catch (Exception $e) {
            return false;
        }

    }

    private function gerarCorpoHtmlEmail($destinatarioNome, $codigo) {
        return <<<HTML
            <div style="background-color: #F3F3F3; padding: 30px;">
                <table width="100%" style="max-width: 600px; display: flex; justify-content: center;" cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody style="margin: auto; width: 100%; background-color: #fff;">
                        <tr style="display: flex;">
                            <td style="width: 100%; font-size: 1rem; padding: 30px">
                                <div>
                                    <table style="width: 100%; font-family: 'Montserrat', segoe ui, sans-serif; background-color: #fff; margin: auto; box-sizing: border-box;">
                                        <tbody>
                                            <tr><td style="padding-bottom: 30px;">Logo</td></tr>
                                            <tr style="font-size: 1.5rem; font-weight: 600; text-align: center;"><td style="padding-bottom: 30px;">Código de autenticação</td></tr>
                                            <tr><td>Olá, <strong>$destinatarioNome!</strong></td></tr>
                                            <tr><td style="padding-bottom: 30px;">Favor, informar o código de autenticação para validar a sua conta.</td></tr>
                                            <tr style="font-size: 20px; text-align: center; font-weight: 600; letter-spacing: .5rem; background-color: #2C2F3E; color: #fff;"><td style="padding: 10px;">$codigo</td></tr>
                                        </tbody>
                                    </table>

                                    <div style="height: 30px; width: 100%; margin: auto; border-bottom: 1px solid #e8e8e8;" aria-hidden="true"></div>
                                    <div style="height: 30px;"></div>

                                    <table style="width: 100%; font-family: 'Montserrat', segoe ui, sans-serif; background-color: #fff; margin: auto;">
                                        <tbody>
                                            <tr><td><strong>Observação:</strong> Código valido por 10 minutos.</td></tr>
                                        </tbody>
                                    </table>

                                    <div style="height: 30px; width: 100%; margin: auto; border-bottom: 1px solid #e8e8e8;" aria-hidden="true"></div>
                                    <div style="height: 30px;"></div>
                                    
                                    <table style="width: 100%; font-family: 'Montserrat', segoe ui, sans-serif; background-color: #fff; margin: auto;">
                                        <tbody>
                                            <tr><td>Atenciosamente,</td></tr>
                                            <tr><td>Equipe devModesto.</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="font-family: 'Montserrat', segoe ui, sans-serif; margin: auto; max-width: 600px; width: 100%; padding: 10px 30px; box-sizing: border-box;">
                    <p>© 2025 · <a href="https://devmodesto.com.br" target="_blank" rel="noopener noreferrer">devModesto</a> · Todos os direitos reservados </p>
                </div>
            </div>
        HTML;

    }

}