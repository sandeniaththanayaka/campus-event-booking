<?php
session_start();
include 'includes/db.php';

$errors = [];
$fullName = '';
$studentId = '';
$email = '';

// Form එක submit කළාද බලනවා
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullName        = trim($_POST['full_name'] ?? '');
    $studentId       = trim($_POST['student_id'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $password        = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // ----- Server-side validation -----
    if ($fullName === '') {
        $errors[] = 'Full name is required.';
    }
    if ($studentId === '') {
        $errors[] = 'Student ID is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }
    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    // ----- Email / Student ID කලින් තියෙනවාද -----
    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT user_id FROM users WHERE email = ? OR student_id = ?');
        $stmt->execute([$email, $studentId]);

        if ($stmt->fetch()) {
            $errors[] = 'This email or student ID is already registered.';
        }
    }

    // ----- වැරදි නැත්නම් database එකට දානවා -----
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            'INSERT INTO users (full_name, student_id, email, password, role)
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([$fullName, $studentId, $email, $hashedPassword, 'student']);

        $_SESSION['success'] = 'Registration successful! Please login.';
        header('Location: login.php');
        exit;
    }
}

$pageTitle = 'Register';
include 'includes/header.php';
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="form-card">
                <h3 class="text-center fw-bold mb-1">Create Account</h3>
                <p class="text-center text-muted mb-4">Register as a student to book events</p>

                <?php if (!empty($errors)) { ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error) { ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                <form id="registerForm" method="POST" action="register.php" novalidate>

                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name"
                               value="<?php echo htmlspecialchars($fullName); ?>">
                        <div class="invalid-feedback">Please enter your full name.</div>
                    </div>

                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id"
                               value="<?php echo htmlspecialchars($studentId); ?>">
                        <div class="invalid-feedback">Please enter your student ID.</div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo htmlspecialchars($email); ?>">
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <div class="invalid-feedback">Password must be at least 6 characters.</div>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        <div class="invalid-feedback">Passwords do not match.</div>
                    </div>

                    <button type="submit" class="btn btn-accent w-100">Register</button>
                </form>

                <p class="text-center mt-3 mb-0">
                    Already have an account? <a href="login.php">Login</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/validation.js"></script>
<?php include 'includes/footer.php'; ?>