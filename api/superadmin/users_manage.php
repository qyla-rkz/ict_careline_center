<?php
// api/superadmin/users_manage.php
session_start();
require_once '../config.php';

// Ensure user is logged in and is a superadmin
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['role']) !== 'super admin' && strtolower($_SESSION['role']) !== 'superadmin') {
    jsonResponse('error', 'Akses ditolak. Anda bukan Super Admin.');
}

$method = $_SERVER['REQUEST_METHOD'];



if ($method === 'GET') {
    try {
        // Optional department filter from query string
        $department = $_GET['department'] ?? '';
        if (!empty($department) && $department !== 'all') {
            $stmt = $pdo->prepare("SELECT id, name, staff_id, phone, department, jawatan, role, status, profile_picture, created_at FROM users WHERE department = ? ORDER BY role ASC, name ASC");
            $stmt->execute([$department]);
        } else {
            $stmt = $pdo->query("SELECT id, name, staff_id, phone, department, jawatan, role, status, profile_picture, created_at FROM users ORDER BY role ASC, name ASC");
        }
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        jsonResponse('success', 'Berjaya mengambil senarai pengguna', ['users' => $users]);
    } catch (PDOException $e) {
        jsonResponse('error', 'Ralat pangkalan data: ' . $e->getMessage());
    }
} 
elseif ($method === 'POST') {
    $id = $_POST['id'] ?? '';
    $action = $_POST['action'] ?? ''; // 'update_role', 'update_status', 'reset_password', 'delete_profile_pic'

    if (empty($id) || empty($action)) {
        jsonResponse('error', 'ID dan tindakan (action) diperlukan.');
    }

    try {
        if ($action === 'update_role') {
            $new_role = $_POST['role'] ?? '';
            $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->execute([$new_role, $id]);
            logAudit($pdo, 'UPDATE_ROLE', "Mengubah peranan pengguna ID: $id kepada $new_role");
            jsonResponse('success', 'Peranan pengguna berjaya dikemaskini.');
        } 
        elseif ($action === 'update_status') {
            $new_status = $_POST['status'] ?? '';
            $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
            $stmt->execute([$new_status, $id]);
            logAudit($pdo, 'UPDATE_STATUS', "Mengubah status pengguna ID: $id kepada $new_status");
            jsonResponse('success', 'Status pengguna berjaya dikemaskini.');
        }
        elseif ($action === 'reset_password') {
            // Reset to default password (e.g. staff_id or 'password123')
            $stmt = $pdo->prepare("SELECT staff_id FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            $new_pass_plain = $user['staff_id']; // Using staff_id as default
            $new_pass_hash = password_hash($new_pass_plain, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$new_pass_hash, $id]);
            logAudit($pdo, 'RESET_PASSWORD', "Menetapkan semula kata laluan bagi pengguna ID: $id");
            jsonResponse('success', "Kata laluan berjaya di-reset ke ID Staf pengguna ($new_pass_plain).");
        }
    } catch (PDOException $e) {
        jsonResponse('error', 'Ralat pangkalan data: ' . $e->getMessage());
    }
}
elseif ($method === 'DELETE') {
    // Parse DELETE request payload (PHP doesn't parse it to $_POST automatically)
    parse_str(file_get_contents("php://input"), $delete_vars);
    $id = $delete_vars['id'] ?? '';

    if (empty($id)) {
        jsonResponse('error', 'ID pengguna diperlukan untuk memadam.');
    }
    
    // Prevent self-deletion
    if ($id == $_SESSION['user_id']) {
        jsonResponse('error', 'Anda tidak boleh memadam akaun anda sendiri!');
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        logAudit($pdo, 'DELETE_USER', "Memadam pengguna ID: $id dari sistem");
        jsonResponse('success', 'Pengguna berjaya dipadam dari pangkalan data.');
    } catch (PDOException $e) {
        // Handle foreign key constraint error (if user has reports/assets)
        if ($e->getCode() == 23000) {
            jsonResponse('error', 'Tidak boleh dipadam kerana pengguna ini masih terikat dengan rekod aset atau laporan. Sila gunakan fungsi "Gantung (Suspend)" sebaliknya.');
        }
        jsonResponse('error', 'Ralat pangkalan data: ' . $e->getMessage());
    }
}
?>
