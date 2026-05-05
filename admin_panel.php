<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['7pdB7689Gf4jkgjkgyggjGFJKHYHkiopu66789403'])) {
    echo '<script>location.href="index"</script>';
    exit;
} 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rwanda-Bus || Admin Dashboard</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="./css/admin_panel.css" />
    <link rel="stylesheet" href="./css/agency_panel.css" />
  </head>
  <body>
    <button class="humburger">&#9776;</button>
    <div class="responsive_nav">
      <h1>ADMIN PANEL</h1>
    </div>
    <div class="admin_body">
      <aside class="admin_aside">
        <h1>Admin</h1>
        <div class="admin_links">
          <a href="admin_panel?"><i class='bx bxs-dashboard'></i> Dashboard</a>
          <a href="admin_panel?activeted_agency"><i class='bx bxs-badge-check'></i> Activated Agency</a>
          <a href="admin_panel?pending_agency"><i class='bx bxs-time-five'></i> Pending Agency</a>
          <a href="admin_panel?deactiv_agency"><i class='bx bxs-block'></i> Deactivated Agency</a>
          <a href="admin_panel?locations"><i class='bx bx-map'></i> Add Locations</a>
          <a href="admin_panel?locations_nam"><i class='bx bx-edit-alt'></i> Manage Locations</a>
          <a href="admin_panel?fedback"><i class='bx bxs-message-detail'></i> Feedback</a>
          <a href="logout"><i class='bx bx-log-out'></i> Sign out</a>
        </div>
      </aside>
      <div class="admin_container">
        <header class="panel-topbar">
          <div class="panel-topbar-left">
            <i class='bx bx-menu-alt-left'></i>
            <strong>NUWO NI UWACU HUB</strong>
          </div>
          <div class="panel-topbar-right">
            <i class='bx bx-user-circle'></i>
            <span>admin</span>
          </div>
        </header>
        <section class="panel-overview">
          <h2>Dashboard Overview</h2>
          <p>Welcome back, admin. Here is what is happening today.</p>
        </section>
        <!-- <div class="agencies_table">
          <table>
            <tr>
              <th>
                N<sup><u>o</u></sup>
              </th>
              <th>Name</th>
              <th>Email</th>
              <th>Password</th>
              <th>Tel</th>
              <th>Update</th>
              <th>Delete</th>
            </tr>
            <tr>
              <td>1</td>
              <td>Litco</td>
              <td>litco250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Stella</td>
              <td>stella250@gmail.com</td>
              <td>**********</td>
              <td>0789375245</td>
              <td><a href="#">Update</a></td>
              <td><a href="#">Delete</a></td>
            </tr>
          </table>
        </div> -->
        <!--Getin information-->
<?php
if(isset($_GET['locations'])){
    ?>
    <div class="agencies_Creation_form">
          <form action="brain" method="post">
            <h2>location Form</h2>
            <input
              type="text"
              name="from"
              id="agency_name"
              placeholder="From"
              required
            />
            <input
              type="text"
              name="to"
              id="agency_name"
              placeholder="To"
              required
            />
            <input
              type="number"
              name="price"
              id="agency_name"
              placeholder="Enter Amount Of Money"
              required
            />
            
            <input
              type="submit"
              name="add_dest"
              id="send_button"
              class="send_button"
              value="Add"
            />
            
          </form>
        </div>
    <?php
}
//start to display feedback
else if(isset($_GET['fedback'])){
  $sel="SELECT *FROM feedback";
  $query=mysqli_query($con,$sel);
  ?><h1><center><u>Feedback</u></center></h1><?php
  while($row=mysqli_fetch_array($query))
  {
    ?>
    
    <div class="nee">
      <div class="ndeba">
      <p>Names : <?php echo $row['names'];?></p>
      <p>Email: <?php echo $row['femail'];?></p>
      <p>Subject : <?php echo $row['fsub'];?></p>
    </div>
    <hr>
    
      <center><h2>Comment</h2>
      <i><?php echo $row['fcoment'];?></i></center>
    </div><br><br>
    <?php
  }
}
//end to display feedback

//<!--Starting to Display activeted_agency-->

