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

// ── Handle actions (resolve / delete) ──────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action    = $_POST['action']    ?? '';
    $report_id = (int)($_POST['report_id'] ?? 0);

    if ($report_id > 0) {
        if ($action === 'resolve') {
            $pdo->prepare("UPDATE tblreports SET status = 'resolved' WHERE id = ?")
                ->execute([$report_id]);
        } elseif ($action === 'unresolve') {
            $pdo->prepare("UPDATE tblreports SET status = 'pending' WHERE id = ?")
                ->execute([$report_id]);
        } elseif ($action === 'delete') {
            // Also delete the image file if it exists
            $row = $pdo->prepare("SELECT image FROM tblreports WHERE id = ?");
            $row->execute([$report_id]);
            $img = $row->fetchColumn();
            if ($img) {
                $img_path = __DIR__ . '/../../uploads/reports/' . $img;
                if (file_exists($img_path)) unlink($img_path);
            }
            $pdo->prepare("DELETE FROM tblreports WHERE id = ?")->execute([$report_id]);
        }
    }

    header("Location: index.php?page=admin-manage");
    exit();
}

// ── Fetch all reports ───────────────────────────────────────────────────────
$manage_items = $pdo->query("
    SELECT r.*, u.fullname AS reporter_name, u.email AS reporter_email
    FROM tblreports r
    JOIN tblusers u ON r.user_id = u.id
    ORDER BY r.created_at DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Items – CIT Lost & Found</title>
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
            <a href="index.php?page=admin-dashboard" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-medium text-red-100 hover:bg-white/10 transition">
                <i class="fa-solid fa-border-all w-5"></i> Dashboard
            </a>
            <a href="index.php?page=admin-manage" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-semibold bg-white/20 shadow-sm text-white transition">
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
            <h1 class="text-xl font-bold text-gray-900">Manage Items</h1>
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
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Manage Reports</h2>
                <p class="text-sm text-gray-500">Mark items as resolved or remove them from the system.</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">

                <?php if (empty($manage_items)): ?>
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <i class="fa-solid fa-inbox text-4xl text-gray-200 mb-3"></i>
                    <p class="text-gray-400 font-bold text-[15px]">No items reported yet.</p>
                    <p class="text-gray-400 text-sm">Reports from students and faculty will appear here.</p>
                </div>
                <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50 text-[10px] uppercase text-gray-500 font-bold tracking-wider">
                                <th class="py-4 px-4">ITEM</th>
                                <th class="py-4 px-4">REPORTED BY</th>
                                <th class="py-4 px-4">LOCATION</th>
                                <th class="py-4 px-4">STATUS</th>
                                <th class="py-4 px-4 text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <?php foreach ($manage_items as $item):
                                $is_lost     = strtolower($item['type']) === 'lost';
                                $is_resolved = strtolower($item['status']) === 'resolved';
                                $icon_letter = strtoupper(mb_substr($item['title'], 0, 1));
                                $icon_color  = $is_lost ? 'bg-citred' : 'bg-green-500';
                                $status_color = $is_resolved
                                    ? 'text-blue-600 bg-blue-100'
                                    : 'text-yellow-600 bg-yellow-100';
                                $status_label = $is_resolved ? 'RESOLVED' : 'PENDING';
                                $date_time = date('n/j/Y', strtotime($item['created_at']));
                                if (!empty($item['time_lost_found'])) {
                                    $date_time .= ' – ' . date('g:i A', strtotime($item['time_lost_found']));
                                }
                            ?>
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition" id="row-<?= $item['id'] ?>">

                                <!-- Item -->
                                <td class="py-5 px-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 <?= $icon_color ?> text-white font-bold rounded-lg flex items-center justify-center text-xl shadow-sm shrink-0">
                                            <?= $icon_letter ?>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 text-sm"><?= htmlspecialchars($item['title']) ?></p>
                                            <p class="text-[10px] text-gray-400 mt-0.5 uppercase tracking-wide font-semibold">
                                                <?= htmlspecialchars($item['category']) ?>
                                                &nbsp;•&nbsp;
                                                <span class="<?= $is_lost ? 'text-red-500' : 'text-green-600' ?>"><?= strtoupper($item['type']) ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Reporter -->
                                <td class="py-5 px-4">
                                    <p class="font-bold text-gray-900 text-sm"><?= htmlspecialchars($item['reporter_name']) ?></p>
                                    <p class="text-[10px] text-gray-400 mt-0.5"><?= htmlspecialchars($item['reporter_email']) ?></p>
                                </td>

                                <!-- Location & Date -->
                                <td class="py-5 px-4">
                                    <p class="font-bold text-gray-900 text-sm"><?= htmlspecialchars($item['location']) ?></p>
                                    <p class="text-[10px] text-gray-400 mt-0.5"><?= $date_time ?></p>
                                </td>

                                <!-- Status -->
                                <td class="py-5 px-4 w-32">
                                    <span class="text-[10px] font-bold px-3 py-1.5 rounded <?= $status_color ?>">
                                        <?= $status_label ?>
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="py-5 px-4">
                                    <div class="flex items-center justify-center gap-4">

                                        <!-- Toggle Resolve / Unresolve -->
                                        <form method="POST" action="index.php?page=admin-manage" onsubmit="return confirm('<?= $is_resolved ? 'Mark as pending?' : 'Mark this item as resolved?' ?>')">
                                            <input type="hidden" name="report_id" value="<?= $item['id'] ?>">
                                            <input type="hidden" name="action" value="<?= $is_resolved ? 'unresolve' : 'resolve' ?>">
                                            <button type="submit"
                                                    title="<?= $is_resolved ? 'Mark as Pending' : 'Mark as Resolved' ?>"
                                                    class="<?= $is_resolved ? 'text-yellow-500 hover:text-yellow-700' : 'text-green-500 hover:text-green-700' ?> transition">
                                                <i class="fa-solid <?= $is_resolved ? 'fa-rotate-left' : 'fa-check' ?> text-2xl font-black"></i>
                                            </button>
                                        </form>

                                        <!-- Delete -->
                                        <form method="POST" action="index.php?page=admin-manage" onsubmit="return confirm('Delete this report permanently? This cannot be undone.')">
                                            <input type="hidden" name="report_id" value="<?= $item['id'] ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" title="Delete Report"
                                                    class="text-red-400 hover:text-red-600 transition">
                                                <i class="fa-solid fa-trash text-xl"></i>
                                            </button>
                                        </form>

                                    </div>
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