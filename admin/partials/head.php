<?php
/** Shared admin <head>. Set $pageTitle before including. */
$pageTitle = $pageTitle ?? 'Admin - Eko Response';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="./assets/static/bootstrap/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<title><?php echo htmlspecialchars($pageTitle); ?></title>
<style>
    body { background:#f4f6f9; }
    .sidebar { min-height: 100vh; background:#1f2937; }
    .sidebar a { color:#cbd5e1; display:block; padding:.75rem 1.25rem; text-decoration:none; }
    .sidebar a:hover, .sidebar a.active { background:#111827; color:#fff; }
    .sidebar .brand { color:#fff; font-weight:700; padding:1.25rem; font-size:1.2rem; }
    .stat-card { border:none; border-radius:.75rem; }
    .stat-card h2 { font-weight:700; }
    #map { height: 420px; border-radius:.5rem; }
</style>
