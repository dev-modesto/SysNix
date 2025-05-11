<?php

namespace App\Services;

use DateTime;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;
require_once BASE_PATH . '/vendor/autoload.php';

class EmailService {

    private $mailer;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(BASE_PATH . '/app/Config/');
        $dotenv->load();

        $this->mailer = new PHPMailer(true);

        $this->mailer->CharSet = 'UTF-8'; // garantir que o conteúdo do corpo do e-mail esteja com o charset correto

        // configurações basicas do servidor
        $this->mailer->isSMTP(); //define o uso de SMPT no envio
        $this->mailer->SMTPAuth = true; //Habilita a autenticação SMTP
        $this->mailer->Username   = $_ENV['EMAIL_USERNAME'];
        $this->mailer->Password   = $_ENV['EMAIL_PASSWORD']; //senha de app. Deve esta habilitada a verificação em duas etapas na conta do gmail
        $this->mailer->SMTPSecure = 'tls'; // Criptografia do envio SSL também é aceito
        
        // Informações específicadas pelo Google
        $this->mailer->Host = $_ENV['EMAIL_HOST'];
        $this->mailer->Port = $_ENV['EMAIL_PORT'];

        // Remetente padrão
        $this->mailer->setFrom($_ENV['EMAIL_USERNAME'], $_ENV['EMAIL_NAME']);
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

