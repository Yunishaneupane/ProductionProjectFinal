<?php


// Sample university data (in a real application, this would come from a database)
$university_data = [
    'name' => 'Delhi University',
    'total_applications' => 158,
    'new_applications' => 25,
    'profile_views' => 1250,
    'program_stats' => [
        [
            'name' => 'B.Tech Computer Science',
            'applications' => 45,
            'available_seats' => 60
        ],
        [
            'name' => 'BBA',
            'applications' => 38,
            'available_seats' => 120
        ],
        [
            'name' => 'B.Sc Physics',
            'applications' => 28,
            'available_seats' => 40
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Portal - EduPath</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .university-dashboard {
            margin-top: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .stat-card i {
            font-size: 2.5rem;
            color: #e74c3c;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-light);
            font-size: 1.1rem;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .action-btn {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: var(--shadow);
            text-align: center;
            text-decoration: none;
            color: var(--text-dark);
            transition: transform 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .action-btn:hover {
            transform: translateY(-5px);
        }

        .action-btn i {
            font-size: 2rem;
            color: #e74c3c;
            margin-bottom: 1rem;
            display: block;
        }

        .program-stats {
            background: var(--white);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: var(--shadow);
        }

        .program-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }

        .program-table th,
        .program-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .program-table th {
            font-weight: 600;
            color: var(--text-dark);
            background: #f8f9fa;
        }

        .seats-available {
            color: #27ae60;
            font-weight: 500;
        }

        .applications-count {
            background: #e1f5fe;
            color: var(--primary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-weight: 500;
            display: inline-block;
        }

        .welcome-banner {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 3rem;
        }

        .welcome-banner h1 {
            margin-bottom: 1rem;
            font-size: 2rem;
        }

        .portal-switch {
            background: #f8f9fa;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            margin-left: 1rem;
        }

        .portal-switch i {
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
<?php include '../header.php'; ?>
   
    <div class="container" style="margin-top: 5rem;">
        <div class="welcome-banner">
            <h1>Welcome, <?php echo $university_data['name']; ?>!</h1>
            <p>Manage your university profile and track student applications</p>
        </div>

        <main class="university-dashboard">
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-file-alt"></i>
                    <div class="stat-number"><?php echo $university_data['total_applications']; ?></div>
                    <div class="stat-label">Total Applications</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-bell"></i>
                    <div class="stat-number"><?php echo $university_data['new_applications']; ?></div>
                    <div class="stat-label">New Applications</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-eye"></i>
                    <div class="stat-number"><?php echo $university_data['profile_views']; ?></div>
                    <div class="stat-label">Profile Views</div>
                </div>
            </div>

            <div class="action-buttons">
                <button class="action-btn">
                    <i class="fas fa-plus-circle"></i>
                    Add New Program
                </button>
                <button class="action-btn">
                    <i class="fas fa-edit"></i>
                    Update Profile
                </button>
                <button class="action-btn">
                    <i class="fas fa-envelope"></i>
                    Message Students
                </button>
                <button class="action-btn">
                    <i class="fas fa-chart-bar"></i>
                    View Reports
                </button>
            </div>

            <div class="program-stats">
                <h2>Program Statistics</h2>
                <table class="program-table">
                    <thead>
                        <tr>
                            <th>Program Name</th>
                            <th>Applications</th>
                            <th>Available Seats</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($university_data['program_stats'] as $program): ?>
                            <tr>
                                <td><?php echo $program['name']; ?></td>
                                <td>
                                    <span class="applications-count">
                                        <?php echo $program['applications']; ?> applications
                                    </span>
                                </td>
                                <td class="seats-available">
                                    <?php echo $program['available_seats']; ?> seats
                                </td>
                                <td>
                                    <?php
                                    $percentage = ($program['applications'] / $program['available_seats']) * 100;
                                    if ($percentage >= 100) {
                                        echo '<span style="color: #e74c3c;">High Competition</span>';
                                    } elseif ($percentage >= 50) {
                                        echo '<span style="color: #f39c12;">Moderate</span>';
                                    } else {
                                        echo '<span style="color: #27ae60;">Open</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <?php include '../footer.php'; ?>
</body>

</html>