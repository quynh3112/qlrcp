// Biến mảng để lưu các món khách chọn tạm thời
let mangGioHang = [];

// 1. Khi vừa mở trang, tự động lấy danh sách món từ database
fetch('../../controllers/foodController.php')
    .then(res => res.json())
    .then(result => {
        let listHtml = '';
        result.data.forEach(item => {
            listHtml += `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.price.toLocaleString()}đ</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <button onclick="botSoLuong(${item.food_id})" class="btn btn-sm btn-outline-danger px-2">-</button>
                            
                            <span id="qty-${item.food_id}" class="mx-3 fw-bold">0</span>
                            
                            <button onclick="themVaoDanhSach(${item.food_id}, '${item.name}', ${item.price})" class="btn btn-sm btn-outline-primary px-2">+</button>
                        </div>
                    </td>
                </tr>`;
        });
        document.getElementById('list-do-an').innerHTML = listHtml;
    });

// 2. Hàm khi khách bấm nút "+ Thêm"
function themVaoDanhSach(id, name, price) {
    let index = mangGioHang.findIndex(item => item.food_id === id);
    if (index !== -1) {
        mangGioHang[index].quantity++;
    } else {
        mangGioHang.push({ food_id: id, name: name, price: price, quantity: 1 });
    }
    capNhatGiaoDienGioHang();
    capNhatConSoBangTrai(id); // Hiện số lượng mới lên bảng trái
}
// Hàm bớt số lượng khi bấm nút "-"
function botSoLuong(id) {
    let index = mangGioHang.findIndex(item => item.food_id === id);
    
    if (index !== -1) {
        if (mangGioHang[index].quantity > 1) {
            mangGioHang[index].quantity--;
        } else {
            // Nếu về 1 rồi mà trừ tiếp thì xóa khỏi giỏ
            mangGioHang.splice(index, 1);
        }
    }
    
    capNhatGiaoDienGioHang(); // Vẽ lại giỏ bên phải
    capNhatConSoBangTrai(id); // Vẽ lại con số ở bảng trái
}

// Hàm này để đi tìm cái <span> và thay con số 0 thành số lượng thật
function capNhatConSoBangTrai(id) {
    let mon = mangGioHang.find(item => item.food_id === id);
    let soLuong = mon ? mon.quantity : 0;
    
    let spanQty = document.getElementById(`qty-${id}`);
    if (spanQty) {
        spanQty.innerText = soLuong;
    }
}

// Sửa lại hàm xóa này để nó reset con số ở bảng trái về 0 luôn
function xoaMon(index) {
    let idBiXoa = mangGioHang[index].food_id; // Lấy ID trước khi xóa khỏi mảng
    mangGioHang.splice(index, 1);
    
    capNhatGiaoDienGioHang();
    capNhatConSoBangTrai(idBiXoa); // Reset số lượng món này ở bảng trái về 0
}
// 3. Hàm vẽ lại cái giỏ hàng bên phải cho khách xem
function capNhatGiaoDienGioHang() {
    let html = '';
    let tong = 0;
    
    if(mangGioHang.length === 0) {
        html = '<p class="text-muted small">Chưa chọn món nào...</p>';
    } else {
        mangGioHang.forEach((item, index) => {
            // Tính tiền từng món: giá * số lượng
            let thanhTien = item.price * item.quantity;
            
            html += `<div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-1">
                        <div>
                            <span class="fw-bold">${item.name}</span> <small>x${item.quantity}</small>
                        </div>
                        <div>
                            <span class="me-2">${thanhTien.toLocaleString()}đ</span>
                            <button onclick="xoaMon(${index})" class="btn btn-sm text-danger p-0"><b>&times;</b></button>
                        </div>
                     </div>`;
            tong += thanhTien;
        });
        
        // Thêm một nút Hủy toàn bộ giỏ hàng cho máu
        html += `<button onclick="mangGioHang=[]; capNhatGiaoDienGioHang();" class="btn btn-sm btn-link text-secondary w-100 mt-2">Hủy tất cả</button>`;
    }
    
    document.getElementById('gio-hang-tam').innerHTML = html;
    document.getElementById('tong-tien').innerText = tong.toLocaleString();
}
// 4. Hàm khi bấm nút "XÁC NHẬN ĐẶT HÀNG"
function nutBamDatHang() {
    let uId = document.getElementById('id_nguoi_dung').value;
    
    if(!uId) return alert("Vui lòng nhập User ID!");
    if(mangGioHang.length === 0) return alert("Bạn chưa chọn món nào!");

    // Đóng gói dữ liệu gửi đi (Đúng cấu trúc OrderModel cần)
    let dataGuiDi = {
        user_id: uId,
        items: mangGioHang
    };

    fetch('../../controllers/orderController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dataGuiDi)
    })
    .then(res => res.json())
    .then(res => {
        if(res.success) {
            document.getElementById('thong-bao').innerHTML = `<span class="text-success fw-bold">Đặt thành công! Mã đơn: ${res.order_id}</span>`;
            // Sau 2 giây chuyển sang trang thanh toán
            setTimeout(() => {
                window.location.href = "payment.php?order_id=" + res.order_id;
            }, 2000);
        } else {
            alert("Lỗi: " + res.message);
        }
    });
}