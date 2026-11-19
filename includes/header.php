<?php
// Session එක පටන් ගන්නවා (login වුණු user ව මතක තියාගන්න)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Login වෙලාද, role එක මොකක්ද කියලා variables වලට ගන්නවා
$isLoggedIn = isset($_SESSION['user_id']);
$userRole   = $isLoggedIn ? $_SESSION['role'] : 'visitor';
$userName   = $isLoggedIn ? $_SESSION['full_name'] : '';

// Page title එක (සෑම page එකකම මේක වෙනස් කරන්න පුළුවන්)
if (!isset($pageTitle)) {
    $pageTitle = 'NIIBS Club Events';
}

// Pages වල folder එක අනුව links නිවැරදි කරන්න base URL එකක්
$baseUrl = '/campus-event-booking/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle); ?> | NIIBS Club Events</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- අපේ CSS file එක -->
    <link href="<?php echo $baseUrl; ?>assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark site-navbar">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $baseUrl; ?>index.php">
            <i class="bi bi-calendar-event"></i> NIIBS Club Events
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <?php if ($userRole === 'admin') { ?>
                    <!-- Admin links -->
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>admin/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>admin/manage-events.php">Manage Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>admin/all-bookings.php">All Bookings</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>logout.php">Logout</a></li>

                <?php } elseif ($userRole === 'student') { ?>
                    <!-- Student links -->
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>events.php">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>student/my-bookings.php">My Bookings</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>student/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>logout.php">Logout</a></li>

                <?php } else { ?>
                    <!-- Visitor links -->
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>events.php">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>login.php">Login</a></li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-accent btn-sm" href="<?php echo $baseUrl; ?>register.php">Register</a>
                    </li>
                <?php } ?>

            </ul>
        </div>
    </div>
</nav>
<main>