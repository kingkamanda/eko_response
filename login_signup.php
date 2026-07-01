<?php
session_start();
require_once "classes/State.php";

// Already signed in? Go straight to the dashboard.
if (!empty($_SESSION['useronline'])) {
    header("location: user_dashboard.php");
    exit();
}

$state1 = new State();
$states = $state1->get_state();

$activeTab = (($_GET['form'] ?? '') === 'signup') ? 'signup' : 'login';
$error = $_SESSION['user_errormessage'] ?? ($_SESSION['errormsg'] ?? null);
unset($_SESSION['user_errormessage'], $_SESSION['errormsg']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign in · Eko Response</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/static/css/app.css">
    <style>
        body { min-height:100vh; display:flex; align-items:center;
               background:
                 linear-gradient(rgba(15,23,42,.78), rgba(15,23,42,.86)),
                 url('assets/static/images/login_img.jpg') center/cover fixed; }
        .auth-card { max-width: 460px; width: 100%; }
        .auth-tabs .nav-link { font-weight:600; color:var(--er-ink); }
        .auth-tabs .nav-link.active { color:var(--er-primary); border-bottom:2px solid var(--er-primary); background:none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="mx-auto auth-card">
            <div class="text-center text-white mb-3">
                <a href="index.php" class="text-white text-decoration-none">
                    <h3 class="mb-0"><i class="fa-solid fa-fire text-danger"></i> Eko Response</h3>
                </a>
                <p class="text-white-50 mb-0">When every second counts.</p>
            </div>

            <div class="card er-card">
                <div class="card-body p-4">
                    <ul class="nav nav-tabs auth-tabs mb-4" role="tablist">
                        <li class="nav-item"><button class="nav-link <?php echo $activeTab === 'login' ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#loginPane" type="button">Sign in</button></li>
                        <li class="nav-item"><button class="nav-link <?php echo $activeTab === 'signup' ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#signupPane" type="button">Create account</button></li>
                    </ul>

                    <?php if ($error): ?>
                        <div class="alert alert-danger py-2"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <div class="tab-content">
                        <!-- Sign in -->
                        <div class="tab-pane fade <?php echo $activeTab === 'login' ? 'show active' : ''; ?>" id="loginPane">
                            <form action="process/process_login.php" method="post">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="pwd" class="form-control" required>
                                </div>
                                <button class="btn btn-brand w-100" name="btnlogin">Sign in</button>
                            </form>
                        </div>

                        <!-- Create account -->
                        <div class="tab-pane fade <?php echo $activeTab === 'signup' ? 'show active' : ''; ?>" id="signupPane">
                            <form action="process/process_signup.php" method="post">
                                <div class="mb-3">
                                    <label class="form-label">Full name</label>
                                    <input type="text" name="fullname" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="pwd" class="form-control" minlength="6" required>
                                    <div class="form-text">At least 6 characters.</div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">State</label>
                                        <select name="state" id="state" class="form-select" required>
                                            <option value="">Select state</option>
                                            <?php foreach ($states as $s): ?>
                                                <option value="<?php echo $s['state_id']; ?>"><?php echo htmlspecialchars($s['state_name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">LGA</label>
                                        <select name="lga" id="lga" class="form-select" required>
                                            <option value="">Select state first</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-brand w-100" name="btnsignup">Create account</button>
                            </form>
                        </div>
                    </div>

                    <p class="text-center text-muted mt-3 mb-0"><a href="index.php" class="text-decoration-none">← Back to home</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // State -> LGA (only that state's LGAs).
        $("#state").change(function () {
            var stateId = $(this).val();
            var $lga = $("#lga");
            $lga.html('<option value="">Loading…</option>');
            if (!stateId) { $lga.html('<option value="">Select state first</option>'); return; }
            $.ajax({
                url: "server.php", method: "post", data: { state: stateId }, dataType: "json",
                success: function (res) {
                    $lga.empty().append('<option value="">Select LGA</option>');
                    res.forEach(function (l) { $lga.append('<option value="' + l.lga_id + '">' + l.lga_name + '</option>'); });
                }
            });
        });
    </script>
</body>
</html>
