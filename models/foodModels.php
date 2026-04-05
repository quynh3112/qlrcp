<?php
class FoodItem {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function getAll() {
        $sql = "SELECT * FROM fooditems ORDER BY food_id ASC";
        return $this->conn->query($sql);
    }
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM fooditems WHERE food_id = ?");
        $stmt->bind_param("i", $id);    
        $stmt->execute();
        return $stmt->get_result();
    }
    public function create($data) {
        if (empty($data['name']) || !isset($data['price'])) return false;
        $stmt = $this->conn->prepare("INSERT INTO fooditems (name, price) VALUES (?, ?)");
        $stmt->bind_param("sd", $data['name'], $data['price']);
        return $stmt->execute();
    }
    public function update($id, $data) {
        if (empty($data['name']) || !isset($data['price'])) return false;
        $stmt = $this->conn->prepare("UPDATE fooditems SET name = ?, price = ? WHERE food_id = ?");
        $stmt->bind_param("sdi", $data['name'], $data['price'], $id);
        return $stmt->execute();
    }
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM fooditems WHERE food_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>