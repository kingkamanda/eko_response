<?php
session_start();
if (isset($_SESSION['staffonline'])) {
    header("location: dashboard.php");
    exit();
}
$error = $_SESSION['staff_error'] ?? null;
unset($_SESSION['staff_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Portal Sign In - Eko Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <style>
        body { background:#0f172a; min-height:100vh; display:flex; align-items:center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-1"><i class="ri-shield-star-line"></i> Agency Portal</h3>
                        <p class="text-center text-muted mb-4">Eko Response responders &amp; agency staff</p>

                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>

                        <form action="process/process_login.php" method="post">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button class="btn btn-primary w-100" name="stafflogin">Sign in</button>
                        </form>
                        <p class="text-center mt-3 mb-0"><a href="../index.php">← Back to main site</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
