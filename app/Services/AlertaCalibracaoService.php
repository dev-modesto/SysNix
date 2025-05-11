<?php
namespace App\Services;

use App\Controllers\EquipamentoCalibracaoController;
use App\Helpers\DataHelper;
use App\Models\AlertaModel;
use App\Models\EquipamentoCalibracaoModel;
use App\Models\LogModel;

include_once BASE_PATH . '/vendor/autoload.php';

class AlertaCalibracaoService
{

    public static function cronjobAlertaCalibracao() {

        $EquipamentoCalibracaoModel = new EquipamentoCalibracaoModel();
        $dadosEquipamentosCalibracao = $EquipamentoCalibracaoModel->selecionar(30);
        $arrayDatas = DataHelper::getDataHoraSistema();
        $dataPtbr = $arrayDatas['data_ptbr'];
        $hora = $arrayDatas['hora'];
        $createdAt = date('Y-m-d H:i:s');

        $logModel = new LogModel();

        if (!empty($dadosEquipamentosCalibracao)) {
            $alertaModel = new AlertaModel();
            $dadosUsuarioAlerta = $alertaModel->consultarAlertaUsuario();

            if (!empty($dadosUsuarioAlerta)) {
                echo '<pre>';


                foreach ($dadosUsuarioAlerta as $chave => $valor) {
                    $arrayEquipamentosEnviarEmail = [];
                    $arrayEquipamentosEnviarNotificacao = [];

                    $idUsuario = $valor['id_usuario'];
                    $email = $valor['email'];
                    $nomeUsuario = $valor['nome'];
                    $sobrenomeUsuario = $valor['sobrenome'];
                    $canalAlerta = $valor['canal'];

                    foreach ($dadosEquipamentosCalibracao as $chave => $valor) {

                        $id_equipamento = $valor['id'];
                        $numero_certificado = $valor['numero_certificado'];
                        $dt_calibracao_previsao = $valor['dt_calibracao_previsao'];
                        $nome_identificador = $valor['nome_identificador'];

                        $dadosConsultaVerifica = $alertaModel->consultarNotificacaoEquipamentoUsuario($id_equipamento, $numero_certificado, $idUsuario, $dt_calibracao_previsao, $canalAlerta);

                        if (empty($dadosConsultaVerifica)) {
                            // echo "$nomeUsuario $sobrenomeUsuario | NÃO RECEBEU alerta '$canalAlerta' referente ao equipamento: $nome_identificador." . "<br>";
                            $idTblOrigem = 1; //provisoriamente

                            $arrayDadosAlertaCalibracao = [
                                'id_equipamento' => $valor['id'], 
                                'numero_certificado' => $valor['numero_certificado'],
                                'id_usuario' => $idUsuario,
                                'dt_calibracao_previsao' => $valor['dt_calibracao_previsao'],
                                'canal' => $canalAlerta,
                                'visto' => 0,
                                'id_tbl_origem' => $idTblOrigem,
                                'created_at' => $createdAt
                            ];

                            $insertAlertaCalibracao = $alertaModel->inserirAlertaCalibracaoEquipamento($arrayDadosAlertaCalibracao);
                            $statusReturnInsert = '';
                            
                            foreach ($insertAlertaCalibracao as $chave => $valorInsert) {
                                $statusReturnInsert = $valorInsert['status'];

                                if ($statusReturnInsert == 0) {
                                    $statusReturnInsert;

                                } else {
                                    $statusReturnInsert++;
                                }
                            }

                            if ($statusReturnInsert == 0) {
                                if ($canalAlerta == 'email') {
                                    $arrayEquipamentosEnviarEmail[] = $valor;
                                }

                                if ($canalAlerta == 'notificação') {
                                    $arrayEquipamentosEnviarNotificacao[] = $valor;
                                }

                            } else {
                                echo 'ocorreu algum erro';
                            }

                        } else {
                            // NAO FAZER NADA. USUARIO RECEBEU O ALERTA

                        }
                    }

                    if (!empty($arrayEquipamentosEnviarEmail)) {
                        $destinatarioNome = "$nomeUsuario $sobrenomeUsuario";
                        $enviarAlertaEmail = EquipamentoCalibracaoController::enviarEmailAlertaEquipamentoController($email, $destinatarioNome, $arrayEquipamentosEnviarEmail);
    
                        if ($enviarAlertaEmail['status'] == 0) {
                            $idsEquipamentos = [];

                            foreach ($arrayEquipamentosEnviarEmail as $valor) {
                                $idsEquipamentos[] = $valor['id'];
                            }
                            
                            $stringIdEquipamentos = implode(',', $idsEquipamentos);

                            $mensagemCronjob = "O usuário $nomeUsuario $sobrenomeUsuario recebeu um envio de alerta do tipo '$canalAlerta' referente aos equipamentos de calibração de id: ($stringIdEquipamentos) em $dataPtbr às $hora";

                            $dadosLogCronjobAlertaCalibracao = [
                                'id_usuario' => $idUsuario,
                                'canal' => $canalAlerta,
                                'status_cronjob' => 0,
                                'mensagem' => $mensagemCronjob,
                                'created_at' => $createdAt
                            ];

                            $logModel->inserirLogCronjobEquipamentoCalibracao($dadosLogCronjobAlertaCalibracao);

                        }
                    } 
    
                    if (!empty($arrayEquipamentosEnviarNotificacao)) {
                        $idsEquipamentosNotificacao = [];

                        foreach ($arrayEquipamentosEnviarNotificacao as $valor) {
                            $idsEquipamentosNotificacao[] = $valor['id'];
                        }
                        
                        $stringIdEquipamentosNotificacao = implode(',', $idsEquipamentosNotificacao);

                        $mensagemCronjob = "O usuário $nomeUsuario $sobrenomeUsuario recebeu um envio de alerta do tipo '$canalAlerta' referente aos equipamentos de calibração de id: ($stringIdEquipamentosNotificacao) em $dataPtbr às $hora";

                        $dadosLogCronjobAlertaCalibracao = [
                            'id_usuario' => $idUsuario,
                            'canal' => $canalAlerta,
                            'status_cronjob' => 0,
                            'mensagem' => $mensagemCronjob,
                            'created_at' => $createdAt
                        ];

                        $logModel->inserirLogCronjobEquipamentoCalibracao($dadosLogCronjobAlertaCalibracao);

                    }
                    
                    if (empty($arrayEquipamentosEnviarEmail) && empty($arrayEquipamentosEnviarNotificacao)) {
                        $mensagemCronjob = "O usuario $nomeUsuario $sobrenomeUsuario não tem nenhum alerta do tipo '$canalAlerta' a receber referentes os equipamentos de calibração que estão a vencer nos proximos 30 dias.";

                        $dadosLogCronjobAlertaCalibracao = [
                            'id_usuario' => $idUsuario,
                            'canal' => $canalAlerta,
                            'status_cronjob' => 0,
                            'mensagem' => $mensagemCronjob,
                            'created_at' => $createdAt
                        ];

                        $logModel->inserirLogCronjobEquipamentoCalibracao($dadosLogCronjobAlertaCalibracao);
                    }
                }

            } else {
                $mensagemCronjob = "Nenhum usuário cadastrado para receber alertas referentes os equipamentos de calibração que estão a vencer nos proximos 30 dias.";

                $dadosLogCronjobAlertaCalibracao = [
                    'id_usuario' => '',
                    'canal' => '',
                    'status_cronjob' => 0,
                    'mensagem' => $mensagemCronjob,
                    'created_at' => $createdAt
                ];

                $logModel->inserirLogCronjobEquipamentoCalibracao($dadosLogCronjobAlertaCalibracao);
            }
                
        } else {
            $mensagemCronjob = "Nenhum equipamento de calibração encontrado com a validade de calibração prestes a vencer nos proximos 30 dias.";

            $dadosLogCronjobAlertaCalibracao = [
                'id_usuario' => '',
                'canal' => '',
                'status_cronjob' => 0,
                'mensagem' => $mensagemCronjob,
                'created_at' => $createdAt
            ];

            $logModel->inserirLogCronjobEquipamentoCalibracao($dadosLogCronjobAlertaCalibracao);

        }

    }
}