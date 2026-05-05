<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rwanda-Bus || Contact Us</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/navbar.css" />
    <link rel="stylesheet" href="css/footer.css" />
    <link rel="stylesheet" href="css/contactUs.css" />
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

    <section class="contact-page">
      <div class="contact-card">
        <h1>Contact Us</h1>
        <p>Have questions? Send us a message and we will help quickly.</p>
        <form id="contact-form" method="POST" action="brain">
          <label for="name">Name</label>
          <input type="text" id="name" name="nam" required />

          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />

          <label for="subject">Subject</label>
          <input type="text" id="subject" name="subject" required />

          <label for="message">Message</label>
          <textarea id="message" name="message" rows="5" required></textarea>

          <button type="submit" name="feed">Send Message</button>
        </form>
      </div>
    </section>

    <footer class="footer">
      <div class="footer-container">
        <div class="footer-contaner-up">
          <div class="footer-brand">
            <h2 class="footer-logo">Rwanda<span>Bus</span></h2>
            <p>Safe and reliable bus ticket booking across Rwanda.</p>
            <div class="footer-contact-line"><i class='bx bx-phone'></i> 0789117044</div>
          </div>
          <div class="footer-col-holder">
            <div class="col-footer">
              <h3>Pages</h3>
              <ul>
                <li><a href="index">Home</a></li>
                <li><a href="booking">Booking</a></li>
                <li><a href="contactUs">Contact Us</a></li>
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

    <script src="js/main.js"></script>
    <script src="js/chatbot.js"></script>
  </body>
</html>