else if(isset($_GET['activeted_agency'])){
  ?>
  <?php
  $sel="SELECT * FROM company WHERE C_Checking='activated'";
  $query=mysqli_query($con,$sel);
  if(mysqli_num_rows($query)>0)
  {
?>
        <div class="Activated Agency Table">
          <center><h1><u>Activated Agency</u></h1></center><br>
          <div class="agencies_table">
          <table>
            <tr>
              <th>Name</th>
              <th>Phone Number</th>
              <th>Email</th>
              <th>CEO</th>
              <th>UserName</th>
              <th>Action</th>
            </tr>
           <?php
           while($row=mysqli_fetch_array($query))
           {
            ?>
            <tr>
              <td><?php echo $row['C_Name'];?></td>
              <td><?php echo $row['C_Phone'];?></td>
              <td><?php echo $row['C_Email'];?></td>
              <td><?php echo $row['C_Ceo'];?></td>
              <td><?php echo $row['C_Username'];?></td>
              <td><a href="admin_panel?deactivate=<?php echo $row['C_Id'];?>" onclick="return confirm('ATTENTION\n______________\n\nAre you ready to deactivate <?php echo $row['C_Name'];?>\n\nIf you are ready click Okay.')" style="background-color:black;">Deactivate</a></td>
            </tr>
            <?php
           }
           ?>
          </table>
          </div>
        </div>
<?php

  }
  else{
    ?>
         <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>There is no Activeted Agency </h2>
          <input type="button" class="agency_send_button" value="NEXT" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="admin_panel";
        }
        
        </script>
    <?php
    
  }
}

// Ending to Display activeted_agency
// starting to display Desactivated
else if(isset($_GET["deactivate"])){
  $d=$_GET["deactivate"];
  $sel="SELECT * FROM company WHERE C_Checking='deactivate' AND C_Id=$d";
  $q=mysqli_query($con,$sel);
  if(mysqli_num_rows($q)==0){
  $update=mysqli_query($con,"UPDATE company SET C_Checking='deactivate' WHERE C_Id='$d'") or die(mysqli_error($con));
  
  if($update==true){
    ?>
            <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Agency Deactivated successfull </h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="admin_panel?activeted_agency";
        }
        
        </script>
    <?php
  }
}
else{
  ?>
   <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry,<br> The Agency is already  deactivated </h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="admin_panel?activeted_agency";
        }
        
        </script>
<?php
}
}
//Display pending agency
elseif(isset($_GET['pending_agency']))
{
  $sel="SELECT * FROM company WHERE C_Checking='pending....'";
  $query=mysqli_query($con,$sel);
  if(mysqli_num_rows($query)){
  ?>
  <div class="Activated Agency Table">
          <center><h1><u>Pending  Agency</u></h1></center><br>
          <div class="agencies_table">
          <table>
            <tr>
              <th>Name</th>
              <th>Phone Number</th>
              <th>Email</th>
              <th>CEO</th>
              <th>UserName</th>
              <th>Action</th>
            </tr>
           <?php
           while($row=mysqli_fetch_array($query))
           { 
            ?>
            <tr>
              <td><?php echo $row['C_Name'];?></td>
              <td><?php echo $row['C_Phone'];?></td>
              <td><?php echo $row['C_Email'];?></td>
              <td><?php echo $row['C_Ceo'];?></td>
              <td><?php echo $row['C_Username'];?></td>
              <td class="tdDiv"><a href="admin_panel?activate=<?php echo $row['C_Id'];?>" <?php echo $row['C_Id'];?> onclick="return confirm('ATTENTION\n______________\n\nAre you ready to activate <?php echo $row['C_Name'];?>\n\nIf you are ready click OK.')" style="background-color:orange;">Activate</a>
              <a href="admin_panel?agency_delet=<?php echo $row['C_Id'];?>" 
              style="background-color:black;" 
              onclick="return confirm('Are you ready to delete Agency\n\nIf you are ready click Ok')">Delete</a></td>
            </tr>
            <?php
           }
           ?>
          </table>
          </div>
        </div>
  <?php
  }
    else{
    ?>
         <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>There is no Pending... Agency </h2>
          <input type="button" class="agency_send_button" value="NEXT" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="admin_panel";
        }
        
        </script>
    <?php
    
  }
}
//Start to delete Pending Agency
else if(isset($_GET['agency_delet'])){
  $de=$_GET['agency_delet'];
  $del="DELETE FROM company WHERE company.C_Id = '$de'";
  $query=mysqli_query($con,$del);
  if($query==true){
    ?>
    <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Pending Agency Deleted are successfull </h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="admin_panel?pending_agency";
        }
        
        </script>
    <?php

  }
}
//End to delete Pending Agency
//activate pending....
else if(isset($_GET['activate'])){
  $act=$_GET['activate'];
  $sel="SELECT * FROM company WHERE C_Checking='activated' AND C_Id=$act";
  $que=mysqli_query($con,$sel);
  if(mysqli_num_rows($que)==0){
  $update=mysqli_query($con,"UPDATE company SET C_Checking='activated' WHERE C_Id='$act'") or die(mysqli_error($con));
  
  if($update==true){
    ?>
            <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Agency activated successfull </h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="admin_panel?pending_agency";
        }
        
        </script>
    <?php
  }
}
else{
  ?>
   <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry,<br>The Agency is already activated</h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="admin_panel?pending_agency";
        }
        
        </script>
