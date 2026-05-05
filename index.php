<?php
require 'connection.php';

function parseDepartureDateTime($dateValue, $timeValue)
{
    $datePart = date('Y-m-d', strtotime($dateValue));
    $dateTime = DateTime::createFromFormat('Y-m-d h:i A', $datePart . ' ' . trim($timeValue));
    return $dateTime ?: null;
}

function fetchUpcomingTrips($con, $limit = null)
{
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

    if ($limit !== null) {
        $rows = array_slice($rows, 0, (int)$limit);
    }

    return $rows;
}

function fetchSingleCount($con, $sql, $key)
{
    $result = mysqli_query($con, $sql);
    if ($result && $row = mysqli_fetch_assoc($result)) {
        return (int)($row[$key] ?? 0);
    }
    return 0;
}

function fetchPlatformStats($con)
{
    return [
        'routes' => fetchSingleCount($con, "SELECT COUNT(*) AS count_value FROM locations", 'count_value'),
        'agencies' => fetchSingleCount($con, "SELECT COUNT(*) AS count_value FROM company", 'count_value'),
        'departures_today' => fetchSingleCount($con, "SELECT COUNT(*) AS count_value FROM cars_to_leave WHERE DATE(date_car_to) = CURDATE()", 'count_value'),
        'tickets_booked' => fetchSingleCount($con, "SELECT COUNT(*) AS count_value FROM booking", 'count_value'),
    ];
}

