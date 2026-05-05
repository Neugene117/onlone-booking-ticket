<?php
session_start(); // Start the session
include 'connection.php';
//Login Function?>
<link rel="stylesheet" href="./css/agency_panel.css" />
<?php
function generateTicketCode($con) {
  $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
  $max = strlen($characters) - 1;
  for ($attempt = 0; $attempt < 30; $attempt++) {
    $code = '';
    for ($i = 0; $i < 5; $i++) {
      $code .= $characters[random_int(0, $max)];
    }
    $safeCode = mysqli_real_escape_string($con, $code);
    $check = mysqli_query($con, "SELECT B_Id FROM booking WHERE Ticket_Code='$safeCode' LIMIT 1");
    if ($check && mysqli_num_rows($check) === 0) {
      return $code;
    }
  }
  return strtoupper(substr(md5(uniqid((string)mt_rand(), true)), 0, 5));
}

function location(){
    global $con;
    if(isset($_POST['add_dest'])){
       $f= mysqli_real_escape_string($con,htmlspecialchars($_POST['from']));
       $t= mysqli_real_escape_string($con,htmlspecialchars($_POST['to']));
       $a= mysqli_real_escape_string($con,htmlspecialchars($_POST['price']));
       $query=mysqli_query($con,"INSERT INTO locations(L_id,L_from,L_to,price)VALUES(NULL,'$f','$t','$a')");
       if($query==1){
        ?>
        
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Destination Added successfull </h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="admin_panel?locations";
        }
        
        </script>
        <?php
       }
       else{
        ?>
         <script>
        function gusubiraInyuma() {
          location.href="admin_panel?location";
        }
        </script>
        <?php
       }
    }
}
location();
function buyticket(){
  global $con;
  if(isset($_POST['byy'])){
    $price=(int) mysqli_real_escape_string($con, htmlspecialchars($_POST['price']));
    $C_Phone=mysqli_real_escape_string($con, htmlspecialchars($_POST['C_Phone']));
    $nam=mysqli_real_escape_string($con, htmlspecialchars($_POST['P_name']));
    $pn=mysqli_real_escape_string($con, htmlspecialchars($_POST['phone']));
    $eml=mysqli_real_escape_string($con, htmlspecialchars($_POST['email']));
    $ide=(int) mysqli_real_escape_string($con, htmlspecialchars($_POST['idd']));
    $seatCount = 1;
    $seatNumber=(int) mysqli_real_escape_string($con, htmlspecialchars($_POST['seat_number'] ?? 0));
    if($seatNumber < 1){
      ?>
      <div class="agency_cars_creation_form" style="margin-top: 5em;">
      <form>
        <h2>Please select a seat before booking.</h2>
        <input type="button" class="agency_send_button" value="BACK" onclick="gusubiraInyuma()">
      </form>
      </div>
      <script>
      function gusubiraInyuma() {
        location.href="booking?booking_form=<?php echo $ide; ?>";
      }
      </script>
      <?php
      return;
    }

    $availabilitySql = "SELECT cr.Number_Place, COALESCE(SUM(b.Seat_Count), 0) AS booked_seats
                        FROM cars_to_leave ct
                        INNER JOIN cars cr ON cr.Car_Id = ct.Car_Id
                        LEFT JOIN booking b ON b.Id = ct.id
                        WHERE ct.id = '$ide'
                        GROUP BY ct.id, cr.Number_Place";
    $availabilityResult = mysqli_query($con, $availabilitySql);
    $availability = mysqli_fetch_assoc($availabilityResult);
    $totalSeats = (int)($availability['Number_Place'] ?? 0);
    $bookedSeats = (int)($availability['booked_seats'] ?? 0);
    $remainingSeats = $totalSeats - $bookedSeats;

    if($totalSeats <= 0 || $seatCount > $remainingSeats || $seatNumber > $totalSeats){
      ?>
      <div class="agency_cars_creation_form" style="margin-top: 5em;">
      <form>
        <h2>Sorry, this seat is not available. Only <?php echo max(0, $remainingSeats); ?> seat(s) remain.</h2>
        <input type="button" class="agency_send_button" value="BACK" onclick="gusubiraInyuma()">
      </form>
      </div>
      <script>
      function gusubiraInyuma() {
        location.href="booking?booking_form=<?php echo $ide; ?>";
      }
      </script>
      <?php
      return;
    }

    $seatTaken = mysqli_query($con, "SELECT B_Id FROM booking WHERE Id='$ide' AND Seat_Number='$seatNumber' LIMIT 1");
    if($seatTaken && mysqli_num_rows($seatTaken) > 0){
      ?>
      <div class="agency_cars_creation_form" style="margin-top: 5em;">
      <form>
        <h2>Seat <?php echo $seatNumber; ?> has already been selected. Please choose another seat.</h2>
        <input type="button" class="agency_send_button" value="CHOOSE AGAIN" onclick="gusubiraInyuma()">
      </form>
      </div>
      <script>
      function gusubiraInyuma() {
        location.href="booking?booking_form=<?php echo $ide; ?>";
      }
      </script>
      <?php
      return;
    }

    $ticketCode = generateTicketCode($con);
    $safeTicketCode = mysqli_real_escape_string($con, $ticketCode);
    $i="INSERT INTO booking (B_Id,P_Names,P_Phone,P_Email,Id,Seat_Count,Seat_Number,Ticket_Code,activityi) VALUES(NULL,'$nam','$pn','$eml','$ide','$seatCount','$seatNumber','$safeTicketCode','wait...')";
    $ql=mysqli_query($con,$i);
    if($ql==true){
      $totalPayment = $price * $seatCount;
    ?>
        
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
        <h3 id="billing-title" style="color: #a52a2a;font-style: italic;">Thank you. We've sent the ticket to your email. Please wait for it to be activated after we verify your payment.</h3>
              <div>
                <p><strong>FOLLOW THE INSTRUCTIONS BELOW TO SEND YOUR PAYMENT:</strong></p>
                <br><p><b>Ticket Number:</b> <?php echo $ticketCode; ?></p>
                <br><p><b>Seat Number:</b> <?php echo $seatNumber; ?></p>
                <br><p><b>Total Payment:</b> <?php echo number_format($totalPayment); ?> RWF</p>
                <br><p><b>A.</b> Send your payment to our Mobile Money Marchant code: <b>Dial *182*1*1*<?php echo $C_Phone; ?>*<?php echo $totalPayment; ?>*YOUR PIN#</b></p>
                <br><p><b>B.</b> Please use a Mobile Money account registered under your name. Do not use someone else's account.</p>
                <br><p><i><b>Dial *182*1*1*<?php echo $C_Phone; ?>*<?php echo $totalPayment; ?>*YOUR PIN#</b></i></p>
              </div>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="booking";
        }
        
        </script>
        
        <?php
       } 
       else{
        if (mysqli_errno($con) == 1062) {
    ?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Seat <?php echo $seatNumber; ?> has just been taken. Please choose another seat.</h2>
          <input type="button" class="agency_send_button" value="CHOOSE AGAIN" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="booking?booking_form=<?php echo $ide; ?>";
        }
        </script>
        <?php
        return;
        }
    ?>
        
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Ticket Are Not sended<br> pleas TRY Again </h2>
          <input type="button" class="agency_send_button" value="TRY" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="booking";
        }
        
        </script>
        <?php
       } 

  }
}
buyticket();
function feedback(){
  global $con;
  if(isset($_POST['feed'])){
    $n=$_POST['nam'];
    $em=$_POST['email'];
    $sub=$_POST['subject'];
    $co=$_POST['message'];
    $ins="INSERT INTO feedback VALUES(NULL,'$n','$em','$sub','$co')";
    $query=mysqli_query($con,$ins);
    if($query==true){
      ?>
      <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Comment Are  Delivered </h2>
          <input type="button" class="agency_send_button" value="Next" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="contactUs";
        }
        
        </script>
      <?php
    }
    else {
      echo "data are not inserted";
    }
  }
}
feedback();
?>
