<?php
include_once "../config/db.php";

class Booking {

    // Tạo booking mới (transaction: insert ticket + update seat_status)
    public function create($showtime_id, $seat_id, $user_id) {
        global $conn;
        $conn->begin_transaction();
        try {
            $booking_time = date("Y-m-d H:i:s");
            $sql = "INSERT INTO tickets (showtime_id, seat_id, user_id, booking_time)
                    VALUES ('$showtime_id', '$seat_id', '$user_id', '$booking_time')";
            if (!$conn->query($sql)) throw new Exception("Lỗi khi tạo vé!");
            $ticket_id = $conn->insert_id;

            // Cập nhật hoặc thêm seat_status
            $chk = $conn->query("SELECT id FROM seat_status WHERE showtime_id='$showtime_id' AND seat_id='$seat_id'");
            if ($chk->num_rows > 0) {
                $conn->query("UPDATE seat_status SET status='booked' WHERE showtime_id='$showtime_id' AND seat_id='$seat_id'");
            } else {
                $conn->query("INSERT INTO seat_status (showtime_id, seat_id, status) VALUES ('$showtime_id', '$seat_id', 'booked')");
            }

            $conn->commit();
            return ["status" => true, "message" => "Đặt vé thành công!", "ticket_id" => $ticket_id, "booking_time" => $booking_time];
        } catch (Exception $e) {
            $conn->rollback();
            return ["status" => false, "message" => $e->getMessage()];
        }
    }

