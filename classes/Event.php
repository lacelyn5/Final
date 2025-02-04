<?php
require_once 'Database.php';
class Event {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }
    public function create($user_id, $name, $description, $event_date, $location) {
        $query = "INSERT INTO events (user_id, name, description, event_date, location) 
                  VALUES (:user_id, :name, :description, :event_date, :location)";
        $this->db->query($query);
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':name', $name);
        $this->db->bind(':description', $description);
        $this->db->bind(':event_date', $event_date);
        $this->db->bind(':location', $location);
        return $this->db->execute();
    }
    public function update($id, $name, $description, $event_date, $location) {
        $query = "UPDATE events SET name = :name, description = :description, 
                  event_date = :event_date, location = :location WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        $this->db->bind(':name', $name);
        $this->db->bind(':description', $description);
        $this->db->bind(':event_date', $event_date);
        $this->db->bind(':location', $location);
        return $this->db->execute();
    }
    public function delete($id) {
        $query = "DELETE FROM events WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    public function getEventsByUser($user_id) {
        $query = "SELECT * FROM events WHERE user_id = :user_id";
        $this->db->query($query);
        $this->db->bind(':user_id', $user_id);
        return $this->db->fetchAll();
    }
    public function getEventById($id) {
        $query = "SELECT * FROM events WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->fetch();
    }
}
