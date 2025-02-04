<?php
include_once __DIR__ . '/../config.php';
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;
    private $stmt;
    public function __construct() {
        $this->host = DATA_HOST;
        $this->db_name = DATA_NAME;
        $this->username = DATA_USER;
        $this->password = DATA_PASS;
        $this->connect();  
    }
    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage()); 
        }
    }
    public function query($sql) {
        if ($this->conn === null) {
            throw new Exception("No database connection established.");
        }
        $this->stmt = $this->conn->prepare($sql);
    }
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    public function execute() {
        return $this->stmt->execute();
    }
    public function fetch() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function fetchAll() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function rowCount() {
        return $this->stmt->rowCount();
    }
}