    // Hủy vé (transaction: delete ticket + reset seat_status)
    public function delete($ticket_id) {
        global $conn;
        $ticket = $this->findById($ticket_id);
        if (!$ticket) return ["status" => false, "message" => "Vé không tồn tại!"];

        $conn->begin_transaction();
        try {
            if (!$conn->query("DELETE FROM tickets WHERE ticket_id='$ticket_id'"))
                throw new Exception("Lỗi khi xóa vé!");

            $conn->query("UPDATE seat_status SET status='available'
                          WHERE showtime_id='{$ticket['showtime_id']}' AND seat_id='{$ticket['seat_id']}'");
            $conn->commit();
            return ["status" => true, "message" => "Hủy vé thành công!"];
        } catch (Exception $e) {
            $conn->rollback();
            return ["status" => false, "message" => $e->getMessage()];
        }
    }

    // Lấy tất cả booking (JOIN đầy đủ)
    public function findAll() {
        global $conn;
        $sql = "SELECT t.ticket_id, t.booking_time,
                       t.user_id, u.username,
                       t.showtime_id,
                       m.title AS movie_title,
                       st.show_date, st.start_time, st.price AS showtime_price,
                       t.seat_id, s.seat_number, s.seat_type, s.price AS seat_price,
                       r.theater_name, c.name AS cinema_name
                FROM tickets t
                JOIN users u ON t.user_id = u.user_id
                JOIN showtimes st ON t.showtime_id = st.showtime_id
                JOIN movies m ON st.movie_id = m.movie_id
                JOIN seats s ON t.seat_id = s.seat_id
                JOIN rooms r ON s.theater_id = r.theater_id
                JOIN cinemas c ON r.cinema_id = c.cinema_id
                ORDER BY t.booking_time DESC";
        return $conn->query($sql);
    }

    // Lấy chi tiết 1 vé
    public function findById($ticket_id) {
        global $conn;
        $sql = "SELECT t.ticket_id, t.booking_time,
                       t.user_id, u.username, u.email, u.phone,
                       t.showtime_id, t.seat_id,
                       m.title AS movie_title, m.duration, m.genre,
                       st.show_date, st.start_time, st.price AS showtime_price,
                       s.seat_number, s.seat_type, s.price AS seat_price,
                       r.theater_name, r.type AS room_type,
                       c.name AS cinema_name, c.location AS cinema_location
                FROM tickets t
                JOIN users u ON t.user_id = u.user_id
                JOIN showtimes st ON t.showtime_id = st.showtime_id
                JOIN movies m ON st.movie_id = m.movie_id
                JOIN seats s ON t.seat_id = s.seat_id
                JOIN rooms r ON s.theater_id = r.theater_id
                JOIN cinemas c ON r.cinema_id = c.cinema_id
                WHERE t.ticket_id='$ticket_id'";
        $res = $conn->query($sql);
        return $res && $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    // Lịch sử vé theo user
    public function findByUser($user_id) {
        global $conn;
        $sql = "SELECT t.ticket_id, t.booking_time,
                       t.showtime_id,
                       m.title AS movie_title, m.poster_url,
                       st.show_date, st.start_time, st.price AS showtime_price,
                       t.seat_id, s.seat_number, s.seat_type, s.price AS seat_price,
                       r.theater_name, r.type AS room_type,
                       c.name AS cinema_name, c.location AS cinema_location
                FROM tickets t
                JOIN showtimes st ON t.showtime_id = st.showtime_id
                JOIN movies m ON st.movie_id = m.movie_id
                JOIN seats s ON t.seat_id = s.seat_id
                JOIN rooms r ON s.theater_id = r.theater_id
                JOIN cinemas c ON r.cinema_id = c.cinema_id
                WHERE t.user_id='$user_id'
                ORDER BY t.booking_time DESC";
        return $conn->query($sql);
    }

    // Kiểm tra ghế đã đặt chưa trong suất chiếu
    public function checkSeatBooked($showtime_id, $seat_id) {
        global $conn;
        // Kiểm tra trong seat_status
        $res = $conn->query("SELECT status FROM seat_status WHERE showtime_id='$showtime_id' AND seat_id='$seat_id'");
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            if ($row["status"] === "booked" || $row["status"] === "locked") return true;
        }
        // Kiểm tra trong tickets
        $res2 = $conn->query("SELECT 1 FROM tickets WHERE showtime_id='$showtime_id' AND seat_id='$seat_id'");
        return $res2->num_rows > 0;
    }

    // Lấy trạng thái ghế theo showtime
    public function getSeatStatus($showtime_id) {
        global $conn;
        $st = $conn->query("SELECT theater_id FROM showtimes WHERE showtime_id='$showtime_id'");
        if ($st->num_rows === 0) return null;
        $theater_id = $st->fetch_assoc()["theater_id"];

        $sql = "SELECT s.seat_id, s.seat_number, s.seat_type, s.price,
                       COALESCE(ss.status, 'available') AS status
                FROM seats s
                LEFT JOIN seat_status ss ON ss.seat_id = s.seat_id AND ss.showtime_id='$showtime_id'
                WHERE s.theater_id='$theater_id'
                ORDER BY s.seat_number";
        return $conn->query($sql);
    }

    // Lấy tất cả phim
    public function findAllMovies() {
        global $conn;
        return $conn->query("SELECT movie_id, title, genre, duration, release_date,
                                    director, language, rating, description, poster_url, trailer_url
                             FROM movies ORDER BY release_date DESC");
    }

    // Lấy suất chiếu theo phim và rạp
    public function findShowtimes($movie_id, $cinema_id = null) {
        global $conn;
        $where = "st.movie_id='$movie_id' AND st.show_date >= CURDATE()";
        if ($cinema_id) $where .= " AND c.cinema_id='$cinema_id'";
        $sql = "SELECT st.showtime_id, st.show_date, st.start_time, st.price,
                       r.theater_id, r.theater_name, r.type AS room_type, r.total_seats,
                       c.cinema_id, c.name AS cinema_name, c.location AS cinema_location,
                       m.title AS movie_title, m.duration
                FROM showtimes st
                JOIN rooms r ON st.theater_id = r.theater_id
                JOIN cinemas c ON r.cinema_id = c.cinema_id
                JOIN movies m ON st.movie_id = m.movie_id
                WHERE $where
                ORDER BY st.show_date ASC, st.start_time ASC";
        return $conn->query($sql);
    }

    // Lấy user theo username (dùng sau login)
    public function findUserByUsername($username) {
        global $conn;
        $res = $conn->query("SELECT user_id, username, email, phone, role FROM users WHERE username='$username' LIMIT 1");
        return $res && $res->num_rows > 0 ? $res->fetch_assoc() : null;
    }

    // ── FOOD ──────────────────────────────────────────────────────────────
    public function findAllFood() {
        global $conn;
        return $conn->query("SELECT food_id, name, price, '' AS description, 'combo' AS category FROM fooditems ORDER BY food_id");
    }

    // ── ORDER DETAILS ─────────────────────────────────────────────────────
    // Lưu danh sách đồ ăn đã chọn cho 1 ticket
    public function saveOrderDetails($ticket_id, $items) {
        global $conn;
        // Lấy showtime_id và user_id từ ticket
        $t = $conn->query("SELECT showtime_id, user_id FROM tickets WHERE ticket_id='$ticket_id'")->fetch_assoc();
        $showtime_id = $t['showtime_id'] ?? null;
        $user_id     = $t['user_id']     ?? null;

        // Tính tổng tiền
        $total = 0;
        foreach ($items as $item) {
            $total += intval($item['unit_price']) * intval($item['quantity']);
        }

        // Tạo foodorder
        $time = date("Y-m-d H:i:s");
        $conn->query("INSERT INTO foodorders (user_id, showtime_id, total_price, order_time)
                      VALUES ('$user_id','$showtime_id','$total','$time')");
        $order_id = $conn->insert_id;

        // Thêm chi tiết vào foodorders_details
        foreach ($items as $item) {
            $food_id  = intval($item['food_id']);
            $quantity = intval($item['quantity']);
            $conn->query("INSERT INTO foodorders_details (order_id, food_id, quantity)
                          VALUES ('$order_id','$food_id','$quantity')");
        }
        return $order_id;
    }

    // Lấy order_details theo ticket_id
    public function findOrderDetails($ticket_id) {
        global $conn;
        // Lấy qua foodorders (liên kết qua showtime_id + user_id của ticket)
        $t = $conn->query("SELECT showtime_id, user_id FROM tickets WHERE ticket_id='$ticket_id'")->fetch_assoc();
        if (!$t) return null;
        $showtime_id = $t['showtime_id'];
        $user_id     = $t['user_id'];

        $sql = "SELECT fod.detail_id, fod.order_id, fod.food_id, fod.quantity,
                       fi.name AS food_name, fi.price AS unit_price,
                       (fod.quantity * fi.price) AS subtotal
                FROM foodorders_details fod
                JOIN fooditems fi ON fod.food_id = fi.food_id
                JOIN foodorders fo ON fod.order_id = fo.order_id
                WHERE fo.showtime_id='$showtime_id' AND fo.user_id='$user_id'";
        return $conn->query($sql);
    }

    // Kiểm tra showtime tồn tại
    public function checkShowtime($showtime_id) {
        global $conn;
        $res = $conn->query("SELECT 1 FROM showtimes WHERE showtime_id='$showtime_id'");
        return $res->num_rows > 0;
    }

    // Kiểm tra seat tồn tại
    public function checkSeat($seat_id) {
        global $conn;
        $res = $conn->query("SELECT 1 FROM seats WHERE seat_id='$seat_id'");
        return $res->num_rows > 0;
    }

    // Kiểm tra user tồn tại
    public function checkUser($user_id) {
        global $conn;
        $res = $conn->query("SELECT 1 FROM users WHERE user_id='$user_id'");
        return $res->num_rows > 0;
    }
}
?>
