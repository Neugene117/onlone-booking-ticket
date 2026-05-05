<?php
session_start();
require 'connection.php';
use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\Exception;
if (!isset($_SESSION['a49r-aN3c03639dr92Cb1cK6cb^6bf494035c05a%4eC1ddQa61c9d552*Pdu34d1e4e85992ba+bR3Pe5f6g8d0664/055758e06707127h8ij0klrLb9db021bTQ0bf0a6H'])) {
    echo '<script>location.href="index"</script>';
    exit;
}
$user_id = $_SESSION['a49r-aN3c03639dr92Cb1cK6cb^6bf494035c05a%4eC1ddQa61c9d552*Pdu34d1e4e85992ba+bR3Pe5f6g8d0664/055758e06707127h8ij0klrLb9db021bTQ0bf0a6H'];
$get_user_id = mysqli_query($con, "SELECT * FROM company WHERE C_ID = $user_id");
if ($get_user_id === false) {
    echo "<b>Error:</b> " . mysqli_error($con);
    exit;
}
if (mysqli_num_rows($get_user_id) > 0) {
    $user_info = mysqli_fetch_assoc($get_user_id);
} else {
    echo '<script>location.href="signout"</script>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Rwanda-Bus || Agency Dashboard</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="./css/admin_panel.css" />
    <link rel="stylesheet" href="./css/agency_panel.css" />
  </head>
  <body>
    <button class="humburger">&#9776;</button>
    <div class="responsive_nav">
      <h1>AGENCY PANEL</h1>
    </div>
    <div class="agency_admin_body">
      <aside class="agency_admin_aside">
        <h1>Agency</h1>
        
<div class="agency_admin_links">
  <a href="agency_panel?dashboard"><i class='bx bxs-dashboard'></i> Dashboard</a>
    <div class="dropdown">
        <div class="dropbtn"><i class='bx bx-bar-chart-alt-2'></i> Reports  &#9662;</div>
        <div class="dropdown-content">
            <a href="agency_panel?drivers_report">Drivers Report</a>
            <a href="agency_panel?cars_report">Cars Report</a>
            <a href="agency_panel?balance">Balance Report</a>
            <a href="agency_panel?destinations_report">Destinations Report</a>
        </div>
    </div>

    <div class="dropdown">
        <div class="dropbtn"><i class='bx bx-id-card'></i> Drivers  &#9662;</div>
        <div class="dropdown-content">
            <a href="agency_panel?drivers">Show Drivers</a>
            <a href="agency_panel?add_drivers">Add New Driver</a>
        </div>
    </div>

    <div class="dropdown">
        <div class="dropbtn"><i class='bx bxs-bus'></i> Cars  &#9662;</div>
        <div class="dropdown-content">
            <a href="agency_panel?cars">Show Cars</a>
            <a href="agency_panel?add_cars">Add New Car</a>
            <a href="agency_panel?show_car_to_leave">Show Car to Leave</a>
            <a href="agency_panel?add_car_to_leave">Add Car to Leave</a>
        </div>
    </div>

    <div class="dropdown">
        <div class="dropbtn"><i class='bx bx-map'></i> Destinations  &#9662;</div>
        <div class="dropdown-content">
            <a href="agency_panel?destinations">Show Destinations</a>
            <a href="agency_panel?add_destinations">Add New Destination</a>
        </div>
    </div>

    <div class="dropdown">
        <div class="dropbtn"><i class='bx bxs-user-detail'></i> Clients  &#9662;</div>
        <div class="dropdown-content">
            <a href="agency_panel?clients">Clients Pending</a>
            <a href="agency_panel?clients_paid">Clients Paid</a>
        </div>
    </div>

    <a href="agency_panel?change_password"><i class='bx bx-lock'></i> Change Password</a>
    <a href="signout"><i class='bx bx-log-out'></i> Sign Out</a>
</div>
      </aside>
      
      <div class="agency_admin_container">
        <header class="panel-topbar">
          <div class="panel-topbar-left">
            <i class='bx bx-menu-alt-left'></i>
            <strong>NUWO NI UWACU HUB</strong>
          </div>
          <div class="panel-topbar-right">
            <i class='bx bx-user-circle'></i>
            <span><?php echo htmlspecialchars($user_info["C_Name"]); ?></span>
          </div>
        </header>
        <section class="panel-overview">
          <h2>Dashboard Overview</h2>
          <p>Welcome back, <?php echo htmlspecialchars($user_info["C_Name"]); ?>. Here is what is happening today.</p>
        </section>
      <!-- START DASHBOARD -->
      <?php
      if(isset($_GET["dashboard"])) {
      ?>
      <title>Rwanda-Bus || Dashboard</title>
        <?php
          $carsTotal = 0;
          $driversTotal = 0;
          $destinationsTotal = 0;
          $pendingClients = 0;
          $currentBalance = 0;

          $carsQ = mysqli_query($con, "SELECT COUNT(Car_Id) AS total FROM cars WHERE C_Id='$user_id'") or die(mysqli_error($con));
          if ($carsQ && mysqli_num_rows($carsQ) > 0) { $carsTotal = (int)mysqli_fetch_assoc($carsQ)['total']; }

          $driversQ = mysqli_query($con, "SELECT COUNT(Emp_Id) AS total FROM employeers WHERE C_Id='$user_id'") or die(mysqli_error($con));
          if ($driversQ && mysqli_num_rows($driversQ) > 0) { $driversTotal = (int)mysqli_fetch_assoc($driversQ)['total']; }

          $destinationQ = mysqli_query($con, "SELECT COUNT(D_Id) AS total FROM destination WHERE C_Id='$user_id'") or die(mysqli_error($con));
          if ($destinationQ && mysqli_num_rows($destinationQ) > 0) { $destinationsTotal = (int)mysqli_fetch_assoc($destinationQ)['total']; }

          $pendingQ = mysqli_query($con, "SELECT COUNT(B_Id) AS total FROM booking b INNER JOIN cars_to_leave ct ON ct.id=b.Id INNER JOIN cars c ON c.Car_Id=ct.Car_Id WHERE c.C_Id='$user_id' AND b.activityi='wait...'");
          if ($pendingQ && mysqli_num_rows($pendingQ) > 0) { $pendingClients = (int)mysqli_fetch_assoc($pendingQ)['total']; }

          $balanceQ = mysqli_query($con, "SELECT COALESCE(SUM(locations.price * booking.Seat_Count),0) as totalamount FROM cars_to_leave INNER JOIN booking ON cars_to_leave.id=booking.Id INNER JOIN cars ON cars.Car_Id=cars_to_leave.Car_Id INNER JOIN destination ON destination.D_Id=cars_to_leave.D_Id INNER JOIN locations ON locations.L_id=destination.L_id WHERE cars.C_Id='$user_id' AND booking.activityi='activated'");
          if ($balanceQ && mysqli_num_rows($balanceQ) > 0) { $currentBalance = (int)mysqli_fetch_assoc($balanceQ)['totalamount']; }
        ?>
        <div class="stats-grid">
          <div class="stat-card"><div class="stat-icon"><i class='bx bxs-bus'></i></div><div><h3><?php echo $carsTotal; ?></h3><p>Total Cars</p></div></div>
          <div class="stat-card"><div class="stat-icon"><i class='bx bx-id-card'></i></div><div><h3><?php echo $driversTotal; ?></h3><p>Total Drivers</p></div></div>
          <div class="stat-card"><div class="stat-icon"><i class='bx bx-map'></i></div><div><h3><?php echo $destinationsTotal; ?></h3><p>Destinations</p></div></div>
          <div class="stat-card"><div class="stat-icon"><i class='bx bxs-user-detail'></i></div><div><h3><?php echo $pendingClients; ?></h3><p>Pending Clients</p></div></div>
          <div class="stat-card stat-card-wide"><div class="stat-icon"><i class='bx bx-wallet'></i></div><div><h3><?php echo number_format($currentBalance); ?> RWF</h3><p>Current Balance</p></div></div>
        </div>
      <?php
      } 
      
      else if (isset($_GET["change_password"])) {
?>
<title>Rwanda-Bus || Change Password</title>
<div class="agency_cars_creation_form">
    <form action="brain2" method="post" onsubmit="return validatePassword()">
        <h1><u>Change Password</u></h1>
        <input type="password" id="ibanga1" name="ibanga1" placeholder="Current password" required/>
        <input type="password" id="ibanga2" placeholder="New password" required/>
        <input type="password" id="ibanga3" name="ibanga3" placeholder="Confirm new password" required/>
        <input type="checkbox" id="showPasswords" onclick="togglePasswordVisibility()"> Show Passwords
        <br>
        <input type="submit" name="hinduraIbanga" class="agency_send_button" value="Change"/>
    </form>
</div>
<?php
      }

      else if(isset($_GET["cars"])) {
      ?>


      <!-- START CARS -->
      <title>Rwanda-Bus || Cars</title>
<?php
$showCars=mysqli_query($con,"SELECT C.*,E.* FROM cars C, employeers E WHERE E.Emp_Id=C.Emp_Id AND E.C_Id='$user_id' AND C.C_Id='$user_id' ORDER BY Car_Plaque ASC") or die(mysqli_error($con));
if (mysqli_num_rows($showCars)>0){
?>
<form method="post">
        <div class="agency_car_search">
          <input type="search" name="car_search" id="car_search_engine" class="car_search_engine" placeholder="Car Search" required/>
          <input type="submit" value="Search" name="shaka_car" id="car_search_button" class="car_search_button"/>
        </div>
</form>
<?php
} else {
?>
        <div style="max-width: 600px;" class="agency_car_search">
          <input style="font-size: 1.9em;" type="button" class="car_search_engine" value="Sorry, you don't have a car."/>
          <input style="font-size: 1em;width: 20em;" type="button" class="car_search_button" value="CLICK HERE TO ADD A CAR" onclick="kwinjiza_shoferi()">
        </div>
        <script>
          function kwinjiza_shoferi() {
            location.href="agency_panel?add_cars";
          }
        </script>
<?php
}
if (isset($_POST["shaka_car"])) {
  $car_search = mysqli_real_escape_string($con, htmlspecialchars($_POST['car_search']));
$showCars=mysqli_query($con,"SELECT C.*,E.* FROM cars C, employeers E WHERE E.Emp_Id=C.Emp_Id AND Car_Plaque LIKE '%$car_search%' AND E.C_Id='$user_id' ORDER BY Car_Plaque ASC") or die(mysqli_error($con));
if (mysqli_num_rows($showCars)>0){
?>
<table>
            <tr>
              <th>N<sup><u>o</u></sup></th>
              <th>Plate number</th>
              <th>Seats number</th>
              <th>Driver Name</th>
              <th>Driver Phone Number</th>
              <th>Actions</th>
            </tr>
<?php
while($car=mysqli_fetch_assoc($showCars)){
  @$count++;
?>
            <tr>
              <td><?php echo $count; ?></td>
              <td><?php echo $car["Car_Plaque"]; ?></td>
              <td><?php echo $car["Number_Place"]; ?></td>
              <td><?php echo $car["Emp_Fname"]." ".$car["Emp_Lname"]; ?></td>
              <td><?php echo $car["Emp_Phone"]; ?></td>
              <td style="text-align: center;">
                <a href="agency_panel?upCar=<?php echo $car["Car_Id"]."imodoka".$car["Emp_Id"]; ?>">UPDATE</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="agency_panel?delCar=<?php echo $car["Car_Id"]; ?>" onclick="return confirm('Are you sure you want to delete a car of the following:\n\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Plate number: <?php echo $car['Car_Plaque']; ?>\n\nIf yes, click OK')">DELETE</a>
              </td>
            </tr>
<?php
}
?>
          </table>
                  </form>
                </div>
</div>
<?php
} else {
?>
 
 <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry, <span style="background-color: black;color: white;border-radius: 3px;"><?php echo $car_search; ?></span> was not found.</h2>
          <input type="button" class="agency_send_button" value="CLOSE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?cars";
        }
        </script>
<?php
}
?>
<?php
} else {
?>
        <div class="agency_cars_table">
          <table>
<?php
$showCars=mysqli_query($con,"SELECT C.*,E.* FROM cars C, employeers E WHERE E.Emp_Id=C.Emp_Id AND E.C_Id='$user_id' ORDER BY Car_Plaque ASC") or die(mysqli_error($con));
if (mysqli_num_rows($showCars)>0){
?>
            <tr>
              <th>N<sup><u>o</u></sup></th>
              <th>Plate number</th>
              <th>Seats number</th>
              <th>Driver Name</th>
              <th>Driver Phone Number</th>
              <th>Actions</th>
            </tr>
<?php
while($car=mysqli_fetch_assoc($showCars)){
  @$count++;
?>
            <tr>
              <td><?php echo $count; ?></td>
              <td><?php echo $car["Car_Plaque"]; ?></td>
              <td><?php echo $car["Number_Place"]; ?></td>
              <td><?php echo $car["Emp_Fname"]." ".$car["Emp_Lname"]; ?></td>
              <td><?php echo $car["Emp_Phone"]; ?></td>
              <td style="text-align: center;">
                <a href="agency_panel?upCar=<?php echo $car["Car_Id"]."imodoka".$car["Emp_Id"]; ?>">UPDATE</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="agency_panel?delCar=<?php echo $car["Car_Id"]; ?>" onclick="return confirm('Are you sure you want to delete a car of the following:\n\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Plate number: <?php echo $car['Car_Plaque']; ?>\n\nIf yes, click OK')">DELETE</a>
              </td>
            </tr>
<?php
}
}
}
?>
          </table>
                  </form>
                </div>
        </div>
        <?php
      }
      //start balance
      else if(isset($_GET['balance'])){
       $ss=" SELECT booking.B_Id,booking.P_Names,booking.P_Phone,booking.P_Email, 
       cars_to_leave.Time_to_leave,cars.Car_Plaque,company.C_Id ,locations.L_from,
        locations.L_to,SUM(locations.price * booking.Seat_Count) as totalamount FROM cars_to_leave INNER JOIN booking ON
         cars_to_leave.id=booking.Id INNER JOIN cars ON cars.Car_Id=cars_to_leave.Car_Id
          INNER JOIN company ON company.C_Id=cars.C_Id inner join destination on
           destination.D_Id=cars_to_leave.D_Id inner join locations on 
           locations.L_id=destination.L_id WHERE company.C_Id='$user_id' AND booking.activityi='activated'";
           $qw=mysqli_query($con,$ss);
           if(mysqli_num_rows($qw)>0){
        while($tt=mysqli_fetch_array($qw)){
          if($tt['totalamount']>0){
          echo "<h1 style='color:orange;'><center>Total Amount = ".$tt['totalamount']." RWF </center></h1>";
          }
          else{
            echo "<h1 style='color:orange;'><center> Total Balance = 0 RWF</center></h1>";
          }
        }}
        else{
          echo "<h1 style='color:orange;'><center>Balance = 0</center></h1>";
        }
      }
      //end of balance
      //Start To Showing clients
      else if(isset($_GET['clients'])){
$sel="SELECT booking.B_Id,booking.P_Names,booking.P_Phone,booking.P_Email,
 cars_to_leave.Time_to_leave,cars.Car_Plaque,company.C_Id ,locations.L_from,
 locations.L_to,locations.price,booking.Seat_Count,booking.Seat_Number,booking.Ticket_Code,(locations.price * booking.Seat_Count) AS total_price FROM cars_to_leave INNER JOIN booking ON 
 cars_to_leave.id=booking.Id INNER JOIN cars ON cars.Car_Id=cars_to_leave.Car_Id INNER JOIN 
 company ON company.C_Id=cars.C_Id inner join destination on 
 destination.D_Id=cars_to_leave.D_Id inner join locations on locations.L_id=destination.L_id 
 WHERE company.C_Id=$user_id AND booking.activityi='wait...'";
          $queryy=mysqli_query($con,$sel);
          if(mysqli_num_rows($queryy) > 0){
          ?>
          <div class="available_cars_table">
            <h1><center> CLIENTS PENDING </center></h1>
          <table>
            <tr>
              <th>
                N<sup><u>o</u></sup>
              </th>
              <th>Client Names</th>
              <th>Phone Number</th>
              <th>Email</th>
              <th>Time</th>
              <th>Location</th>
              <th>Seat(s)</th>
              <th>Selected Seat</th>
              <th>Ticket No</th>
              <th>Price</th>
              <th>Car</th>
              <th>Activate</th>
            </tr>
          <?php
            $count=0;
            while($rrr=mysqli_fetch_array($queryy)){
              $count++;
              ?>
            <tr>
              <td><?php echo $count;?></td>
              <td><?php echo $rrr['P_Names'];?></td>
              <td><?php echo $rrr['P_Phone'];?></td>
              <td><?php echo $rrr['P_Email'];?></td>
              <td><?php echo $rrr['Time_to_leave'];?></td>
              <td><?php echo $ahoAgiye= $rrr['L_from']."-".$rrr['L_to'];?></td>
              <td><?php echo $rrr['Seat_Count'];?></td>
              <td><?php echo (int)$rrr['Seat_Number']; ?></td>
              <td><?php echo htmlspecialchars($rrr['Ticket_Code']); ?></td>
              <td><?php echo $rrr['total_price'];?> RWF</td>
              <td><?php echo $rrr['Car_Plaque'];?></td>
              <td><a href="agency_panel?actv_custom=<?php echo (int)$rrr['B_Id']; ?>" style="background-color:orange;">Activate</td>
            </tr>
          
              <?php
            }
          }
          else{
            echo "<h1><center style='color:orange;'>We don't have Pending client<center> </h1>";
            }?>
            </table>
          </div><?php
        }
      //End To Showing Clients
      //start to activate client
      
      else if(isset($_GET['actv_custom'])){
        $iyiId = (int)mysqli_real_escape_string($con, htmlspecialchars($_GET['actv_custom']));
        $ticketInfoSql = "SELECT booking.B_Id, booking.P_Names, booking.P_Email, booking.Seat_Number, booking.Ticket_Code,
                                 cars_to_leave.Time_to_leave, cars.Car_Plaque, locations.L_from, locations.L_to,
                                 (locations.price * booking.Seat_Count) AS total_price
                          FROM booking
                          INNER JOIN cars_to_leave ON cars_to_leave.id = booking.Id
                          INNER JOIN cars ON cars.Car_Id = cars_to_leave.Car_Id
                          INNER JOIN destination ON destination.D_Id = cars_to_leave.D_Id
                          INNER JOIN locations ON locations.L_id = destination.L_id
                          WHERE booking.B_Id='$iyiId' AND cars.C_Id='$user_id' LIMIT 1";
        $ticketInfoQ = mysqli_query($con, $ticketInfoSql);
        if ($ticketInfoQ && mysqli_num_rows($ticketInfoQ) > 0) {
          $ticketInfo = mysqli_fetch_assoc($ticketInfoQ);
          $up=mysqli_query($con,"UPDATE booking SET activityi = 'activated' WHERE B_Id = '$iyiId';");
          if($up==true){
            $iyiZina = $ticketInfo['P_Names'];
            $iyEmail = $ticketInfo['P_Email'];
            $iyiSaha = $ticketInfo['Time_to_leave'];
            $iyiLocation = $ticketInfo['L_from']."-".$ticketInfo['L_to'];
            $iyiMafaranga = $ticketInfo['total_price'];
            $iyiPlaque = $ticketInfo['Car_Plaque'];
            $selectedSeat = (int)$ticketInfo['Seat_Number'];
            $ticketCode = $ticketInfo['Ticket_Code'];

        require 'vendor/autoload.php';
        require 'vendor/phpmailer/phpmailer/src/Exception.php';
        require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require 'vendor/phpmailer/phpmailer/src/SMTP.php';
         $mail = new PHPMailer();
         $mail->CharSet =  "utf-8";
         $mail->IsSMTP();
         $mail->SMTPAuth = true;  
         $mail->Username = "foodpickup250@gmail.com";
         $mail->Password = "nzrn sdwl hjzq annw";
         $mail->SMTPSecure = "tls";
         $mail->Host = "smtp.gmail.com";
         $mail->Port = "587";
         $mail->From='foodpickup250@gmail.com';
         $mail->FromName='Online Booking Ticket';
         $mail->SMTPDebug = 0;
         $mail->AddAddress($iyEmail);
         $mail->Subject  =  'Ticket Purchase Confirmation';
         $mail->IsHTML(true);
         $mail->Body ='
         <div style="background-color: #f4f4f4;">
    <div
      style="
        width: 80%;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
      "
    >
      <div
        style="
          background-color: #ff6b00;
          color: #fff;
          padding: 10px;
          border-radius: 8px 8px 0 0;
          text-align: center;
        "
      >
        <h1>Ticket Purchase Confirmation</h1>
      </div>
      <div style="margin: 20px 0">
        <p>
            Hello <b>'.$iyiZina.'</b>,
        </p>
        <p>
          Thank you for your purchase! Your ticket is now activated.
        </p>

        <table style="border-collapse: collapse; width: 100%; margin-top: 20px">
          <tr>
            <th style="border: 1px solid #ddd;padding: 8px;text-align: left;background-color: #f2f2f2;">Agency</th>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: left">'.$user_info['C_Name'].'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #ddd;padding: 8px;text-align: left;background-color: #f2f2f2;">Ticket Number</th>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: left">'.$ticketCode.'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #ddd;padding: 8px;text-align: left;background-color: #f2f2f2;">Seat Number</th>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: left">'.$selectedSeat.'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #ddd;padding: 8px;text-align: left;background-color: #f2f2f2;">Plate Number</th>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: left">'.$iyiPlaque.'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #ddd;padding: 8px;text-align: left;background-color: #f2f2f2;">Time / Date</th>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: left">'.$iyiSaha.' / '. date('Y-m-d').'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #ddd;padding: 8px;text-align: left;background-color: #f2f2f2;">Location</th>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: left">'.$iyiLocation.'</td>
          </tr>
          <tr>
            <th style="border: 1px solid #ddd;padding: 8px;text-align: left;background-color: #f2f2f2;">Ticket Price</th>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: left">'.$iyiMafaranga.' RWF</td>
          </tr>
        </table>
        <p>If you have any questions, contact our support team.</p>
        <p>Best regards,<br><b>The Online Booking Ticket Team</b></p>
      </div>
    </div>
 </div>';
         if($mail->Send())
         {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Success! Payment activated and ticket sent by email.</h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?clients";
        }
        </script>
<?php
         }
         else
         {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Payment activated, but email was not sent to the client.</h2>
          <input type="button" class="agency_send_button" value="NEXT" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?clients";
        }
        </script>
<?php
         }
          }
        }
      }
      //end activate client 
      //start to showing client Done
      else if(isset($_GET['clients_paid'])){
$sel="SELECT booking.B_Id,booking.P_Names,booking.P_Phone,booking.P_Email,
 cars_to_leave.Time_to_leave,cars.Car_Plaque,company.C_Id ,locations.L_from,
 locations.L_to,locations.price,booking.Seat_Count,booking.Seat_Number,booking.Ticket_Code,(locations.price * booking.Seat_Count) AS total_price FROM cars_to_leave INNER JOIN booking ON 
 cars_to_leave.id=booking.Id INNER JOIN cars ON cars.Car_Id=cars_to_leave.Car_Id INNER JOIN 
 company ON company.C_Id=cars.C_Id inner join destination on 
 destination.D_Id=cars_to_leave.D_Id inner join locations on locations.L_id=destination.L_id 
 WHERE company.C_Id=$user_id AND booking.activityi='activated'";
          $queryy=mysqli_query($con,$sel);
          if(mysqli_num_rows($queryy) > 0){
          ?>
          <div class="available_cars_table">
            <h1><center> CLIENTS PAID </center></h1>
          <table>
            <tr>
              <th>
                N<sup><u>o</u></sup>
              </th>
              <th>Client Names</th>
              <th>Phone Number</th>
              <th>Email</th>
              <th>Time</th>
              <th>Location</th>
              <th>Seat(s)</th>
              <th>Selected Seat</th>
              <th>Ticket No</th>
              <th>Price</th>
              <th>Car</th>
            </tr>
          <?php
            $count=0;
            while($rrr=mysqli_fetch_array($queryy)){
              $count++;
              ?>
            <tr>
              <td><?php echo $count;?></td>
              <td><?php echo $rrr['P_Names'];?></td>
              <td><?php echo $rrr['P_Phone'];?></td>
              <td><?php echo $rrr['P_Email'];?></td>
              <td><?php echo $rrr['Time_to_leave'];?></td>
              <td><?php echo $rrr['L_from']."-".$rrr['L_to'];?></td>
              <td><?php echo $rrr['Seat_Count'];?></td>
              <td><?php echo (int)$rrr['Seat_Number']; ?></td>
              <td><?php echo htmlspecialchars($rrr['Ticket_Code']); ?></td>
              <td><?php echo $rrr['total_price'];?> RWF</td>
              <td><?php echo $rrr['Car_Plaque'];?></td>
            </tr>
          
              <?php
            }
          }
          else{
            echo "<h1 style='color:orange;'><center>We don't have Paid client<center></h1>";
          }?>
          </table>
        </div><?php
        }
      //end to showing client Done
      else if(isset($_GET["add_drivers"])) {
        ?>


        <!-- START ADD DRIVERS -->
      <title>Rwanda-Bus || Add Drivers</title>
        <div class="agency_cars_creation_form">
          <form action="brain2" method="post">
            <h1><u>Add Driver</u></h1>
            <input
              type="text"
              name="Emp_Fname"
              placeholder="First name"
              required
            />
            <input
              type="text"
              name="Emp_Lname"
              placeholder="Last name"
              required
            />
            <input
              type="text"
              name="Emp_Phone"
              minlength="10"
              maxlength="10"
              pattern="^(079|078|072|073)[0-9]{7}$"
              title="Please enter a 10-digit phone number starting with 079, 078, 072, or 073."
              placeholder="Phone number"
              required
            />
            <input
              type="text"
              name="Emp_Idcard"
              pattern="[0-9]+"
              title="Please enter a number. Only numeric values are allowed."
              minlength="16"
              maxlength="16"
              placeholder="National id"
              required
            />
            <input
              type="submit"
              name="C_Add_Driver"
              class="agency_send_button"
              value="Add"
            />
          </form>
        <?php
      }
      else if(isset($_GET["upCar"])) {
        $thisCar=mysqli_real_escape_string($con, htmlspecialchars($_GET["upCar"]));
        list($myModoka,$myShoferi)=explode("imodoka",$thisCar);
        $myCar=mysqli_query($con,"SELECT E.*,C.* FROM employeers E,cars C WHERE E.Emp_Id=C.Emp_Id AND E.Emp_Id='$myShoferi' AND C.Car_Id='$myModoka' AND C.C_Id='$user_id' AND E.C_Id='$user_id'") or die(mysqli_error($con));
        $iyiModoka=mysqli_fetch_assoc($myCar);
?>        
        <!-- START ADD CAR -->
      <title>Rwanda-Bus || Update Car</title>
        <div class="agency_cars_creation_form">
          <form action="brain2" method="post">
            <h1><u>Update Car</u></h1>
            <input type="text" name="back" value="<?php echo $myModoka."imodoka".$myShoferi; ?>" required hidden/>
            <input type="text" name="idImodoka" value="<?php echo $myModoka; ?>" required hidden/>
            <input type="text" name="Car_Plaque" placeholder="Plate Number: <?php echo $iyiModoka['Car_Plaque']; ?>" value="<?php echo $iyiModoka['Car_Plaque']; ?>" required/>
            <input type="text" name="Number_Place" placeholder="Number of Seats: <?php echo $iyiModoka['Number_Place']; ?>" value="<?php echo $iyiModoka['Number_Place']; ?>" required/>
            <select name="C_Driver" style="text-transform: capitalize;cursor: pointer;" required>
              <option style="background-color: rgb(255, 107, 0);color: black;font-size: 1.4em;border: 2px solid black;" value="<?php echo $iyiModoka['Emp_Id']; ?>"><?php echo $iyiModoka['Emp_Fname']," ".$iyiModoka['Emp_Lname']; ?></option>
<?php
$allDrivers=mysqli_query($con,"SELECT * FROM employeers WHERE C_Id='$user_id'") or die(mysqli_error($con));
if(mysqli_num_rows($allDrivers)>0){
  while($driver=mysqli_fetch_assoc($allDrivers)){
    @$count++;
?>
              <option value="<?php echo $driver['Emp_Id']; ?>" style="background-color: rgb(255, 107, 0);color: black;font-size: 1.4em;border: 2px solid black;"><?php echo "(".$count."). ".$driver["Emp_Phone"]." (".$driver["Emp_Fname"]." ".$driver["Emp_Lname"].")"; ?></option>
<?php
  }
}
?>
            </select>
            <input type="submit" name="U_Add_Car" class="agency_send_button" value="Update"/>
          </form>
        </div>
<?php
      
      } else if(isset($_GET["delCar"])){
        $thisCar = mysqli_real_escape_string($con, htmlspecialchars($_GET["delCar"]));
        $sibaImodoka=mysqli_query($con,"DELETE FROM cars WHERE Car_Id='$thisCar' AND C_Id='$user_id'") or die(mysqli_error($con));
        if($sibaImodoka==true){
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Well, the car was deleted successful.</h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?cars";
        }
        </script>
<?php
        } else {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry, something went wrong. Please try again later.</h2>
          <input type="button" class="agency_send_button" value="EXIT" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?cars";
        }
        </script>
