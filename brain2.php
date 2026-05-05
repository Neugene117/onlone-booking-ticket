<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['a49r-aN3c03639dr92Cb1cK6cb^6bf494035c05a%4eC1ddQa61c9d552*Pdu34d1e4e85992ba+bR3Pe5f6g8d0664/055758e06707127h8ij0klrLb9db021bTQ0bf0a6H'])) {
    echo '<script>location.href="index"</script>';
    exit;
}
$user_id = $_SESSION['a49r-aN3c03639dr92Cb1cK6cb^6bf494035c05a%4eC1ddQa61c9d552*Pdu34d1e4e85992ba+bR3Pe5f6g8d0664/055758e06707127h8ij0klrLb9db021bTQ0bf0a6H'];
$get_user_id = mysqli_query($con, "SELECT * FROM company WHERE C_Id = $user_id");
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
<link rel="stylesheet" href="./css/agency_panel.css" />


<?php
function add_car() {
    global $con,$user_id;
    if (isset($_POST["C_Add_Car"])) {
        echo '<title>Rwanda-Bus || Add Car</title>';
        $Car_Plaque = mysqli_real_escape_string($con, htmlspecialchars($_POST['Car_Plaque']));
        $Car_Driver = mysqli_real_escape_string($con, htmlspecialchars($_POST['C_Driver']));
        $C_Id = mysqli_real_escape_string($con, htmlspecialchars($user_id));
        $Number_Place = mysqli_real_escape_string($con, htmlspecialchars($_POST['Number_Place']));
            $check_Plaque = mysqli_query($con,"SELECT Car_Plaque FROM cars WHERE Car_Plaque='$Car_Plaque' OR Emp_Id='$Car_Driver'") or die(mysqli_error($con));
            if (mysqli_num_rows($check_Plaque) == 0) {
                $kwinjiza=mysqli_query($con,"INSERT INTO cars VALUES(NULL,'$Car_Plaque','$C_Id','$Number_Place','$Car_Driver')") or die(mysqli_error($con));
                if ($kwinjiza == true) {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form onclick="gusubiraInyuma()">
        <h2>Well, a new car with the plate number <span style="background-color: black; color: white; border-radius: 3px;"><?php echo $Car_Plaque; ?></span> has been added.</h2>
          <input type="button" class="agency_send_button" value="CONTINUE">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?add_cars";
        }
        </script>
<?php
                } else {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry, something went wrong. Please try again later.</h2>
          <input type="button" class="agency_send_button" value="Okay" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?add_cars";
        }
        </script>
<?php
        }
            } else {
              $check_CarInfo = mysqli_query($con,"SELECT * FROM cars WHERE Car_Plaque='$Car_Plaque' OR Emp_Id='$Car_Driver'") or die(mysqli_error($con));
              if (mysqli_num_rows($check_Plaque) > 0) {
                while($iyiModoka=mysqli_fetch_assoc($check_CarInfo)){
                  $plateNumber=$iyiModoka["Car_Plaque"];
                  $driverId=$iyiModoka["Emp_Id"];
                }
              }
              if ($Car_Plaque==$plateNumber) {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
           <h2>Sorry, the car with plate number <u><i><?php echo $Car_Plaque; ?></i></u> has already been added.</h2>
          <input type="button" class="agency_send_button" value="CLOSE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?add_cars";
        }
        </script>
<?php
              } else if ($driverId==$Car_Driver) {
?>
<div class="agency_cars_creation_form" style="margin-top: 5em;">
<form>
   <h2>Sorry, Driver has already been added to another car.</h2>
  <input type="button" class="agency_send_button" value="CLOSE" onclick="gusubiraInyuma()">
</form>
</div>
<script>
function gusubiraInyuma() {
  location.href="agency_panel?add_cars";
}
</script>
<?php
              }
            }
    }
}
add_car();


