<?php
  class Database{
    private $host = "db";
    private $user = "user";
    private $pass = "user123";
    private $dbname = "todo_db";
    private $port = "3306";

    public function connect_db() {

      $mysqli = new mysqli($this->host, $this->user, $this->pass, $this->dbname, $this->port);

      if ($mysqli->connect_errno) {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao conectar o banco: " . $mysqli->connect_error]);
        exit;
        }
      
      $mysqli->set_charset("utf8mb4");

      return $mysqli;
    }
  }
?>