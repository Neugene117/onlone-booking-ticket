<?php
require 'connection.php';
?>
<link rel="stylesheet" href="./css/agency_panel.css" />
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function signin(){
  global $con;
session_start();
  if (isset($_POST["S_C_Sigin"])) {
    echo '<title>Rwanda-Bus || Sign In</title>';
      $S_C_Username = stripslashes($_REQUEST['S_C_Username']);
      $S_C_Password = stripslashes($_REQUEST['S_C_Password']);
      
      $S_C_Username = mysqli_real_escape_string($con, htmlspecialchars($S_C_Username));
      $S_C_Password = mysqli_real_escape_string($con, htmlspecialchars($S_C_Password));
      
      $get_user_Admin = mysqli_query($con,"SELECT * FROM system_controller WHERE S_Username='$S_C_Username' AND S_Password='$S_C_Password' AND Rolee='admini'");
      if (mysqli_num_rows($get_user_Admin) > 0) {
        $user_info = mysqli_fetch_assoc($get_user_Admin);
          $_SESSION['7pdB7689Gf4jkgjkgyggjGFJKHYHkiopu66789403'] = $user_info['S_Id'];
          echo '<script>location.href="admin_panel"</script>';
      } else {
          $get_user_info = mysqli_query($con,"SELECT * FROM company WHERE C_Username='$S_C_Username' AND C_Password='$S_C_Password'");
          if (mysqli_num_rows($get_user_info) > 0) {
            $user_info = mysqli_fetch_assoc($get_user_info);
              $_SESSION['a49r-aN3c03639dr92Cb1cK6cb^6bf494035c05a%4eC1ddQa61c9d552*Pdu34d1e4e85992ba+bR3Pe5f6g8d0664/055758e06707127h8ij0klrLb9db021bTQ0bf0a6H'] = $user_info['C_Id'];
              if($user_info["C_Checking"] != "activated") {
                session_destroy();
                ?>
                <div class="agency_cars_creation_form" style="margin-top: 5em;">
                      <form>
                        <h1 style="background-color: black; color: white;border-radius: 3px;"><?php echo $user_info["C_Name"]; ?></h1>
                        <h2>Sorry, Your account is not activated.<br>So, wait activation or call us in order to help you.</h2>
                        <input type="button" class="agency_send_button" value="CONTINUE" onclick="injira()">
                      </form>
                    </div>
                    <script>
                      function injira() {
                        location.href="index?injira";
                      }
                    </script>
                <?php
              } else {
                echo '<script>location.href="agency_panel?dashboard"</script>';
                exit();
              }
          } else {
  ?>
            <div class="agency_cars_creation_form" style="margin-top: 5em;">
                  <form>
                    <h2>Incorrect username or password.</h2>
                    <input type="button" class="agency_send_button" value="TRY AGAIN" onclick="injira()">
                  </form>
                </div>
                <script>
                  function injira() {
                    location.href="index?injira";
                  }
                </script>
  <?php
          }
      }
  }
}
signin();

###<===---------------> > >---(01 BRIDGE (01)---< < <---------------===>###


function agency_signup() {
    global $con;
    if(isset($_POST['C_Signup']) && isset($_FILES['C_Logo'])) {
      echo '<title>Rwanda-Bus || Sign Up</title>';
      $C_Name = mysqli_real_escape_string($con, htmlspecialchars($_POST['C_Name']));
      $C_Phone = mysqli_real_escape_string($con, htmlspecialchars($_POST['C_Phone']));
      $C_email= mysqli_real_escape_string($con,htmlspecialchars($_POST['email']));
      $C_Ceo = mysqli_real_escape_string($con, htmlspecialchars($_POST['C_Ceo']));
      $C_Username = mysqli_real_escape_string($con, $_POST["C_Username"]);
      $C_Password = mysqli_real_escape_string($con, htmlspecialchars($_POST['C_Password']));

    $C_Logo = mysqli_real_escape_string($con, htmlspecialchars($_FILES['C_Logo']['name']));
    $img_size = $_FILES['C_Logo']['size'];
    $tmp_name = $_FILES['C_Logo']['tmp_name'];
    $error = $_FILES['C_Logo']['error'];
    if($error==0)
    {
        if($img_size > 12500000)
        {
?>
<div class="agency_cars_creation_form" style="margin-top: 5em;">
      <form>
        <h2>Sorry, your file is too large.</h2>
        <input type="button" class="agency_send_button" value="TRY AGAIN" onclick="iyandikishe()">
      </form>
    </div>
    <script>
      function iyandikishe() {
        location.href="index?iyandikishe";
      }
    </script>
<?php
        }
        else{
          $checkUsername = "SELECT 'company' AS amakuruAvamuri_company FROM company WHERE C_Username = '$C_Username'
                            UNION
                            SELECT 'system_controller' AS amakuruAvamuri_system_controller FROM system_controller WHERE S_Username = '$C_Username'";
          $result1 = mysqli_query($con, $checkUsername) or die(mysqli_error($con));
          if(mysqli_num_rows($result1) == 0) {
            $checkCompanyName= "SELECT C_Name FROM company WHERE C_Name = '$C_Name'";
            $result2 = mysqli_query($con, $checkCompanyName) or die(mysqli_error($con));
            if(mysqli_num_rows($result2) == 0) {
            $img_ex=pathinfo($C_Logo,PATHINFO_EXTENSION);
            $img_ex_lc=strtolower($img_ex);
            $allowed_exs=array("jpg","jpeg","png");
            if(in_array($img_ex_lc,$allowed_exs)){
                $new_img_name = uniqid("(".$C_Name.")__(",true).').'.$img_ex_lc;
                $im_upload_path ='agency_logo/'.$new_img_name;
                move_uploaded_file($tmp_name,$im_upload_path);
                $kwinjiza=mysqli_query($con,"INSERT INTO company VALUES(NULL,'$C_Name','$im_upload_path','$C_Phone','$C_email','$C_Ceo','$C_Username','$C_Password','pending....')") or die(mysqli_error($con));
                if($kwinjiza==true){
?>
<div class="agency_cars_creation_form" style="margin-top: 5em;">
      <form onmousemove="injira()">
        <h2>Your agency account was created successfully.<br>pleas contact this number(0789117044)</h2>
        <input type="button" class="agency_send_button" value="SIGN IN">
      </form>
    </div>
    <script>
      function injira() {
        location.href="index?injira";
      }
    </script>
<?php
                }
            }
            else{
?>
<div class="agency_cars_creation_form" style="margin-top: 5em;">
      <form>
        <h2>Sorry, you can't upload files of this type.</h2>
        <input type="button" class="agency_send_button" value="TRY AGAIN" onclick="iyandikishe()">
      </form>
    </div>
    <script>
      function iyandikishe() {
        location.href="index?iyandikishe";
      }
    </script>
<?php
            }
          } else {
            ?>
            <div class="agency_cars_creation_form" style="margin-top: 5em;">
                  <form>
                    <h2>Sorry, the agency name already exists.</h2>
                    <input type="button" class="agency_send_button" value="TRY AGAIN" onclick="iyandikishe()">
                  </form>
                </div>
                <script>
                  function iyandikishe() {
                    location.href="index?iyandikishe";
                  }
                </script>
            <?php
                      }
        } else {
?>
<div class="agency_cars_creation_form" style="margin-top: 5em;">
      <form>
        <h2>Sorry, the username already exists.<br>pleas contact this number(0789117044)</h2>
        <input type="button" class="agency_send_button" value="TRY AGAIN" onclick="iyandikishe()">
      </form>
    </div>
    <script>
      function iyandikishe() {
        location.href="index?iyandikishe";
      }
    </script>
<?php
          }
        }
        }
      }
}
agency_signup();