    public function enviarEmailAlertaEquipamentosCalibracao(string $destinatarioEmail, string $destinatarioNome, array $dados) {

        try {

            $this->mailer->addAddress($destinatarioEmail, $destinatarioNome); // Endereço destinatário

            // Conteúdo da mensagem
            $this->mailer->Subject = 'Equipamentos de Calibração vencendo';
            $this->mailer->Body = $this->gerarCorpoHtmlEmailAlertaEquipamentoCalibracao($destinatarioNome, $dados);
            $this->mailer->AltBody = "Olá, $destinatarioNome! Seus equipamentos precisam ser calibrados em breve.";

            if ($this->mailer->send()) {
                $mensagem = ['status' => 0, 'msg' => 'E-mail enviado com sucesso.'];
                return $mensagem;
            } else {
                error_log("Erro ao enviar e-mail: " . $this->mailer->ErrorInfo);
                return false;
            }

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
                                    <table style="width: 100%; font-family: 'Roboto', segoe ui, sans-serif; background-color: #fff; margin: auto; box-sizing: border-box;">
                                        <tbody>
                                            <tr><td style="padding-bottom: 30px;"><a href=""><img src='https://i.postimg.cc/PNmJDM8d/logo-full-color.png' alt="logo" width="auto" height="40"></a></td></tr>
                                            <tr style="font-size: 1.5rem; font-weight: 600; text-align: center;"><td style="padding-bottom: 30px;">Código de autenticação</td></tr>
                                            <tr><td>Olá, <strong>$destinatarioNome!</strong></td></tr>
                                            <tr><td style="padding-bottom: 30px;">Favor, informar o código de autenticação para validar a sua conta.</td></tr>
                                            <tr style="font-size: 20px; text-align: center; font-weight: 600; letter-spacing: .5rem; background-color: #2C2F3E; color: #fff;"><td style="padding: 10px;">$codigo</td></tr>
                                        </tbody>
                                    </table>

                                    <div style="height: 30px; width: 100%; margin: auto; border-bottom: 1px solid #e8e8e8;" aria-hidden="true"></div>
                                    <div style="height: 30px;"></div>

                                    <table style="width: 100%; font-family: 'Roboto', segoe ui, sans-serif; background-color: #fff; margin: auto;">
                                        <tbody>
                                            <tr><td><strong>Observação:</strong> Código valido por 10 minutos.</td></tr>
                                        </tbody>
                                    </table>

                                    <div style="height: 30px; width: 100%; margin: auto; border-bottom: 1px solid #e8e8e8;" aria-hidden="true"></div>
                                    <div style="height: 30px;"></div>
                                    
                                    <table style="width: 100%; font-family: 'Roboto', segoe ui, sans-serif; background-color: #fff; margin: auto;">
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
                <div style="font-family: 'Roboto', segoe ui, sans-serif; margin: auto; max-width: 600px; width: 100%; padding: 10px 30px; box-sizing: border-box;">
                    <p>© 2025 · <a href="https://devmodesto.com.br" target="_blank" rel="noopener noreferrer">devModesto</a> · Todos os direitos reservados </p>
                </div>
            </div>
        HTML;

    }

    private function gerarCorpoHtmlEmailAlertaEquipamentoCalibracao($destinatarioNome, $dados) {

        $linhaEquipamentos = "";
        $numRow = 0;
                                                    
        foreach ($dados as $chave => $valor) {

            $nome_identificador = $valor["nome_identificador"];
            $descricao = $valor['descricao'];
            $modelo = $valor['modelo'];
            $fabricante = $valor['fabricante'];
            $serie = $valor['serie'];
            $dt_ultima_calibracao = new DateTime($valor['dt_ultima_calibracao']);
            $dt_ultima_calibracao = date_format($dt_ultima_calibracao, 'd/m/Y');
            $numero_certificado = $valor['numero_certificado'];
            $dt_calibracao_previsao = new DateTime($valor['dt_calibracao_previsao']);
            $dt_calibracao_previsao = date_format($dt_calibracao_previsao, 'd/m/Y');
            $id_status_funcional = $valor['status_funcional'];
            $id_status_uso = $valor['status_uso'];
            $dias_calibracao_previsao = $valor['dias_calibracao_previsao'];

            $numRow++;

            $linhaEquipamentos .= "
                <tr>
                    <td style='border: 1px solid #ddd; text-align: center; padding: 8px'>$numRow</td>
                    <td style='border: 1px solid #ddd; text-align: center; padding: 8px'>$nome_identificador</td>
                    <td style='border: 1px solid #ddd; text-align: center; padding: 8px'>$descricao</td>
                    <td style='border: 1px solid #ddd; text-align: center; padding: 8px'>$modelo</td>
                    <td style='border: 1px solid #ddd; text-align: center; padding: 8px'>$fabricante</td>
                    <td style='border: 1px solid #ddd; text-align: center; padding: 8px'>$serie</td>
                    <td style='border: 1px solid #ddd; text-align: center; padding: 8px'>$dt_ultima_calibracao</td>
                    <td style='border: 1px solid #ddd; text-align: center; padding: 8px'>$numero_certificado</td>
                    <td style='border: 1px solid #ddd; text-align: center; padding: 8px'>$dt_calibracao_previsao</td>
                    <td style='border: 1px solid #ddd; text-align: center; padding: 8px'>$id_status_funcional</td>
                    <td style='border: 1px solid #ddd; text-align: center; padding: 8px'>$id_status_uso</td>
                    <td style='border: 1px solid #ddd; text-align: center; padding: 8px'>$dias_calibracao_previsao</td>
                </tr>
            ";
        }

        return <<<PHP
 
            <div style="background-color: #F3F3F3; padding: 30px;">
                <table width="100%" style="max-width: 1400px; display: flex; justify-content: center;" cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody style="margin: auto; width: 100%; background-color: #fff;">
                        <tr style="display: flex;">
                            <td style="width: 100%; font-size: 1rem; padding: 30px">
                                <div>
                                    <table style="width: 100%; font-family: 'Roboto', segoe ui, sans-serif; background-color: #fff; margin: auto;">
                                        <tbody>
                                            <tr><td style="padding-bottom: 0px;"><a href=""><img src='https://i.postimg.cc/PNmJDM8d/logo-full-color.png' alt="logo" width="auto" height="40"></a></td></tr>
                                        </tbody>
                                    </table>
                                    <table style="width: 100%; font-family: 'Roboto', segoe ui, sans-serif; background-color: #fff; margin: auto;">
                                        <tbody>
                                            <div style="height: 30px; width: 100%; margin: auto; border-bottom: 1px solid #e8e8e8;" aria-hidden="true"></div>
                                            <div style="height: 30px;"></div>
                                            
                                            <tr>
                                                <td style="font-size: 1.1rem; padding-bottom: 15px;">
                                                    <tr style="font-size: 1.5rem; font-weight: 600; text-align: center;"><td style="padding-bottom: 30px;">⚠️ Alerta de Calibração</td></tr>
                                                </td>
                                            </tr>
                                            <tr><td>Olá, <strong>$destinatarioNome!</strong></td></tr>

                                            <tr>
                                                <td style="padding-bottom: 30px;">
                                                    Identificamos que alguns dos seus equipamentos de medição e controle estão com a <strong>calibração prestes a vencer</strong>. <br> 
                                                    Para manter a conformidade e garantir a confiabilidade dos seus processos, recomendamos providenciar a calibração dentro do prazo
                                                </td>
                                            </tr>
                                            <tr style="font-size: 20px; text-align: center; font-weight: 600; background-color: #2C2F3E; color: #fff; height: 50px;"><td style="padding: 10px;">Lista de Equipamentos de Calibração Vencendo</td></tr>
                                        </tbody>

                                    </table>
                                    <table style="width: 100%; font-family: 'Roboto', segoe ui, sans-serif; background-color: #fff; margin: auto; box-sizing: border-box; border-collapse: collapse;">

                                        <thead class="thead">
                                            <tr>
                                                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px;" align="center">#</th>
                                                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px;" align="center">Identificador</th>
                                                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px;" align="center">Descrição</th>
                                                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px;" align="center">Modelo</th>
                                                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px;" align="center">Fabricante</th>
                                                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px;" align="center">Nº série</th>
                                                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px;" align="center">Última calibração</th>
                                                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px;" align="center">Nº Certificado</th>
                                                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px;" align="center">Calibração prevista</th>
                                                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px;" align="center">Status Funcional</th>
                                                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px;" align="center">Status Uso</th>
                                                <th style="border: 1px solid #dddddd; text-align: center; padding: 8px;" align="center">Dias a vencer</th>
                                            </tr>
                                        </thead>

                                        <tbody class="tbody">
                                            $linhaEquipamentos
                                        </tbody>
                                    </table>

                                    <div style="height: 30px; width: 100%; margin: auto; border-bottom: 1px solid #e8e8e8;" aria-hidden="true"></div>
                                    <div style="height: 30px;"></div>
                                    
                                    <table style="width: 100%; font-family: 'Roboto', segoe ui, sans-serif; background-color: #fff; margin: auto;">
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
                <div style="font-family: 'Roboto', segoe ui, sans-serif; margin: auto; max-width: 600px; width: 100%; padding: 10px 30px; box-sizing: border-box;">
                    <p>© 2025 · <a href="https://devmodesto.com.br" target="_blank" rel="noopener noreferrer">devModesto</a> · Todos os direitos reservados </p>
                </div>
            </div>
        PHP;
            
    }
}