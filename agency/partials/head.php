<?php
/** Shared agency-portal <head>. Set $pageTitle before including. */
$pageTitle = $pageTitle ?? 'Agency Portal - Eko Response';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="../assets/static/css/app.css">
<title><?php echo htmlspecialchars($pageTitle); ?></title>
<style>
    .er-side { position: sticky; top: 0; }
    #map { height: 420px; border-radius: .5rem; }
</style>