<?php
}
} //   echo "<h2>There is End of activate pending... Agency</h2>";
  // }
  else if(isset($_GET['deactiv_agency'])){

  $sel="SELECT * FROM company WHERE C_Checking='deactivate'";
  $query=mysqli_query($con,$sel);
  if(mysqli_num_rows($query)){
  ?>
  <div class="Activated Agency Table">
          <center><h1><u>Deactivate  Agency</u></h1></center><br>
          <div class="agencies_table">
          <table>
            <tr>
              <th>Name</th>
              <th>Phone Number</th>
              <th>Email</th>
              <th>CEO</th>
              <th>UserName</th>
              <th>Action</th>
            </tr>
           <?php
           while($row=mysqli_fetch_array($query))
           { 
            ?>
            <tr>
              <td><?php echo $row['C_Name'];?></td>
              <td><?php echo $row['C_Phone'];?></td>
              <td><?php echo $row['C_Email'];?></td>
              <td><?php echo $row['C_Ceo'];?></td>
              <td><?php echo $row['C_Username'];?></td>
              <td><a href="admin_panel?activates=<?php echo $row['C_Id'];?>" <?php echo $row['C_Id'];?> onclick="return confirm('ATTENTION\n______________\n\nAre you ready to activate <?php echo $row['C_Name'];?>\n\nIf you are ready click OK.')" style="background-color:orange;">Activate</a>
              </td>
            </tr>
            <?php
           }
           ?>
          </table>
          </div>
        </div>
  <?php
  }
    else{
    ?>
         <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>There is no deactivate Agency </h2>
          <input type="button" class="agency_send_button" value="NEXT" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="admin_panel";
        }
        
        </script>
    <?php
    
  }
}

//start to activate Deactivated_agency

else if(isset($_GET['activates'])){
  $act=$_GET['activates'];
  $sel="SELECT * FROM company WHERE C_Checking='activated' AND C_Id=$act";
  $que=mysqli_query($con,$sel);
  if(mysqli_num_rows($que)==0){
  $update=mysqli_query($con,"UPDATE company SET C_Checking='activated' WHERE C_Id='$act'") or die(mysqli_error($con));
  
  if($update==true){
    ?>
            <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Agency activated successfull </h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="admin_panel?deactiv_agency";
        }
        
        </script>
    <?php
  }
}
else{
  ?>
   <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Sorry,<br>The Agency is already activated</h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="admin_panel?deactiv_agency";
        }
        
        </script>
<?php
}
}
//end to activate deactiveted_agency
//Start To Display Locations
else if(isset($_GET['locations_nam'])){
$sel="select *from locations";
$query=mysqli_query($con,$sel);
?>
    <h1><center>Location</center></h1>
   <div class="agencies_table">
          <table>
            <tr>
              <th>From</th>
              <th>To</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
            <?php 
            while($row=mysqli_fetch_array($query))
            {
              echo "<tr>";
              echo "<td>".$row['L_from']."</td>";
              echo "<td>".$row['L_to']."</td>";
              echo "<td>".$row['price']."</td>";
            ?>
            <td class="tdDiv"><a href='admin_panel?up=<?php echo $row['L_id'];?>'>Update</a>
            <a href='admin_panel?del=<?php echo $row['L_id'];?>' style='background-color:black;' onclick='return confirm("ATTENTION\n______________\n\nAre you ready to Delete Location \n\nIf you are ready click Okay.")'>Delete</a>
          </td>
            <?php
            }
            ?>
          </table>
        </div>
        <?php
}
//End to display Locations
//Delete Location
else if(isset($_GET['del'])){
  $d=$_GET['del'];
  $delet="DELETE FROM locations WHERE locations.L_id ='$d'";
  $query=mysqli_query($con,$delet);
  if($query==true){
    ?>
    <div class="agency_cars_creation_form" style="margin-top: 5em;">
        <form>
          <h2>Location Deleted successfull </h2>
          <input type="button" class="agency_send_button" value="CONTINUE" onclick="gusubiraInyuma()">
        </form>
        </div>
        <script>
        function gusubiraInyuma() {
          location.href="admin_panel?locations_nam";
        }
        
        </script>
    <?php
    
  }

  
}
//End to Delete Location

