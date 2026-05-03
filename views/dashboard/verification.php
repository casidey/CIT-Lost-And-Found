<?php
// views/dashboard/verification.php
// Handles approve and decline of verification requests

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit();
}

require_once __DIR__ . '/../../config/db.php';

$action  = $_GET['action'] ?? '';
$vr_id   = (int)($_GET['id'] ?? 0);
$user_id = (int)$_SESSION['user_id'];

if ($vr_id > 0 && in_array($action, ['approve', 'decline'])) {

    // Make sure this verification request belongs to a report owned by the logged-in user
    $stmt = $pdo->prepare("
        SELECT v.*, r.verification_answer, r.user_id AS owner_id, r.id AS report_id
        FROM tblverification_requests v
        JOIN tblreports r ON v.report_id = r.id
        WHERE v.id = ? AND r.user_id = ?
        LIMIT 1
    ");
    $stmt->execute([$vr_id, $user_id]);
    $vr = $stmt->fetch();

    if ($vr) {
        if ($action === 'approve') {
            $correct = strtolower(trim($vr['claimant_answer'])) === strtolower(trim($vr['verification_answer']));

            if ($correct) {
                $pdo->prepare("UPDATE tblverification_requests SET status = 'approved' WHERE id = ?")
                    ->execute([$vr_id]);
                $pdo->prepare("UPDATE tblreports SET status = 'resolved' WHERE id = ?")
                    ->execute([$vr['report_id']]);
                $pdo->prepare("UPDATE tblverification_requests SET status = 'declined' WHERE report_id = ? AND id != ?")
                    ->execute([$vr['report_id'], $vr_id]);
            } else {
                $pdo->prepare("UPDATE tblverification_requests SET status = 'declined' WHERE id = ?")
                    ->execute([$vr_id]);
            }

        } elseif ($action === 'decline') {
            $pdo->prepare("UPDATE tblverification_requests SET status = 'declined' WHERE id = ?")
                ->execute([$vr_id]);
        }
    }
}

header("Location: index.php?page=dashboard");
exit();