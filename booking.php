<?php
require 'connection.php';

function parseDepartureDateTime($dateValue, $timeValue)
{
    $datePart = date('Y-m-d', strtotime($dateValue));
    $dateTime = DateTime::createFromFormat('Y-m-d h:i A', $datePart . ' ' . trim($timeValue));
    return $dateTime ?: null;
}

function fetchUpcomingTrips($con, $companyId = null, $from = null, $to = null)
{
    $conditions = [];
    if ($companyId !== null) {
        $companyId = (int)$companyId;
        $conditions[] = "cp.C_Id = $companyId";
    }
    if ($from !== null && $to !== null) {
        $from = mysqli_real_escape_string($con, $from);
        $to = mysqli_real_escape_string($con, $to);
        $conditions[] = "lc.L_from = '$from'";
        $conditions[] = "lc.L_to = '$to'";
    }

    $where = '';
    if (!empty($conditions)) {
        $where = 'WHERE ' . implode(' AND ', $conditions);
    }

    $sql = "SELECT ct.id, ct.Time_to_leave, ct.date_car_to, cr.Car_Plaque, cr.Number_Place,
                   lc.L_from, lc.L_to, lc.price,
                   cp.C_Id, cp.C_Name, cp.C_Phone,
                   COALESCE(SUM(b.Seat_Count), 0) AS seats_taken
            FROM cars_to_leave ct
            INNER JOIN cars cr ON cr.Car_Id = ct.Car_Id
            INNER JOIN destination ds ON ds.D_Id = ct.D_Id
            INNER JOIN locations lc ON lc.L_id = ds.L_id
            INNER JOIN company cp ON cp.C_Id = cr.C_Id
            LEFT JOIN booking b ON b.Id = ct.id
            $where
            GROUP BY ct.id, ct.Time_to_leave, ct.date_car_to, cr.Car_Plaque, cr.Number_Place,
                     lc.L_from, lc.L_to, lc.price, cp.C_Id, cp.C_Name, cp.C_Phone
            ORDER BY ct.date_car_to ASC";

    $result = mysqli_query($con, $sql);
    $now = new DateTime();
    $rows = [];

    while ($result && $trip = mysqli_fetch_assoc($result)) {
        $departureAt = parseDepartureDateTime($trip['date_car_to'], $trip['Time_to_leave']);
        if (!$departureAt || $departureAt < $now) {
            continue;
        }

        $seatsLeft = (int)$trip['Number_Place'] - (int)$trip['seats_taken'];
        if ($seatsLeft <= 0) {
            continue;
        }

        $trip['seats_left'] = $seatsLeft;
        $trip['departure_ts'] = $departureAt->getTimestamp();
        $rows[] = $trip;
    }

    usort($rows, function ($a, $b) {
        return $a['departure_ts'] <=> $b['departure_ts'];
    });

    return $rows;
}

