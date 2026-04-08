<?php
class OrderModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function getAll() {
        $sql = "SELECT fo.*, u.username 
                FROM foodorders fo
                JOIN users u ON fo.user_id = u.user_id
                ORDER BY fo.order_time DESC";
        return $this->conn->query($sql);
    }
    public function getById($id){
        $stmt = $this->conn->prepare("
        SELECT fo.*, u.username,
        GROUP_CONCAT(fi.name, ' x ', od.quantity SEPARATOR ', ') AS items_list
        FROM foodorders fo
        JOIN users u ON fo.user_id = u.user_id
        LEFT JOIN orderdetail od ON fo.order_id = od.order_id
        LEFT JOIN fooditems fi ON od.food_id = fi.food_id
        WHERE fo.order_id = ?
        GROUP BY fo.order_id
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function create($data) {
        //tạo đơn hàng
        $time = date("Y-m-d H:i:s");
        $stmt = $this->conn->prepare("INSERT INTO foodorders (user_id, order_time) VALUES (?, ?)");
        $stmt->bind_param("is", $data['user_id'], $time);
        if (!$stmt->execute()) return false;
        $order_id = $this->conn->insert_id;

        //thêm từng món vào foodorderdetails + tính tổng tiền
        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $s2 = $this->conn->prepare("INSERT INTO orderdetail (order_id, food_id, quantity) VALUES (?, ?, ?)");
                $s2->bind_param("iii", $order_id, $item['food_id'], $item['quantity']);
                $s2->execute();
            }
        }
        return $order_id;
    }
    public function delete($id) {
        $s1 = $this->conn->prepare("DELETE FROM orderdetail WHERE order_id = ?");
        $s1->bind_param("i", $id);
        $s1->execute();

        $s2 = $this->conn->prepare("DELETE FROM foodorders WHERE order_id = ?");
        $s2->bind_param("i", $id);
        return $s2->execute();
    }
}
?>