function update_driver() {
    global $con,$user_id;
    if (isset($_POST["U_Add_Driver"])) {
        echo '<title>Rwanda-Bus || Update Driver</title>';
        $C_Id = mysqli_real_escape_string($con, htmlspecialchars($user_id));
        $iShoferi = mysqli_real_escape_string($con, htmlspecialchars($_POST['iShoferi']));
        $Emp_Fname = mysqli_real_escape_string($con, htmlspecialchars($_POST['Emp_Fname']));
        $Emp_Lname = mysqli_real_escape_string($con, htmlspecialchars($_POST['Emp_Lname']));
        $Emp_Phone = mysqli_real_escape_string($con, htmlspecialchars($_POST['Emp_Phone']));
        $Emp_Idcard = mysqli_real_escape_string($con, htmlspecialchars($_POST['Emp_Idcard']));
        $check_DriverInfo = mysqli_query($con, "SELECT Emp_Phone, Emp_Idcard FROM employeers WHERE (Emp_Phone='$Emp_Phone' OR Emp_Idcard='$Emp_Idcard') AND C_Id != '$user_id'") or die(mysqli_error($con));
            if (mysqli_num_rows($check_DriverInfo) == 0) {
  
              $check_EmpPhone = mysqli_query($con, "SELECT Emp_Phone FROM employeers WHERE Emp_Phone='$Emp_Phone' AND Emp_Id!='$iShoferi' AND C_Id = '$user_id' LIMIT 1") or die(mysqli_error($con));
                   $myEmpPhone=mysqli_fetch_assoc( $check_EmpPhone);
  
                      $check_EmpIdcard = mysqli_query($con, "SELECT Emp_Idcard FROM employeers WHERE Emp_Idcard='$Emp_Idcard' AND Emp_Id!='$iShoferi' AND C_Id = '$user_id' LIMIT 1") or die(mysqli_error($con));
                           $myEmpIdcard=mysqli_fetch_assoc( $check_EmpIdcard);
  
              if($Emp_Phone==@$myEmpPhone["Emp_Phone"]){
  ?>
  <div class="agency_cars_creation_form" style="margin-top: 5em;">
  <form>
    <h2>Sorry, Phone number already used by other driver.</h2>
    <input type="button" class="agency_send_button" value="BACK" onclick="gusubiraInyuma()">
  </form>
  </div>
  <script>
  function gusubiraInyuma() {
    location.href="agency_panel?upDriver=<?php echo $iShoferi; ?>";
  }
  </script>
  <?php
              } else if($Emp_Idcard==@$myEmpIdcard["Emp_Idcard"]){
  ?>
  <div class="agency_cars_creation_form" style="margin-top: 5em;">
  <form>
    <h2>Sorry, National Identity already used by other driver.</h2>
    <input type="button" class="agency_send_button" value="BACK" onclick="gusubiraInyuma()">
  </form>
  </div>
  <script>
  function gusubiraInyuma() {
    location.href="agency_panel?upDriver=<?php echo $iShoferi; ?>";
  }
  </script>
  <?php
              } else {
                $kwinjiza=mysqli_query($con,"UPDATE employeers SET Emp_Fname='$Emp_Fname',Emp_Lname='$Emp_Lname',Emp_Phone='$Emp_Phone',Emp_Idcard='$Emp_Idcard' WHERE C_Id='$C_Id' AND Emp_Id='$iShoferi'") ;
                if ($kwinjiza == true) {
  ?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form onclick="gusubiraInyuma()">
        <h2>Well, a driver  updated successful.</h2>
          <input type="button" class="agency_send_button" value="CONTINUE">
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
          <input type="button" class="agency_send_button" value="Okay" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?upDriver=<?php echo $iShoferi; ?>";
        }
        </script>
  <?php
        }
      }
            } else {
  ?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
           <h2>
            Sorry, a driver with
            <?php
            $check_idcard_phone = mysqli_query($con,"SELECT * FROM employeers WHERE (Emp_Phone='$Emp_Phone' OR Emp_Idcard='$Emp_Idcard') AND C_Id!='$user_id'") or die(mysqli_error($con));
            if (mysqli_num_rows($check_idcard_phone) > 0) {
              $checked_idcard_phone = mysqli_fetch_assoc($check_idcard_phone);
              $D_Phone = $checked_idcard_phone["Emp_Phone"];
              $D_Idcard = $checked_idcard_phone["Emp_Idcard"];
              $D_C_Id = $checked_idcard_phone["C_Id"];
            }
            if ($Emp_Phone == $D_Phone && $Emp_Idcard == $D_Idcard) {
              echo "the phone number <span style='background-color: orange; color: white; border-radius: 3px;'>$D_Phone </span> and national identity <span style='background-color: orange; color: white; border-radius: 3px;'> $D_Idcard</span>";
            } else if ($Emp_Phone == $D_Phone) {
              echo "the phone number <span style='background-color: orange; color: white; border-radius: 3px;'>$D_Phone</span>";
            } else {
              echo "the national identity <span style='background-color: orange; color: white; border-radius: 3px;'>$D_Idcard</span>";
            }
            $check_C_Name = mysqli_query($con,"SELECT C_Name FROM company WHERE C_Id='$D_C_Id'") or die(mysqli_error($con));
            if (mysqli_num_rows($check_C_Name) > 0) {
              $checked_C_Name = mysqli_fetch_assoc($check_C_Name);
              $C_C_Name = $checked_C_Name['C_Name'];
            }
            echo " has already been added by <span style='background-color: black; color: white; border-radius: 3px;'>".$C_C_Name." agency</span>.";
            ?>
          </h2>
          <input type="button" class="agency_send_button" value="BACK" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?upDriver=<?php echo $iShoferi; ?>";
        }
        </script>
  <?php
            }
    }
  }
  update_driver();


