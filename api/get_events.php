<?php
header('Content-Type: application/json');
include '../includes/db.php';

// අනාගත events සහ ඒවායේ available seats ගණනය කරනවා
$sql = "SELECT e.event_id, e.title, e.description, e.category, e.venue,
               e.event_date, e.event_time, e.total_seats, e.ticket_price,
               e.total_seats - COALESCE(SUM(CASE WHEN b.status = 'confirmed' THEN b.seats END), 0) AS available_seats
        FROM events e
        LEFT JOIN bookings b ON b.event_id = e.event_id
        WHERE e.event_date >= CURDATE()
        GROUP BY e.event_id
        ORDER BY e.event_date, e.event_time";

$stmt = $pdo->query($sql);
echo json_encode($stmt->fetchAll());