//Form To Update Location
else if(isset($_GET['up'])){
  $n=$_GET['up'];
?>
<div class="agencies_Creation_form">
          <form action="admin_panel?updat_location" method="POST">
            <h2>location Form</h2>
            <input
              type="text"
              name="id"
              id="agency_name"
              value="<?php $sel="select *from locations where L_id='$n' ";
              $query=mysqli_query($con,$sel);
              while($row=mysqli_fetch_array($query)){ echo $row['L_id'];}?>"
              required
            style="display:none;"/>
            <input
              type="text"
              name="from"
              id="agency_name"
              value="<?php $sel="select *from locations where L_id='$n' ";
              $query=mysqli_query($con,$sel);
              while($row=mysqli_fetch_array($query)){ echo $row['L_from'];}?>"
              required
            />
            <input
              type="text"
              name="to"
              id="agency_name"
              value="<?php $sel="select *from locations where L_id='$n' ";
              $query=mysqli_query($con,$sel);
              while($row=mysqli_fetch_array($query)){ echo $row['L_to'];}?>"
              required
            />
            <input
              type="number"
              name="price"
              id="agency_name"
              value="<?php $sel="select *from locations where L_id='$n' ";
              $query=mysqli_query($con,$sel);
              while($row=mysqli_fetch_array($query)){ echo $row['price'];}?>"
              required
            />
            
            <input
              type="submit"
              name="update"
              id="send_button"
              class="send_button"
              value="Change"
            />
            
          </form>
        </div>
<?php
}
//End Form To Update Location
//Update Location
else if(isset($_GET['updat_location'])){
  if(isset($_POST['update'])){
    $idd=mysqli_real_escape_string($con,htmlspecialchars($_POST['id']));
    $fr=mysqli_real_escape_string($con,htmlspecialchars($_POST['from']));
    $t=mysqli_real_escape_string($con,htmlspecialchars($_POST['to']));
    $pr=mysqli_real_escape_string($con,htmlspecialchars($_POST['price']));
    $upd="update locations set L_from='$fr',L_to='$t',price='$pr' where L_id='$idd'";
    $query=mysqli_query($con,$upd);
    if($query==true){
    echo '<script> location.href="admin_panel?locations_nam"</script>'; 
     
    }
    else{
  
    }
  }
}
//End Update Location
else{
  $activatedCount = 0;
  $pendingCount = 0;
  $deactivatedCount = 0;
  $feedbackCount = 0;

  $activatedQ = mysqli_query($con, "SELECT COUNT(C_Id) as count FROM company WHERE C_Checking='activated'");
  if ($activatedQ && mysqli_num_rows($activatedQ) > 0) {
    $activatedCount = (int)mysqli_fetch_assoc($activatedQ)['count'];
  }

  $pendingQ = mysqli_query($con, "SELECT COUNT(C_Id) as count FROM company WHERE C_Checking='pending....'");
  if ($pendingQ && mysqli_num_rows($pendingQ) > 0) {
    $pendingCount = (int)mysqli_fetch_assoc($pendingQ)['count'];
  }

  $deactivatedQ = mysqli_query($con, "SELECT COUNT(C_Id) as count FROM company WHERE C_Checking='deactivate'");
  if ($deactivatedQ && mysqli_num_rows($deactivatedQ) > 0) {
    $deactivatedCount = (int)mysqli_fetch_assoc($deactivatedQ)['count'];
  }

  $feedbackQ = mysqli_query($con, "SELECT COUNT(fid) as count FROM feedback");
  if ($feedbackQ && mysqli_num_rows($feedbackQ) > 0) {
    $feedbackCount = (int)mysqli_fetch_assoc($feedbackQ)['count'];
  }
  ?>
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-icon"><i class='bx bxs-badge-check'></i></div>
      <div><h3><?php echo $activatedCount; ?></h3><p>Activated Agencies</p></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon"><i class='bx bxs-time-five'></i></div>
      <div><h3><?php echo $pendingCount; ?></h3><p>Pending Agencies</p></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon"><i class='bx bxs-block'></i></div>
      <div><h3><?php echo $deactivatedCount; ?></h3><p>Deactivated Agencies</p></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon"><i class='bx bxs-message-detail'></i></div>
      <div><h3><?php echo $feedbackCount; ?></h3><p>Total Feedback</p></div>
    </div>
  </div>
  <?php
}
?>


<!--End Of Geting Information-->
        
      </div>
    </div>

    <script>
      const resBut = document.querySelector(".humburger");
      const sidebar = document.querySelector(".admin_aside");
      resBut.addEventListener("click", () => {
        if (sidebar.classList != "admin_aside active") {
          resBut.innerHTML = "&#10006;";
          sidebar.classList.add("active");
        } else {
          resBut.innerHTML = "&#9776;";
          sidebar.classList.remove("active");
        }
      });
    </script>
    <script src="js/chatbot.js"></script>
  </body>
</html>

