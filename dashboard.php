<?php
session_start();


// Security: Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}


// Prevent browser caching so 'Back' button won't work after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SessionAuthSystem</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">


    <!-- Top Navigation Header -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom px-4 py-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary fs-5" href="#">
                <i class="bi bi-shield-check me-2"></i>SessionAuthSystem
            </a>
            
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center bg-light px-3 py-1.5 rounded-pill border me-3">
                    <i class="bi bi-person-circle text-secondary me-2 fs-5"></i>
                    <span class="small fw-bold text-dark"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                </div>
                <a href="logout.php" class="btn btn-outline-danger btn-sm px-3 fw-semibold">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>


    <!-- Main Panel Container -->
    <div class="container py-5">
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <!-- Welcome Box -->
                <div class="bg-primary text-white p-4 rounded-4 shadow-sm mb-4">
                    <h1 class="fw-bold fs-3 mb-1">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                    <p class="mb-0 text-white-50 small">Welcome to your secured dashboard panel. Everything looks great!</p>
                </div>


                <!-- Info Grid -->
                <div class="row g-3">
                    
                    <!-- Card 1: Session Status -->
                    <div class="col-md-4">
                        <div class="bg-white p-4 rounded-4 border shadow-sm h-100">
                            <div class="text-success fw-bold small mb-2"><i class="bi bi-check-circle-fill me-1"></i> SESSION STATUS</div>
                            <p class="text-muted small mb-0">Active and protected against session fixation using <code>session_regenerate_id(true)</code>.</p>
                        </div>
                    </div>


                    <!-- Card 2: User Account Info -->
                    <div class="col-md-4">
                        <div class="bg-white p-4 rounded-4 border shadow-sm h-100">
                            <div class="text-primary fw-bold small mb-2"><i class="bi bi-person-badge-fill me-1"></i> USER DETAILS</div>
                            <p class="small text-muted mb-1">ID: <strong class="text-dark"><?php echo htmlspecialchars($_SESSION['user_id']); ?></strong></p>
                            <p class="small text-muted mb-0">Name: <strong class="text-dark"><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
                        </div>
                    </div>


                    <!-- Card 3: Session ID Token -->
                    <div class="col-md-4">
                        <div class="bg-white p-4 rounded-4 border shadow-sm h-100">
                            <div class="text-warning fw-bold small mb-2"><i class="bi bi-key-fill me-1"></i> SESSION TOKEN</div>
                            <p class="small text-muted mb-1">Active Session ID:</p>
                            <code class="text-dark small text-break bg-light p-1 rounded border d-block"><?php echo htmlspecialchars(session_id()); ?></code>
                        </div>
                    </div>


                </div>


            </div>
        </div>


    </div>


</body>
</html>