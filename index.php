<?php
session_start();
require_once 'db.php';


$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');


    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user && password_verify($password, $user['password_hash'])) {
            // Generate a fresh session ID on login to prevent fixation
            session_regenerate_id(true);


            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['active_session_id'] = session_id();


            header("Location: dashboard.php");
            exit;
        } else {
            $error = "invalid credentials";
        }
    } else {
        $error = "Please fill in all fields";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Session Auth System</title>
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
                        
                        <h3 class="fw-bold text-dark">Welcome Back</h3>
                        <p class="text-muted small">Please sign in to your account</p>
                    </div>


                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger py-2 text-center small mb-3" role="alert">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>


                    <form action="index.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-secondary small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">Sign In</button>
                    </form>


                    <div class="text-center mt-4 small text-muted">
                        Don't have an account? <a href="register.php" class="text-primary text-decoration-none fw-semibold">Create account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>