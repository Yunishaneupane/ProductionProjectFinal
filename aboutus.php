<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us - EduPath</title>
  <link rel="stylesheet" href="aboutus.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>


<?php 
 
include 'header.php'; 
?>






<!-- ABOUT US SECTION -->
<section class="about-hero">
  <div class="about-left">
    <h1>Find your dream university<br>today</h1>
  </div>
  <div class="about-right">
    <img src="images/aboutus1.png" alt="Illustration of student" />
  </div>
</section>


<!-- ---------------------------------- -->

<section class="transcript-upload-section">
  <h2>Get Personalized University Recommendations</h2>
  <p>Upload your academic transcript and we'll suggest universities that match your profile.</p>

  <form method="POST" enctype="multipart/form-data" class="transcript-form">
    <input type="file" id="transcript" name="transcript" accept=".pdf,.jpg,.png" required>
    <span id="file-name">No file selected</span>
    <button type="submit" name="analyze">Upload Transcript</button>
  </form>

  <?php if (!empty($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
</section>

<!-- ---------------------------------- -->

<section class="ranking-cards-container">
  <div class="ranking-card">
    <img src="images/aboutus2.jpg" alt="QS World Rankings 2025">
    <h2>QS World University Rankings 2025</h2>
    <p>Discover the top-performing universities around the world</p>
    <a href="#" class="explore-btn">Explore &rarr;</a>
  </div>

  <div class="ranking-card">
    <img src="images/aboutus2.jpg" alt="QS World Rankings by Subject 2025">
    <h2>QS World University Rankings by Subject 2025</h2>
    <p>Find out which universities excel in your chosen subject</p>
    <a href="#" class="explore-btn">Explore &rarr;</a>
  </div>

  <div class="ranking-card">
    <img src="images/aboutus2.jpg" alt="QS Asia Rankings 2025">
    <h2>QS World University Rankings: Asia 2025</h2>
    <p>Study at one of the best universities in Asia. Explore our ranking of Asian universities.</p>
    <a href="#" class="explore-btn">Explore &rarr;</a>
  </div>
</section>




<!-- QS SUPPORT SECTION -->
<section class="qs-support-section">
  <h2>How QS can support you</h2>
  <p class="qs-subheading">
    We're here to support you through all stages of the university journey; whether it's researching institutions, navigating admissions or submitting your application.
  </p>

  <div class="qs-timeline">
    <div class="qs-entry">
      <img src="images/enroll-1.png" alt="Student with laptop" />
      <div class="qs-content">
        <h3>Find the right course for you</h3>
        <p>Our course matching tool features thousands of programmes and uses your personal study preferences to find the right course for you.</p>
        <a href="/find-course" class="qs-btn">Find Your Course →</a>
      </div>
    </div>

    <div class="qs-entry reverse">
      <img src="images/enroll-2.png" alt="Jumping over world map" />
      <div class="qs-content">
        <h3>Easily compare universities with QS rankings</h3>
        <p>Filter our rankings by region or subject to compare university performance in factors that matter to you including reputation, employability and sustainability.</p>
        <a href="/rankings" class="qs-btn">Explore Rankings →</a>
      </div>
    </div>
  </div>
</section>



<!-- FOR STUDENTS SECTION -->
<section class="highlight-section">
  <div class="highlight-wrapper reverse">
    <div class="highlight-text">
      <p class="label"><i class="fas fa-graduation-cap"></i> For students</p>
      <h2>Find your perfect course to study abroad or online</h2>
      <p>Find your Best-Fit study among more than 245,000 bachelors, masters, PhDs, short courses or online programmes globally.</p>
      <a href="forstudent.php" class="highlight-btn">For students</a>
    </div>
    <div class="highlight-image">
      <img src="images/forstudents.jpg" alt="Students studying" />
    </div>
  </div>
</section>

<!-- FOR INSTITUTIONS SECTION -->
<section class="highlight-section">
  <div class="highlight-wrapper">
    <div class="highlight-image">
      <img src="images/forinstitutions.jpg" alt="University campus" />
    </div>
    <div class="highlight-text">
      <p class="label"><i class="fas fa-building"></i> For institutions</p>
      <h2>Your partner for digital, direct and truly global student recruitment</h2>
      <p>Reach and enrol the most diverse, independent students looking for the best university match globally, and realise your international student recruitment ambitions.</p>
      <a href="forinstitution.php" class="highlight-btn">For institutions</a>
    </div>
  </div>
</section>


<!-- GLOBAL STUDENT SATISFACTION SECTION -->
<section class="student-award-section">
  <div class="student-award-wrapper">
    <div class="award-text">
      <h2>Empower students through education</h2>
      <p>
        The Global Student Satisfaction Awards empower students across the globe
        to determine the best universities of 2025.
      </p>
      <button class="award-btn" onclick="toggleMoreInfo()">Read more here</button>
      <p id="more-info" class="more-info">
        These awards are based on feedback from thousands of students globally, assessing their satisfaction
        with teaching quality, campus facilities, international experience, and career opportunities.
        The initiative provides an authentic student voice in shaping future education standards.
      </p>
    </div>
    <div class="award-image">
      <img src="images/studentsatisfaction.jpg" alt="Global Student Satisfaction" />
    </div>
  </div>
</section>

<script>
  function toggleMoreInfo() {
    const moreInfo = document.getElementById("more-info");
    moreInfo.style.display = moreInfo.style.display === "block" ? "none" : "block";
  }
</script>



<section class="testimonial-section">
  <h2 class="testimonial-title">What students say</h2>
  <p class="testimonial-subtitle">Hear how we’ve supported students like you to find their perfect study destination</p>

  <div class="testimonial-carousel">
    <button class="testimonial-nav">&lt;</button>

    <div class="testimonial-card orange">
      <p class="quote">“My counsellor’s assistance at every step has been invaluable, and I cannot thank him enough for making my dreams a reality.”</p>
      <div class="testimonial-footer">
        <div class="testimonial-user">
          <img src="images/aboutus3swoopna.jpg" alt="Pranay" />
          <div>
            <h4>Swoopna Suman</h4>
            <p>Master of Science in Global Logistics, W.P. Carey School of Business, Arizona State University</p>
          </div>
        </div>
      </div>
    </div>

    <div class="testimonial-card image-card">
      <img src="images/aboutus3swoopna.jpg" alt="Pranay">
      <div class="info">
        <h4>Pranay Kasat</h4>
        <p>Master of Science in Global Logistics, W.P. Carey School of Business, Arizona State University</p>
      </div>
    </div>

    <div class="testimonial-card orange">
      <p class="quote">“QS were a huge help from the very beginning. When I felt overwhelmed, it was my counsellor who helped me to clarify my goals and find a programme best suited for my future.”</p>
      <div class="testimonial-footer">
        <div class="testimonial-user">
          <img src="images/aboutus3swoopna.jpg" alt="Bibil" />
          <div>
            <h4>Bibil Jose</h4>
            <p>BSc in Mechanical Engineering, Arizona State University</p>
          </div>
        </div>
      </div>
    </div>

    <button class="testimonial-nav">&gt;</button>
  </div>
</section>

<script>

document.addEventListener("DOMContentLoaded", () => {
  const levelSelect = document.getElementById("level");
  const destinationSelect = document.getElementById("destination");
  const subjectSelect = document.getElementById("subject");

  // Load Study Levels manually
  const studyLevels = ["Bachelor's", "Master's", "PhD"];
  levelSelect.innerHTML = '<option disabled selected>Select Study Level</option>';
  studyLevels.forEach(level => {
    levelSelect.innerHTML += `<option value="${level}">${level}</option>`;
  });

  // Load destinations dynamically from universities.json
  fetch('data.json')
    .then(response => response.json())
    .then(universities => {
      const countries = [...new Set(universities.map(u => u.country))];
      destinationSelect.innerHTML = '<option disabled selected>Select Destination</option>';
      countries.forEach(country => {
        destinationSelect.innerHTML += `<option value="${country}">${country}</option>`;
      });
    });

  // Load subjects dynamically from fields.json
  fetch('fields.json')
    .then(response => response.json())
    .then(fields => {
      subjectSelect.innerHTML = '<option disabled selected>Select Subject</option>';
      fields.forEach(field => {
        subjectSelect.innerHTML += `<option value="${field.name}">${field.name}</option>`;
      });
    });

  // Handle form submission
  document.getElementById("search-form").addEventListener("submit", (e) => {
    e.preventDefault();

    // Check login before searching
    fetch('check_login.php')
      .then(response => response.json())
      .then(data => {
        if (data.loggedIn) {
          const selectedLevel = levelSelect.value;
          const selectedDestination = destinationSelect.value;
          const selectedSubject = subjectSelect.value;

          let redirectPage = "";
          if (selectedLevel === "Bachelor's") {
            redirectPage = "bachelor_data.php";
          } else if (selectedLevel === "Master's") {
            redirectPage = "master_data.php";
          } else if (selectedLevel === "PhD") {
            redirectPage = "phd_data.php";
          }

          // If selections are valid, redirect with parameters
          if (redirectPage && selectedDestination && selectedSubject) {
            window.location.href = `${redirectPage}?destination=${encodeURIComponent(selectedDestination)}&subject=${encodeURIComponent(selectedSubject)}`;
          } else {
            alert("⚠️ Please select Study Level, Destination, and Subject.");
          }
        } else {
          alert("⚠️ You must be logged in to search!");
          window.location.href = "login.php"; // Redirect to login page
        }
      })
      .catch(error => {
        console.error('Login check failed:', error);
      });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const transcriptInput = document.getElementById("transcript");
  const fileNameSpan = document.getElementById("file-name");

  if (transcriptInput) {
    transcriptInput.addEventListener("change", () => {
      const file = transcriptInput.files[0];
      fileNameSpan.textContent = file ? file.name : "No file selected";
    });
  }
});




</script>

<?php include 'footer.php'; ?>
</body>
</html>
