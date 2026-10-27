<?php
// portal.php - Redirect to modular staff dashboard
session_start();
header("Location: staff/dashboard.php");
exit;