###<===---------------> > >---(02 BRIDGE (02)---< < <---------------===>###


function kwibuka_ijambaBanga() {
  global $con;
  if (isset($_POST["ryaJamboBangaRyange"])) {
    $usernameYange = mysqli_real_escape_string($con, htmlspecialchars($_POST["iyiUsernameYange"]));
    $emailYange = mysqli_real_escape_string($con, htmlspecialchars($_POST["iyiEmailYange"]));
    $gusuzumaEmail=mysqli_query($con,"SELECT * FROM company WHERE C_Email='$emailYange' AND C_Username='$usernameYange'") or die(mysqli_error($con));
    if (mysqli_num_rows($gusuzumaEmail)>0) {
      $imyirondoro=mysqli_fetch_assoc($gusuzumaEmail);
      $izina=$imyirondoro["C_Ceo"];
      $yeyeyeIjoro=date("stsmsNs")-60/(12)+3;
      $yeyeyeIjoro = mysqli_real_escape_string($con, htmlspecialchars($yeyeyeIjoro));
      $ijamboBangaRishya=mysqli_query($con,"UPDATE company SET C_Password='$yeyeyeIjoro' WHERE C_Email='$emailYange' AND C_Username='$usernameYange'") or die(mysqli_error($con));
      if ($ijamboBangaRishya==true) {
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
         $mail->AddAddress($emailYange," ".$izina);
         $mail->Subject  =  'Your password has been changed';
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
        <h1>Success!</h1>
      </div>
      <div style="margin: 20px 0">
        <p>Hello '.$izina.',</p>
        <p>
          Your password has been changed successful.
        </p>
        <p style="font-size: 1.5em;">
          <strong>New password:</strong> <i>'.$yeyeyeIjoro.'</i>
        </p>
      </div>
      <div
        style="
          font-size: 0.9em;
          color: #666;
          text-align: center;
          border-top: 1px solid #ddd;
          padding-top: 10px;
        "
      >
        <p>Â© '.date("Y").' Online Booking Ticket. All rights reserved.</p>
      </div>
    </div>
  </div>
         ';
         if($mail->Send())
         {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Success! We sent a new password to your <i>email</i>.</h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="index?injira";
        }
        </script>
<?php
         }
         else
         {
?>
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>We changed your password, but because something went wrong, we didn't send it to your email. So, please try again.</h2>
          <input type="button" class="agency_send_button" value="TRY AGAIN" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="index?ijambobangaRyange";
        }
        </script>
<?php
         }
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
          location.href="index?ijambobangaRyange";
        }
        </script>
<?php
      }
    } else {
?>  
        <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry, you entered an incorrect <u>Username</u> or <u>Email</u>.</h2>
          <input type="button" class="agency_send_button" value="Try Again Later" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="index?ijambobangaRyange";
        }
        </script>
<?php
    }
  }
}
kwibuka_ijambaBanga();

function gutangira_order() {
  global $con;
  if (isset($_POST["tangiraOrder"])) {
    $crazyFrom = mysqli_real_escape_string($con, htmlspecialchars($_POST["crazyFrom"]));
    $crazyTo = mysqli_real_escape_string($con, htmlspecialchars($_POST["crazyTo"]));
    echo '<script>location.href="booking?selectedLocation='.$crazyFrom.'icyerekezo'.$crazyTo.'"</script>';
  }
}
gutangira_order();

?>
