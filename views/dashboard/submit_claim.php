<?php
// views/dashboard/submit_claim.php
// Called via fetch() from browse.php

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
$answer    = trim($_POST['answer'] ?? '');
$claimant_id = (int)$_SESSION['user_id'];

if ($report_id <= 0 || empty($answer)) {
    echo json_encode(['success' => false, 'message' => 'Missing data.']);
    exit();
}

// Fetch the report
$stmt = $pdo->prepare("SELECT * FROM tblreports WHERE id = ? LIMIT 1");
$stmt->execute([$report_id]);
$report = $stmt->fetch();

if (!$report) {
    echo json_encode(['success' => false, 'message' => 'Report not found.']);
    exit();
}

// Can't claim your own item
if ((int)$report['user_id'] === $claimant_id) {
    echo json_encode(['success' => false, 'message' => 'You cannot claim your own report.']);
    exit();
}

// Check if already submitted a claim
$check = $pdo->prepare("SELECT id FROM tblverification_requests WHERE report_id = ? AND claimant_id = ? LIMIT 1");
$check->execute([$report_id, $claimant_id]);
if ($check->fetch()) {
    echo json_encode(['success' => false, 'message' => 'You already submitted a claim for this item.']);
    exit();
}

// Save the verification request
$insert = $pdo->prepare("
    INSERT INTO tblverification_requests (report_id, claimant_id, claimant_answer, status)
    VALUES (?, ?, ?, 'pending')
");
$insert->execute([$report_id, $claimant_id, $answer]);

echo json_encode(['success' => true]);
exit();