function update_car() {
    global $con,$user_id;
    if (isset($_POST["U_Add_Car"])) {
        echo '<title>Rwanda-Bus || Update Car</title>';
        $back = mysqli_real_escape_string($con, htmlspecialchars($_POST['back']));
        $idImodoka = mysqli_real_escape_string($con, htmlspecialchars($_POST['idImodoka']));
        $Car_Plaque = mysqli_real_escape_string($con, htmlspecialchars($_POST['Car_Plaque']));
        $Car_Driver = mysqli_real_escape_string($con, htmlspecialchars($_POST['C_Driver']));
        $C_Id = mysqli_real_escape_string($con, htmlspecialchars($user_id));
        $Number_Place = mysqli_real_escape_string($con, htmlspecialchars($_POST['Number_Place']));
        $check_carInfo = mysqli_query($con,"SELECT Car_Plaque, Emp_Id FROM cars WHERE (Car_Plaque='$Car_Plaque' OR Emp_Id='$Car_Driver') AND C_Id != '$user_id'") or die(mysqli_error($con));
        if (mysqli_num_rows($check_carInfo) == 0) {

              $check_Plaque = mysqli_query($con,"SELECT Car_Plaque FROM cars WHERE Car_Plaque='$Car_Plaque' AND Car_Id!='$idImodoka' AND C_Id = '$user_id' LIMIT 1") or die(mysqli_error($con));
                $myPlaque=mysqli_fetch_assoc($check_Plaque);

                  $check_Emp = mysqli_query($con,"SELECT Emp_Id FROM cars WHERE Emp_Id='$Car_Driver' AND Car_Id!='$idImodoka' AND C_Id = '$user_id' LIMIT 1") or die(mysqli_error($con));
                    $myEmp=mysqli_fetch_assoc($check_Emp);

                  if ($Car_Plaque==@$myPlaque["Car_Plaque"]) {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry, a plate number <span style="background-color: black;color: white;border-radius: 3px;"><?php echo $myPlaque["Car_Plaque"]; ?></span> already regestered to another car.</h2>
          <input type="button" class="agency_send_button" value="BACK" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?upCar=<?php echo $back; ?>";
        }
        </script>
<?php
                  } else if ($Car_Driver==@$myEmp["Emp_Id"]) {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry, a driver already registered to another car.</h2>
          <input type="button" class="agency_send_button" value="BACK" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?upCar=<?php echo $back; ?>";
        }
        </script>
<?php
                  } else {
                $kwinjiza=mysqli_query($con,"UPDATE cars SET Car_Plaque='$Car_Plaque',Number_Place='$Number_Place',Emp_Id='$Car_Driver' WHERE 	Car_Id='$idImodoka ' AND C_Id='$user_id'") or die(mysqli_error($con));
                if ($kwinjiza == true) {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form onclick="gusubiraInyuma()">
        <h2>Well, a car updated successful.</h2>
          <input type="button" class="agency_send_button" value="CONTINUE">
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
          <input type="button" class="agency_send_button" value="BACK" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?upCar=<?php echo $back; ?>";
        }
        </script>
<?php
        }
      }
            } else {
              $check_CarInfo = mysqli_query($con,"SELECT * FROM cars WHERE (Car_Plaque='$Car_Plaque' OR Emp_Id='$Car_Driver') AND C_Id!='$user_id'") or die(mysqli_error($con));
              if (mysqli_num_rows($check_CarInfo) > 0) {
                while($iyiModoka=mysqli_fetch_assoc($check_CarInfo)){
                  $plateNumber=$iyiModoka["Car_Plaque"];
                  $driverId=$iyiModoka["Emp_Id"];
                }
              }
              if ($Car_Plaque==$plateNumber) {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
           <h2>Sorry, the car with plate number <u><i><?php echo $Car_Plaque; ?></i></u> has already been added.</h2>
          <input type="button" class="agency_send_button" value="BACK" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?upCar=<?php echo $back; ?>";
        }
        </script>
<?php
              } else if ($driverId==$Car_Driver) {
?>
<div class="agency_cars_creation_form" style="margin-top: 5em;">
<form>
   <h2>Sorry, Driver has already been added to another car.</h2>
  <input type="button" class="agency_send_button" value="CLOSE" onclick="gusubiraInyuma()">
</form>
</div>
<script>
function gusubiraInyuma() {
  location.href="agency_panel?upCar=<?php echo $back; ?>";
}
</script>
<?php
              }
            }
    }
}
update_car();

