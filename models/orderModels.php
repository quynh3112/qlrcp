<?php
class OrderModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function getAll() {
        $sql = "SELECT fo.*, u.username, s.start_time, s.price AS showtime_price
                FROM foodorders fo
                JOIN users u ON fo.user_id = u.user_id
                LEFT JOIN showtimes s ON fo.showtime_id = s.showtime_id
                ORDER BY fo.order_time DESC";
        return $this->conn->query($sql);
    }
    public function getById($id){
        $stmt = $this->conn->prepare("
        SELECT fo.*, u.username, s.start_time,
        GROUP_CONCAT(fi.name, 'x', fod.quantity SEPARATOR ', ') AS items
        FROM foodorders fo
        JOIN users u ON fo.user_id = u.user_id
        LEFT JOIN showtimes s ON fo.showtime_id = s.showtime_id
        LEFT JOIN foodorderdetails fod ON fo.order_id = fod.order_id
        LEFT JOIN fooditems fi ON fod.food_id = fi.food_id
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
        $showtime_id = $data['showtime_id'] ?? null;
        $stmt = $this->conn->prepare("INSERT INTO foodorders (user_id, showtime_id, total_price, order_time) VALUES (?, ?, 0, ?)");
        $stmt->bind_param("iis", $data['user_id'], $showtime_id, $time);
        if (!$stmt->execute()) return false;
        $order_id = $this->conn->insert_id;

        //thêm từng món vào foodorderdetails + tính tổng tiền
        $total_price = 0;
        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $food_id  = intval($item['food_id']);
                $quantity = intval($item['quantity']);
                //lấy giá món ăn
                $s = $this->conn->prepare("SELECT price FROM fooditems WHERE food_id = ?");
                $s->bind_param("i", $food_id);
                $s->execute();
                $r = $s->get_result()->fetch_assoc();
                $price = floatval($r['price'] ?? 0);
                //thêm vào details
                 $s2 = $this->conn->prepare("INSERT INTO foodorders_details (order_id, food_id, quantity) VALUES (?, ?, ?)");
                $s2->bind_param("iii", $order_id, $food_id, $quantity);
                $s2->execute();
 
                $total_price += $price * $quantity;
            }
    }
        //cập nhật tổng tiền
       $upd = $this->conn->prepare("UPDATE foodorders SET total_price = ? WHERE order_id = ?");
        $upd->bind_param("di", $total_price, $order_id);
        $upd->execute();
 
        return $order_id;
    }
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM foodorders_details WHERE order_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $stmt2 = $this->conn->prepare("DELETE FROM foodorders_details WHERE order_id = ?");
        $stmt2->bind_param("i", $id);
        return $stmt2->execute();
    }
}
?>