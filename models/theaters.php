<?php
class Theater {
    private $conn;
    public function __construct($db){
        $this->conn = $db;
    }
    public function getAll(){
        $sql = "SELECT * FROM theaters";
        return $this->conn->query($sql);
    }
    public function getById($id){
        $stmt = $this->conn->prepare("SELECT * FROM theaters WHERE theater_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function create($data){
        $stmt = $this->conn->prepare("
            INSERT INTO theaters(theater_name)
            VALUES (?)
        ");
        $stmt->bind_param("s", $data['theater_name']);
        return $stmt->execute();
    }
    public function update($data){
        $stmt = $this->conn->prepare("
            UPDATE theaters SET theater_name=?
            WHERE theater_id=?
        ");
        $stmt->bind_param(
            "si",
            $data['theater_name'],
            $data['theater_id']
        );
        return $stmt->execute();
    }
    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM theaters WHERE theater_id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>