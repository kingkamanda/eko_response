<?php
session_start();
$err = $_SESSION['admin_errormessage'] ?? ($_SESSION['errormessage'] ?? null);
unset($_SESSION['admin_errormessage'], $_SESSION['errormessage']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign in - Eko Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/static/css/app.css">
    <style> body { background:#0f172a; min-height:100vh; display:flex; align-items:center; } </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card er-card border-0">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-1"><i class="fa-solid fa-truck-medical text-danger"></i> Eko Response</h3>
                        <p class="text-center text-muted mb-4">Administrator sign in</p>

                        <?php if ($err): ?>
                            <div class="alert alert-danger py-2"><?php echo htmlspecialchars($err); ?></div>
                        <?php endif; ?>

                        <form action="process/process_adminlogin.php" method="post">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-brand w-100" name="adminlogin">Sign in</button>
                        </form>
                        <p class="text-center mt-3 mb-0"><a href="../index.php" class="text-decoration-none">← Back to main site</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