$pageTitle = 'Rwanda-Bus || Home';
if (isset($_GET['injira'])) {
    $pageTitle = 'Rwanda-Bus || Login';
} elseif (isset($_GET['ijambobangaRyange'])) {
    $pageTitle = 'Rwanda-Bus || Reset Password';
} elseif (isset($_GET['iyandikishe'])) {
    $pageTitle = 'Rwanda-Bus || Sign Up';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/navbar.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  </head>
  <body class="<?php echo isset($_GET['injira']) || isset($_GET['ijambobangaRyange']) || isset($_GET['iyandikishe']) ? 'auth-page' : 'home-page'; ?>">

    <button class="hamburger" id="hamburger" aria-label="Open menu">
      <span></span><span></span><span></span>
    </button>
    <header>
      <nav class="nav" id="navbar">
        <div class="nav-logo">Rwanda<span>Bus</span></div>
        <ul class="nav-links">
          <li><a href="index">Home</a></li>
          <li><a href="booking">Booking</a></li>
          <li><a href="contactUs">Contact Us</a></li>
          <li>
            <a href="index?injira" class="butt">
              <button class="login-button">Login / Sign Up</button>
            </a>
          </li>
        </ul>
      </nav>
    </header>

    <?php if(isset($_GET['injira'])): ?>
      <div class="formDiv">
        <div class="loginDiv animate-slide-up">
          <form method="post" action="controller">
            <div class="form-icon">BUS</div>
            <h1>Welcome Back</h1>
            <p class="form-subtitle">Login to manage your tickets</p>
            <div class="loginInput">
              <label for="uname">Username</label>
              <div class="input-wrap">
                <i class='bx bx-user'></i>
                <input type="text" name="S_C_Username" id="uname" placeholder="Enter your username" required/>
              </div>
            </div>
            <div class="loginInput">
              <label for="pass">Password</label>
              <div class="input-wrap">
                <i class='bx bx-lock-alt'></i>
                <input type="password" name="S_C_Password" id="pass" placeholder="********" required/>
              </div>
            </div>
            <div class="loginButton">
              <input type="submit" name="S_C_Sigin" class="submit" value="Login"/>
            </div>
            <span class="form-link">Forgot password? <a href="index?ijambobangaRyange">Reset it here</a></span>
            <p class="form-link">New here? <a href="index?iyandikishe">Create an account</a></p>
          </form>
        </div>
      </div>

    <?php elseif(isset($_GET["ijambobangaRyange"])): ?>
      <div class="formDiv">
        <div class="loginDiv animate-slide-up">
          <form method="post" action="controller">
            <div class="form-icon">KEY</div>
            <h1>Reset Password</h1>
            <p class="form-subtitle">We'll help you get back in</p>
            <div class="loginInput">
              <label>Username</label>
              <div class="input-wrap">
                <i class='bx bx-user'></i>
                <input type="text" name="iyiUsernameYange" placeholder="Enter your username" required/>
              </div>
            </div>
            <div class="loginInput">
              <label>Email Address</label>
              <div class="input-wrap">
                <i class='bx bx-envelope'></i>
                <input type="email" name="iyiEmailYange" placeholder="Enter your email" required/>
              </div>
            </div>
            <div class="loginButton">
              <input type="submit" name="ryaJamboBangaRyange" class="submit" value="Send Reset Link"/>
            </div>
            <p class="form-link">Remember it? <a href="index?injira">Sign In</a></p>
          </form>
        </div>
      </div>

    <?php elseif(isset($_GET['iyandikishe'])): ?>
      <div class="formDiv">
        <div class="signUpDiv animate-slide-up">
          <form action="controller" method="post" enctype="multipart/form-data">
            <div class="form-icon">AGENCY</div>
            <h1>Register Agency</h1>
            <p class="form-subtitle">Join Rwanda's bus platform</p>
            <div class="signUpInput">
              <label>Agency Name</label>
              <div class="input-wrap">
                <i class='bx bx-buildings'></i>
                <input type="text" name="C_Name" placeholder="e.g. Volcano Express" required/>
              </div>
            </div>
            <div class="signUpInput">
              <label>Agency Logo</label>
              <div class="agencyLogoDiv">
                <input type="file" name="C_Logo" required/>
              </div>
            </div>
            <div class="signUpInput">
              <label>Phone Number</label>
              <div class="input-wrap">
                <i class='bx bx-phone'></i>
                <input type="text" name="C_Phone" minlength="10" maxlength="10"
                  pattern="^(079|078|072|073)[0-9]{7}$"
                  title="10-digit number starting with 079, 078, 072, or 073."
                  placeholder="07xxxxxxxx" required/>
              </div>
            </div>
            <div class="signUpInput">
              <label>Agency Email</label>
              <div class="input-wrap">
                <i class='bx bx-envelope'></i>
                <input type="text" name="email" placeholder="name@gmail.com" required/>
              </div>
            </div>
            <div class="signUpInput">
              <label>CEO Name</label>
              <div class="input-wrap">
                <i class='bx bx-user-circle'></i>
                <input type="text" name="C_Ceo" placeholder="e.g. KIZERE Dan" required/>
              </div>
            </div>
            <div class="signUpInput">
              <label>Username</label>
              <div class="input-wrap">
                <i class='bx bx-at'></i>
                <input type="text" name="C_Username" placeholder="Choose a username" required/>
              </div>
            </div>
            <div class="signUpInput">
              <label>Password</label>
              <div class="input-wrap">
                <i class='bx bx-lock-alt'></i>
                <input type="password" name="C_Password" placeholder="********" required/>
              </div>
            </div>
            <div class="signUpButton">
              <input type="submit" name="C_Signup" class="agencySubmit" value="Create Account"/>
            </div>
            <p class="form-link">Already registered? <a href="index?injira">Sign In</a></p>
          </form>
        </div>
      </div>

    <?php else: ?>
      <?php
      $platformStats = fetchPlatformStats($con);
      $upcomingRows = fetchUpcomingTrips($con, 5);
      $allCompanies = mysqli_query($con,"SELECT * FROM company ORDER BY C_Name ASC") or die(mysqli_error($con));
      ?>

      <section class="hero-section">
        <div class="hero-bg-pattern"></div>
        <div class="hero-glow hero-glow-one"></div>
        <div class="hero-glow hero-glow-two"></div>
        <div class="hero-content">
          <div class="hero-text animate-fade-in">
            <span class="hero-kicker">Fast Bus Booking</span>
            <h1 class="hero-title">Book Bus Tickets<br/><span>Across Rwanda</span></h1>
            <p class="hero-desc">Find your route, pick a trusted company, and reserve your seat in minutes.</p>
            <div class="hero-actions">
              <a href="booking" class="hero-btn hero-btn-primary">Book Your Trip</a>
              <a href="#upcomingBuses" class="hero-btn hero-btn-ghost">See Departures</a>
            </div>
            <div class="hero-trust">
              <span><i class='bx bx-shield-quarter'></i> Secure Booking</span>
              <span><i class='bx bx-time-five'></i> Fast Checkout</span>
            </div>
          </div>

          <div class="booking-widget animate-slide-left">
            <div class="widget-header">
              <h2>Find Available Buses</h2>
              <p>Choose your origin and destination</p>
            </div>
            <div class="widget-metrics">
              <div><strong><?php echo number_format($platformStats['routes']); ?>+</strong><span>Routes</span></div>
              <div><strong><?php echo number_format($platformStats['agencies']); ?>+</strong><span>Agencies</span></div>
              <div><strong><?php echo number_format($platformStats['departures_today']); ?></strong><span>Today</span></div>
              <div><strong><?php echo number_format($platformStats['tickets_booked']); ?>+</strong><span>Tickets</span></div>
            </div>
            <form action="controller" method="post" class="booking-form">
              <div class="form-row">
                <div class="form-field">
                  <label for="from"><i class='bx bx-map'></i> From</label>
                  <select id="from" name="crazyFrom" required>
                    <option value="" selected disabled>Select origin...</option>
                    <?php
                    $origins = mysqli_query($con,"SELECT DISTINCT L_from FROM locations ORDER BY L_from ASC") or die(mysqli_error($con));
                    while($thisFrom = mysqli_fetch_assoc($origins)){
                      echo '<option value="'.htmlspecialchars($thisFrom['L_from']).'">'.htmlspecialchars($thisFrom['L_from']).'</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="swap-icon" id="swapBtn" title="Swap routes"><i class='bx bx-transfer-alt'></i></div>
                <div class="form-field">
                  <label for="to"><i class='bx bx-map-pin'></i> To</label>
                  <select id="to" name="crazyTo" required>
                    <option value="" selected disabled>Select destination...</option>
                    <?php
                    $destinations = mysqli_query($con,"SELECT DISTINCT L_to FROM locations ORDER BY L_to ASC") or die(mysqli_error($con));
                    while($thisTo = mysqli_fetch_assoc($destinations)){
                      echo '<option value="'.htmlspecialchars($thisTo['L_to']).'">'.htmlspecialchars($thisTo['L_to']).'</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <button type="submit" name="tangiraOrder" class="search-btn">
                <span>Search Available Buses</span>
                <i class='bx bx-right-arrow-alt'></i>
              </button>
            </form>
          </div>
        </div>
      </section>

      <section class="features-section">
        <div class="section-header">
          <h2>Why Travelers Choose RwandaBus</h2>
          <p>Everything is organized to help customers book quickly and confidently.</p>
        </div>
        <div class="features-grid">
          <article class="feature-card">
            <i class='bx bx-layer'></i>
            <h3>Clear Options</h3>
            <p>Compare routes, prices, and departure times in one organized interface.</p>
          </article>
          <article class="feature-card">
            <i class='bx bx-check-shield'></i>
            <h3>Trusted Agencies</h3>
            <p>Book only with registered companies and reach them easily when needed.</p>
          </article>
          <article class="feature-card">
            <i class='bx bx-mobile-alt'></i>
            <h3>Mobile Friendly</h3>
            <p>Enjoy the same smooth booking experience on phones, tablets, and desktops.</p>
          </article>
        </div>
      </section>

      <section class="cars-section" id="upcomingBuses">
        <div class="section-header">
          <h2>Next Available Departures</h2>
          <p>The first 5 upcoming buses with open seats.</p>
        </div>

        <?php if(count($upcomingRows)>0): ?>
        <div class="buses-grid">
          <?php foreach($upcomingRows as $index => $r): ?>
          <div class="bus-card" style="animation-delay: <?php echo $index * 0.1; ?>s">
            <div class="bus-card-top">
              <div class="agency-name"><?php echo htmlspecialchars($r['C_Name']); ?></div>
              <div class="seats-badge <?php echo $r['seats_left']<=5 ? 'seats-low' : ''; ?>">
                <?php echo (int)$r['seats_left']; ?> seats
              </div>
            </div>
            <div class="route-display">
              <div class="route-city"><?php echo htmlspecialchars($r['L_from']); ?></div>
              <div class="route-arrow">
                <div class="route-line"></div>
                <i class='bx bx-right-arrow-alt'></i>
              </div>
              <div class="route-city"><?php echo htmlspecialchars($r['L_to']); ?></div>
            </div>
            <div class="bus-card-details">
              <div class="detail-item">
                <i class='bx bx-time'></i>
                <span><?php echo htmlspecialchars($r['Time_to_leave']); ?></span>
              </div>
              <div class="detail-item">
                <i class='bx bx-money'></i>
                <span><?php echo number_format((int)$r['price']); ?> RWF</span>
              </div>
              <div class="detail-item">
                <i class='bx bx-id-card'></i>
                <span><?php echo htmlspecialchars($r['Car_Plaque']); ?></span>
              </div>
              <div class="detail-item">
                <i class='bx bx-phone'></i>
                <span><?php echo htmlspecialchars($r['C_Phone']); ?></span>
              </div>
            </div>
            <a href="booking?booking_form=<?php echo (int)$r['id']; ?>" class="get-ticket-btn">
              Get Ticket <i class='bx bx-right-arrow-alt'></i>
            </a>
          </div>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="no-buses">
          <div class="no-buses-icon">BUS</div>
          <h3>No buses available right now</h3>
          <p>Check back soon for upcoming departures.</p>
        </div>
        <?php endif; ?>
      </section>

      <section class="agencies-section">
        <div class="section-header">
          <h2>Explore Bus Companies</h2>
          <p>Search by company name, phone number, or CEO and open tickets instantly.</p>
        </div>

        <div class="company-search-wrap">
          <i class='bx bx-search'></i>
          <input type="search" id="companySearch" placeholder="Search company by name, phone, or CEO" />
        </div>

        <?php if(mysqli_num_rows($allCompanies) > 0): ?>
        <div class="companies-grid" id="companiesGrid">
          <?php while($company = mysqli_fetch_assoc($allCompanies)): ?>
          <a href="booking?company=<?php echo (int)$company['C_Id']; ?>" class="company-card"
             data-company-name="<?php echo strtolower($company['C_Name']); ?>"
             data-company-phone="<?php echo strtolower($company['C_Phone']); ?>"
             data-company-ceo="<?php echo strtolower($company['C_Ceo']); ?>">
            <div class="company-card-image">
              <div class="company-logo-wrap">
                <img class="company-logo" src="<?php echo htmlspecialchars($company['C_Logo']); ?>" alt="<?php echo htmlspecialchars($company['C_Name']); ?>" onerror="this.onerror=null;this.src='dashborad-image.PNG';" />
              </div>
            </div>
            <div class="company-card-content">
              <div class="company-body">
                <h3><?php echo htmlspecialchars($company['C_Name']); ?></h3>
                <p><i class='bx bx-phone'></i> <?php echo htmlspecialchars($company['C_Phone']); ?></p>
                <p><i class='bx bx-user'></i> CEO: <?php echo htmlspecialchars($company['C_Ceo']); ?></p>
              </div>
              <span class="company-link">View Tickets <i class='bx bx-right-arrow-alt'></i></span>
            </div>
          </a>
          <?php endwhile; ?>
        </div>
        <div class="no-companies" id="noCompanies" style="display:none;">
          <h3>No company matched your search.</h3>
        </div>
        <?php else: ?>
        <div class="no-buses">
          <h3>No companies found</h3>
          <p>Please check back later.</p>
        </div>
        <?php endif; ?>
      </section>

    <?php endif; ?>

    <footer class="footer">
      <div class="footer-container">
        <div class="footer-contaner-up">
          <div class="footer-brand">
            <h2 class="footer-logo">Rwanda<span>Bus</span></h2>
            <p>Your trusted partner for bus travel across Rwanda. Safe, affordable, and always on time.</p>
            <div class="footer-contact-line">
              <i class='bx bx-phone'></i> 0789117044
            </div>
          </div>
          <div class="footer-col-holder">
            <div class="col-footer">
              <h3>Platform</h3>
              <ul>
                <li><a href="booking">Booking</a></li>
                <li><a href="#companiesGrid">Agencies</a></li>
                <li><a href="contactUs">Contact Us</a></li>
              </ul>
            </div>
            <div class="col-footer">
              <h3>Quick Links</h3>
              <ul>
                <li><a href="booking">Book Now</a></li>
                <li><a href="index?injira">Agency Login</a></li>
              </ul>
            </div>
            <div class="col-footer">
              <h3>Newsletter</h3>
              <div class="footer-form">
                <h4>Get Updates & Offers</h4>
                <form action="#" class="subscribe" method="post">
                  <input type="email" placeholder="Your email address"/>
                  <button type="submit">Subscribe</button>
                </form>
                <p>No spam. Unsubscribe anytime.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-line"></div>
        <div class="footer-container-down">
          <div class="footer-text-left">
            <p>© <?php echo date('Y'); ?> Rwanda-Bus. All rights reserved.</p>
          </div>
          <ul class="footer-social">
            <li><a href="#facebook"><i class="bx bxl-facebook-circle"></i></a></li>
            <li><a href="#linkedin"><i class="bx bxl-linkedin"></i></a></li>
            <li><a href="#twitter"><i class="bx bxl-twitter"></i></a></li>
            <li><a href="#google"><i class="bx bxl-gmail"></i></a></li>
            <li><a href="#github"><i class="bx bxl-github"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>

    <script src="js/scroll.js"></script>
    <script src="js/main.js"></script>
    <script src="js/chatbot.js"></script>
  </body>
</html>
