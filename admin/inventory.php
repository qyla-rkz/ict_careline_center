<?php
session_start();
// Fungsi Inventori Aset telah dipindahkan secara eksklusif ke Super Admin
if (isset($_SESSION['role']) && in_array(strtolower($_SESSION['role']), ['super admin', 'superadmin'])) {
    header("Location: ../superadmin/inventory.php");
    exit;
}
header("Location: dashboard.php");
exit;
?>
