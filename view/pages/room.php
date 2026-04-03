<!DOCTYPE html>
<html>
    <head>
        <title>Quản lý phòng</title>
        <meta charset="UTF-8"> 
        <link rel="stylesheet" href="../css/room.css">
        <link rel="stylesheet" href="../css/menu.css"/>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">


    </head>
    <body >
         <?php include "../component/header.php";?>
        <div>
        <div  class="container">
            <h1 >Quản Lý Phòng Chiếu Phim</h1>
            <button class="add" onclick="openDialog()">Thêm</button>
            <dialog id="myDialog" ">
                <div class="content">
                    
                 <select  name="cinema_id" id="select">
                 </select>
                <input type="text" placeholder="Tên phòng" id="name" class="">
                <input type="text" placeholder="Tổng số ghế" id="total">
                <input type="text" placeholder="Loại Phòng" id="type">
                <button class="bg-blue-500" onclick="submitData()">Lưu</button>
                <button  class ="bg-gray-500" onclick="closeDialog()">Đóng</button>
                </div>
               
            </dialog>
            
            <div  class="filler">
                <div >
                <label for="branch">Chi nhánh:</label>
                <select name="cinema_id" id="branch"></select>
                </div>
                <table >
                    <thead > 
                        <tr>
                        <th >ID</th>
                        <th  >Tên Phòng</th>
                        <th>Số ghế</th>
                        <th >Loại Phòng</th>
                        <th >Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">

                    </tbody>
                </table>
            </div>
        </div>
        </div>
        <script src="../js/room.js"></script>
        
    </body>
</html>