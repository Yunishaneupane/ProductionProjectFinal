<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduPath | Home</title>
  <link rel="stylesheet" href="homestyle.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>


<!-- HERO SECTION with background video -->
<section class="hero-video-container">
  <video autoplay muted loop playsinline class="background-video">
    <source src="images/homevideo.mp4" type="video/mp4" />
    Your browser does not support the video tag.
  </video>

  <div class="hero-content">
    <h1>Start your journey<br>with the right university</h1>
    <div class="hero-buttons">
      <a class="hero-btn" href="forstudent.php">🎓 I’m a student</a>
      <a class="hero-btn secondary" href="forinstitution.php">🏢 I’m an institution</a>
    </div>
  </div>
</section>

<!-- ---------------------------------- -->

<section class="admission-section">
  <p class="admission-subtext">
    Your journey begins here - Stay informed with the latest admission notices and updates
  </p>
  <h1 class="admission-title">
    Explore - Gateway to Academic Excellence
  </h1>
  <a href="forstudent.php">
    <button class="explore-btn">Explore</button>
  </a>
</section>


<!-- ---------------------------------- -->

<section class="edu-section">
  <div class="edu-content">
    <p class="edu-label">Guided Discovery</p>
    <h2 class="edu-title">A New Way to Explore Universities</h2>
    <p class="edu-desc">
      EduPath redefines how students discover their ideal university. From smart search filters to personalized recommendations powered by data, we make it easier than ever to compare programs, explore campuses, and find your perfect academic match—all in one place.
    </p>
    <a href="forstudent.php" class="edu-btn"> See Universities ▸</a>
  </div>
  <div class="edu-image">
    <img src="images/homestd.jpg" alt="Students walking">
  </div>
</section>



<!-- ---------------------------------- -->


<section class="discover-section">
  <h2 class="discover-heading">Discover universities across the world</h2>
  <p class="discover-subheading">
    We compare universities in 28 countries, giving you plenty of options to find the right one.
  </p>
  <div class="country-cards">
    <div class="country-card">
      <img src="images/uk.png" alt="United Kingdom">
      <div class="card-footer">
        <span>United Kingdom</span>
        <span class="arrow">›</span>
      </div>
    </div>
    <div class="country-card">
      <img src="images/aus.jpeg" alt="Australia">
      <div class="card-footer">
        <span>Australia</span>
        <span class="arrow">›</span>
      </div>
    </div>
    <div class="country-card">
      <img src="images/usa.jpg" alt="United States">
      <div class="card-footer">
        <span>United States</span>
        <span class="arrow">›</span>
      </div>
    </div>
    <div class="country-card">
      <img src="images/canada.jpg" alt="Canada">
      <div class="card-footer">
        <span>Canada</span>
        <span class="arrow">›</span>
      </div>
    </div>
  </div>
</section>


<!-- ---------------------------------- -->


<section class="breathe-section">
  <div class="breathe-left">

  <video src="images/relax.mp4"
   poster="images/thumbnail.png"
       playsinline
       controls
       class="tiny-video">
</video>

  </div>

  <div class="breathe-right">
    <h2><strong>Breathe deeply, succeed effortlessly.</strong></h2>
    <p>Gather your study group at your favorite coffee shop, sip iced coffee, and review these tools to feel confident in your academic journey. You got this!</p>

    <div class="resource-block">
      <img src="images/collegeicon.png" alt="Notebook Icon">
      <div>
        <h3>Explore Colleges and Apply Now</h3>
        <p>Discover top colleges tailored to your goals. Start your application journey today with expert-backed tools and guidance.</p>
        <a href="/apply" class="resource-btn">Explore Now</a>
      </div>
    </div>

    <div class="resource-block">
      <img src="images/study.png" alt="Notebook Icon">
      <div>
        <h3>Connect with us Now</h3>
        <p>Textbooks, study guides, and notes are great, but improving your study habits can make a big difference. Boost focus, reduce stress, and stay motivated to reset anytime.</p>
        <a href="/reset-tips" class="resource-btn">Hit Reset</a>
      </div>
    </div>

    <div class="resource-block">
      <img src="images/music.png" alt="Music Icon">
      <div>
        <h3>Lofi Beats for Study Time</h3>
        <p>Drown out the distractions with these Lofi beats to keep you company while you study, plan, and work toward your goals.</p>
        <a href="https://www.youtube.com/watch?v=jfKfPfyJRdk" target="_blank" class="resource-btn">Listen Now</a>
      </div>
    </div>
  </div>
</section>


<!-- ---------------------------------- -->



<!-- ---------------------------------- -->

<section class="why-edupath">
  <h2 class="section-title">Why EDUPATH Finder?</h2>
  <div class="why-grid">
    <div class="why-card">
      <h3>Affordability For All </h3>
      <p>World-class learning, low-cost tuition, and the power to pursue your dreams for less.</p>
    </div>
    <div class="why-card">
      <h3>Committment to Success</h3>
      <p>Our dedicated faculty offer personalized mentorship and an immersive, practical education to help you excel.</p>
    </div>
    <div class="why-card">
      <h3>Career and World-Ready</h3>
      <p>We offer career resources and support for life. Supported by a guaranteed alumni mentor and wide-reaching 94,000+ strong alumni network.</p>
    </div>
    <div class="why-card">
      <h3>Success by the Lake</h3>
      <p>Our lakeside campus offers a serene environment for learning and living, with soothing waves and breathtaking sunsets. It’s truly a unique experience.</p>
    </div>
  </div>
</section>

<!-- START STRONG SECTION -->
<section class="start-strong-section">
  <div class="start-strong-wrapper">
    <div class="start-strong-text">
      <p class="start-label">Connect with us.</p>
      <h2 class="start-title">Start strong. Go far.</h2>
      <div class="start-underline"></div>
      <p class="start-description">
        Whether you're discovering your passion or taking the next step in your journey, EduPath provides the experiences, mentors, and opportunities to guide you every step of the way.
      </p>
      <a href="forstudent.php" class="start-btn">Explore</a>
    </div>
    <div class="start-strong-image">
      <img src="images/students.jpg" alt="Students Group" />
    </div>
  </div>
</section>

<!-- === VISIT CAMPUS SECTION === -->
<section class="visit-campus-section">
  <div class="visit-campus-overlay">
    <div class="visit-campus-content">
      <p class="visit-subtitle">YOUR STORY STARTS HERE</p>
      <h2 class="visit-heading">Visit Edu Path</h2>
      <p class="visit-description">
        We are excited to welcome you and your family for a campus tour. Led by a current EduPath student, 
        learn more about what makes our lakeside campus truly unique.
      </p>
      <a href="forstudent.php" class="visit-button">PLAN YOUR VISIT</a>
    </div>
  </div>
</section>





<?php include 'footer.php'; ?>



<script>
  const slides = document.querySelectorAll('.slide');
  let current = 2;

  function updateSlider() {
    slides.forEach((slide, index) => {
      slide.classList.remove('active');
    });

    slides[current].classList.add('active');

    // Scroll effect
    const offset = (current - 2) * (200 + 32); // slide width + gap
    document.querySelector('.slider').style.transform = `translateX(-${offset}px)`;
  }

  setInterval(() => {
    current = (current + 1) % slides.length;
    updateSlider();
  }, 2000);
</script>




</body>
</html>
