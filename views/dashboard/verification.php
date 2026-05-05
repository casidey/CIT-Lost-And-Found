<?php
// views/dashboard/verification.php

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

    $stmt = $pdo->prepare("
        SELECT v.*,
               r.verification_answer, r.user_id AS owner_id, r.id AS report_id, r.title AS item_title,
               u.fullname AS claimant_name
        FROM tblverification_requests v
        JOIN tblreports r ON v.report_id = r.id
        JOIN tblusers u   ON v.claimant_id = u.id
        WHERE v.id = ? AND r.user_id = ?
        LIMIT 1
    ");
    $stmt->execute([$vr_id, $user_id]);
    $vr = $stmt->fetch();

    if ($vr) {
        if ($action === 'approve') {
            $correct = strtolower(trim($vr['claimant_answer'])) === strtolower(trim($vr['verification_answer']));

            if ($correct) {
                // Approve this request
                $pdo->prepare("UPDATE tblverification_requests SET status = 'approved' WHERE id = ?")
                    ->execute([$vr_id]);
                // Mark report as resolved
                $pdo->prepare("UPDATE tblreports SET status = 'resolved' WHERE id = ?")
                    ->execute([$vr['report_id']]);
                // Decline all other pending claims for same report
                $pdo->prepare("UPDATE tblverification_requests SET status = 'declined' WHERE report_id = ? AND id != ?")
                    ->execute([$vr['report_id'], $vr_id]);

                // ── Notify admin ─────────────────────────────────────────
                $message = 'Claim approved: "' . $vr['item_title'] . '" has been successfully claimed by ' . $vr['claimant_name'] . '.';
                $pdo->prepare("INSERT INTO tblnotifications (type, message, report_id) VALUES ('claim_approved', ?, ?)")
                    ->execute([$message, $vr['report_id']]);

            } else {
                // Wrong answer — auto-decline
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