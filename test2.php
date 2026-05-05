<?php
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rwanda-Bus || Booking page</title>
  <link rel="stylesheet" href="css/navbar.css" />
  <link rel="stylesheet" href="css/footer.css" />
  <link rel="stylesheet" href="css/booking.css" />
  <link rel="stylesheet" href="css/bookingform.css" />
</head>
<body>
  <button class="humburger">&#9776;</button>
  <header>
    <nav class="nav">
      <li><a href="index">Home</a></li>
      <li><a href="booking">Booking</a></li>
      <li><a href="contactUs">Contact Us</a></li>
      <li><a href="index?injira" class="butt"><button class="login-button">Login/SignUp</button></a></li>
    </nav>
  </header>

  <?php
  if (isset($_GET['booking_form'])) {
    $iid = mysqli_real_escape_string($con, $_GET['booking_form']);
    
    // Query to fetch booking form details
    $query = "SELECT cars_to_leave.id, cars_to_leave.Time_to_leave, cars_to_leave.date_car_to, cars_to_leave.timing, cars.Car_Plaque, cars.Number_Place, employeers.Emp_Fname, employeers.Emp_Lname, employeers.Emp_Phone, destination.L_id, locations.L_from, locations.L_to, locations.price, company.C_Id, company.C_Name, company.C_Phone
              FROM cars
              INNER JOIN cars_to_leave ON cars.Car_Id = cars_to_leave.Car_Id
              INNER JOIN destination ON destination.D_Id = cars_to_leave.D_Id
              INNER JOIN employeers ON employeers.Emp_Id = cars.Emp_Id
              INNER JOIN locations ON locations.L_id = destination.L_id
              INNER JOIN company ON company.C_Id = destination.C_Id
              WHERE cars_to_leave.id = '$iid'";

    $result = mysqli_query($con, $query);

    while ($rr = mysqli_fetch_assoc($result)) {
  ?>
    <section class="booking-form-all">
      <div class="booking-form">
        <div class="booking-car-details">
          <div class="booking-car-info">
            <div class="car-infoo">
              <p><?php echo htmlspecialchars($rr['C_Name']); ?></p>
              <p><?php echo htmlspecialchars($rr['Car_Plaque']); ?></p>
            </div>
            <div class="car-info">
              <p>FROM: &nbsp;&nbsp;<?php echo htmlspecialchars($rr['L_from']); ?></p>
              <p>TO:&nbsp;&nbsp;<?php echo htmlspecialchars($rr['L_to']); ?></p>
              <p>Price:&nbsp;&nbsp;<?php echo htmlspecialchars($rr['price']); ?> RWF</p>
            </div>
          </div>
          <form action="brain" method="post">
            <fieldset>
              <label for="name">Name:</label>
              <input type="text" name="P_name" placeholder="Names" required />
            </fieldset>
            <fieldset>
              <label for="phone">Phone:</label>
              <input
                type="tel"
                name="phone"
                minlength="10"
                maxlength="10"
                pattern="^(079|078|072|073)[0-9]{7}$"
                title="Please enter a 10-digit phone number starting with 079, 078, 072, or 073."
                placeholder="07********" required
              />
              <input type="text" name="idd" value="<?php echo $rr['id'];?>" readonly style="display:none;">
            </fieldset>
            <fieldset>
              <label for="email">Email:</label>
              <input
                type="email"
                name="email"
                placeholder="Example@***.***" required
              />
            </fieldset>
            <fieldset class="car">
              <label for="car">Car:</label>
              <input type="text" />
            </fieldset>
            <fieldset>
              <button type="submit" name="byy">Buy A Ticket</button>
            </fieldset>
          </form>
        </div>
      </div>
    </section>
    <?php
    }
    
  } 
  
  else if (isset($_GET["selectedLocation"])) {
  $thisLocation = stripslashes($_GET["selectedLocation"]);
  $thisLocation = mysqli_real_escape_string($con, htmlspecialchars($_GET["selectedLocation"]));
  list($myLocation1,$myLocation2)=explode("icyerekezo",$thisLocation);
?>
<?php
$ahantu=mysqli_query($con,"SELECT * FROM locations WHERE L_from='$myLocation1' AND L_to='$myLocation2'") or die(mysqli_error($con));
$hanoHantu=mysqli_fetch_assoc($ahantu);
@$icyerekezo = $hanoHantu["L_id"];
$imodokaZijyayo=mysqli_query($con,"SELECT * FROM destination WHERE L_id='32'") or die(mysqli_error($con));
$kubara=1;
if (mysqli_num_rows($imodokaZijyayo)>0) {
  $Displayed = false;
  while($imodoka=mysqli_fetch_assoc($imodokaZijyayo)) {
    $lightning = $imodoka["D_Id"];
  $iziriBugende=mysqli_query($con,"SELECT Cp.*, Cr.*, Lc.*, Ds.*, Ct.*, 
  (SELECT COUNT(*) FROM cars_to_leave WHERE Car_Id = Cr.Car_Id) AS imyanya_yafashwe 
  FROM company Cp
  JOIN cars Cr ON Cp.C_Id = Cr.C_Id
  JOIN cars_to_leave Ct ON Cr.Car_Id = Ct.Car_Id
  JOIN destination Ds ON Ds.D_Id = Ct.D_Id
  JOIN locations Lc ON Lc.L_id = Ds.L_id
  ORDER BY CASE 
  WHEN SUBSTRING(Time_to_leave, LOCATE(' ', Time_to_leave) + 1, 2) = 'AM' THEN 0 
  ELSE 1 
  END ASC, 
  STR_TO_DATE(Time_to_leave, '%l:%i %p') ASC LIMIT 20
  ") or die(mysqli_error($con));
  if (mysqli_num_rows($iziriBugende)>0) {
    if (!$Displayed) {
?>
<h1 style="text-transform: capitalize;text-align: center;margin-top: 2em;"><?php echo $myLocation1." - ".$myLocation2; ?></h1>
  <br><div class="booking_cars_table">
    <table>
    <tr>
        <th>N<sup><u>o</u></sup></th>
        <th>Agency</th>
        <th>Plate N<sup><u>o</u></sup></th>
        <th>Location</th>
        <th>Duration</th>
        <th>Price</th>
        <th>Tel</th>
        <th>Order</th>
    </tr>
<?php
$Displayed = true;
    }
while($iyiGenda=mysqli_fetch_assoc($iziriBugende)) {
  $imyanyaYose=$iyiGenda["Number_Place"];
  $imyanyaYafashwe=$iyiGenda["imyanya_yafashwe"];
  $isahaIbitswe=$iyiGenda["Time_to_leave"];
  $blackning = $iyiGenda["D_Id"];
  
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
 

  $imyanyaIsigaye=$imyanyaYose-$imyanyaYafashwe;
  $igihe=substr($iyiGenda["date_car_to"], 0, 10);
  $uyuMunsi=date("Y-m-d");
  if ($imyanyaIsigaye>0 && $uyuMunsi<=$igihe && $time24_1>$time24_2 && $lightning==$blackning) {
    @$yegoImodokaZirahari = true;
?>
<?php
?>
        <tr>
            <td><?php echo $kubara++," ".$icyerekezo; ?></td>
            <td><?php echo $iyiGenda["C_Name"]; ?></td>
            <td><?php echo $iyiGenda["Car_Plaque"]; ?></td>
            <td><?php echo $iyiGenda["L_from"]." - ".$iyiGenda['L_to']; ?></td>
            <td><?php echo $iyiGenda["Time_to_leave"]; ?></td>
            <td><?php echo $iyiGenda["price"]; ?> RWF</td>
            <td>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
            <path d="M6.62 10.79a15.091 15.091 0 006.59 6.59l2.2-2.2a1.003 1.003 0 011.11-.27c1.12.45 2.33.69 3.59.69.55 0 1 .45 1 1v3.5c0 .55-.45 1-1 1C10.29 22 2 13.71 2 3c0-.55.45-1 1-1H6.5c.55 0 1 .45 1 1 0 1.26.24 2.47.69 3.59.15.39.05.84-.27 1.11l-2.2 2.2z"/>
            </svg> <?php echo $iyiGenda["C_Phone"]; ?>
            </td>
            <td><a href="booking?booking_form=<?php echo $iyiGenda["id"]; ?>">Get Ticket</a></td>
        </tr>
<?php
  }
}
  }
if (!@$yegoImodokaZirahari) {
  echo '<script>alert("\n\nSorry!\n\nThere is no car going from ' . htmlspecialchars($myLocation1) . ' to ' . htmlspecialchars($myLocation2) . ' available now.")</script>';
  echo '<script>location.href="index"</script>';
}
}
} else {
?>
        <div style="margin-top: 5em;background-color: orange;border-radius: 3px;">
        <form>
          <br><h2>There are no agencies with cars moving from <span style="background-color: black;color: white;border-radius: 3px;"><?php echo $myLocation1."</span> to <span style='background-color: black;color: white;border-radius: 3px;'>".$myLocation2; ?></span> at the moment.</h2><br>
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="index";
        }
        </script>
<?php
}
?>
    </table>
    <br><br>
      </div>
<?php
}

  else {
  ?>
    <section class="booking_body">
<?php
$iziriBugende=mysqli_query($con,"SELECT Cp.*, Cr.*, Lc.*, Ds.*, Ct.*, 
(SELECT COUNT(*) FROM cars_to_leave WHERE Car_Id = Cr.Car_Id) AS imyanya_yafashwe 
FROM company Cp
JOIN cars Cr ON Cp.C_Id = Cr.C_Id
JOIN cars_to_leave Ct ON Cr.Car_Id = Ct.Car_Id
JOIN destination Ds ON Ds.D_Id = Ct.D_Id
JOIN locations Lc ON Lc.L_id = Ds.L_id
ORDER BY CASE 
WHEN SUBSTRING(Time_to_leave, LOCATE(' ', Time_to_leave) + 1, 2) = 'AM' THEN 0 
ELSE 1 
END ASC, 
STR_TO_DATE(Time_to_leave, '%l:%i %p') ASC
") or die(mysqli_error($con));
if (mysqli_num_rows($iziriBugende)>0) {
?>
<?php
$kubara=1;
$Displayed = false;
while($iyiGenda=mysqli_fetch_assoc($iziriBugende)) {
  $imyanyaYose=$iyiGenda["Number_Place"];
  $imyanyaYafashwe=$iyiGenda["imyanya_yafashwe"];
  $isahaIbitswe=$iyiGenda["Time_to_leave"];
  
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
 

  $imyanyaIsigaye=$imyanyaYose-$imyanyaYafashwe;
  $igihe=substr($iyiGenda["date_car_to"], 0, 10);
  $uyuMunsi=date("Y-m-d");
  if ($imyanyaIsigaye>0 && $uyuMunsi<=$igihe && $time24_1>$time24_2) {
    if (!$Displayed) {
?>
     <h1>Available Now</h1>
<div class="booking_cars_table">
    <table>
        <tr>
            <th>N<sup><u>o</u></sup></th>
            <th>Agency</th>
            <th>Plate N<sup><u>o</u></sup></th>
            <th>Location</th>
            <th>Duration</th>
            <th>Price</th>
            <th>Tel</th>
            <th>Order</th>
        </tr>
<?php
$Displayed = true;
    }
?>
        <tr>
            <td><?php echo $kubara++; ?></td>
            <td><?php echo $iyiGenda["C_Name"]; ?></td>
            <td><?php echo $iyiGenda["Car_Plaque"]; ?></td>
            <td><?php echo $iyiGenda["L_from"]." - ".$iyiGenda['L_to']; ?></td>
            <td><?php echo $iyiGenda["Time_to_leave"]; ?></td>
            <td><?php echo $iyiGenda["price"]; ?> RWF</td>
            <td>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
            <path d="M6.62 10.79a15.091 15.091 0 006.59 6.59l2.2-2.2a1.003 1.003 0 011.11-.27c1.12.45 2.33.69 3.59.69.55 0 1 .45 1 1v3.5c0 .55-.45 1-1 1C10.29 22 2 13.71 2 3c0-.55.45-1 1-1H6.5c.55 0 1 .45 1 1 0 1.26.24 2.47.69 3.59.15.39.05.84-.27 1.11l-2.2 2.2z"/>
            </svg> <?php echo $iyiGenda["C_Phone"]; ?>
            </td>
            <td><a href="booking?booking_form=<?php echo $iyiGenda["id"]; ?>">Get Ticket</a></td>
        </tr>
<?php
  } 
  // else {
  //   echo '<script>alert("there is no car available now.")</script>';
  //   echo '<script>location.href="index"</script>';
  // }
}
}?>
        </table>
      </div>
    </section>
  <?php
  }
  ?>

  <section>
    <footer class="footer">
      <div class="footer-container">
        <div class="footer-contaner-up">
          <div class="footer-col-holder">
            <div class="col-footer">
              <h3>Company</h3>
              <ul>
                <li><a href="#">Booking </a></li>
                <li><a href="#">Agencies</a></li>
                <li><a href="#">Destinations</a></li>
                <li><a href="#">Routes</a></li>
                <li><a href="#">Working Days</a></li>
              </ul>
            </div>
            <div class="col-footer">
              <h3>Useful links</h3>
              <ul>
                <li><a href="#">Book Now</a></li>
                <li><a href="#">Reach Us</a></li>
                <li><a href="#">Be a Partner</a></li>
              </ul>
            </div>
          </div>

          <div class="footer-col-holder">
            <div class="col-footer footer-display-none">
              <h3>Our Services</h3>
              <ul>
                <li><a href="#">New Cars</a></li>
                <li><a href="#">Our Services</a></li>
              </ul>
            </div>
            <div class="col-footer">
              <h3>Newsletter</h3>
              <div class="footer-form">
                <h4>Updates and Offers.</h4>
                <form action="#" class="subscribe" method="post">
                  <input
                    type="email"
                    name="email"
                    placeholder="Email Address"
                    required=""
                  />
                  <button type="submit">Go</button>
                </form>
                <p>
                  Write us your email and we'll keep you updated on new tours and
                  places.
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-line"></div>
        <div class="footer-container-down">
          <div class="footer-text-left">
            <p>2024 Online Bus Tickets. All rights reserved!</p>
          </div>
          <ul class="footer-social">
            <li>
              <a href="#facebook"><i class="bx bxl-facebook-circle"></i></a>
            </li>
            <li>
              <a href="#linkedin"><i class="bx bxl-linkedin"></i></a>
            </li>
            <li>
              <a href="#twitter"><box-icon type="logo" name="twitter"></box-icon></a>
            </li>
            <li>
              <a href="#google"><i class="bx bxl-gmail"></i></a>
            </li>
            <li>
              <a href="#github"><i class="bx bxl-github"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </footer>
  </section>
  <script src="../js/scroll.js"></script>
</body>
</html>
