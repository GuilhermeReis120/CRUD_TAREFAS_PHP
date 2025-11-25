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

  public function atualizar()
  {
    $entrada = json_decode(file_get_contents('php://input'), true);

    $tarefa = new Tarefa($this->db);
    $tarefa->id = $entrada['id'];
    $tarefa->titulo = $entrada['titulo'];
    $tarefa->descricao = $entrada['descricao'];
    $tarefa->status = $entrada['status'];

    if ($tarefa->atualizar_tarefas()) {

      echo json_encode(array("mensagem" => "Tarefa atualizada com sucesso."));
    } else {

      echo json_encode(array("mensagem" => "Não foi possível atualizar a tarefa."));
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
