<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

// Backend role check: student කෙනෙක් පමණයි
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: ../login.php');
    exit;
}

$eventId = (int)($_GET['id'] ?? $_POST['event_id'] ?? 0);

$stmt = $pdo->prepare('SELECT * FROM events WHERE event_id = ?');
$stmt->execute([$eventId]);
$event = $stmt->fetch();

if (!$event) {
    header('Location: ../events.php');
    exit;
}

$available = getAvailableSeats($pdo, $eventId);
$errors = [];
$seats = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seats = (int)($_POST['seats'] ?? 0);

    // ----- Booking validation -----
    if ($event['event_date'] < date('Y-m-d')) {
        $errors[] = 'This event has already ended.';
    }
    if ($available <= 0) {
        $errors[] = 'Sorry, this event is sold out.';
    } else {
        if ($seats < 1) {
            $errors[] = 'Please enter at least 1 seat.';
        }
        if ($seats > MAX_SEATS_PER_BOOKING) {
            $errors[] = 'You can book a maximum of ' . MAX_SEATS_PER_BOOKING . ' seats at a time.';
        }
        if ($seats > $available) {
            $errors[] = 'Only ' . $available . ' seats are available.';
        }
    }

    if (empty($errors)) {
        $discount = getDiscountPercent($seats);
        $total    = calculateTotal($event['ticket_price'], $seats);

        $stmt = $pdo->prepare(
            'INSERT INTO bookings (user_id, event_id, seats, unit_price, discount_percent, total_amount, status)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $_SESSION['user_id'], $eventId, $seats,
            $event['ticket_price'], $discount, $total, 'confirmed'
        ]);

        $_SESSION['success'] = 'Booking confirmed! ' . $seats . ' seat(s) for ' . $event['title'] . '.';
        header('Location: dashboard.php');
        exit;
    }
}

$pageTitle = 'Book Event';
include '../includes/header.php';
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="form-card">
                <h3 class="fw-bold mb-1">Book: <?php echo htmlspecialchars($event['title']); ?></h3>
                <p class="text-muted">
                    <?php echo date('F j, Y', strtotime($event['event_date'])); ?> |
                    <?php echo htmlspecialchars($event['venue']); ?><br>
                    <?php echo $available; ?> seats available |
                    LKR <?php echo number_format($event['ticket_price'], 2); ?> per seat
                </p>

                <?php if (!empty($errors)) { ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error) { ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                <form method="POST" action="book-event.php">
                    <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">

                    <div class="mb-3">
                        <label for="seats" class="form-label">Number of seats (1 - <?php echo MAX_SEATS_PER_BOOKING; ?>)</label>
                        <input type="number" class="form-control" id="seats" name="seats"
                               min="1" max="<?php echo MAX_SEATS_PER_BOOKING; ?>"
                               value="<?php echo $seats; ?>">
                    </div>

                    <p class="small text-muted">Group discount: 4-6 seats = 10% off, 7-10 seats = 15% off.</p>

                    <button type="submit" class="btn btn-accent w-100">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>