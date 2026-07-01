<?php
/** Shared agency-portal <head>. Set $pageTitle before including. */
$pageTitle = $pageTitle ?? 'Agency Portal - Eko Response';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<title><?php echo htmlspecialchars($pageTitle); ?></title>
<style>
    body { background:#f4f6f9; }
    .sidebar { min-height: 100vh; background:#0f172a; }
    .sidebar a { color:#cbd5e1; display:block; padding:.7rem 1.25rem; text-decoration:none; }
    .sidebar a:hover, .sidebar a.active { background:#020617; color:#fff; }
    .sidebar .brand { color:#fff; font-weight:700; padding:1.1rem 1.25rem; font-size:1.15rem; line-height:1.2; }
    .sidebar .brand small { font-weight:400; font-size:.75rem; color:#94a3b8; display:block; }
    .stat-card { border:none; border-radius:.75rem; }
    .stat-card h2 { font-weight:700; margin:0; }
    #map { height: 420px; border-radius:.5rem; }
</style>
