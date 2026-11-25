<?php
// Database connection settings (XAMPP default)
$host     = 'localhost';
$dbName   = 'campus_event_booking';
$username = 'root';
$password = '';   // XAMPP එකේ default password එක හිස්

try {
    // PDO object එකක් හදලා database එකට සම්බන්ධ වෙනවා
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbName;charset=utf8mb4",
        $username,
        $password
    );

    // Error එකක් ආවොත් exception එකක් විදියට පෙන්වන්න
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Data ගන්නකොට associative array විදියට දෙන්න
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>