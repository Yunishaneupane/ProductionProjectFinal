<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us | EduPath</title>
  <link rel="stylesheet" href="contactus.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>

  <!-- HEADER -->
  <?php include 'header.php'; ?>

  <!-- HERO SECTION -->
  <section class="contact-hero">
  <div class="overlay">
    <div class="hero-text">
      <h1>We are here for you!</h1>
      <p>"Please fill out our form, and we’ll get in touch with you as soon as possible."

</p>
    </div>
  </div>
</section>


  <!-- CONTACT FORM -->
  <section class="contact-form-section">
    <div class="form-container">
      <h2>Contact us for more information about working with EduPath</h2>
      <form>
        <div class="form-group">
          <input type="text" placeholder="First Name" required />
          <input type="text" placeholder="Last Name" required />
        </div>
        <div class="form-group">
          <input type="email" placeholder="Email Address" required />
          <input type="text" placeholder="Phone Number" />
        </div>
        <textarea placeholder="Your Message" rows="6" required></textarea>
        <button type="submit">Submit</button>
      </form>
    </div>
  </section>


  <!-- Scrollable Team Card Section -->
<section class="scroll-team-section">
  <div class="scroll-card-container" id="teamCardSlider">
    <div class="card-scroll-indicator">
      <div class="dot active" onclick="showTeamCard(0)"></div>
      <div class="dot" onclick="showTeamCard(1)"></div>
      <div class="dot" onclick="showTeamCard(2)"></div>
    </div>

    <!-- Card Slides -->
    <div class="scroll-card-text" id="cardText">
      <h2>We're Here to Help</h2>
      <p>Get technical support for our platform, assist with bugs or troubleshooting, and more. Our expert team is always ready.</p>
    </div>
    <div class="scroll-card-image" id="cardImage">
      <img src="images/me.jpg" alt="Team 1">
    </div>
  </div>
</section>



<script>
  const teamSlides = [
    {
      title: "We're Here to Help",
      text: "Get technical support for our platform, assist with bugs or troubleshooting, and more. Our expert team is always ready.",
      img: "images/me.jpg"
    },
    {
      title: "Flexible Billing Support",
      text: "Have questions about pricing, licensing, or account management? We’ve got you covered with tailored assistance.",
      img: "images/me.jpg"
    },
    {
      title: "Expert Product Guidance",
      text: "Evaluating our services? Let our experts guide you to the best fit and ensure you're set for success.",
      img: "images/contact3.jpg"
    }
  ];

  function showTeamCard(index) {
    // Update text
    document.getElementById('cardText').innerHTML = `
      <h2>${teamSlides[index].title}</h2>
      <p>${teamSlides[index].text}</p>
    `;

    // Update image
    document.getElementById('cardImage').innerHTML = `
      <img src="${teamSlides[index].img}" alt="Team ${index + 1}">
    `;

    // Update active dot
    document.querySelectorAll('.card-scroll-indicator .dot').forEach((dot, i) => {
      dot.classList.toggle('active', i === index);
    });
  }
</script>


  <!-- FOOTER -->
  <?php include 'footer.php'; ?>

</body>
</html>
