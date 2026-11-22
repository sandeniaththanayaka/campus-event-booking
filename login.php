<?php
$pageTitle = 'Login';
include 'includes/header.php';
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="form-card">
                <h3 class="text-center fw-bold mb-1">Welcome Back</h3>
                <p class="text-center text-muted mb-4">Login to your account</p>

                <form id="loginForm" method="POST" action="login.php" novalidate>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <div class="invalid-feedback">Please enter your password.</div>
                    </div>

                    <button type="submit" class="btn btn-accent w-100">Login</button>
                </form>

                <p class="text-center mt-3 mb-0">
                    New student? <a href="register.php">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/validation.js"></script>
<?php include 'includes/footer.php'; ?>