function update_destination() {
    global $con,$user_id;
    if (isset($_POST["U_destination"])) {
        echo '<title>Rwanda-Bus || Update Destination</title>';
        $D_Id = mysqli_real_escape_string($con, htmlspecialchars($_POST['D_Id']));
        $L_id = mysqli_real_escape_string($con, htmlspecialchars($_POST['L_id']));
        $C_Destination = mysqli_real_escape_string($con, htmlspecialchars($_POST['c_destination']));
        $C_Id = mysqli_real_escape_string($con, htmlspecialchars($user_id));
        $check_Destination = mysqli_query($con,"SELECT L_id FROM destination WHERE L_id='$C_Destination' AND C_Id='$user_id'") or die(mysqli_error($con));
        if (mysqli_num_rows($check_Destination) == 0) {
        $kwinjiza=mysqli_query($con,"UPDATE destination SET L_id='$C_Destination' WHERE D_Id='$D_Id' AND C_Id='$C_Id'") or die(mysqli_error($con));
        if ($kwinjiza == true) {
          $allDestinations=mysqli_query($con,"SELECT * FROM locations WHERE L_id='$C_Destination'") or die(mysqli_error($con));
          if(mysqli_num_rows($allDestinations)>0){
            while($destination=mysqli_fetch_assoc($allDestinations)){
              $icyerekezo=$destination["L_from"]." to ".$destination["L_to"];
              $igiciro=$destination["price"];
            }
          }
  ?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
        <h2>Success! The destination from <span style="text-transform: capitalize;background-color: black;color: white;border-radius: 3px;"><?php echo $icyerekezo ?></span> with a cost of <span style="text-transform: capitalize;background-color: black;color: white;border-radius: 3px;">Rwf <?php echo $igiciro; ?></span> was set.</h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
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
          location.href="agency_panel?upDestination=<?php echo $L_id; ?>";
        }
        </script>
  <?php
                }
              } else {
                $check_Destination = mysqli_query($con,"SELECT * FROM locations WHERE L_id='$C_Destination'") or die(mysqli_error($con));
                if (mysqli_num_rows($check_Destination) > 0) {
                  while($destination=mysqli_fetch_assoc($check_Destination)){
                    $icyerekezo=$destination["L_from"]." to ".$destination["L_to"];
                  }
                }
  ?>
          <div class="agency_cars_creation_form" style="margin-top: 5em;">
          <form>
             <h2>Sorry, the destination from <i style="background-color: black;color: white;text-transform: capitalize;"><?php echo $icyerekezo; ?></i> has already been added.</h2>
            <input type="button" class="agency_send_button" value="BACK" onclick="gusubiraInyuma()">
          </form>
          </div>
          <script>
          function gusubiraInyuma() {
            location.href="agency_panel?upDestination=<?php echo $L_id; ?>";
          }
          </script>
  <?php
              }
    }
  }
  update_destination();



