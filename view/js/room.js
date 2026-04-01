let currentId = null; 

function openDialog() {
    document.getElementById('myDialog').showModal();
    loadCinema();
}

function closeDialog() {
    document.getElementById('myDialog').close();
}

function loadCinema() {
    const select = document.getElementById("select");
    select.innerHTML = ""; 
    fetch("http://qlrcp.test/controllers/cinemaController.php")
        .then(res => res.json())
        .then(data => {
            const list = Array.isArray(data) ? data : (data.data || []);
            list.forEach(item => {
                const option = document.createElement("option");
                option.value = item.cinema_id;
                option.textContent = item.name;
                select.appendChild(option);
            });
        })
        .catch(err => console.log("Lỗi:", err));
}

function submitData() {
    const name = document.getElementById('name').value;
    const total_seat = document.getElementById('total').value;
    const type = document.getElementById('type').value;
    const cinema_id = document.getElementById("select").value;

    let method = "POST";
    let bodyData = {
        theater_name: name,
        total_seats: total_seat,
        cinema_id: cinema_id,
        type: type
    };

    if (currentId !== null) {
        method = "PUT";
        bodyData.theater_id = currentId;
    }

    fetch("http://qlrcp.test/controllers/roomController.php", {
        method: method,
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(bodyData)
    })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            currentId = null;
            closeDialog();
            loadData();
        })
        .catch(err => console.log(err));
}

function deleteRoom(id) {
    if (!confirm("Bạn có chắc muốn xóa không?")) return;

    fetch('http://qlrcp.test/controllers/roomController.php', {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ theater_id: id })
    })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            loadData();
        })
        .catch(err => console.log(err));
}

function openEdit(id, name, total_seat, type) {
    currentId = id;
    document.getElementById("name").value = name;
    document.getElementById("total").value = total_seat;
    document.getElementById("type").value = type;
    document.getElementById("myDialog").showModal();
}

function loadData() {
    const tbody = document.getElementById('tableBody');
    fetch("http://qlrcp.test/controllers/roomController.php")
        .then(res => res.json())
        .then(data => {
            tbody.innerHTML = "";
            const list = Array.isArray(data) ? data : [data];

            list.forEach(item => {
                // escape dấu nháy trong tên phòng để không phá template literal
                const safeName = item.theater_name.replace(/'/g, "\\'");
                const safeType = item.type.replace(/'/g, "\\'");

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.theater_id}</td>
                    <td>${safeName}</td>
                    <td>${item.total_seats}</td>
                    <td>${safeType}</td>
                    <td>
                        <button onclick="openEdit(${item.theater_id}, '${safeName}', '${item.total_seats}', '${safeType}')">Sửa</button>
                        <button onclick="deleteRoom(${item.theater_id})">Xóa</button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(err => console.error(err));
}

window.onload = function () {
    loadData();
};