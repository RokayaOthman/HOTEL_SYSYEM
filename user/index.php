
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

</head>

 <?php
 #connecting to the server
 $hostname = 'localhost';
 $username = 'root';
 $pass = '';
 $db = "hotelsystem";

 $conn = mysqli_connect($hostname, $username, $pass, $db);

 
 ##
 $guest_id = 1;
 $guest_name = '';
 $guest_phone = '';
 $guest_room_type = '';
 $checkin = '';
 $checkout = '';

    if (isset($_POST['name'])) {
        $guest_name = $_POST['name'];
    }

    if (isset($_POST['number']))
    {
        $guest_phone = $_POST['number'];
    }

    if (isset($_POST['room']))
    {
        $guest_room_type = $_POST['room'];
    }

    if (isset($_POST['checkin']))
    {
        $checkin = $_POST['checkin'];
    }

    if (isset($_POST['checkout']))
    {
        $checkout = $_POST['checkout'];
    }

    $checkin_date = strtotime($checkin);
    $checkout_date = strtotime($checkout);
    $days = ($checkout_date - $checkin_date) / (60 * 60 * 24);
    
    $single_room_price = 50;
    $double_room_price = 100;


    if ($guest_room_type == 'Single') {
        $total_price = $days * $single_room_price;

    } elseif ($guest_room_type == 'Double') {
        $total_price = $days * $double_room_price;
    }

$sqls = '';
if(isset($_POST['addguest']))
{
    $sqlguest = "INSERT INTO guests (guest_name, guest_phone, guest_room_type, checkin, checkout, total_price) 
                 VALUES ('$guest_name', '$guest_phone', '$guest_room_type', '$checkin', '$checkout', '$total_price')";
    $sqlbooking = "INSERT INTO booking ( check_in,check_out) VALUES ( '$checkin', '$checkout')";	
    $sqlpayment = "INSERT INTO payment (total_amount) VALUES ('$total_price')";
    $_booked = "booked";
    $sqlroom = "INSERT INTO rooms (room_availibility, room_type, room_price)
     VALUES ('$_booked', '$guest_room_type', '$total_price' )";
    mysqli_query($conn, $sqlguest);
    mysqli_query($conn, $sqlbooking);
    mysqli_query($conn, $sqlpayment);
    mysqli_query($conn,$sqlroom);
    header("location : main_page.php");
}
if (isset($_POST['deleteguest']))
{
    $sqls = "delete from guests where guest_name = '$guest_name' and
    guest_phone = '$guest_phone'";
   
    mysqli_query($conn,$sqls);
    
}
 ?>
<body>
<aside> 
    <div id="mother">
        <img src="https://cdn-icons-png.flaticon.com/512/235/235889.png" alt="logo"
         width="150px">
        <form method="POST">
                <div id="div">
                    
                    <label>Name</label><br>
                    <input type="text" name="name" id="name"><br>

                    <label>Phone</label><br>
                    <input type="text" name="number" id='number'><br><br>


                    <label>Room</label>
                    <select id="room" name="room">
                        <option value="Single">Single</option>
                        <option value="Double">Double<option>
                    </select><br><br>

                    <label>Check-in</label><br>
                    <input type="date" name="checkin" id="checkin"><br>


                    <label>Check-out</label><br>
                    <input type="date" name="checkout" id="checkout">
                    <br><br>

                    <button name="addguest" id="btn">Register</button>
                    <button name="deleteguest" id="btn">Delete</button><br><br>
                </div>
    
        </form>
    </div>

</aside>
 
<main>
<table id="tbl">
        <thead>
        <tr>           
                <th>Guest name</th>
                <th>Guest phone</th>
                <th>Room Type</th> 
                <th>Check-in</th>
                <th>Check-out</th>  
                <th>Total Price</th>      
        </tr>     
        </thead>
        <tbody></tbody>
<?php
$res = mysqli_query($conn, "SELECT * FROM guests");
while($row = mysqli_fetch_array($res))
    {
        echo "<tr>
    <td>" . $row["guest_name"] . "</td>
    <td>" . $row["guest_phone"] . "</td>
    <td>" . $row["guest_room_type"] . "</td>
    <td>" . $row["checkin"] . "</td>
    <td>" . $row["checkout"] . "</td>
    <td>$" . $row["total_price"] . "</td>
            </tr>";
            
    
    }
?>
 </table>
 </main 
</body>
</html>