###<===---------------> > >---(01) BRIDGE (01)---< < <---------------===>###


function add_driver() {
    global $con,$user_id;
    if (isset($_POST["C_Add_Driver"])) {
        echo '<title>Rwanda-Bus || Add Driver</title>';
        $C_Id = mysqli_real_escape_string($con, htmlspecialchars($user_id));
        $Emp_Fname = mysqli_real_escape_string($con, htmlspecialchars($_POST['Emp_Fname']));
        $Emp_Lname = mysqli_real_escape_string($con, htmlspecialchars($_POST['Emp_Lname']));
        $Emp_Phone = mysqli_real_escape_string($con, htmlspecialchars($_POST['Emp_Phone']));
        $Emp_Idcard = mysqli_real_escape_string($con, htmlspecialchars($_POST['Emp_Idcard']));
        
            $check_idcard_phone = mysqli_query($con,"SELECT Emp_Phone,Emp_Idcard FROM employeers WHERE Emp_Phone='$Emp_Phone' OR Emp_Idcard='$Emp_Idcard'") or die(mysqli_error($con));
            if (mysqli_num_rows($check_idcard_phone) == 0) {
                $kwinjiza=mysqli_query($con,"INSERT INTO employeers VALUES(NULL,'$Emp_Fname','$Emp_Lname','$Emp_Phone','$Emp_Idcard','$C_Id')") or die(mysqli_error($con));
                if ($kwinjiza == true) {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form onclick="gusubiraInyuma()">
        <h2>Well, a driver with the phone number <span style="background-color: orange; color: white; border-radius: 3px;"><?php echo $Emp_Phone; ?></span> and national identity <span style="background-color: orange; color: white; border-radius: 3px;"><?php echo $Emp_Idcard; ?></span> has been added.</h2>
          <input type="button" class="agency_send_button" value="CONTINUE">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?add_drivers";
        }
        </script>
<?php
                } else {
?>

        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry, something went wrong. Please try again later.</h2>
          <input type="button" class="agency_send_button" value="Okay" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?add_drivers";
        }
        </script>
<?php
        }
            } else {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
           <h2>
            Sorry, a driver with
            <?php
            $check_idcard_phone = mysqli_query($con,"SELECT * FROM employeers WHERE Emp_Phone='$Emp_Phone' OR Emp_Idcard='$Emp_Idcard'") or die(mysqli_error($con));
            if (mysqli_num_rows($check_idcard_phone) > 0) {
              $checked_idcard_phone = mysqli_fetch_assoc($check_idcard_phone);
              $D_Phone = $checked_idcard_phone["Emp_Phone"];
              $D_Idcard = $checked_idcard_phone["Emp_Idcard"];
              $D_C_Id = $checked_idcard_phone["C_Id"];
            }
            if ($Emp_Phone == $D_Phone && $Emp_Idcard == $D_Idcard) {
              echo "the phone number <span style='background-color: orange; color: white; border-radius: 3px;'>$D_Phone </span> and national identity <span style='background-color: orange; color: white; border-radius: 3px;'> $D_Idcard</span>";
            } else if ($Emp_Phone == $D_Phone) {
              echo "the phone number <span style='background-color: orange; color: white; border-radius: 3px;'>$D_Phone</span>";
            } else {
              echo "the national identity <span style='background-color: orange; color: white; border-radius: 3px;'>$D_Idcard</span>";
            }
            $check_C_Name = mysqli_query($con,"SELECT C_Name FROM company WHERE C_Id='$D_C_Id'") or die(mysqli_error($con));
            if (mysqli_num_rows($check_C_Name) > 0) {
              $checked_C_Name = mysqli_fetch_assoc($check_C_Name);
              $C_C_Name = $checked_C_Name['C_Name'];
            }
            echo " has already been added by <span style='background-color: black; color: white; border-radius: 3px;'>".$C_C_Name." agency</span>.";
            ?>
          </h2>
          <input type="button" class="agency_send_button" value="TRY AGAIN" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?add_drivers";
        }
        </script>
