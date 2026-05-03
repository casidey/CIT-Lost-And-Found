<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit();
}

require_once __DIR__ . '/../../config/db.php';

// ── Fetch admin user ────────────────────────────────────────────────────────
$stmt = $pdo->prepare("SELECT * FROM tblusers WHERE id = ? LIMIT 1");
$stmt->execute([$_SESSION['user_id']]);
$admin = $stmt->fetch();

if (!$admin) {
    session_destroy();
    header("Location: index.php?page=login");
    exit();
}

$admin_name    = htmlspecialchars($admin['fullname']);
$avatar_letter = strtoupper(mb_substr($admin_name, 0, 1));

// ── Stats from DB ───────────────────────────────────────────────────────────
$total_lost     = $pdo->query("SELECT COUNT(*) FROM tblreports WHERE type = 'lost'")->fetchColumn();
$total_found    = $pdo->query("SELECT COUNT(*) FROM tblreports WHERE type = 'found'")->fetchColumn();
$total_resolved = $pdo->query("SELECT COUNT(*) FROM tblreports WHERE status = 'resolved'")->fetchColumn();
$total_all      = $pdo->query("SELECT COUNT(*) FROM tblreports")->fetchColumn();

// ── Recent reports (last 10) ────────────────────────────────────────────────
$reports = $pdo->query("
    SELECT r.*, u.fullname AS reporter_name
    FROM tblreports r
    JOIN tblusers u ON r.user_id = u.id
    ORDER BY r.created_at DESC
    LIMIT 10
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard – CIT Lost & Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { citred: '#DC2626', citdarkred: '#b91c1c', bglight: '#F8FAFC' }
                }
            }
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
            <a href="index.php?page=admin-dashboard" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-semibold bg-white/20 shadow-sm text-white transition">
                <i class="fa-solid fa-border-all w-5"></i> Dashboard
            </a>
            <a href="index.php?page=admin-manage" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-medium text-red-100 hover:bg-white/10 transition">
                <i class="fa-solid fa-box-open w-5"></i> Manage Items
            </a>
        </nav>
        <div class="p-4 border-t border-red-500/30 flex items-center gap-3 mt-auto">
            <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center text-white font-bold border border-white/20">
                <?= $avatar_letter ?>
            </div>
            <div>
                <p class="text-xs font-bold truncate max-w-[140px]"><?= $admin_name ?></p>
                <p class="text-[10px] text-red-200">Admin</p>
            </div>
        </div>
    </aside>

    <div class="flex-1 ml-64 flex flex-col h-screen">

        <!-- Header -->
        <header class="bg-white shadow-sm h-16 flex justify-between items-center px-8 border-b border-gray-100 shrink-0">
            <h1 class="text-xl font-bold text-gray-900">Admin Dashboard</h1>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-800">
                        <?= $admin_name ?>
                        <span class="bg-citred text-white w-7 h-7 inline-flex justify-center items-center rounded-full ml-1 text-xs">
                            <?= $avatar_letter ?>
                        </span>
                    </p>
                    <p class="text-[10px] text-gray-400">Admin</p>
                </div>
                <a href="index.php?page=logout" class="text-xs text-gray-500 font-semibold hover:text-citred border-l border-gray-200 pl-4 ml-2">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out
                </a>
            </div>
        </header>

        <main class="p-8 max-w-6xl w-full mx-auto overflow-y-auto flex-1">

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Welcome back, <?= htmlspecialchars(explode(' ', $admin['fullname'])[0]) ?>!</h2>
                <p class="text-sm text-gray-500">System overview and statistics</p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
                <div class="bg-white py-8 px-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-full border-2 border-red-100 text-red-400 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">LOST ITEMS</p>
                        <p class="text-4xl font-black text-gray-800"><?= $total_lost ?></p>
                    </div>
                </div>
                <div class="bg-white py-8 px-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-full border-2 border-green-100 text-green-500 flex items-center justify-center text-2xl">
                        <i class="fa-regular fa-circle-check"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">FOUND ITEMS</p>
                        <p class="text-4xl font-black text-gray-800"><?= $total_found ?></p>
                    </div>
                </div>
                <div class="bg-white py-8 px-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-full border-2 border-blue-100 text-blue-500 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">RESOLVED</p>
                        <p class="text-4xl font-black text-gray-800"><?= $total_resolved ?></p>
                    </div>
                </div>
                <div class="bg-white py-8 px-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-full border-2 border-purple-100 text-purple-400 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-cube"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">TOTAL ITEMS</p>
                        <p class="text-4xl font-black text-gray-800"><?= $total_all ?></p>
                    </div>
                </div>
            </div>

            <!-- Recent Reports Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-900 text-lg">Recent Reports</h3>
                    <a href="index.php?page=admin-manage" class="text-xs text-citred font-bold hover:underline">View All &rarr;</a>
                </div>

                <?php if (empty($reports)): ?>
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <i class="fa-solid fa-inbox text-4xl text-gray-200 mb-3"></i>
                    <p class="text-gray-400 font-bold">No reports yet.</p>
                </div>
                <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50 text-[10px] uppercase text-gray-500 font-bold tracking-wider">
                                <th class="py-4 px-4">ITEM</th>
                                <th class="py-4 px-4">TYPE</th>
                                <th class="py-4 px-4">CATEGORY</th>
                                <th class="py-4 px-4">LOCATION</th>
                                <th class="py-4 px-4">DATE</th>
                                <th class="py-4 px-4">STATUS</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <?php foreach ($reports as $r):
                                $is_lost     = strtolower($r['type']) === 'lost';
                                $is_resolved = strtolower($r['status']) === 'resolved';
                                $type_color  = $is_lost ? 'bg-citred' : 'bg-green-500';
                                $type_label  = strtoupper($r['type']);
                                $status_color = $is_resolved
                                    ? 'text-blue-600 bg-blue-100'
                                    : 'text-yellow-600 bg-yellow-100';
                                $status_label = $is_resolved ? 'RESOLVED' : 'PENDING';
                            ?>
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                <td class="py-5 px-4">
                                    <p class="font-bold text-gray-800 text-sm"><?= htmlspecialchars($r['title']) ?></p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">Rep. by <?= htmlspecialchars($r['reporter_name']) ?></p>
                                </td>
                                <td class="py-5 px-4">
                                    <span class="text-[10px] font-bold px-3 py-1 rounded-full text-white <?= $type_color ?>">
                                        <?= $type_label ?>
                                    </span>
                                </td>
                                <td class="py-5 px-4 text-xs text-gray-600 uppercase font-semibold tracking-wide">
                                    <?= htmlspecialchars($r['category']) ?>
                                </td>
                                <td class="py-5 px-4 text-xs text-gray-600">
                                    <?= htmlspecialchars($r['location']) ?>
                                </td>
                                <td class="py-5 px-4 text-xs text-gray-600">
                                    <?= date('n/j/Y', strtotime($r['created_at'])) ?>
                                </td>
                                <td class="py-5 px-4">
                                    <span class="text-[10px] font-bold px-2.5 py-1 rounded <?= $status_color ?>">
                                        <?= $status_label ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>

        </main>
    </div>
</div>
</body>
</html>