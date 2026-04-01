let selectedSeats = [];
let total = 0;

const theater_id = 6; 


function loadSeats(){
    fetch(`http://qlrcp.test/controllers/seatController.php?theater_id=${theater_id}`)
    .then(res => res.json())
    .then(data => renderSeats(data));
}

function renderSeats(data){

    const container = document.getElementById("seats");
    container.innerHTML = "";

    const list = Array.isArray(data) ? data : (data.data || []);

    let rows = {};

   
    list.forEach(item => {
        const row = item.seat_number.charAt(0);

        if(!rows[row]) rows[row] = [];
        rows[row].push(item);
    });

    
    Object.keys(rows).sort().forEach(row => {

        const rowDiv = document.createElement("div");
        rowDiv.classList.add("row");

        rows[row].forEach(item => {

            const seat = document.createElement("button");
            seat.classList.add("seat");
            seat.innerText = item.seat_number;

            
            if(item.status === "occupied"){
                seat.classList.add("occupied");
            } 
            else {
                if(item.seat_type === "couple"){
                 seat.classList.add("couple");
                } else

                
                if(item.seat_type === "VIP"){
                    seat.classList.add("vip");
                }

                seat.onclick = () => toggleSeat(item, seat);
            }

            rowDiv.appendChild(seat);
        });

        container.appendChild(rowDiv);
    });
}

function toggleSeat(item, btn){

    if(selectedSeats.includes(item.seat_number)){
        selectedSeats = selectedSeats.filter(s => s !== item.seat_number);
        btn.classList.remove("selected");
        total -= item.price;
    } else {
        selectedSeats.push(item.seat_number);
        btn.classList.add("selected");
        total += parseInt(item.price);
    }

    document.getElementById("selected").innerText = selectedSeats.join(", ");
    document.getElementById("total").innerText = total;
}

function book(){
    alert("Ghế: " + selectedSeats.join(", "));
}

// chạy
loadSeats();