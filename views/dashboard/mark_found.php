<?php
// views/dashboard/mark_found.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in.']);
    exit();
}

require_once __DIR__ . '/../../config/db.php';

$report_id = (int)($_POST['report_id'] ?? 0);
$user_id   = (int)$_SESSION['user_id'];

if ($report_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid report.']);
    exit();
}

// Fetch the report — must be owned by this user and be a LOST type
$stmt = $pdo->prepare("SELECT r.*, u.fullname FROM tblreports r JOIN tblusers u ON r.user_id = u.id WHERE r.id = ? AND r.user_id = ? AND r.type = 'lost' LIMIT 1");
$stmt->execute([$report_id, $user_id]);
$report = $stmt->fetch();

if (!$report) {
    echo json_encode(['success' => false, 'message' => 'Report not found or not authorized.']);
    exit();
}

// Mark as resolved
$pdo->prepare("UPDATE tblreports SET status = 'resolved' WHERE id = ?")
    ->execute([$report_id]);

// ── Notify admin ────────────────────────────────────────────────────────────
$message = 'Lost item resolved: ' . $report['fullname'] . ' has found their lost item "' . $report['title'] . '".';
$pdo->prepare("INSERT INTO tblnotifications (type, message, report_id) VALUES ('lost_resolved', ?, ?)")
    ->execute([$message, $report_id]);

echo json_encode(['success' => true]);
exit();