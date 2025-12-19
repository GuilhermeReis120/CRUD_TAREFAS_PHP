<?php
  class Database{
    private $host = "db";
    private $user = "user";
    private $pass = "user123";
    private $dbname = "todo_db";
    private $port = "3306";
    private $conn;

    public function connect_db() {
      $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4";
      
      try {
        $this->conn = new PDO($dsn, $this->user, $this->pass);
        
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $this->conn;
      } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Erro ao conectar o banco: " . $e->getMessage()]);
        exit;
      }
    }
  }
?>