<?php
include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/home.css" />
    <link rel="stylesheet" href="./css/agency_panel.css" />
  </head>
  <body>

<?php
if(isset($_GET["iyandikishe"])) {
?>
<title>Rwanda-Bus || Sign Up</title>
    <div class="agency_cars_creation_form" style="margin-top: 5em;">
<form action="controller" method="post" enctype="multipart/form-data">
            <h1>Sign Up</h1>
            <input
              type="text"
              name="C_Name"
              placeholder="Enter agency name"
              required
            />
            <agency>
            Agency logo<input
              type="file"
              name="C_Logo"
              required
            />
            </agency>
            <input
              type="text"
              name="C_Phone"
              placeholder="Enter agency phone number"
              required
            />
             <input
              type="text"
              name="email"
              placeholder="Enter agency Email"
              required
            />
            <input
              type="text"
              name="C_Ceo"
              placeholder="Enter Ceo of agency"
              required
            />
            <input
              type="text"
              name="C_Username"
              placeholder="Enter username"
              required
            />
            <input
              type="password"
              name="C_Password"
              placeholder="Enter password"
              required
            />
            <input
              type="submit"
              name="C_Signup"
              class="agency_send_button"
              value="Sign Up"
            />
             <input
              type="button"
              name="back"
              class="agency_send_button"
              value="BACK"
              onclick="inyuma()"
            /></a>
    <script>
      function inyuma() {
        location.href="index";
      }
    </script>
          </form>
        </div>
<?php
} else if(isset($_GET["injira"])) {
?>
<title>Rwanda-Bus || Sign In</title>
    <div class="agency_cars_creation_form" style="margin-top: 7em;">
            <form method="post" action="controller">
            <h1>Sign In</h1>
            <input
              type="text"
              name="S_C_Username"
              placeholder="Username . . . ."
              required
            />
            <input
              type="password"
              name="S_C_Password"
              placeholder="Password * * * *"
              required
            />
            <input
              type="submit"
              name="S_C_Sigin"
              class="agency_send_button"
              value="Sign In"
            />
            <input
              type="button"
              name="back"
              class="agency_send_button"
              value="BACK"
              onclick="inyuma()"
            /></a>
    <script>
      function inyuma() {
        location.href="index";
      }
    </script>
          </form>
        </div>
<?php
  } else{
  echo '<title>Rwanda-Bus || Home</title>';
}
?>

    <!-- Start JavaScript -->
    <script>
      function injira() {
        location.href="auth_aunte?injira";
      }
    </script>
    <script>
      function iyandikishe() {
        location.href="auth_aunte?iyandikishe";
      }
    </script>
    <!-- End JavaScript -->
  </body>
</html>
