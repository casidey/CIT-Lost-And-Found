<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit();
}

require_once __DIR__ . '/../../config/db.php';

$active_page = 'dashboard';

// ── Fetch user ──────────────────────────────────────────────────────────────
$stmt = $pdo->prepare("SELECT * FROM tblusers WHERE id = ? LIMIT 1");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header("Location: index.php?page=login");
    exit();
}

$full_name     = htmlspecialchars($user['fullname']);
$role          = htmlspecialchars($user['role']);
$user_id       = (int)$_SESSION['user_id'];
$avatar_letter = strtoupper(mb_substr($full_name, 0, 1));
$first_name    = htmlspecialchars(explode(' ', trim($user['fullname']))[0]);

// ── Fetch this user's reports ───────────────────────────────────────────────
$reports = [];
try {
    $stmt2 = $pdo->prepare("SELECT * FROM tblreports WHERE user_id = ? ORDER BY created_at DESC");
    $stmt2->execute([$user_id]);
    $reports = $stmt2->fetchAll();
} catch (Exception $e) { $reports = []; }

// ── Stats ───────────────────────────────────────────────────────────────────
$total_reports  = count($reports);
$resolved       = 0;
$active_reports = 0;
foreach ($reports as $r) {
    strtolower($r['status'] ?? '') === 'resolved' ? $resolved++ : $active_reports++;
}

$stats = [
    ['icon' => 'fa-clock',             'color' => 'text-blue-500',   'bg' => 'bg-blue-50',   'label' => 'ACTIVE REPORTS', 'count' => $active_reports],
    ['icon' => 'fa-check-circle',      'color' => 'text-green-500',  'bg' => 'bg-green-50',  'label' => 'RESOLVED',       'count' => $resolved],
    ['icon' => 'fa-exclamation-circle','color' => 'text-purple-500', 'bg' => 'bg-purple-50', 'label' => 'TOTAL REPORTS',  'count' => $total_reports],
];

// ── Verification requests for items THIS USER reported as FOUND ─────────────
$verification_requests = [];
try {
    $stmt3 = $pdo->prepare("
        SELECT v.*, 
               r.title AS item_title, 
               r.verification_question, 
               r.verification_answer,
               r.id AS report_id,
               u.fullname AS claimant_name
        FROM tblverification_requests v
        JOIN tblreports r ON v.report_id = r.id
        JOIN tblusers u   ON v.claimant_id = u.id
        WHERE r.user_id = ?
          AND v.status = 'pending'
        ORDER BY v.created_at DESC
    ");
    $stmt3->execute([$user_id]);
    $verification_requests = $stmt3->fetchAll();
} catch (Exception $e) { $verification_requests = []; }

$just_reported = isset($_GET['reported']) && $_GET['reported'] == '1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – CIT Lost & Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { citred: '#DC2626', citdarkred: '#b91c1c' } } }
        }
    </script>
</head>
<body>

<!-- Success Toast -->
<?php if ($just_reported): ?>
<div id="toast" class="fixed top-6 right-6 z-50 bg-green-500 text-white px-6 py-4 rounded-xl shadow-xl flex items-center gap-3 text-sm font-bold transition-all">
    <i class="fa-solid fa-circle-check text-lg"></i> Report submitted successfully!
</div>
<script>
    setTimeout(() => {
        const t = document.getElementById('toast');
        if (t) { t.style.opacity='0'; t.style.transform='translateY(-10px)'; setTimeout(()=>t.remove(),400); }
    }, 3000);
</script>
<?php endif; ?>

