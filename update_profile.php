<?php
session_start();
require_once "user_guard.php";
require_once "classes/User.php";

// Always edit the signed-in user's own profile (ignore any ?id in the URL).
$user1    = new User();
$userdata = $user1->get_current_user($_SESSION["useronline"]);
$firstname = ucfirst($userdata["user_fullname"] ?? 'User');

$error    = $_SESSION['errormsg'] ?? null;   unset($_SESSION['errormsg']);
$feedback = $_SESSION['feedback'] ?? null;   unset($_SESSION['feedback']);
$gender   = strtolower((string)($userdata['user_gender'] ?? ''));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Eko Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body { background:#f4f6f9; }
        .side { min-height:100vh; background:#1f2937; }
        .side a { color:#cbd5e1; display:block; padding:.7rem 1.1rem; text-decoration:none; }
        .side a:hover, .side a.active { background:#111827; color:#fff; }
        .side .brand { color:#fff; font-weight:700; padding:1.1rem; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar (mirrors the dashboard) -->
        <nav class="col-md-2 p-0 side">
            <div class="brand"><i class="fa-solid fa-fire"></i> Eko Response</div>
            <div class="text-center my-3 text-white">
                <img src="uploads/<?php echo htmlspecialchars($userdata['user_image'] ?? ''); ?>"
                     onerror="this.style.display='none'" class="rounded-circle" style="width:84px;height:84px;object-fit:cover;" alt="">
                <div class="mt-2"><?php echo htmlspecialchars($firstname); ?></div>
                <small class="text-secondary">User</small>
            </div>
            <a href="user_dashboard.php"><i class="fa-solid fa-table-cells-large"></i><span class="px-2">Dashboard</span></a>
            <a href="emergency_form.php"><i class="fa-solid fa-triangle-exclamation"></i><span class="px-2">Report Emergency</span></a>
            <a href="hotzones.php"><i class="fa-solid fa-fire"></i><span class="px-2">Hot Zones</span></a>
            <a href="request_emergency_type.php"><i class="fa-solid fa-lightbulb"></i><span class="px-2">Request Type</span></a>
            <a href="update_profile.php" class="active"><i class="fa-solid fa-user"></i><span class="px-2">Update Profile</span></a>
            <a href="index.php"><i class="fa-solid fa-house"></i><span class="px-2">Home</span></a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i><span class="px-2">Logout</span></a>
        </nav>

        <!-- Content -->
        <main class="col-md-10 px-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Update your profile</h3>
                <a href="user_dashboard.php" class="btn btn-outline-secondary">Go to Dashboard</a>
            </div>

            <?php if ($error): ?><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
            <?php if ($feedback): ?><div class="alert alert-success"><?php echo htmlspecialchars($feedback); ?></div><?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="./process/process_updateprofile.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label class="form-label">Profile picture</label>
                                    <input type="file" name="profile_pic" id="profile_pic" class="form-control" accept="image/*">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Full name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($userdata['user_fullname'] ?? ''); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($userdata['user_email'] ?? ''); ?>" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone number</label>
                                        <input type="text" name="phonenumber" class="form-control" value="<?php echo htmlspecialchars($userdata['user_phone'] ?? ''); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Gender</label>
                                        <select name="gender" class="form-select">
                                            <option value="">Select gender</option>
                                            <option value="male"   <?php echo $gender === 'male' ? 'selected' : ''; ?>>Male</option>
                                            <option value="female" <?php echo $gender === 'female' ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Date of birth</label>
                                        <input type="date" name="age" class="form-control" value="<?php echo htmlspecialchars($userdata['user_age'] ?? ''); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($userdata['user_address'] ?? ''); ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($userdata['user_id'] ?? ''); ?>">
                                <button type="submit" class="btn btn-primary" name="btnupdate" value="btnupdate">Save profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
