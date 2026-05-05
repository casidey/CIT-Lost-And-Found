<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/db.php';

// ── Fetch stats ──────────────────────────────────────────────────────────────
$active_reports = 0;
$total_returned = 0;

try {
    $stmt = $pdo->query("SELECT COUNT(*) FROM tblreports WHERE status != 'resolved'");
    $active_reports = (int)$stmt->fetchColumn();

    $stmt = $pdo->query("SELECT COUNT(*) FROM tblreports WHERE status = 'resolved'");
    $total_returned = (int)$stmt->fetchColumn();
} catch (Exception $e) {}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Dashboard – CIT Lost & Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { citred: '#DC2626', citdarkred: '#b91c1c', bglight: '#F8FAFC' } } }
        }
    </script>
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fadeInUp 0.45s ease both; }
        .delay-1    { animation-delay: 0.08s; }
        .delay-2    { animation-delay: 0.18s; }
    </style>
</head>
<body class="bg-bglight">
<div class="flex bg-bglight min-h-screen">

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
            <a href="index.php?page=guest-dashboard"
               class="flex items-center gap-4 px-4 py-3.5 bg-white/20 text-white rounded-lg font-bold text-[15px] transition-all">
                <i class="fa-solid fa-table-cells-large w-5 text-center"></i> Dashboard
            </a>
            <a href="index.php?page=guest-browse"
               class="flex items-center gap-4 px-4 py-3.5 text-white/70 hover:bg-white/10 hover:text-white rounded-lg font-bold text-[15px] transition-all">
                <i class="fa-solid fa-magnifying-glass w-5 text-center"></i> Browse Items
            </a>
        </nav>
        <div class="mt-auto p-6 border-t border-white/10 bg-black/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white font-bold border border-white/10">
                    <i class="fa-solid fa-user text-sm"></i>
                </div>
                <div class="text-white overflow-hidden">
                    <p class="text-[13px] font-bold truncate">Guest User</p>
                    <p class="text-[11px] opacity-60">Guest</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 ml-64 flex flex-col h-screen">

        <!-- Header -->
        <header class="bg-white shadow-sm h-16 flex justify-between items-center px-8 border-b border-gray-100 shrink-0 z-10">
            <h1 class="text-xl font-bold text-gray-800">Guest Dashboard</h1>
            <div class="flex items-center gap-5">
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-[14px] font-bold text-gray-800 leading-tight">Guest User</p>
                        <p class="text-[11px] text-gray-400 font-medium">Guest</p>
                    </div>
                    <div class="bg-citred text-white w-9 h-9 flex justify-center items-center rounded-full text-sm font-bold shadow-sm">G</div>
                </div>
                <div class="h-6 w-px bg-gray-200 mx-1"></div>
                <a href="index.php?page=landing" class="text-[13px] text-gray-500 font-bold hover:text-citred flex items-center gap-2">
                    [ <i class="fa-solid fa-arrow-right-from-bracket text-[10px]"></i> Exit ]
                </a>
            </div>
        </header>

        <main class="p-8 w-full max-w-screen-2xl mx-auto overflow-y-auto flex-1">

            <!-- Welcome notice -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 flex gap-4 items-start mb-8 fade-in-up">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fa-solid fa-circle-info text-blue-500 text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-blue-900 mb-0.5">Welcome, Teknoys!</p>
                    <p class="text-xs text-blue-700 leading-relaxed">
                        You are viewing the CIT Lost &amp; Found system as a guest. You can browse found items, but you cannot report items or
                        claim them online. Please <a href="index.php?page=login" class="font-bold underline hover:text-blue-900">log in with your student or faculty account</a> for full access.
                    </p>
                </div>
            </div>

            <!-- Cards row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Browse Items card -->
                <div class="bg-white border border-gray-100 rounded-xl p-8 shadow-sm flex flex-col items-center text-center fade-in-up delay-1 hover:shadow-lg transition-shadow duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-5">
                        <i class="fa-solid fa-magnifying-glass text-green-500 text-2xl"></i>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900 mb-2">Browse Found Items</h2>
                    <p class="text-[13px] text-gray-500 leading-relaxed mb-6">
                        Check if your lost item has been found<br>and turned in to the office.
                    </p>
                    <a href="index.php?page=guest-browse"
                       class="bg-citred hover:bg-citdarkred text-white text-sm font-bold px-6 py-2.5 rounded-lg transition shadow-sm inline-flex items-center gap-2">
                        View Found Items <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- System Statistics card -->
                <div class="bg-white border border-gray-100 rounded-xl p-8 shadow-sm flex flex-col fade-in-up delay-2 hover:shadow-lg transition-shadow duration-300">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 text-center">System Statistics</h2>
                    <div class="flex justify-around items-center flex-1">

                        <div class="flex flex-col items-center gap-3">
                            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-magnifying-glass text-citred text-xl"></i>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-citred leading-none"><?= $active_reports ?></p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Active Reports</p>
                            </div>
                        </div>

                        <div class="w-px h-16 bg-gray-100"></div>

                        <div class="flex flex-col items-center gap-3">
                            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-circle-check text-green-500 text-xl"></i>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-green-600 leading-none"><?= $total_returned ?></p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Total Returned</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </main>
    </div>
</div>
</body>
</html>