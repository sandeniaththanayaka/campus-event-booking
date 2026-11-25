<?php
// ===== Business rule settings (වෙනස් කරන්න ඕනේ නම් මෙතන විතරක්) =====
define('MAX_SEATS_PER_BOOKING', 10);

// Discount rules: [අවම seats, discount %] (ලොකුම එකෙන් පටන් ගන්න)
$discountRules = [
    [7, 15],
    [4, 10],
    [1, 0],
];

// Seats ගණනට අදාළ discount % එක දෙනවා
function getDiscountPercent($seats)
{
    global $discountRules;

    foreach ($discountRules as $rule) {
        if ($seats >= $rule[0]) {
            return $rule[1];
        }
    }
    return 0;
}

// Event එකක available seats ගණන database එකෙන් ගණනය කරනවා
// $excludeBookingId = edit කරන booking එකේ seats ගණන් නොගන්න (පසුව පාවිච්චි වෙනවා)
function getAvailableSeats($pdo, $eventId, $excludeBookingId = 0)
{
    $sql = "SELECT e.total_seats - COALESCE(SUM(b.seats), 0) AS available
            FROM events e
            LEFT JOIN bookings b
                   ON b.event_id = e.event_id
                  AND b.status = 'confirmed'
                  AND b.booking_id <> ?
            WHERE e.event_id = ?
            GROUP BY e.event_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$excludeBookingId, $eventId]);
    $row = $stmt->fetch();

    return $row ? (int)$row['available'] : 0;
}

// අවසාන මුදල ගණනය කරනවා
function calculateTotal($unitPrice, $seats)
{
    $discount = getDiscountPercent($seats);
    $subtotal = $unitPrice * $seats;
    return round($subtotal - ($subtotal * $discount / 100), 2);
}
?>