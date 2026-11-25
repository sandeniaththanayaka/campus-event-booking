<?php
session_start();

// Backend role check: admin කෙනෙක් නොවේ නම් login එකට යවනවා
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$pageTitle = 'Admin Dashboard';
include '../includes/header.php';
?>

<div class="container py-4">
    <h2 class="fw-bold">Admin Dashboard</h2>
    <p class="text-muted">Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>. More features coming soon.</p>
</div>

<?php include '../includes/footer.php'; ?>