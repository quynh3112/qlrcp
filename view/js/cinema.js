let currentId = null;
function submitData() {
    const nameinput = document.getElementById('name').value;
    const location = document.getElementById('location').value;

    let method = "POST";
    let bodyData = {
        name: nameinput,
        location: location
    };

    if (currentId !== null) {
        method = "PUT";
        bodyData.id = currentId;
    }

    fetch("http://qlrcp.test/controllers/cinemaController.php", {
        method: method,
        headers: {
            "Content-Type": "application/json"
        },
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
function openDialog() {
    document.getElementById('myDialog').showModal();
}

function closeDialog() {
    document.getElementById("myDialog").close();
}
function loadData(){
    const table = document.getElementById('cinemaTable');

    fetch("http://qlrcp.test/controllers/cinemaController.php")
    .then(res => res.json())
    .then(data => {
        console.log(data); // debug

        table.innerHTML = "";

        const list = Array.isArray(data) ? data : (data.data || []);

        list.forEach(item => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${item.cinema_id}</td>
                <td>${item.name}</td>
                <td>${item.location}</td>
                <td>
                <button onclick="deleteCinema(${item.cinema_id})">Xóa</button>
                <button onclick="openEdit(${item.cinema_id},'${item.name}', '${item.location}')">Sửa</button>
                </td>


                
            `;
            table.appendChild(row);
        });
    })
    .catch(err => console.log("Lỗi:", err));
}
window.onload = function() {
    loadData();
}
function deleteCinema(id){
    if(!confirm("Bạn có chắc muốn xóa không?")) return;

    fetch("http://qlrcp.test/controllers/cinemaController.php", {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
           id: id
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        loadData();
    })
    .catch(err => console.log(err));
}
function openEdit(id,name,location){
    currentId=id;
    document.getElementById("name").value=name;
    document.getElementById("location").value=location;
    document.getElementById("myDialog").showModal();


}




