# CinemaX — Hệ thống quản lý rạp phim

Dự án môn **Kiến trúc & Thiết kế Phần mềm** — Đại học Công nghệ Giao thông Vận tải

---

## Cấu trúc dự án

```
qlrcp/
├── config/
│   └── db.php                    # Kết nối database
├── models/
│   ├── Cinema.php                # Model chi nhánh
│   ├── Room.php                  # Model phòng chiếu
│   ├── Seats.php                 # Model ghế ngồi
│   ├── Ticket.php                # Model vé
│   ├── User.php                  # Model người dùng
│   ├── WorkSchedule.php          # Model lịch làm việc
│   └── Booking.php               # Model đặt vé (tickets + seat_status)
├── controllers/
│   ├── cinemaController.php      # API chi nhánh
│   ├── roomController.php        # API phòng chiếu
│   ├── seatController.php        # API ghế ngồi
│   ├── ticketController.php      # API vé
│   ├── userController.php        # API người dùng
│   ├── workScheduleController.php# API lịch làm việc
│   └── bookingController.php     # API đặt vé (booking module)
├── views/
│   ├── pages/
│   │   ├── user.html             # Giao diện user: đặt vé từng bước
│   │   ├── booking.html          # Giao diện admin: quản lý booking
│   │   ├── cinema.html           # Quản lý chi nhánh
│   │   ├── room.html             # Quản lý phòng chiếu
│   │   ├── seat.html             # Sơ đồ ghế ngồi
│   │   └── workSchedule.html     # Lịch làm việc
│   ├── js/
│   │   ├── cinema.js
│   │   ├── room.js
│   │   ├── seat.js
│   │   └── workSchedule.js
│   └── css/
│       └── seat.css
└── index.html                    # Trang chủ điều hướng
```

---

## Cài đặt

1. Copy thư mục `qlrcp` vào `C:\xampp\htdocs\`
2. Import file SQL vào MySQL (database: `mntheatre`)
3. Mở trình duyệt: `http://localhost/qlrcp/`

---

## Phân chia module

| Người | Module |
|-------|--------|
| 1 | User + Ticket History |
| 2 | Movie + Showtime |
| 3 | Cinema + Room + Seat |
| **4** | **Booking (tickets + seat_status)** |
| 5 | WorkSchedule |

---

## API Endpoints

| Controller | Method | Params | Chức năng |
|------------|--------|--------|-----------|
| `bookingController.php` | GET | — | Lấy tất cả vé |
| `bookingController.php` | GET | `?ticket_id=X` | Chi tiết 1 vé |
| `bookingController.php` | GET | `?user_id=X` | Lịch sử theo user |
| `bookingController.php` | GET | `?showtime_id=X` | Trạng thái ghế |
| `bookingController.php` | GET | `?action=movies` | Danh sách phim |
| `bookingController.php` | GET | `?action=showtimes&movie_id=X&cinema_id=Y` | Suất chiếu |
| `bookingController.php` | GET | `?action=login&username=X` | Lấy user info |
| `bookingController.php` | POST | `{showtime_id, seat_id, user_id}` | Tạo booking |
| `bookingController.php` | DELETE | `{ticket_id}` | Hủy vé |
| `cinemaController.php` | GET/POST/PUT/DELETE | — | CRUD chi nhánh |
| `roomController.php` | GET/POST/PUT/DELETE | — | CRUD phòng chiếu |
| `seatController.php` | GET | `?theater_id=X` | Lấy ghế theo phòng |
| `userController.php` | POST/DELETE | — | Tạo/xóa user |
| `workScheduleController.php` | GET/POST | `?user_id=X` | Lịch làm việc |
