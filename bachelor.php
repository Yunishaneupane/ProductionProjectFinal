<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bachelor Portal</title>
  <link rel="stylesheet" href="bachelor.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>

<?php include 'header.php'; ?>

<link rel="stylesheet" href="bachelor.css" />

<section class="bachelor-hero">
  <h1>Find your dream study</h1>
  <p>Discover thousands of Bachelor's degrees worldwide!</p>

  <div class="bachelor-search">
    <input type="text" placeholder="Search by name..." />
    <button>Search</button>
  </div>
</section>

<section class="bachelor-steps">
  <div class="step">
    <img src="images/explore.png" alt="Explore Icon" />
    <h3>Explore</h3>
    <p>You can browse more than 10,000 Bachelor’s programmes from all over the world.</p>
  </div>

  <div class="step">
    <img src="images/explore.png" alt="Compare Icon" />
    <h3>Compare</h3>
    <p>Make a wishlist of your favourite programmes, check your fit with them, and read what other students are saying.</p>
  </div>

  <div class="step">
    <img src="images/explore.png" alt="Decide Icon" />
    <h3>Decide</h3>
    <p>Now that you have your top programmes shortlisted, you can pick the ones that fit you the best.</p>
  </div>

  <div class="step">
    <img src="images/explore.png" alt="Apply Icon" />
    <h3>Apply</h3>
    <p>When you feel confident about your programme choice, you can apply.</p>
  </div>
</section>



<section class="what-to-expect">
  <h2>What to expect</h2>
  <div class="expect-grid">

    <div class="expect-card">
      <div class="expect-icon">👥</div>
      <h3>Explore and engage</h3>
      <p>Meet a variety of university and business school representatives and alumni at their booths. Discuss your goals and experience and get answers straight from the source.</p>
    </div>

    <div class="expect-card">
      <div class="expect-icon">🤝</div>
      <h3>Personal meetings</h3>
      <p>At our Connect and Connect+ events, we’ll use your CV to match you with universities or business schools small group meetings. It’s a chance for more in-depth discussions with your best-fit institutions.</p>
    </div>

    <div class="expect-card">
      <div class="expect-icon">🎤</div>
      <h3>Panels and seminars</h3>
      <p>Events include expert-led panels, Q&amp;A sessions, seminars and workshops to help you choose the right programme and become a stronger applicant.</p>
    </div>

    <div class="expect-card">
      <div class="expect-icon">📘</div>
      <h3>Expert insights</h3>
      <p>Have questions about admissions tests, language requirements, or funding? Meet IELTS, GRE and GMAT providers, CV experts, and financial advisors at our events.</p>
    </div>

    <div class="expect-card">
      <div class="expect-icon">💰</div>
      <h3>Exclusive scholarships</h3>
      <p>As an event attendee, you can apply to our exclusive QS ImpACT Scholarships.</p>
    </div>

    <div class="expect-card">
      <div class="expect-icon">🧑‍💼</div>
      <h3>QS info desk</h3>
      <p>Our knowledgeable and experienced team is readily available to assist you throughout the event.</p>
    </div>

  </div>
</section>

<!-- 
<div class="university-card">
  <div class="card-header">
    <img src="images/college-profile.jpg" alt="College" class="college-img" />
    <div class="college-info">
      <h3>Oxford University</h3>
      <p><i class="fas fa-map-marker-alt"></i> Oxford, United Kingdom</p>
    </div>
  </div>

  <div class="card-footer">
    <button class="view-btn">View University</button>
    <button class="programs-btn">View Programs</button>
    <div class="card-actions">
      <button class="contact-btn"><i class="fas fa-envelope"></i> Contact</button>
      <button class="wishlist-btn"><i class="fas fa-heart"></i> Wishlist</button>
    </div>
  </div>
</div> -->



<?php include 'footer.php'; ?>


</body>
</html>
