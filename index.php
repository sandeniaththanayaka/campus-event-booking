<?php
$pageTitle = 'Home';
include 'includes/header.php';
?>

<!-- ===== Hero section ===== -->
<section class="hero">
    <div class="container text-center">
        <h1>Discover &amp; Book <span class="highlight">Campus Events</span></h1>
        <p class="lead mt-3 mb-4">
            Workshops, seminars and club activities at NIIBS Campus.
            Find an event and reserve your seat in a few clicks.
        </p>
        <a href="events.php" class="btn btn-accent btn-lg me-2">
            <i class="bi bi-search"></i> Browse Events
        </a>

        <?php if ($userRole === 'visitor') { ?>
            <a href="register.php" class="btn btn-outline-light btn-lg">Create Account</a>
        <?php } ?>
    </div>
</section>

<!-- ===== Why use this system ===== -->
<section class="container my-5">
    <h2 class="text-center fw-bold mb-4">Why use NIIBS Club Events?</h2>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-calendar-check feature-icon"></i>
                <h5 class="mt-3">Find Events Easily</h5>
                <p class="mb-0">Search upcoming campus events by name or category.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-ticket-perforated feature-icon"></i>
                <h5 class="mt-3">Book Your Seats</h5>
                <p class="mb-0">Reserve seats online and manage your bookings anytime.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card">
                <i class="bi bi-percent feature-icon"></i>
                <h5 class="mt-3">Group Discounts</h5>
                <p class="mb-0">Book more seats together and get a discount automatically.</p>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming events section: database හදලා ඉවර වුණාම මෙතන එකතු කරනවා (Phase 5/6) -->

<?php include 'includes/footer.php'; ?>