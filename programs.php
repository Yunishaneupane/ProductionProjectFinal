<?php
$universities = json_decode(file_get_contents("data.json"), true);
$universityId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$selectedUniversity = null;
foreach ($universities as $uni) {
  if ($uni['university_id'] === $universityId) {
    $selectedUniversity = $uni;
    break;
  }
}

if (!$selectedUniversity) {
  echo "<h2 style='text-align:center; padding: 3rem;'>University not found.</h2>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?php echo $selectedUniversity['name']; ?> - Programs</title>
  <link rel="stylesheet" href="bachelor.css">
  <style>
    .program-hero {
      background: url("images/finduni.jpg") center/cover no-repeat;
      position: relative;
      color: white;
      padding: 100px 20px 80px;
      text-align: center;
    }

    .program-hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 0;
    }

    .program-hero h1,
    .program-hero p {
      position: relative;
      z-index: 1;
    }

    .uni-details {
      max-width: 800px;
      background: #fff;
      margin: -60px auto 2rem;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      text-align: center;
      position: relative;
      z-index: 1;
    }

    .uni-details img {
      max-width: 150px;
      border-radius: 10px;
      margin-bottom: 1rem;
    }

    .program-category {
      background-color: #f9f9f9;
      padding: 2rem;
      text-align: center;
    }

    .program-category h2 {
      font-size: 2rem;
      margin-bottom: 1rem;
    }

    .back-btn {
      display: inline-block;
      margin: 2rem auto 0;
      padding: 10px 20px;
      background-color: #004080;
      color: #fff;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    .back-btn:hover {
      background-color: #002b5e;
    }

    .category-card {
      max-width: 600px;
      margin: 0 auto;
      background: #ffffff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .category-card:hover {
      transform: translateY(-4px);
    }

    .category-card h2 {
      color: #004080;
      font-size: 1.8rem;
      margin-bottom: 1rem;
    }

    .category-card h3 {
      font-size: 1.3rem;
      color: #222;
      margin-bottom: 0.5rem;
    }

    .category-card p {
      font-size: 1rem;
      color: #444;
      line-height: 1.5;
    }
  </style>
</head>

<body>

  <?php include 'header.php'; ?>

  <section class="program-hero">
    <h1><?php echo $selectedUniversity['name']; ?></h1>
    <p>Explore program offerings and details</p>
  </section>

  <div class="uni-details">
    <img src="<?php echo $selectedUniversity['image_url']; ?>" alt="Logo">
    <h2><?php echo $selectedUniversity['name']; ?></h2>
    <p><strong>Country:</strong> <?php echo $selectedUniversity['country']; ?> |
      <strong>Ranking:</strong> #<?php echo $selectedUniversity['ranking']; ?>
    </p>
    <p style="margin-top: 1rem;"><?php echo $selectedUniversity['details']; ?></p>
  </div>

  <section class="program-category">
    <div class="category-card">
      <h2>Program Category</h2>
      <h3><?php echo $selectedUniversity['category']['name']; ?></h3>
      <p><?php echo $selectedUniversity['category']['description']; ?></p>
    </div>
  </section>

  <div style="text-align:center;">
    <a class="back-btn" href="javascript:history.back()"><i class="fas fa-arrow-left"></i> Back</a>
  </div>

  <?php include 'footer.php'; ?>
</body>

</html>