<?php
        }
      }else if(isset($_GET["add_cars"])) {
        ?>
      <title>Rwanda-Bus || Add Cars</title>
        <div class="agency_cars_creation_form">
          <form action="brain2" method="post">
            <h1><u>Add Car</u></h1>
            <input type="text" name="Car_Plaque" placeholder="Plate Number" required/>
            <input type="text" name="Number_Place" placeholder="Number of Seats" required/>
            <select name="C_Driver" style="text-transform: capitalize;cursor: pointer;" required>
              <option style="background-color: black;color: white;font-size: 1.8em;" value="" selected disabled>Select driver</option>
<?php
$allDrivers=mysqli_query($con,"SELECT * FROM employeers WHERE C_Id='$user_id'") or die(mysqli_error($con));
if(mysqli_num_rows($allDrivers)>0){
  while($driver=mysqli_fetch_assoc($allDrivers)){
    @$count++;
?>
              <option value="<?php echo $driver['Emp_Id']; ?>" style="background-color: rgb(255, 107, 0);color: black;font-size: 1.4em;border: 2px solid black;"><?php echo "(".$count."). ".$driver["Emp_Phone"]." (".$driver["Emp_Fname"]." ".$driver["Emp_Lname"].")"; ?></option>
<?php
  }
} else {
?>
              <option disabled style="background-color: orange;color: black;font-size: 1.4em;">There is no driver.</option>
<?php
}
?>
            </select>
            <input type="submit" name="C_Add_Car" class="agency_send_button" value="Add"/>
          </form>
        </div>
        <?php
      }
      else if(isset($_GET["upDriver"])) {
  $thisDriver = stripslashes($_GET["upDriver"]);
  $thisDriver = mysqli_real_escape_string($con, htmlspecialchars($_GET["upDriver"]));
  $uyuMushoferi=mysqli_query($con,"SELECT * FROM employeers WHERE Emp_Id='$thisDriver'") or die(mysqli_error($con));
  $shoferi=(mysqli_fetch_assoc($uyuMushoferi));
?>
<title>Rwanda-Bus || Update Drivers</title>
  <div class="agency_cars_creation_form">
    <form action="brain2" method="post">
      <h1><u>Update Driver</u></h1>
      <input
        type="text"
        name="Emp_Fname"
        placeholder="First name: <?php echo $shoferi["Emp_Fname"]; ?>"
        value="<?php echo $shoferi["Emp_Fname"]; ?>"
        required
      />
      <input
        type="text"
        name="Emp_Lname"
        placeholder="Last name: <?php echo $shoferi["Emp_Lname"]; ?>"
        value="<?php echo $shoferi["Emp_Lname"]; ?>"
        required
      />
      <input
        type="text"
        name="Emp_Phone"
        minlength="10"
        maxlength="10"
        pattern="^(079|078|072|073)[0-9]{7}$"
        title="Please enter a 10-digit phone number starting with 079, 078, 072, or 073."
        placeholder="Phone number: <?php echo $shoferi["Emp_Phone"]; ?>"
        value="<?php echo $shoferi["Emp_Phone"]; ?>"
        required
      />
      <input
        type="text"
        name="Emp_Idcard"
        pattern="[0-9]+"
        title="Please enter a number. Only numeric values are allowed."
        minlength="16"
        maxlength="16"
        placeholder="National id: <?php echo $shoferi["Emp_Idcard"]; ?>"
        value="<?php echo $shoferi["Emp_Idcard"]; ?>"
        required
      />
      <input
        type="text" name="iShoferi" value="<?php echo $thisDriver; ?>" required hidden/>
      <input
        type="submit"
        name="U_Add_Driver"
        class="agency_send_button"
        value="Update"
      />
    </form>
<?php
}
else if(isset($_GET["delDriver"])){
        $thisDriver = mysqli_real_escape_string($con, htmlspecialchars($_GET["delDriver"]));
        $sibaShoferi=mysqli_query($con,"DELETE FROM employeers WHERE Emp_Id='$thisDriver' AND C_Id='$user_id'") or die(mysqli_error($con));
        if($sibaShoferi==true){
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Well, a driver deleted successful.</h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?drivers";
        }
        </script>
<?php
        } else {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry, something went wrong. Please try again later.</h2>
          <input type="button" class="agency_send_button" value="EXIT" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?drivers";
        }
        </script>
