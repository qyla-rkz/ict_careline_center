<?php
// staff/includes/header.php
if (!isset($pageTitle)) {
    $pageTitle = 'Portal Staf - eICT Desk';
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/portal.css">
    <?php if (!empty($includeMermaid)): ?>
    <script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>
    <?php endif; ?>
    <script src="../assets/js/global.js?v=14"></script>
</head>
<body>
<div class="bg-image"></div>
<div class="bg-overlay"></div>

<a href="dashboard.php" class="top-logo" title="Ke Papan Pemuka Staf">
    <img src="../assets/images/logo-mpm.png" alt="MPM">
    <span class="top-logo-text">eICT <span>Desk</span></span>
</a>

<div class="portal-layout">