<?php
            }
    }
}
add_driver();


###<===---------------> > >---(02) BRIDGE (02)---< < <---------------===>###

function add_destination() {
    global $con,$user_id;
    if (isset($_POST["add_destination"])) {
        echo '<title>Rwanda-Bus || Add Destination</title>';
        $C_Destination = mysqli_real_escape_string($con, htmlspecialchars($_POST['c_destination']));
        $C_Id = mysqli_real_escape_string($con, htmlspecialchars($user_id));
        $check_Destination = mysqli_query($con,"SELECT L_id FROM destination WHERE L_id='$C_Destination' AND C_Id='$user_id'") or die(mysqli_error($con));
        if (mysqli_num_rows($check_Destination) == 0) {
        $kwinjiza=mysqli_query($con,"INSERT INTO destination VALUES(NULL,'$C_Destination','$C_Id')") or die(mysqli_error($con));
        if ($kwinjiza == true) {
          $allDestinations=mysqli_query($con,"SELECT * FROM locations WHERE L_id='$C_Destination'") or die(mysqli_error($con));
          if(mysqli_num_rows($allDestinations)>0){
            while($destination=mysqli_fetch_assoc($allDestinations)){
              $icyerekezo=$destination["L_from"]." to ".$destination["L_to"];
              $igiciro=$destination["price"];
            }
          }
  ?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
        <h2>Successful! The destination from <span style="text-transform: capitalize;background-color: black;color: white;border-radius: 3px;"><?php echo $icyerekezo ?></span> with a cost of <span style="text-transform: capitalize;background-color: black;color: white;border-radius: 3px;">Rwf <?php echo $igiciro; ?></span>, has been added.</h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?add_destinations";
        }
        </script>
  <?php
                } else {
  ?>
  
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry, something went wrong. Please try again later.</h2>
          <input type="button" class="agency_send_button" value="Okay" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?add_destinations";
        }
        </script>
  <?php
                }
              } else {
                $check_Destination = mysqli_query($con,"SELECT * FROM locations WHERE L_id='$C_Destination'") or die(mysqli_error($con));
                if (mysqli_num_rows($check_Destination) > 0) {
                  while($destination=mysqli_fetch_assoc($check_Destination)){
                    $icyerekezo=$destination["L_from"]." to ".$destination["L_to"];
                  }
                }
  ?>
          <div class="agency_cars_creation_form" style="margin-top: 5em;">
          <form>
             <h2>Sorry, the destination from <i style="background-color: black;color: white;text-transform: capitalize;"><?php echo $icyerekezo; ?></i> has already been added.</h2>
            <input type="button" class="agency_send_button" value="CLOSE" onclick="gusubiraInyuma()">
          </form>
          </div>
          <script>
          function gusubiraInyuma() {
            location.href="agency_panel?add_destinations";
          }
          </script>
  <?php
              }
    }
  }
  add_destination();


