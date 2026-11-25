<?php
session_start();
include 'includes/db.php';

// URL එකෙන් id එක ගන්නවා, අංකයක් බව තහවුරු කරනවා
$eventId = (int)($_GET['id'] ?? 0);

$sql = "SELECT e.*,
               e.total_seats - COALESCE(SUM(CASE WHEN b.status = 'confirmed' THEN b.seats END), 0) AS available_seats
        FROM events e
        LEFT JOIN bookings b ON b.event_id = e.event_id
        WHERE e.event_id = ?
        GROUP BY e.event_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([$eventId]);
$event = $stmt->fetch();

// Event එක නැත්නම් events page එකට යවනවා
if (!$event) {
    header('Location: events.php');
    exit;
}

$isPast    = $event['event_date'] < date('Y-m-d');
$isSoldOut = $event['available_seats'] <= 0;

$pageTitle = $event['title'];
include 'includes/header.php';
?>

<div class="container py-4">
    <a href="events.php" class="text-decoration-none">&larr; Back to Events</a>

    <div class="form-card mt-3">
        <span class="badge bg-primary mb-2"><?php echo htmlspecialchars($event['category']); ?></span>
        <h2 class="fw-bold"><?php echo htmlspecialchars($event['title']); ?></h2>

        <p class="mt-3"><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>

        <ul class="list-unstyled">
            <li class="mb-1"><i class="bi bi-calendar-event"></i>
                <?php echo date('F j, Y', strtotime($event['event_date'])); ?>
                at <?php echo date('g:i A', strtotime($event['event_time'])); ?></li>
            <li class="mb-1"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($event['venue']); ?></li>
            <li class="mb-1"><i class="bi bi-cash"></i>
                <?php if ($event['ticket_price'] > 0) { ?>
                    LKR <?php echo number_format($event['ticket_price'], 2); ?> per seat
                <?php } else { ?>
                    Free
                <?php } ?>
            </li>
            <li class="mb-1"><i class="bi bi-people"></i>
                <?php echo (int)$event['available_seats']; ?> of <?php echo (int)$event['total_seats']; ?> seats available
            </li>
        </ul>

        <p class="small text-muted">Group discount: 4-6 seats = 10% off, 7-10 seats = 15% off.</p>

        <?php if ($isPast) { ?>
            <span class="badge bg-secondary fs-6">This event has ended</span>

        <?php } elseif ($isSoldOut) { ?>
            <span class="badge bg-danger fs-6">Sold Out</span>

        <?php } elseif (!isset($_SESSION['user_id'])) { ?>
            <a href="login.php" class="btn btn-accent">Login to Book</a>

        <?php } elseif ($_SESSION['role'] === 'student') { ?>
            <a href="student/book-event.php?id=<?php echo $event['event_id']; ?>" class="btn btn-accent">Book Now</a>
        <?php } ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>