<?php

use App\Helpers\MensagemHelper;

require_once '../app/Config/config.php';

$rotasPermitidas = [
    'Auth' => ['consultar', 'validarToken', 'validarEmpresaSelecionada'], 
    'EquipamentoCalibracao' => ['selecionar', 'cadastrar', 'atualizar', 'remover', 'importar'],
    'StatusEquipamentoCalibracao' => ['retornarStatusUso'],
    'Usuario' => ['cadastrar'] 
];


if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $contentType = $_SERVER["CONTENT_TYPE"] ?? '';

    if (stripos($contentType, 'application/json') !== false) {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true) ?? [];

    } else {
        $data = $_POST;
    }

    $acao = htmlspecialchars(trim($data['acao']));
    $controller = htmlspecialchars(trim($data['controller']));
    header('Content-Type: application/json');

    if (str_starts_with($acao, '__')) {
        http_response_code(403);
        echo json_encode(['status' => false, 'msg' => 'Método proibido']);
        exit;
    }

    if (!$controller || !$acao) {
        http_response_code(400);
        echo json_encode(['status' => false, 'msg' => 'Parâmetros ausentes']);
        exit;
    }

    if (!array_key_exists($controller, $rotasPermitidas) || !in_array($acao, $rotasPermitidas[$controller])) {
        http_response_code(403);
        echo json_encode(['status' => false, 'msg' => 'Ação não permitida'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    }

    $controllerClass = "App\\Controllers\\" . $controller . "Controller";

    if (!class_exists($controllerClass)) {
        http_response_code(404);
        echo json_encode(['status' => false, 'msg' => 'Controller não encontrado']);
        exit;
    }

    $controller = new $controllerClass();

    if (!method_exists($controller, $acao)) {
        http_response_code(404);
        echo json_encode(['status' => false, 'msg' => 'Método não encontrado']);
        exit;
    }
    try {
        $resposta = $controller->{$acao}($data);
        echo json_encode(['data' => $resposta], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => false, 'msg' => 'Erro interno', 'erro' => $e->getMessage()]);
    }

}