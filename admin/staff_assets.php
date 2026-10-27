<?php
session_start();
// Fungsi Aset Staf telah dipindahkan secara eksklusif ke Super Admin
if (isset($_SESSION['role']) && in_array(strtolower($_SESSION['role']), ['super admin', 'superadmin'])) {
    header("Location: ../superadmin/staff_assets.php");
    exit;
}
header("Location: dashboard.php");
exit;
?>
