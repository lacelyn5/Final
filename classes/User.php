<?php
require_once 'Database.php';  
class User {
    private $db;
    public function __construct() {
       
        $this->db = new Database(); 
    }   
    public function register($username, $password, $email) {
        if ($this->isUsernameTaken($username) || $this->isEmailTaken($email)) {
            return false; 
        }
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
        $this->db->query($query);
        $this->db->bind(':username', $username);
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':email', $email);
        try {
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage()); 
            return false;
        }
    }
    public function isUsernameTaken($username) {
        $query = "SELECT id FROM users WHERE username = :username";
        $this->db->query($query);
        $this->db->bind(':username', $username);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }
    public function isEmailTaken($email) {
        $query = "SELECT id FROM users WHERE email = :email";
        $this->db->query($query);
        $this->db->bind(':email', $email);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }
    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = :username";
        $this->db->query($query);
        $this->db->bind(':username', $username);
        $row = $this->db->fetch();
        if ($row && password_verify($password, $row['password'])) {
            return $row['id']; 
        } else {
            return false; 
        }
    }
}