<div class="flex bg-[#F8FAFC] min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-citred fixed h-full flex flex-col z-20 shadow-xl">
        <div class="p-6 flex items-center gap-3 border-b border-white/10">
            <img src="images/cit-logo.png" class="w-10 h-10 object-contain bg-white rounded-full p-0.5 shadow-sm" alt="Logo">
            <div class="text-white leading-tight">
                <p class="font-black text-[12px] tracking-wider uppercase">CIT University</p>
                <p class="font-bold text-[12px] opacity-90">LOST &amp; FOUND</p>
            </div>
        </div>
        <nav class="mt-8 px-4 space-y-2.5">
            <a href="index.php?page=dashboard" class="flex items-center gap-4 px-4 py-3.5 bg-white/20 text-white rounded-lg font-bold text-[15px] transition-all">
                <i class="fa-solid fa-table-cells-large w-5 text-center"></i> Dashboard
            </a>
            <a href="index.php?page=report" class="flex items-center gap-4 px-4 py-3.5 text-white/70 hover:bg-white/10 hover:text-white rounded-lg font-bold text-[15px] transition-all">
                <i class="fa-solid fa-circle-plus w-5 text-center"></i> Report Item
            </a>
            <a href="index.php?page=browse" class="flex items-center gap-4 px-4 py-3.5 text-white/70 hover:bg-white/10 hover:text-white rounded-lg font-bold text-[15px] transition-all">
                <i class="fa-solid fa-magnifying-glass w-5 text-center"></i> Browse Items
            </a>
        </nav>
        <div class="mt-auto p-6 border-t border-white/10 bg-black/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white font-bold border border-white/10"><?= $avatar_letter ?></div>
                <div class="text-white overflow-hidden">
                    <p class="text-[13px] font-bold truncate"><?= $full_name ?></p>
                    <p class="text-[11px] opacity-60 capitalize"><?= $role ?></p>
                </div>
            </div>
        </div>
    </aside>

    <div class="flex-1 ml-64 flex flex-col h-screen">
        <header class="bg-white shadow-sm h-16 flex justify-between items-center px-8 border-b border-gray-100 shrink-0 z-10">
            <h1 class="text-xl font-bold text-gray-800 capitalize"><?= ucfirst($role) ?> Dashboard</h1>
            <div class="flex items-center gap-5">
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-[14px] font-bold text-gray-800 leading-tight"><?= $full_name ?></p>
                        <p class="text-[11px] text-gray-400 font-medium capitalize"><?= $role ?></p>
                    </div>
                    <div class="bg-citred text-white w-9 h-9 flex justify-center items-center rounded-full text-sm font-bold shadow-sm"><?= $avatar_letter ?></div>
                </div>
                <div class="h-6 w-px bg-gray-200 mx-1"></div>
                <a href="index.php?page=logout" class="text-[13px] text-gray-500 font-bold hover:text-citred flex items-center gap-2">
                    [ <i class="fa-solid fa-arrow-right-from-bracket text-[10px]"></i> Log Out ]
                </a>
            </div>
        </header>

        <main class="p-8 w-full max-w-screen-2xl mx-auto overflow-y-auto flex-1 flex flex-col">

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Welcome back, <?= $first_name ?>!</h2>
                <p class="text-[15px] text-gray-500">Here's an overview of your lost &amp; found activity.</p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <?php foreach ($stats as $stat): ?>
                <div class="bg-white py-6 px-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl <?= $stat['bg'] ?> <?= $stat['color'] ?> flex items-center justify-center text-xl">
                        <i class="fa-solid <?= $stat['icon'] ?>"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 tracking-wider mb-0.5 uppercase"><?= $stat['label'] ?></p>
                        <p class="text-3xl font-black text-gray-900 leading-none"><?= $stat['count'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Verification Requests -->
            <?php if (!empty($verification_requests)): ?>
            <div class="bg-[#EEF2F6] rounded-xl border border-[#D0D7E2] p-6 mb-8 shadow-sm">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-[#DCE4EF] text-blue-700 flex items-center justify-center rounded-lg text-lg shadow-sm">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg leading-tight">Verification Requests</h3>
                        <p class="text-[13px] text-blue-700 font-medium">Someone is trying to claim an item you found.</p>
                    </div>
                </div>

                <div class="space-y-5">
                <?php foreach ($verification_requests as $vr):
                    $answer_correct = strtolower(trim($vr['claimant_answer'])) === strtolower(trim($vr['verification_answer']));
                ?>
                <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                    <p class="text-sm text-gray-800 font-medium mb-4">
                        <span class="font-bold text-gray-900"><?= htmlspecialchars($vr['claimant_name']) ?></span>
                        wants to claim
                        <span class="font-bold text-citred"><?= htmlspecialchars($vr['item_title']) ?></span>
                    </p>

                    <div class="bg-gray-50 border border-gray-100 rounded-lg p-4 mb-4">
                        <p class="text-[10px] font-bold text-gray-500 tracking-wider uppercase mb-1">Your Question</p>
                        <p class="text-[13px] font-bold text-gray-900 mb-4"><?= htmlspecialchars($vr['verification_question']) ?></p>

                        <div class="flex gap-10">
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 tracking-wider uppercase mb-1.5">Expected Answer</p>
                                <span class="bg-green-50 text-green-700 text-[12px] font-bold px-3 py-1 rounded-md">
                                    <?= htmlspecialchars($vr['verification_answer']) ?>
                                </span>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 tracking-wider uppercase mb-1.5">Their Answer</p>
                                <span class="<?= $answer_correct ? 'bg-blue-50 text-blue-700' : 'bg-red-50 text-red-600' ?> text-[12px] font-bold px-3 py-1 rounded-md">
                                    <?= htmlspecialchars($vr['claimant_answer']) ?>
                                </span>
                            </div>
                            <div class="flex items-center">
                                <?php if ($answer_correct): ?>
                                <span class="flex items-center gap-1 text-green-600 text-[11px] font-bold">
                                    <i class="fa-solid fa-circle-check"></i> Answer matches!
                                </span>
                                <?php else: ?>
                                <span class="flex items-center gap-1 text-red-500 text-[11px] font-bold">
                                    <i class="fa-solid fa-circle-xmark"></i> Answer does not match
                                </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 justify-end">
                        <a href="index.php?page=verification&action=decline&id=<?= (int)$vr['id'] ?>"
                           onclick="return confirm('Decline this claim?')"
                           class="bg-white border border-red-200 text-red-500 hover:bg-red-50 font-bold text-sm px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all shadow-sm">
                            <i class="fa-solid fa-xmark text-lg"></i> Decline
                        </a>
                        <a href="index.php?page=verification&action=approve&id=<?= (int)$vr['id'] ?>"
                           onclick="return confirm('Approve this claim? <?= $answer_correct ? '' : 'WARNING: The answer does not match. Are you sure?' ?>')"
                           class="<?= $answer_correct ? 'bg-[#60A06D] hover:bg-[#4E885A]' : 'bg-gray-400 hover:bg-gray-500' ?> text-white font-bold text-sm px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all shadow-sm">
                            <i class="fa-solid fa-check text-lg"></i> Approve
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Reports Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 w-full flex-1">
                <div class="flex justify-between items-center mb-6 border-b border-gray-50 pb-4">
                    <h3 class="text-base font-bold text-gray-800 uppercase tracking-wide">Your Reports</h3>
                    <a href="index.php?page=browse" class="text-xs text-citred font-bold hover:underline">View All →</a>
                </div>

                <?php if (empty($reports)): ?>
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-box-open text-2xl text-gray-300"></i>
                    </div>
                    <p class="text-[15px] font-bold text-gray-400 mb-1">No reports yet</p>
                    <p class="text-[13px] text-gray-400 mb-6">You haven't reported any lost or found items.</p>
                    <a href="index.php?page=report" class="bg-citred hover:bg-citdarkred text-white font-bold text-sm px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all shadow-sm">
                        <i class="fa-solid fa-circle-plus"></i> Report an Item
                    </a>
                </div>

                <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($reports as $report):
                        $is_lost      = strtolower($report['type'] ?? '') === 'lost';
                        $type_char    = $is_lost ? 'L' : 'F';
                        $type_color   = $is_lost ? 'bg-citred' : 'bg-green-500';
                        $is_resolved  = strtolower($report['status'] ?? '') === 'resolved';
                        $status_label = $is_resolved ? 'RESOLVED' : 'PENDING';
                        $status_color = $is_resolved ? 'text-blue-600 bg-blue-100' : 'text-yellow-600 bg-yellow-100';
                        $date         = isset($report['created_at']) ? date('n/j/Y', strtotime($report['created_at'])) : '—';
                        $location     = htmlspecialchars($report['location'] ?? '—');
                        $title        = htmlspecialchars($report['title'] ?? 'Untitled');
                    ?>
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-xl transition cursor-pointer group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 <?= $type_color ?> text-white font-bold rounded-lg flex items-center justify-center shadow-sm text-sm"><?= $type_char ?></div>
                            <div>
                                <p class="font-bold text-sm text-gray-900 group-hover:text-citred transition-colors"><?= $title ?></p>
                                <p class="text-xs text-gray-400 mt-0.5 font-medium"><?= $date ?> • <?= $location ?></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-[10px] font-bold px-3 py-1 rounded-md <?= $status_color ?> uppercase tracking-tighter"><?= $status_label ?></span>
                            <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-citred text-[10px] transition"></i>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

        </main>
    </div>
</div>
</body>
</html>