//start send car to leave
function car_to_leale(){
  global $con,$user_id;
  if(isset($_POST['add_tleave_car'])){
    $cd=mysqli_real_escape_string($con, htmlspecialchars($_POST['C_id']));
    $destin=mysqli_real_escape_string($con, htmlspecialchars($_POST['c_destination']));
    $hr=mysqli_real_escape_string($con, htmlspecialchars($_POST['hr']));
    $mn=mysqli_real_escape_string($con, htmlspecialchars($_POST['min']));
    $ap=mysqli_real_escape_string($con, htmlspecialchars($_POST['ap']));
    $tim=$hr.":".$mn." ".$ap;
    $i="INSERT INTO cars_to_leave VALUES(NULL,'$cd','$destin','$tim',NULL,NULL)";
    $q=mysqli_query($con,$i);
    if($q==true){
      ?>
      <div class="agency_cars_creation_form" style="margin-top: 5em;">
      <form>
      <h2>Car To leav Already Are <br>Successful!  <span style="text-transform: capitalize;background-color: black;color: white;border-radius: 3px;">
        <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
      </form>
      </div>
      <script>
      function gusubiraInyuma() {
        location.href="agency_panel?add_car_to_leave";
      }
      </script>

      <?php
    }
    else{
      echo "Data are not inserted";
    }
    
  }

}
car_to_leale();
//end to send car to leave
###<===---------------> > >---(03) BRIDGE (03)---< < <---------------===>###

function change_password() {
  global $con,$user_id,$user_info;
  if (isset($_POST["hinduraIbanga"])) {
    $ibanga1 = mysqli_real_escape_string($con, htmlspecialchars($_POST["ibanga1"]));
    $ibanga3 = mysqli_real_escape_string($con, htmlspecialchars($_POST["ibanga3"]));
    if ($ibanga3!=$user_info["C_Password"]) {
    $rebaIbangaRisanzwe=mysqli_query($con,"SELECT C_Password FROM company WHERE C_Password='$ibanga1' AND C_Id='$user_id'") or die(mysqli_error($con));
    if (mysqli_num_rows($rebaIbangaRisanzwe)>0) {
      $yegoHinduraIjamboBanga=mysqli_query($con,"UPDATE company SET C_Password='$ibanga3' WHERE C_Password='$ibanga1' AND C_Id='$user_id'") or die(mysqli_error($con));
      if ($yegoHinduraIjamboBanga==true) {
?>
<body onmousemove="gusubiraInyuma()"></body>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Success! Your password has been changed successful.</h2>
          <input type="button" class="agency_send_button" value="NEXT" onmousemove="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="signout";
        }
        </script>
<?php
      } else {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry, Something Went Wrnong.</h2>
          <input type="button" class="agency_send_button" value="TRY AGAIN" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?change_password";
        }
        </script>
<?php
      }
    } else {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Incorrect Current Password</h2>
          <input type="button" class="agency_send_button" value="TRY AGAIN" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?change_password";
        }
        </script>
<?php
    }
  } else {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry, You must use new password.</h2>
          <input type="button" class="agency_send_button" value="TRY AGAIN" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="agency_panel?change_password";
        }
        </script>
<?php
  }
  }
}
change_password();



###<===---------------> > >---(Final) BRIDGE (Final)---< < <---------------===>###


?>


