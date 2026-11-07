<?php
session_start();
require_once 'db.php';


$error = '';
$success = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');


    // Validation: Prevent registration if fields are empty
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required! Cannot register with empty inputs.";
    } else {
        // Check existing user or email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Username or Email is already registered.";
        } else {
            // Hash the password securely
            $password_hash = password_hash($password, PASSWORD_DEFAULT);


            $insert = $pdo->prepare("INSERT INTO users (username, email, password_hash, created_at) VALUES (?, ?, ?, NOW())");
            if ($insert->execute([$username, $email, $password_hash])) {
                $success = "Registration successful! You may now <a href='index.php' class='alert-link fw-bold'>Login</a>.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Session Auth System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-white d-flex align-items-center py-4" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-4 col-md-6">
                <div class="p-4 border rounded-4 shadow-sm bg-light">
                    <div class="text-center mb-4">
                        
                        <h3 class="fw-bold text-dark">Create Account</h3>
                        <p class="text-muted small">Sign up for a new account</p>
                    </div>


                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger py-2 text-center small mb-3" role="alert">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>


                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success py-2 text-center small mb-3" role="alert">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>


                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter username">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-secondary small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password">
                        </div>
                        <button type="submit" class="btn btn-success w-100 py-2 fw-semibold shadow-sm">Register</button>
                    </form>


                    <div class="text-center mt-4 small text-muted">
                        Already have an account? <a href="index.php" class="text-success text-decoration-none fw-semibold">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>