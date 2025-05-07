<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>For Students - EduPath</title>
  <link rel="stylesheet" href="forstudentstyle.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

<!-- FOR STUDENTS SECTION -->
<section class="students-hero">
  <div class="students-overlay">
    <div class="students-inner">

      <div class="students-searchbox">
        <select>
          <option><b>Study level</b></option>
          <option>Bachelor</option>
          <option>Master</option>
          <option>PhD</option>
        </select>
        <select>
          <option><b>Study destination</b></option>
          <option>USA</option>
          <option>UK</option>
          <option>Canada</option>
        </select>
        <select>
          <option><b>Subject</b></option>
          <option>Computer Science</option>
          <option>Engineering</option>
          <option>Business</option>
        </select>
        <button class="search-btn">
  <i class="fas fa-search"></i>&nbsp;Search
</button>

      </div>
    </div>
  </div>
</section>




<!-- STATS SECTION -->
<section class="stats-section">
  <div class="stats-card">
    <div class="stat">
      <img src="images/universitysvg.png" alt="Institution Icon">
      <h2>3,500+</h2>
      <p>featured institutions</p>
    </div>
    <div class="stat">
      <img src="images/books.png" alt="Programs Icon">
      <h2>245,000+</h2>
      <p>programmes listed globally</p>
    </div>
    <div class="stat">
      <img src="images/profile.png" alt="Portals Icon">
      <h2>3</h2>
      <p>portals</p>
    </div>
  </div>
</section>

<!-- PORTALS SECTION -->
<section class="portals-section">
  <p class="portals-subtitle">What course are you looking for?</p>
  <h2 class="portals-title">Discover our portals</h2>

  <div class="portal-cards">
    <!-- Bachelors -->
    <div class="portal-card">
      <div class="portal-header">
        <img src="images/gradicon.png" alt="Bachelor Icon" />
        <div>
          <span class="portal-type orange">Bachelors</span><br />
          <span class="portal-label blue">Portal</span>
        </div>
      </div>
      <h3>Bachelor's programmes</h3>
      <p>
        Choose from more than 105,000 Bachelor’s programmes at universities, colleges and schools worldwide.
      </p>
      <a href="aboutus.php" class="portal-btn">Search bachelors</a>
    </div>

    <!-- Masters -->
    <div class="portal-card">
      <div class="portal-header">
        <img src="images/gradicon.png" alt="Masters Icon" />
        <div>
          <span class="portal-type orange">Masters</span><br />
          <span class="portal-label blue">Portal</span>
        </div>
      </div>
      <h3>Master's programmes</h3>
      <p>
        Find and compare more than 102,000 Master’s degrees from top universities worldwide.
      </p>
      <a href="aboutus.php" class="portal-btn">Search masters</a>
    </div>

    <!-- PhD -->
    <div class="portal-card">
      <div class="portal-header">
        <img src="images/gradicon.png" alt="PhD Icon" />
        <div>
          <span class="portal-type orange">PhD</span><br />
          <span class="portal-label blue">Portal</span>
        </div>
      </div>
      <h3>PhD programmes</h3>
      <p>
        PhD, professional doctorates and other Doctoral degrees at graduate schools, universities and research institutes.
      </p>
      <a href="aboutus.php" class="portal-btn">Search PhDs</a>
    </div>
  </div>
</section>





<section class="short-courses-section">
  <div class="short-courses-content">
    <p class="highlight">Explore courses</p>
    <h2>Learn more in less time</h2>
    <p class="description">
      Find and compare international summer/winter schools, study abroad semesters, conferences, short courses and certificate programmes across the world on
      <a href="#">Courses Portal</a>.
    </p>
    <button class="short-courses-btn">Search courses</button>
  </div>
  <div class="short-courses-image">
    <img src="images/laptop.jpg" alt="Short courses students" />
  </div>
</section>




<section class="gradient-banner">
  <div class="gradient-banner-content">
    <h2>EduPath alumni succeed <br>at world-leading universities</h2>
    <p>
      ~ Many EduPath users have been accepted into top institutions.
    </p>
  </div>
</section>





<?php include 'footer.php'; ?>
</body>
</html>

