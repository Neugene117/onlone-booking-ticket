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
      <div class="contact-bg-orb orb-one"></div>
      <div class="contact-bg-orb orb-two"></div>

      <div class="contact-shell">
        <div class="contact-intro animate-rise">
          <span class="contact-kicker">Customer Support</span>
          <h1>Let’s Help You Travel With Confidence</h1>
          <p>Share your question and our team will respond as quickly as possible with the right support.</p>

          <div class="contact-info-grid">
            <article class="contact-info-card">
              <i class='bx bx-phone-call'></i>
              <div>
                <h3>Call Us</h3>
                <p>0789117044</p>
              </div>
            </article>
            <article class="contact-info-card">
              <i class='bx bx-envelope'></i>
              <div>
                <h3>Email</h3>
                <p>support@rwandabus.rw</p>
              </div>
            </article>
            <article class="contact-info-card">
              <i class='bx bx-time-five'></i>
              <div>
                <h3>Working Hours</h3>
                <p>Mon - Sat, 7:00 AM - 9:00 PM</p>
              </div>
            </article>
          </div>
        </div>

        <div class="contact-card animate-rise delay-sm">
          <h2>Send a Message</h2>
          <p>Complete the form below and we will get back to you shortly.</p>
          <form id="contact-form" method="POST" action="brain">
            <div class="input-group">
              <label for="name">Name</label>
              <input type="text" id="name" name="nam" placeholder="Your full name" required />
            </div>

            <div class="input-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" placeholder="you@example.com" required />
            </div>

            <div class="input-group">
              <label for="subject">Subject</label>
              <input type="text" id="subject" name="subject" placeholder="How can we help?" required />
            </div>

            <div class="input-group">
              <label for="message">Message</label>
              <textarea id="message" name="message" rows="5" placeholder="Write your message..." required></textarea>
            </div>

            <button type="submit" name="feed">
              Send Message
              <i class='bx bx-send'></i>
            </button>
          </form>
        </div>
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

