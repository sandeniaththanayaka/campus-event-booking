<?php
include 'includes/db.php';

echo "<h3>Database connected successfully!</h3>";

// events table එකේ දත්ත ගන්නවා
$stmt = $pdo->query("SELECT title, event_date, total_seats FROM events");
$events = $stmt->fetchAll();

foreach ($events as $event) {
       echo $event['title'] . " | " . $event['event_date'] . " | Seats: " . $event['total_seats'] . "<br>";
}
?>