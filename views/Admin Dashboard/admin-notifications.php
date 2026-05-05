<?php
// views/dashboard/admin-notifications.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit();
}

require_once __DIR__ . '/../../config/db.php';

// Fetch admin user
$stmt = $pdo->prepare("SELECT * FROM tblusers WHERE id = ? LIMIT 1");
$stmt->execute([$_SESSION['user_id']]);
$admin = $stmt->fetch();

$admin_name    = htmlspecialchars($admin['fullname']);
$avatar_letter = strtoupper(mb_substr($admin_name, 0, 1));

// Mark all as read when page is opened
$pdo->exec("UPDATE tblnotifications SET is_read = 1 WHERE is_read = 0");

// Fetch all notifications newest first
$notifications = $pdo->query("SELECT * FROM tblnotifications ORDER BY created_at DESC")->fetchAll();

$unread_count = 0; // already marked read above
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications – CIT Lost & Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { citred: '#DC2626', citdarkred: '#b91c1c', bglight: '#F8FAFC' } } }
        }
    </script>
</head>
<body class="bg-bglight">
<div class="flex bg-bglight min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-citred h-screen fixed left-0 top-0 text-white flex flex-col shadow-xl z-40">
        <div class="p-6 flex flex-col items-center border-b border-red-500/30 mb-4">
            <div class="w-14 h-14 bg-white rounded-full shadow-lg mb-3 flex items-center justify-center p-1">
                <img src="images/cit-logo.png" alt="CIT Logo" class="w-full h-full object-contain">
            </div>
            <h2 class="text-center text-xs font-bold tracking-wider leading-tight">CIT UNIVERSITY<br>LOST &amp; FOUND</h2>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="index.php?page=admin-dashboard" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-medium text-red-100 hover:bg-white/10 transition">
                <i class="fa-solid fa-border-all w-5"></i> Dashboard
            </a>
            <a href="index.php?page=admin-manage" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-medium text-red-100 hover:bg-white/10 transition">
                <i class="fa-solid fa-box-open w-5"></i> Manage Items
            </a>
            <a href="index.php?page=admin-notifications" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-semibold bg-white/20 shadow-sm text-white transition">
                <i class="fa-solid fa-bell w-5"></i> Notifications
            </a>
        </nav>
        <div class="p-4 border-t border-red-500/30 flex items-center gap-3 mt-auto">
            <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center text-white font-bold border border-white/20"><?= $avatar_letter ?></div>
            <div>
                <p class="text-xs font-bold truncate max-w-[140px]"><?= $admin_name ?></p>
                <p class="text-[10px] text-red-200">Admin</p>
            </div>
        </div>
    </aside>

    <div class="flex-1 ml-64 flex flex-col h-screen">

        <!-- Header -->
        <header class="bg-white shadow-sm h-16 flex justify-between items-center px-8 border-b border-gray-100 shrink-0">
            <h1 class="text-xl font-bold text-gray-900">Notifications</h1>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-800">
                        <?= $admin_name ?>
                        <span class="bg-citred text-white w-7 h-7 inline-flex justify-center items-center rounded-full ml-1 text-xs"><?= $avatar_letter ?></span>
                    </p>
                    <p class="text-[10px] text-gray-400">Admin</p>
                </div>
                <a href="index.php?page=logout" class="text-xs text-gray-500 font-semibold hover:text-citred border-l border-gray-200 pl-4 ml-2">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out
                </a>
            </div>
        </header>

        <main class="p-8 max-w-4xl w-full mx-auto overflow-y-auto flex-1">

            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">Notifications</h2>
                    <p class="text-sm text-gray-500">All system alerts about claims and resolutions.</p>
                </div>
                <?php if (!empty($notifications)): ?>
                <form method="POST" action="index.php?page=admin-notifications&action=clear">
                    <button type="submit"
                            onclick="return confirm('Clear all notifications?')"
                            class="text-xs text-red-400 hover:text-red-600 font-bold border border-red-200 hover:border-red-400 px-4 py-2 rounded-lg transition">
                        <i class="fa-solid fa-trash mr-1"></i> Clear All
                    </button>
                </form>
                <?php endif; ?>
            </div>

            <?php
            // Handle clear all
            if ($_SERVER['REQUEST_METHOD'] === 'POST' || (isset($_GET['action']) && $_GET['action'] === 'clear')) {
                $pdo->exec("DELETE FROM tblnotifications");
                header("Location: index.php?page=admin-notifications");
                exit();
            }
            ?>

            <?php if (empty($notifications)): ?>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 flex flex-col items-center text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-regular fa-bell text-2xl text-gray-300"></i>
                </div>
                <p class="font-bold text-gray-400 text-[15px] mb-1">No notifications yet</p>
                <p class="text-gray-400 text-sm">Alerts will appear here when items are claimed or resolved.</p>
            </div>

            <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($notifications as $notif):
                    $is_claim   = $notif['type'] === 'claim_approved';
                    $icon       = $is_claim ? 'fa-circle-check' : 'fa-magnifying-glass';
                    $icon_bg    = $is_claim ? 'bg-green-50'     : 'bg-blue-50';
                    $icon_color = $is_claim ? 'text-green-500'  : 'text-blue-500';
                    $border     = $is_claim ? 'border-green-100': 'border-blue-100';
                    $time_ago   = date('M j, Y • g:i A', strtotime($notif['created_at']));
                ?>
                <div class="bg-white rounded-xl border <?= $border ?> shadow-sm p-5 flex items-start gap-4">
                    <div class="w-11 h-11 <?= $icon_bg ?> <?= $icon_color ?> rounded-xl flex items-center justify-center text-lg shrink-0">
                        <i class="fa-solid <?= $icon ?>"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800 leading-relaxed">
                            <?= htmlspecialchars($notif['message']) ?>
                        </p>
                        <p class="text-[11px] text-gray-400 font-medium mt-1.5">
                            <i class="fa-regular fa-clock mr-1"></i><?= $time_ago ?>
                        </p>
                    </div>
                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-full <?= $is_claim ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' ?> uppercase tracking-wide shrink-0">
                        <?= $is_claim ? 'Claimed' : 'Resolved' ?>
                    </span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </main>
    </div>
</div>
</body>
</html>