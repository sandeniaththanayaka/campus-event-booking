<?php
session_start();

// Backend role check: student කෙනෙක් නොවේ නම් login එකට යවනවා
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: ../login.php');
    exit;
}

$pageTitle = 'Student Dashboard';
include '../includes/header.php';
?>

<div class="container py-4">
    <h2 class="fw-bold">Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h2>
    <p class="text-muted">This is your student dashboard. More features coming soon.</p>
</div>

<?php include '../includes/footer.php'; ?>