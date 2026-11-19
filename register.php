<?php
$pageTitle = 'Register';
include 'includes/header.php';
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="form-card">
                <h3 class="text-center fw-bold mb-1">Create Account</h3>
                <p class="text-center text-muted mb-4">Register as a student to book events</p>

                <form id="registerForm" method="POST" action="register.php" novalidate>

                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name">
                        <div class="invalid-feedback">Please enter your full name.</div>
                    </div>

                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id">
                        <div class="invalid-feedback">Please enter your student ID.</div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
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