<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/md_tarefas.php';

class TarefasController
{
  private $db;
  public function __construct()
  {
    $this->db = (new Database())->connect_db();
  }

  public function listar()
  {
    $tarefa = new Tarefa($this->db);
    $tarefas = $tarefa->listar_tarefas();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($tarefas);
  }

  public function criar()
  {
    $entrada = json_decode(file_get_contents('php://input'), true);

    $tarefa = new Tarefa($this->db);
    $tarefa->titulo = $entrada['titulo'];
    $tarefa->descricao = $entrada['descricao'];
    $tarefa->status = $entrada['status'];

    if ($tarefa->criar_tarefas()) {

      echo json_encode(array("mensagem" => "Tarefa criada com sucesso."));
    } else {

      echo json_encode(array("mensagem" => "Não foi possível criar a tarefa"));
    }
  }

  public function atualizar($id = null)
  {
    header('Content-Type: application/json; charset=utf-8');
    $entrada = json_decode(file_get_contents('php://input'), true);

    if ($id === null) {
      $id = isset($entrada['id']) ? (int)$entrada['id'] : null;
    }

    if (!is_numeric($id)) {
      http_response_code(400);
      echo json_encode(['error' => 'ID inválido']);
      return;
    }

    $tarefa = new Tarefa($this->db);
    $tarefa->id = (int)$id;
    $tarefa->titulo = isset($entrada['titulo']) ? $entrada['titulo'] : null;
    $tarefa->descricao = isset($entrada['descricao']) ? $entrada['descricao'] : null;
    $tarefa->status = isset($entrada['status']) ? $entrada['status'] : null;

    try {
      if ($tarefa->atualizar_tarefas()) {
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Tarefa atualizada']);
      } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Não foi possível atualizar']);
      }
    } catch (PDOException $e) {
      http_response_code(500);
      echo json_encode(['error' => $e->getMessage()]);
    }
  }

  public function deletar($id)
  {
    $tarefa = new Tarefa($this->db);

    if ($tarefa->deletar($id)) {

      echo json_encode(array("mensagem" => "Tarefa deletada com sucesso."));
    } else {

      echo json_encode(array("mensagem" => "Não foi possível deletar a tarefa."));
    }
  }
}