<?php
        }
      }
      else if(isset($_GET["drivers"])) {
        ?>
        <!-- END ADD DRIVERS -->
<title>Rwanda-Bus || Drivers</title>
      <?php
        $kureba_abashoferi = mysqli_query($con,"SELECT * FROM employeers WHERE C_Id='$user_id'") or die(mysqli_error($con));
        if (mysqli_num_rows($kureba_abashoferi)>0) {
      ?>
      <form method="post">
        <div class="agency_car_search">
            <input type="search" name="car_search_engine" id="car_search_engine" class="car_search_engine" placeholder="Driver Search" required/>
            <input type="submit" value="Search" name="shaka_driver" id="car_search_button" class="car_search_button"/>
          </div>
      </form>
      <?php
        }
        if(isset($_POST["shaka_driver"])) {
          $search_driver = mysqli_real_escape_string($con, htmlspecialchars($_POST["car_search_engine"]));
          $kureba_abashoferi = mysqli_query($con,"SELECT * FROM employeers WHERE (Emp_Fname LIKE '%$search_driver%' OR Emp_Lname LIKE '%$search_driver%' OR Emp_Phone LIKE '%$search_driver%' OR Emp_Idcard LIKE '%$search_driver%') AND C_Id='$user_id'") or die(mysqli_error($con));
          if (mysqli_num_rows($kureba_abashoferi)>0) {
            
?><table>
        <tr>
          <th>
            N<sup><u>o</u></sup>
          </th>
          <th>Driver Names</th>
          <th>Driver phone number</th>
          <th>Phone national identity</th>
          <th>Action</th>
        </tr>
<?php
while ($shoferi=mysqli_fetch_array($kureba_abashoferi)) {
  @$count++;
?>
<tr>
  <td><?php echo $count+=0; ?></td>
  <td><?php echo $yose=$shoferi["Emp_Fname"]." ".$shoferi["Emp_Lname"] ?></td>
  <td><?php echo $phoneYe=$shoferi["Emp_Phone"]; ?></td>
  <td><?php echo $shoferi["Emp_Idcard"]; ?></td>
  <td style="text-align: center;">
    <a href="agency_panel?upDriver=<?php echo $shoferi["Emp_Id"]; ?>">UPDATE</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="agency_panel?delDriver=<?php echo $shoferi["Emp_Id"]; ?>" onclick="return confirm('Are you sure you want to delete a driver of the followings:\n\n Names: <?php echo $yose.'\n Phone: '.$phoneYe; ?>\n\nIf yes, click OK')">DELETE</a>
  </td>
</tr>
<?php
}
?>
</table>
</div>
<?php
          } else {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry, <span style="background-color: black;color: white;border-radius: 3px;"><?php echo $search_driver; ?></span> was not found.</h2>
          <input type="button" class="agency_send_button" value="CLOSE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?drivers";
        }
        </script>
<?php
          }
        } else {
      ?>

        <div class="agency_cars_table">
          <table>
        <?php
        $kureba_abashoferi = mysqli_query($con,"SELECT * FROM employeers WHERE C_Id='$user_id'") or die(mysqli_error($con));
        if (mysqli_num_rows($kureba_abashoferi)>0) {
        ?>
        <tr>
          <th>
            N<sup><u>o</u></sup>
          </th>
          <th>Driver Names</th>
          <th>Driver phone number</th>
          <th>Phone national identity</th>
          <th>Action</th>
        </tr>
        <?php
          while ($shoferi=mysqli_fetch_array($kureba_abashoferi)) {
            @$count++;
        ?>
            <tr>
              <td><?php echo $count+=0; ?></td>
              <td><?php echo $yose=$shoferi["Emp_Fname"]." ".$shoferi["Emp_Lname"] ?></td>
              <td><?php echo $phoneYe=$shoferi["Emp_Phone"]; ?></td>
              <td><?php echo $shoferi["Emp_Idcard"]; ?></td>
              <td style="text-align: center;">
                <a href="agency_panel?upDriver=<?php echo $shoferi["Emp_Id"]; ?>">UPDATE</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="agency_panel?delDriver=<?php echo $shoferi["Emp_Id"]; ?>" onclick="return confirm('Are you sure you want to delete a driver of the followings:\n\n Names: <?php echo $yose.'\n Phone: '.$phoneYe; ?>\n\nIf yes, click OK')">DELETE</a>
              </td>
            </tr>
        <?php
          }
        } else {
        ?>
        <div style="max-width: 600px;" class="agency_car_search">
          <input style="font-size: 1.9em;" type="button" class="car_search_engine" value="Sorry, you don't have a driver."/>
          <input style="font-size: 1em;width: 20em;" type="button" class="car_search_button" value="CLICK HERE TO ADD A DRIVER" onclick="kwinjiza_shoferi()">
        </div>
        <script>
          function kwinjiza_shoferi() {
            location.href="agency_panel?add_drivers";
          }
        </script>
        <?php
        }
        ?>
          </table>
                  </form>
                </div>
        </div>
        <!-- START DRIVERS -->
      
        <?php
         }
         } else if(isset($_GET["add_cars"])) {
        ?>
        <!-- END DRIVERS -->
        
        <!-- START ADD CAR -->
      <title>Rwanda-Bus || Add Cars</title>
        <div class="agency_cars_creation_form">
          <form action="brain2" method="post">
            <h1><u>Add Car</u></h1>
            <input type="text" name="Car_Plaque" placeholder="Plate Number" required/>
            <input type="text" name="Number_Place" placeholder="Number of Seats" required/>
            <select name="C_Driver" style="text-transform: capitalize;cursor: pointer;" required>
              <option style="background-color: black;color: white;font-size: 1.8em;" value="" selected disabled>Select driver</option>
<?php
$allDrivers=mysqli_query($con,"SELECT * FROM employeers WHERE C_Id='$user_id'") or die(mysqli_error($con));
if(mysqli_num_rows($allDrivers)>0){
  while($driver=mysqli_fetch_assoc($allDrivers)){
    @$count++;
?>
              <option value="<?php echo $driver['Emp_Id']; ?>" style="background-color: rgb(255, 107, 0);color: black;font-size: 1.4em;border: 2px solid black;"><?php echo "(".$count."). ".$driver["Emp_Phone"]." (".$driver["Emp_Fname"]." ".$driver["Emp_Lname"].")"; ?></option>
<?php
  }
}
?>
            </select>
            <input type="submit" name="C_Add_Car" class="agency_send_button" value="Add"/>
          </form>
        </div>
        <?php
      }
      // START ADD CAR TO LEAVE
        
        else if(isset($_GET['add_car_to_leave'])){
?>
          <div class="agency_cars_creation_form">
          <form action="brain2" method="post">
            <h1><u>Add Car To Leave</u></h1>
            <select name="C_id" style="text-transform: capitalize;cursor: pointer;" required>
              <option style="background-color: black;color: white;font-size: 1.8em;" value="" selected disabled>Select Plaque</option>
              <?php 
              $insc="SELECT * FROM cars WHERE C_Id='$user_id'";
              $cars=mysqli_query($con,$insc);
              if(mysqli_num_rows($cars)>0){
                while($r=mysqli_fetch_array($cars)){
                  @$count++;
                  ?>
                  <option value="<?php echo $r['Car_Id'];?>" style="background-color: rgb(255, 107, 0);color: black;font-size: 1.4em;border: 2px solid black;"> <?php echo "(".$count."). ".$r["Car_Plaque"];?></option>
                  <?php
                }
              }
              ?>
            </select>
            <select name="c_destination" style="text-transform: capitalize;cursor: pointer;" required>
              <option style="background-color: black;color: white;font-size: 1.8em;" value="" disabled selected>Select Destination</option>
<?php
$allDestinations = mysqli_query($con, "SELECT L.*,D.* FROM locations L, destination D WHERE L.L_id=D.L_id AND D.C_Id='$user_id' ORDER BY L_from ASC") or die(mysqli_error($con));
if(mysqli_num_rows($allDestinations)>0){
  while($destination=mysqli_fetch_assoc($allDestinations)){
    @$count++;
?>
              <option value="<?php echo $destination['D_Id']; ?>" style="background-color: rgb(255, 107, 0);color: black;font-size: 1.4em;border: 2px solid black;"><?php echo "(".$count."). ".$destination["L_from"]." - ".$destination["L_to"].": (Rwf ".$destination["price"].")"; ?></option>
<?php
  }
} else {
?>
<option disabled style="background-color: orange;color: black;font-size: 1.4em;border: 2px solid black;">There is no new destination.</option>
<?php
}
?>
            </select>
            <div>
            Hours
<input type="number" id="hr" name="hr"  min="0" max="12" required />
Minutes
<input type="number" id="mn" name="min"  min="0" max="60" required />
choose(AM/PM)
   <select name="ap" id="" required>
  <option value="" disabled selected>select time</option>
  <option value="AM">AM</option>
  <option value="PM">PM</option>
   </select>
</div>

            <input type="submit" name="add_tleave_car" class="agency_send_button" value="Add"/>
          </form>
        </div>
     
<?php
        }
        // END ADD CAR TO LEAVE
      else if(isset($_GET["destinations"])) {
        $showMydestinations=mysqli_query($con,"SELECT D.*,L.* FROM destination D,locations L WHERE L.L_id=D.L_id AND D.C_Id='$user_id' ORDER BY L_from ASC") or die($con);
        if (mysqli_num_rows($showMydestinations)>0) {
        ?>
      <title>Rwanda-Bus || Destinations</title>
      <form method="post">
        <div class="agency_destination_search">
          <input type="search" name="destination_search" id="destination_search_engine" class="destination_search_engine" placeholder="Destination Search"/>
          <input type="submit" value="Search" name="shaka_destination" id="destination_search_button" class="destination_search_button"/>
        </div>
      </form>
<?php
        } else {
?>
        <div style="max-width: 600px;" class="agency_car_search">
          <input style="font-size: 1.9em;" type="button" class="car_search_engine" value="Sorry, you don't have a destination."/>
          <input style="font-size: 1em;width: 20em;" type="button" class="car_search_button" value="CLICK HERE TO ADD A DESTINATION" onclick="kwinjiza_shoferi()">
        </div>
        <script>
          function kwinjiza_shoferi() {
            location.href="agency_panel?add_destinations";
          }
        </script>
<?php
        }
if (isset($_POST["shaka_destination"])) {
  $thisCyerekezo = mysqli_real_escape_string($con, htmlspecialchars($_POST["destination_search"]));
?>
<?php
$showMydestinations=mysqli_query($con,"SELECT D.*,L.* FROM destination D,locations L WHERE (L_from LIKE '%$thisCyerekezo%' OR L_to LIKE '%$thisCyerekezo%') AND L.L_id=D.L_id AND D.C_Id='$user_id' ORDER BY L_from ASC") or die($con);
if (mysqli_num_rows($showMydestinations)>0) {
  $count=1;
?>
<table>
            <tr>
              <th>N<sup><u>o</u></sup></th>
              <th>Destinations</th>
              <th>Price</th>
              <th>Actions</th>
            </tr>
<?php
while ($myDestination=mysqli_fetch_assoc($showMydestinations)){
?>
            <tr>
              <td><?php echo $count++ ?></td>
              <td style="text-transform: capitalize;"><?php echo $ikiCyerekezo=$myDestination["L_from"]." - ".$myDestination["L_to"]; ?></td>
              <td>Rwf <?php echo $myDestination["price"]; ?></td>
              <td style="text-align: center;">
                <a href="agency_panel?upDestination=<?php echo $myDestination["L_id"]; ?>">UPDATE</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="agency_panel?delDestination=<?php echo $myDestination["L_id"]; ?>" onclick="return confirm('Are you sure you want to delete the following destination:\n\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ikiCyerekezo.'&nbsp;&nbsp;=&nbsp;&nbsp;('.$myDestination['price'].')'; ?>\n\nIf yes, click OK')">DELETE</a>
              </td>
            </tr>
<?php
  }
} else {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry, <span style="background-color: black; color: white;border-radius: 3px;"><?php echo $thisCyerekezo; ?></span> was not found.</h2>
          <input type="button" class="agency_send_button" value="Okay" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?destinations";
        }
        </script>
<?php
}
?>
          </table>
        </div>
<?php
} else {
?>
        <div class="agency_destination_table">
          <table>
<?php
$showMydestinations=mysqli_query($con,"SELECT D.*,L.* FROM destination D,locations L WHERE L.L_id=D.L_id AND D.C_Id='$user_id' ORDER BY L_from ASC") or die($con);
if (mysqli_num_rows($showMydestinations)>0) {
  $count=1;
?>
            <tr>
              <th>N<sup><u>o</u></sup></th>
              <th>Destinations</th>
              <th>Price</th>
              <th>Actions</th>
            </tr>
<?php
while ($myDestination=mysqli_fetch_assoc($showMydestinations)){
?>
            <tr>
              <td><?php echo $count++ ?></td>
              <td style="text-transform: capitalize;"><?php echo $ikiCyerekezo=$myDestination["L_from"]." - ".$myDestination["L_to"]; ?></td>
              <td>Rwf <?php echo $myDestination["price"]; ?></td>
              <td style="text-align: center;">
                <a href="agency_panel?upDestination=<?php echo $myDestination["L_id"]; ?>">UPDATE</a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="agency_panel?delDestination=<?php echo $myDestination["L_id"]; ?>" onclick="return confirm('Are you sure you want to delete the following destination:\n\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ikiCyerekezo.'&nbsp;&nbsp;=&nbsp;&nbsp;('.$myDestination['price'].')'; ?>\n\nIf yes, click OK')">DELETE</a>
              </td>
            </tr>
<?php
  }
}
?>
          </table>
        </div>
        <?php
      }
     }

      //Start Driver report
      else if(isset($_GET["upDestination"])) {
    $selectedDestination = $_GET["upDestination"];
    $myCyerekezo = mysqli_query($con, "SELECT L.*,D.* FROM locations L,destination D WHERE L.L_id=D.L_id AND D.L_id='$selectedDestination' AND D.C_Id='$user_id'") or die(mysqli_error($con));
            $thisCyerekezo=mysqli_fetch_assoc($myCyerekezo);
    ?>
  <title>Rwanda-Bus || Update Destinations</title>
    <div class="agency_destination_creation_form">
      <form action="brain2" method="post">
        <h1><u>Update Destination</u></h1>
        <input type="text" name="D_Id" value="<?php echo $thisCyerekezo["D_Id"]; ?>" hidden>
        <input type="text" name="L_id" value="<?php echo $thisCyerekezo["L_id"]; ?>" hidden>
        <select name="c_destination" style="text-transform: capitalize;cursor: pointer;" required>
          <option style="background-color: black;color: white;font-size: 1.8em;" value="<?php echo $thisCyerekezo["L_id"]; ?>" selected><?php echo $thisCyerekezo["L_from"]." - ".$thisCyerekezo["L_to"]; ?></option>
<?php
$allDestinations = mysqli_query($con, "SELECT * FROM locations ORDER BY L_from ASC") or die(mysqli_error($con));
if(mysqli_num_rows($allDestinations)>0){
while($destination=mysqli_fetch_assoc($allDestinations)){
@$count++;
?>
          <option value="<?php echo $destination["L_id"] ?>" style="background-color: rgb(255, 107, 0);color: black;font-size: 1.4em;border: 2px solid black;"><?php echo "(".$count."). ".$destination["L_from"]." - ".$destination["L_to"].": (Rwf ".$destination["price"].")"; ?></option>
<?php
}
} else {
?>
<option disabled style="background-color: orange;color: black;font-size: 1.4em;border: 2px solid black;">There is no new destination.</option>
<?php
}
?>
        </select>
        <input type="submit" name="U_destination" id="send_button" class="agency_send_button" value="Update"/>
      </form>
    </div>
    <?php
  }
  else if(isset($_GET["delDestination"])) {
    $myDestination=$_GET["delDestination"];
    $sibaIcyerekezo=mysqli_query($con,"DELETE FROM destination WHERE L_id='$myDestination' AND C_Id='$user_id'") or die(mysqli_error($con));
    if ($sibaIcyerekezo==true) {
?>
<div class="agency_cars_creation_form" style="margin-top: 5em;">
<form>
  <h2>Well, destination deleted successful.</h2>
  <input type="button" class="agency_send_button" value="BACK" onclick="gusubiraInyuma()">
</form>
</div>
<script>
function gusubiraInyuma() {
  location.href="agency_panel?destinations";
}
</script>
<?php
    } else {
?>
<div class="agency_cars_creation_form" style="margin-top: 5em;">
<form>
  <h2>Sorry, something went wrong. Please try again later.</h2>
  <input type="button" class="agency_send_button" value="BACK" onclick="gusubiraInyuma()">
</form>
</div>
<script>
function gusubiraInyuma() {
  location.href="agency_panel?destinations";
}
</script>
<?php
    }
}
      else if (isset($_GET["drivers_report"])) {
?>
<title>Rwanda-Bus || Drivers Report</title>
<table>
<td style="border: 1px solid white;">
  <a onclick="birashoboka()" >PRINT</a>
</td>
</table>
<div id="cyanerwose">
        <center><h1><span style="background-color: black;color: white;border-radius: 3px;">Ritco</span> <u>(Reports Of Drivers)</u></h1></center>
        <br><div class="agency_cars_table">
<?php
  $totalCars = mysqli_query($con, "SELECT COUNT(Emp_Id) AS total FROM employeers WHERE C_Id='$user_id'") or die(mysqli_error($con));
  $Cars = mysqli_fetch_assoc($totalCars);
  echo "<span style='font-size: 1.3em;'><b>All Drivers:</b> " . $Cars['total']."</span><br>";
?>
        <div class="agency_cars_table">
          <table>
        <?php
        $kureba_abashoferi = mysqli_query($con,"SELECT * FROM employeers WHERE C_Id='$user_id'") or die(mysqli_error($con));
        if (mysqli_num_rows($kureba_abashoferi)>0) {
        ?>
        <tr>
          <th style="border: 3px solid #111111;">N<sup><u>o</u></sup></th>
          <th style="border: 3px solid #111111;">Driver Names</th>
          <th style="border: 3px solid #111111;">Driver phone number</th>
          <th style="border: 3px solid #111111;">Phone national identity</th>
        </tr>
        <?php
          while ($shoferi=mysqli_fetch_array($kureba_abashoferi)) {
            @$count++;
        ?>
            <tr>
              <td style="border: 2px solid #111111;"><?php echo $count+=0; ?></td>
              <td style="border: 2px solid #111111;"><?php echo $yose=$shoferi["Emp_Fname"]." ".$shoferi["Emp_Lname"] ?></td>
              <td style="border: 2px solid #111111;"><?php echo $phoneYe=$shoferi["Emp_Phone"]; ?></td>
              <td style="border: 2px solid #111111;"><?php echo $shoferi["Emp_Idcard"]; ?></td>
            </tr>
        <?php
          }
        }
        ?>
          </table>
                  </form>
                </div>
        </div>
<?php
      }
      //End Driver report
      //Start Car Report
      else if (isset($_GET["cars_report"])) {
    ?>
    <title>Rwanda-Bus || Cars Report</title>
    <table>
    <td style="border: 1px solid white;">
      <a onclick="birashoboka()" >PRINT</a>
    </td>
    </table>
    <div id="cyanerwose">
            <center><h1><span style="background-color: black;color: white;border-radius: 3px;">Ritco</span> <u>(Reports Of Cars)</u></h1></center>
            <br><div class="agency_cars_table">
    <?php
      $totalCars = mysqli_query($con, "SELECT COUNT(Car_Id) AS total FROM cars WHERE C_Id='$user_id'") or die(mysqli_error($con));
      $Cars = mysqli_fetch_assoc($totalCars);
      echo "<span style='font-size: 1.3em;'><b>All Cars:</b> " . $Cars['total']."</span><br>";
    ?>
    <table>
    <?php
    $showCars=mysqli_query($con,"SELECT C.*,E.* FROM cars C, employeers E WHERE E.Emp_Id=C.Emp_Id AND E.C_Id='$user_id' AND C.C_Id='$user_id' ORDER BY Car_Plaque ASC") or die(mysqli_error($con));
    if (mysqli_num_rows($showCars)>0){
    ?>
                <tr>
                  <th style="border: 3px solid #111111;">N<sup><u>o</u></sup></th>
                  <th style="border: 3px solid #111111;">Plate number</th>
                  <th style="border: 3px solid #111111;">Seats number</th>
                  <th style="border: 3px solid #111111;">Driver Name</th>
                  <th style="border: 3px solid #111111;">Driver Phone Number</th>
                </tr>
    <?php
    while($car=mysqli_fetch_assoc($showCars)){
      @$count++;
    ?>
                <tr>
                  <td style="border: 2px solid #111111;"><?php echo $count; ?></td>
                  <td style="border: 2px solid #111111;"><?php echo $car["Car_Plaque"]; ?></td>
                  <td style="border: 2px solid #111111;"><?php echo $car["Number_Place"]; ?></td>
                  <td style="border: 2px solid #111111;"><?php echo $car["Emp_Fname"]." ".$car["Emp_Lname"]; ?></td>
                  <td style="border: 2px solid #111111;"><?php echo $car["Emp_Phone"]; ?></td>
                </tr>
    <?php
    }
    }
    ?>
              </table>
                      </form>
                    </div>
    </div>
    <?php
          }
          //End Car Report
          //Start Destination Report
          else if (isset($_GET["destinations_report"])) {
    ?>
    <title>Rwanda-Bus || Destinations Report</title>
    <table>
    <td style="border: 1px solid white;">
      <a onclick="birashoboka()" >PRINT</a>
    </td>
    </table>
    <div id="cyanerwose">
            <center><h1><span style="background-color: black;color: white;border-radius: 3px;">Ritco</span> <u>(Reports Of Destinations)</u></h1></center>
            <br>
            <div class="agency_destination_table">
    <?php
      $totalCars = mysqli_query($con, "SELECT COUNT(D_Id) AS total FROM destination WHERE C_Id='$user_id'") or die(mysqli_error($con));
      $Cars = mysqli_fetch_assoc($totalCars);
      echo "<span style='font-size: 1.3em;'><b>All Destinations:</b> " . $Cars['total']."</span><br>";
    ?>
              <table>
    <?php
    $showMydestinations=mysqli_query($con,"SELECT D.*,L.* FROM destination D,locations L WHERE L.L_id=D.L_id AND D.C_Id='$user_id' ORDER BY L_from ASC") or die($con);
    if (mysqli_num_rows($showMydestinations)>0) {
      $count=1;
    ?>
                <tr>
                  <th style="border: 3px solid #111111;">N<sup><u>o</u></sup></th>
                  <th style="border: 3px solid #111111;">Destinations</th>
                  <th style="border: 3px solid #111111;">Price</th>
                </tr>
    <?php
    while ($myDestination=mysqli_fetch_assoc($showMydestinations)){
    ?>
                <tr>
                  <td style="border: 2px solid #111111;"><?php echo $count++ ?></td>
                  <td style="text-transform: capitalize;border: 2px solid #111111;"><?php echo $ikiCyerekezo=$myDestination["L_from"]." - ".$myDestination["L_to"]; ?></td>
                  <td style="border: 2px solid #111111;">Rwf <?php echo $myDestination["price"]; ?></td>
                </tr>
    <?php
      }
    }
    ?>
              </table>
    <?php
          }
      
      
      //End Destination Report
       else if(isset($_GET["add_destinations"])) {
        ?>
        <!-- END DESTINATIONS -->


        <!-- START ADD -->
      <title>Rwanda-Bus || Add Destinations</title>
        <div class="agency_destination_creation_form">
          <form action="brain2" method="post">
            <h1><u>Add Destination</u></h1>
            <select name="c_destination" style="text-transform: capitalize;cursor: pointer;" required>
              <option style="background-color: black;color: white;font-size: 1.8em;" value="" disabled selected>Select Destination</option>
<?php
$allDestinations = mysqli_query($con, "SELECT * FROM locations ORDER BY L_from ASC") or die(mysqli_error($con));
if(mysqli_num_rows($allDestinations)>0){
  while($destination=mysqli_fetch_assoc($allDestinations)){
    @$count++;
?>
              <option value="<?php echo $destination["L_id"] ?>" style="background-color: rgb(255, 107, 0);color: black;font-size: 1.4em;border: 2px solid black;"><?php echo "(".$count."). ".$destination["L_from"]." - ".$destination["L_to"].": (Rwf ".$destination["price"].")"; ?></option>
<?php
  }
} else {
?>
<option disabled style="background-color: orange;color: black;font-size: 1.4em;border: 2px solid black;">There is no new destination.</option>
<?php
}
?>
            </select>
            <input type="submit" name="add_destination" id="send_button" class="agency_send_button" value="Add"/>
          </form>
        </div>
        <?php
      } 
      // Start Show Car To leave
      else if(isset($_GET['show_car_to_leave']))
      {
        $se=" SELECT cars_to_leave.Time_to_leave, cars_to_leave.date_car_to, cars_to_leave.timing, cars.Car_Plaque,
         cars.Number_Place, employeers.Emp_Fname, employeers.Emp_Lname,
          employeers.Emp_Phone, destination.L_id, locations.L_from,
           locations.L_to, locations.price, company.C_Id FROM cars INNER JOIN cars_to_leave
            ON cars.Car_Id = cars_to_leave.Car_Id INNER JOIN destination ON 
            destination.D_Id = cars_to_leave.D_Id INNER JOIN employeers ON
             employeers.Emp_Id = cars.Emp_Id INNER JOIN locations 
             ON locations.L_id = destination.L_id INNER JOIN company ON company.C_Id = destination.C_Id
              WHERE company.C_Id = '$user_id'ORDER BY CASE WHEN SUBSTRING(Time_to_leave,LOCATE(' ', Time_to_leave) + 1, 2) = 'AM' THEN 0 ELSE 1 END ASC, STR_TO_DATE(Time_to_leave, '%l:%i %p') ASC;
           ";
           $quer=mysqli_query($con,$se);
           ?>
             <div class="agencies_table">
              <h1><center>Car To Leave</center></h1>
          <table>
            <tr>
              <th>
                N<sup><u>o</u></sup>
              </th>
              <th>Plaque</th>
              <th>Place</th>
              <th>Drivers</th>
              <th>Tel</th>
              <th>location</th>
              <th>Time</th>
              <th>Date</th>
              <th>Timing</th>
              
            </tr>
            <?php
            $count=0;
            while($row=mysqli_fetch_array($quer)){
              $count++;

  $isahaIbitswe=$row["Time_to_leave"];

  
  $iyiSaha=date("h:i A");
  $dateTime2 = new DateTime($iyiSaha);
  $time24_1 = $isahaIbitswe;
  $suzuma = $dateTime2->format('H:i');
  if(substr($suzuma,0,2)>12){
    $n = substr($suzuma,0,2)-12;
    $f="PM";
    $time24_2 = $n."".$dateTime2->format(':i')." ".$f;
  } else {
    $m="AM";
    $time24_2 = $dateTime2->format('H:i')."".$m;

  }
 
  $igihe=substr($row["date_car_to"], 0, 10);
  $uyuMunsi=date("Y-m-d");
  if ($uyuMunsi<=$igihe && $time24_1>$time24_2) { 
?>
              <tr>
              <td><?php echo $count; ?></td>
              <td><?php echo $row['Car_Plaque']; ?></td>
              <td><?php echo $row['Number_Place'];?></td>
              <td><?php echo $row['Emp_Fname']."&nbsp;&nbsp;&nbsp;".$row['Emp_Lname']; ?></td>
              <td><?php echo $row['Emp_Phone'] ?></td>
              <td><?php echo $row['L_from']."-".$row['L_to']; ?></td>
              <td><?php echo $row['Time_to_leave'];?></td>
              <td><?php echo $row['date_car_to']; ?></td>
              <td>Journey</td>
              </tr>
<?php
  } 
  // else {
  //   echo '<script>alert("there is no car available now.")</script>';
  //   // echo '<script>location.href="agency_panel?dashboard"</script>';
  // }
            }
?>
       </table>
        </div> 
<?php
           }
      //End to Show car to leave
      
      else {
        ?>
        <!-- END ADD DESTINATIONS -->


        <!-- START WHEN USER USE INCORRECT LINK -->
        <?php
        ?>
        <title>Rwanda-Bus || Incorrect link</title>
        <div class="agency_destination_creation_form">
          <form action="" method="post">
            <h1>Please use correct link.</h1>
            <input type="button" class="agency_send_button" value="Okay" onmousemove="ahabanza()"/>
          </form>
        </div>
        <script>
          function ahabanza() {
            location.href="agency_panel?dashboard";
          }
        </script>
        <?php
      }
        ?>
        <!-- EMD WHEN USER USE INCORRECT LINK -->

      </div>
    </div>

    <script>
      const resBut = document.querySelector(".humburger");
      const sidebar = document.querySelector(".agency_admin_aside");
      resBut.addEventListener("click", () => {
        if (sidebar.classList != "agency_admin_aside active") {
          resBut.innerHTML = "&#10006;";
          sidebar.classList.add("active");
        } else {
          resBut.innerHTML = "&#9776;";
          sidebar.classList.remove("active");
        }
      });

      const theme = document.querySelector(".theme");

      theme.addEventListener("click", () => {
        if (document.body.classList != "dark_theme") {
          theme.innerHTML = "Light Mode";
          document.body.classList.add("dark_theme");
          sidebar.classList.remove("active");
          resBut.innerHTML = "&#9776;";
        } else {
          sidebar.classList.remove("active");
          resBut.innerHTML = "&#9776;";
          theme.innerHTML = "Dark Mode";
          document.body.classList.remove("dark_theme");
        }
      });

      let selects = document.getElementsByClassName("popupDestination");
      let country = document.getElementById("destination");
      const down = document.querySelector(".selections");
      country.onclick = function () {
        if (down.classList != "on") {
          down.classList.toggle("on");
        }
      };

      //console.log(selects);

      for (select of selects) {
        //console.log(select)
        select.onclick = function () {
          country.value = this.textContent;
          if (down.classList != "on") {
            down.classList.remove("on");
          }
        };
      }
    </script>
    <script type="text/javascript">				
      function birashoboka(){
          var print_div = document.getElementById("cyanerwose");
          var print_area = window.open();
          print_area.document.write(print_div.innerHTML);
          print_area.document.close();
          print_area.focus();
          print_area.print();
          print_area.close();                        
      }                
</script>
<script>
        function validatePassword() {
            var newPassword = document.getElementById("ibanga2").value;
            var confirmPassword = document.getElementById("ibanga3").value;
            if (newPassword !== confirmPassword) {
                alert("New password and confirm new password do not match.");
                return false;
            }
            return true;
        }
        function togglePasswordVisibility() {
            const passwords = document.querySelectorAll('input[type="password"], input[type="text"]');
            passwords.forEach(password => {
                if (password.type === 'password') {
                    password.type = 'text';
                } else {
                    password.type = 'password';
                }
            });
        }
    </script>
<script>
    document.querySelectorAll('.dropbtn').forEach(button => {
        button.addEventListener('click', function() {
            const dropdown = this.parentElement;
            dropdown.classList.toggle('active');
            // Close other dropdowns
            document.querySelectorAll('.dropdown').forEach(otherDropdown => {
                if (otherDropdown !== dropdown) {
                    otherDropdown.classList.remove('active');
                }
            });
        });
    });

    // Close dropdowns if clicked outside
    document.addEventListener('click', function(event) {
        if (!event.target.matches('.dropbtn')) {
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        }
    });
</script>
<script src="js/chatbot.js"></script>
  </body>
</html>



