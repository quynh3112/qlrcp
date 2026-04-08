<?php include '../component/header.php'; ?>
<!-- Nhớ đường dẫn file CSS  -->
<link rel="stylesheet" href="../css/food.css">

<div class="container mt-4">
    <h3 class="tieude-food">DANH SÁCH BẮP NƯỚC</h3>
    
    <div class="row">
        <!-- CỘT TRÁI: HIỆN MÓN ĂN -->
        <div class="col-md-7">
            <table class="table table-bordered shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th>Tên món</th>
                        <th>Giá tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="list-do-an">
                    <!-- Dữ liệu từ JS sẽ đổ vào đây -->
                </tbody>
            </table>
        </div>

        <!-- CỘT PHẢI: GIỎ HÀNG & ĐẶT HÀNG -->
        <div class="col-md-5">
            <div class="khung-don-hang p-3 border shadow-sm bg-white">
                <h5 class="text-primary">Đơn hàng của bạn</h5>
                <hr>
                <div id="gio-hang-tam">
                    <p class="text-muted small">Chưa chọn món nào...</p>
                </div>
                <hr>
                <p><b>Tổng tiền: <span id="tong-tien" class="text-danger">0</span> VNĐ</b></p>
                
                <div class="form-group mb-3">
                    <label class="small">Nhập ID người dùng (User ID):</label>
                    <input type="number" id="id_nguoi_dung" class="form-control" placeholder="Ví dụ: 1">
                </div>
                
                <button onclick="nutBamDatHang()" class="btn btn-primary w-100 fw-bold">XÁC NHẬN ĐẶT HÀNG</button>
                <div id="thong-bao" class="mt-2 text-center small"></div>
            </div>
        </div>
    </div>
</div>

<!-- Nhớ đường dẫn file JS  -->
<script src="../js/food.js"></script>