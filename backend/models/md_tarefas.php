<?php
class Tarefa{
  private $conexao;
  private $table = "tarefas";
  public $id;
  public $titulo;
  public $descricao;
  public $status;
  public $created_at;
  public $updated_at;

  public function __construct($db)
  {
    $this->conexao = $db;
  }

  public function listar_tarefas()
  {
    $sql = "SELECT * FROM " . $this -> table . " ORDER BY id DESC";
    $stmt = $this->conexao->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function criar_tarefas()
  {
    $sql = $sql = "INSERT INTO " . $this -> table . " (titulo, descricao, status) VALUES (:titulo, :descricao, :status)";
    $stmt = $this->conexao->prepare($sql);
    return $stmt->execute([
      ':titulo' => $this->titulo,
      ':descricao' => $this->descricao,
      ':status' => $this->status
    ]);
  }

  public function atualizar_tarefas()
  {
    $sql = "UPDATE " . $this->table . " SET titulo = :titulo, descricao = :descricao, status = :status WHERE id = :id";
    $stmt = $this->conexao->prepare($sql);
    return $stmt->execute([
      ':titulo' => $this->titulo,
      ':descricao' => $this->descricao,
      ':status' => $this->status,
      ':id' => $this->id
    ]);
  }

  public function deletar($id)
  {
    $sql = "DELETE FROM {$this->table} WHERE id = :id";
    $stmt = $this->conexao->prepare($sql);
    return $stmt->execute([':id' => $id]);
  }
}
