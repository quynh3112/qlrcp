<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

include_once "../models/Booking.php";

$booking = new Booking();
$method  = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // ─── POST: Tạo booking mới (có thể kèm order_details đồ ăn) ──────────
    case "POST":
        $data        = json_decode(file_get_contents("php://input"), true);
        $showtime_id = $data["showtime_id"] ?? null;
        $seat_id     = $data["seat_id"]     ?? null;
        $user_id     = $data["user_id"]     ?? null;
        $food_items  = $data["food_items"]  ?? []; // [{food_id, quantity, unit_price}]

        if (!$showtime_id || !$seat_id || !$user_id) {
            echo json_encode(["status" => false, "message" => "Thiếu thông tin: showtime_id, seat_id, user_id là bắt buộc!"]);
            exit;
        }
        if (!$booking->checkShowtime($showtime_id)) {
            echo json_encode(["status" => false, "message" => "Suất chiếu không tồn tại!"]);
            exit;
        }
        if (!$booking->checkSeat($seat_id)) {
            echo json_encode(["status" => false, "message" => "Ghế không tồn tại!"]);
            exit;
        }
        if (!$booking->checkUser($user_id)) {
            echo json_encode(["status" => false, "message" => "Người dùng không tồn tại!"]);
            exit;
        }
        if ($booking->checkSeatBooked($showtime_id, $seat_id)) {
            echo json_encode(["status" => false, "message" => "Ghế này đã được đặt hoặc đang bị khóa!"]);
            exit;
        }

        $result = $booking->create($showtime_id, $seat_id, $user_id);

        if ($result["status"]) {
            $ticket_id = $result["ticket_id"];
            // Lưu order_details nếu có chọn đồ ăn
            if (!empty($food_items)) {
                $booking->saveOrderDetails($ticket_id, $food_items);
            }
            echo json_encode([
                "status"  => true,
                "message" => $result["message"],
                "ticket"  => [
                    "ticket_id"    => $ticket_id,
                    "showtime_id"  => $showtime_id,
                    "seat_id"      => $seat_id,
                    "user_id"      => $user_id,
                    "booking_time" => $result["booking_time"]
                ]
            ]);
        } else {
            echo json_encode(["status" => false, "message" => $result["message"]]);
        }
        break;

    // ─── DELETE: Hủy vé ───────────────────────────────────────────────────
    case "DELETE":
        $data      = json_decode(file_get_contents("php://input"), true);
        $ticket_id = $data["ticket_id"] ?? null;

        if (!$ticket_id) {
            echo json_encode(["status" => false, "message" => "Thiếu ticket_id!"]);
            exit;
        }

        $result = $booking->delete($ticket_id);
        echo json_encode($result);
        break;

    // ─── GET: Lấy danh sách / chi tiết / theo user / seat_status / movies / showtimes ──
    case "GET":
        $action      = $_GET["action"]      ?? null;
        $ticket_id   = $_GET["ticket_id"]   ?? null;
        $user_id     = $_GET["user_id"]     ?? null;
        $showtime_id = $_GET["showtime_id"] ?? null;

        // GET ?action=food → danh sách đồ ăn
        if ($action === "food") {
            $result = $booking->findAllFood();
            $list   = [];
            while ($row = $result->fetch_assoc()) $list[] = $row;
            echo json_encode(["status" => true, "food" => $list]);
            break;
        }

        // GET ?action=orderdetails&ticket_id=X → đồ ăn của 1 vé
        if ($action === "orderdetails") {
            $tid = $_GET["ticket_id"] ?? null;
            if (!$tid) { echo json_encode(["status" => false, "message" => "Thiếu ticket_id!"]); exit; }
            $result = $booking->findOrderDetails($tid);
            $list   = [];
            while ($row = $result->fetch_assoc()) $list[] = $row;
            echo json_encode(["status" => true, "ticket_id" => $tid, "items" => $list]);
            break;
        }

        // GET ?action=movies → danh sách phim
        if ($action === "movies") {
            $result = $booking->findAllMovies();
            $movies = [];
            while ($row = $result->fetch_assoc()) $movies[] = $row;
            echo json_encode(["status" => true, "count" => count($movies), "movies" => $movies]);
            break;
        }

        // GET ?action=showtimes&movie_id=X&cinema_id=Y → suất chiếu
        if ($action === "showtimes") {
            $movie_id  = $_GET["movie_id"]  ?? null;
            $cinema_id = $_GET["cinema_id"] ?? null;
            if (!$movie_id) { echo json_encode(["status" => false, "message" => "Thiếu movie_id!"]); exit; }
            $result = $booking->findShowtimes($movie_id, $cinema_id);
            $list   = [];
            while ($row = $result->fetch_assoc()) $list[] = $row;
            echo json_encode(["status" => true, "count" => count($list), "showtimes" => $list]);
            break;
        }

        // GET ?action=login&username=X → lấy user_id sau đăng nhập
        if ($action === "login") {
            $username = $_GET["username"] ?? null;
            if (!$username) { echo json_encode(["status" => false, "message" => "Thiếu username!"]); exit; }
            $user = $booking->findUserByUsername($username);
            if (!$user) { echo json_encode(["status" => false, "message" => "Không tìm thấy user!"]); exit; }
            echo json_encode(["status" => true, "user_id" => $user["user_id"],
                "username" => $user["username"], "email" => $user["email"], "phone" => $user["phone"]]);
            break;
        }

        // GET ?ticket_id=X → chi tiết 1 vé
        if ($ticket_id) {
            $ticket = $booking->findById($ticket_id);
            if (!$ticket) {
                echo json_encode(["status" => false, "message" => "Không tìm thấy vé!"]);
            } else {
                echo json_encode(["status" => true, "ticket" => $ticket]);
            }
            break;
        }

        // GET ?user_id=X → lịch sử theo user
        if ($user_id) {
            if (!$booking->checkUser($user_id)) {
                echo json_encode(["status" => false, "message" => "Người dùng không tồn tại!"]);
                exit;
            }
            $result  = $booking->findByUser($user_id);
            $tickets = [];
            while ($row = $result->fetch_assoc()) $tickets[] = $row;
            echo json_encode(["status" => true, "count" => count($tickets), "tickets" => $tickets]);
            break;
        }

        // GET ?showtime_id=X → trạng thái ghế
        if ($showtime_id) {
            if (!$booking->checkShowtime($showtime_id)) {
                echo json_encode(["status" => false, "message" => "Suất chiếu không tồn tại!"]);
                exit;
            }
            $result = $booking->getSeatStatus($showtime_id);
            $seats  = [];
            while ($row = $result->fetch_assoc()) $seats[] = $row;
            echo json_encode(["status" => true, "showtime_id" => $showtime_id, "count" => count($seats), "seats" => $seats]);
            break;
        }

        // GET (không có param) → tất cả vé
        $result  = $booking->findAll();
        $tickets = [];
        while ($row = $result->fetch_assoc()) $tickets[] = $row;
        echo json_encode(["status" => true, "count" => count($tickets), "tickets" => $tickets]);
        break;

    default:
        echo json_encode(["status" => false, "message" => "Method không hợp lệ!"]);
}
?>