$selectedCompanyId = isset($_GET['company']) ? (int)$_GET['company'] : null;
$routeFrom = null;
$routeTo = null;
if (isset($_GET['selectedLocation'])) {
    $selectedLocation = mysqli_real_escape_string($con, htmlspecialchars($_GET['selectedLocation']));
    if (strpos($selectedLocation, 'icyerekezo') !== false) {
        list($routeFrom, $routeTo) = explode('icyerekezo', $selectedLocation);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rwanda-Bus || Booking</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/navbar.css" />
  <link rel="stylesheet" href="css/footer.css" />
  <link rel="stylesheet" href="css/booking.css" />
  <link rel="stylesheet" href="css/bookingform.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
</head>
<body>
  <button class="hamburger" id="hamburger" aria-label="Open menu">
    <span></span><span></span><span></span>
  </button>
  <header>
    <nav class="nav solid" id="navbar">
      <div class="nav-logo">Rwanda<span>Bus</span></div>
      <ul class="nav-links">
        <li><a href="index">Home</a></li>
        <li><a href="booking">Booking</a></li>
        <li><a href="contactUs">Contact Us</a></li>
        <li><a href="index?injira" class="butt"><button class="login-button">Login / Sign Up</button></a></li>
      </ul>
    </nav>
  </header>

  <?php if (isset($_GET['booking_form'])): ?>
    <?php
      $tripId = (int)$_GET['booking_form'];
      $tripSql = "SELECT ct.id, ct.Time_to_leave, ct.date_car_to, cr.Car_Plaque, cr.Number_Place,
                         lc.L_from, lc.L_to, lc.price,
                         cp.C_Id, cp.C_Name, cp.C_Phone,
                         COALESCE(SUM(b.Seat_Count), 0) AS seats_taken
                  FROM cars_to_leave ct
                  INNER JOIN cars cr ON cr.Car_Id = ct.Car_Id
                  INNER JOIN destination ds ON ds.D_Id = ct.D_Id
                  INNER JOIN locations lc ON lc.L_id = ds.L_id
                  INNER JOIN company cp ON cp.C_Id = cr.C_Id
                  LEFT JOIN booking b ON b.Id = ct.id
                  WHERE ct.id = '$tripId'
                  GROUP BY ct.id, ct.Time_to_leave, ct.date_car_to, cr.Car_Plaque, cr.Number_Place,
                           lc.L_from, lc.L_to, lc.price, cp.C_Id, cp.C_Name, cp.C_Phone";
      $tripResult = mysqli_query($con, $tripSql);
      $trip = mysqli_fetch_assoc($tripResult);
    ?>

    <?php if ($trip): ?>
    <?php
      $departureAt = parseDepartureDateTime($trip['date_car_to'], $trip['Time_to_leave']);
      $seatsLeft = (int)$trip['Number_Place'] - (int)$trip['seats_taken'];
      $isExpired = !$departureAt || $departureAt < new DateTime();
      $takenSeats = [];
      $takenSeatSql = mysqli_query($con, "SELECT Seat_Number FROM booking WHERE Id = '".$trip['id']."' AND Seat_Number IS NOT NULL");
      if ($takenSeatSql) {
          while ($seatRow = mysqli_fetch_assoc($takenSeatSql)) {
              $takenSeats[] = (int)$seatRow['Seat_Number'];
          }
      }
    ?>
    <section class="booking-form-all">
      <div class="booking-form">
        <div class="booking-car-details">
          <div class="booking-car-info">
            <div class="car-infoo">
              <p><?php echo htmlspecialchars($trip['C_Name']); ?></p>
              <p><?php echo htmlspecialchars($trip['Car_Plaque']); ?></p>
            </div>
            <div class="car-info">
              <p>FROM: <?php echo htmlspecialchars($trip['L_from']); ?></p>
              <p>TO: <?php echo htmlspecialchars($trip['L_to']); ?></p>
              <p>TIME: <?php echo htmlspecialchars($trip['Time_to_leave']); ?></p>
              <p>PRICE: <?php echo number_format((int)$trip['price']); ?> RWF</p>
            </div>
          </div>

          <?php if ($seatsLeft > 0 && !$isExpired): ?>
          <form action="brain" method="post">
            <fieldset>
              <label>Name:</label>
              <input type="text" name="price" value="<?php echo (int)$trip['price']; ?>" readonly hidden>
              <input type="text" name="C_Phone" value="<?php echo htmlspecialchars($trip['C_Phone']); ?>" readonly hidden>
              <input type="text" name="P_name" placeholder="Full names" required />
            </fieldset>
            <fieldset>
              <label>Phone:</label>
              <input
                type="tel"
                name="phone"
                minlength="10"
                maxlength="10"
                pattern="^(079|078|072|073)[0-9]{7}$"
                title="Please enter a 10-digit phone number starting with 079, 078, 072, or 073."
                placeholder="07xxxxxxxx" required
              />
              <input type="text" name="idd" value="<?php echo (int)$trip['id'];?>" readonly hidden>
            </fieldset>
            <fieldset>
              <label>Email:</label>
              <input type="email" name="email" placeholder="example@mail.com" required />
            </fieldset>
            <fieldset>
              <label>Select Seat:</label>
              <div class="seat-picker">
                <?php $requiredSeat = true; ?>
                <?php for ($seat = 1; $seat <= (int)$trip['Number_Place']; $seat++): ?>
                  <?php $isTaken = in_array($seat, $takenSeats, true); ?>
                  <label class="seat-option <?php echo $isTaken ? 'taken' : ''; ?>">
                    <input type="radio" name="seat_number" value="<?php echo $seat; ?>" <?php if($isTaken){ echo 'disabled'; } else if($requiredSeat){ echo 'required'; $requiredSeat = false; } ?> />
                    <span><?php echo $seat; ?></span>
                  </label>
                <?php endfor; ?>
              </div>
              <small><?php echo (int)$seatsLeft; ?> seat(s) available | gray = already booked</small>
            </fieldset>
            <fieldset>
              <button type="submit" name="byy">Buy Ticket</button>
            </fieldset>
          </form>
          <?php else: ?>
          <div class="booking-alert">
            <h3>This bus is no longer available.</h3>
            <p>Please go back to view currently available departures.</p>
            <a href="booking" class="get-ticket-btn">Back to Booking</a>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <?php else: ?>
    <section class="booking-page">
      <div class="no-buses">
        <h3>Trip not found</h3>
        <p>The selected ticket does not exist.</p>
      </div>
    </section>
    <?php endif; ?>

  <?php else: ?>
    <?php
      $selectedCompanyName = null;
      if ($selectedCompanyId !== null) {
          $companyInfo = mysqli_query($con, "SELECT C_Name FROM company WHERE C_Id = '$selectedCompanyId'");
          if ($companyInfo && mysqli_num_rows($companyInfo) > 0) {
              $selectedCompanyName = mysqli_fetch_assoc($companyInfo)['C_Name'];
          }
      }

      $upcomingTrips = fetchUpcomingTrips($con, $selectedCompanyId, $routeFrom, $routeTo);
    ?>

    <section class="booking-page">
      <div class="booking-hero">
        <h1>Available Buses</h1>
        <p>Book by route or open tickets for a specific company.</p>
      </div>

      <?php if ($selectedCompanyName): ?>
      <div class="filter-badge">
        Showing tickets for: <strong><?php echo htmlspecialchars($selectedCompanyName); ?></strong>
        <a href="booking">Clear</a>
      </div>
      <?php endif; ?>

      <?php if ($routeFrom && $routeTo): ?>
      <div class="filter-badge">
        Route: <strong><?php echo htmlspecialchars($routeFrom); ?> to <?php echo htmlspecialchars($routeTo); ?></strong>
        <a href="booking">Clear</a>
      </div>
      <?php endif; ?>

      <?php if (count($upcomingTrips) > 0): ?>
      <div class="buses-grid booking-grid">
        <?php foreach ($upcomingTrips as $trip): ?>
        <div class="bus-card">
          <div class="bus-card-top">
            <div class="agency-name"><?php echo htmlspecialchars($trip['C_Name']); ?></div>
            <div class="seats-badge <?php echo $trip['seats_left'] <= 5 ? 'seats-low' : ''; ?>"><?php echo (int)$trip['seats_left']; ?> seats</div>
          </div>
          <div class="route-display">
            <div class="route-city"><?php echo htmlspecialchars($trip['L_from']); ?></div>
            <div class="route-arrow">
              <div class="route-line"></div>
              <i class='bx bx-right-arrow-alt'></i>
            </div>
            <div class="route-city"><?php echo htmlspecialchars($trip['L_to']); ?></div>
          </div>
          <div class="bus-card-details">
            <div class="detail-item"><i class='bx bx-time'></i><span><?php echo htmlspecialchars($trip['Time_to_leave']); ?></span></div>
            <div class="detail-item"><i class='bx bx-money'></i><span><?php echo number_format((int)$trip['price']); ?> RWF</span></div>
            <div class="detail-item"><i class='bx bx-id-card'></i><span><?php echo htmlspecialchars($trip['Car_Plaque']); ?></span></div>
            <div class="detail-item"><i class='bx bx-phone'></i><span><?php echo htmlspecialchars($trip['C_Phone']); ?></span></div>
          </div>
          <a href="booking?booking_form=<?php echo (int)$trip['id']; ?>" class="get-ticket-btn">Get Ticket <i class='bx bx-right-arrow-alt'></i></a>
        </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <div class="no-buses">
        <h3>No buses available for this filter</h3>
        <p>Try another company or route.</p>
      </div>
      <?php endif; ?>
    </section>
  <?php endif; ?>

  <footer class="footer">
    <div class="footer-container">
      <div class="footer-contaner-up">
        <div class="footer-brand">
          <h2 class="footer-logo">Rwanda<span>Bus</span></h2>
          <p>Your trusted partner for bus travel across Rwanda.</p>
          <div class="footer-contact-line">
            <i class='bx bx-phone'></i> 0789117044
          </div>
        </div>
        <div class="footer-col-holder">
          <div class="col-footer">
            <h3>Platform</h3>
            <ul>
              <li><a href="index">Home</a></li>
              <li><a href="booking">Booking</a></li>
              <li><a href="contactUs">Contact Us</a></li>
            </ul>
          </div>
          <div class="col-footer">
            <h3>Account</h3>
            <ul>
              <li><a href="index?injira">Agency Login</a></li>
              <li><a href="index?iyandikishe">Agency Signup</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-line"></div>
      <div class="footer-container-down">
        <div class="footer-text-left">
          <p>© <?php echo date('Y'); ?> Rwanda-Bus. All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <script src="js/scroll.js"></script>
  <script src="js/main.js"></script>
  <script src="js/chatbot.js"></script>
</body>
</html>

