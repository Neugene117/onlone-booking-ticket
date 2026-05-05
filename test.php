This condition    else if($lightning!=$blackning){
    echo "<h1>There is no cars are available.</h1>";
  } not work to the following codes


  if (isset($_GET["selectedLocation"])) {
  $thisLocation = stripslashes($_GET["selectedLocation"]);
  $thisLocation = mysqli_real_escape_string($con, htmlspecialchars($_GET["selectedLocation"]));
  list($myLocation1,$myLocation2)=explode("icyerekezo",$thisLocation);
?>
<?php
$ahantu=mysqli_query($con,"SELECT * FROM locations WHERE L_from='$myLocation1' AND L_to='$myLocation2'") or die(mysqli_error($con));
$hanoHantu=mysqli_fetch_assoc($ahantu);
@$icyerekezo = $hanoHantu["L_id"];
$imodokaZijyayo=mysqli_query($con,"SELECT * FROM destination WHERE L_id='$icyerekezo'") or die(mysqli_error($con));
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
  } else if($lightning!=$blackning){
    echo "<h1>There is no cars are available.</h1>";
  }
}
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