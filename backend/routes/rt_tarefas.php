<?php
  $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $method = $_SERVER['REQUEST_METHOD'];

  $script_name = dirname($_SERVER['SCRIPT_NAME']);
  $path = '/' . trim(substr($url, strlen($script_name)), '/');

  require_once __DIR__ . '/../controllers/ct_tarefas.php';

  $controller = new TarefasController();

  $partes = array_values(array_filter(explode('/', $path)));

  if (count($partes) == 0 || $partes[0] === '' && $method === 'GET'){
    echo json_encode(["menssagem" => "API Tarefas Funcionando"]);
    exit;
  }
  
  if($partes[0] !== 'tarefas'){
    http_response_code(404);
    echo json_encode(["erro" => "Rota não encontrada"]);
    exit;
  }

  if(count($partes) === 1){
    if($method === 'GET'){
      $controller->listar();
    } elseif ($method === 'POST'){
      $controller->criar();
    }
  }
  if(count($partes) === 2 && is_numeric($partes[1])){
    $id = (int)$partes[1];
    if($method === 'PUT'){
      $controller->atualizar($id);
    } elseif ($method === 'DELETE'){
      $controller->deletar($id);
    }
  }
?>