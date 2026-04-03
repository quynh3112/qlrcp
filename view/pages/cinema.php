<!DOCTYPE html>
<html>
    <head>
        <title>Quản lý phòng </title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" href="../css/cinema.css"/>
        <link rel="stylesheet" href="../css/menu.css"/>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
        
    </head>
    <body>
       <?php
       include "../component/header.php";?>
      
        

            
       
        <div>
            <h1>Quản lý chi nhánh</h1>
            <button class="add" onclick="openDialog()">Thêm</button>
            <dialog id="myDialog">
                <div class ="content">
                <h3>Thêm Chi Nhánh</h3>
                <input type="text" placeholder="Tên..." id="name">
                <input type="text" placeholder="Địa chỉ" id="location"/>
                <br>
                <button onclick="submitData()">Thêm</button>
                <button onclick="closeDialog()">Đóng</button>
                </div>
            </dialog>

            <table>
                <thead>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Địa Chỉ</th>
                    <th>Thao Tác</th>
                    
                </thead>
                <tbody id="cinemaTable">

                </tbody>
            </table>
        </div>
       
        <script src="../js/cinema.js">
          
        </script>
        
    </body>
</html>