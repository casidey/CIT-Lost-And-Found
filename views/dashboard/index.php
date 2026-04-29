<?php 
$active_page = 'dashboard'; 
require 'includes/header.php'; 

$stats = [
    ['icon' => 'fa-clock', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50', 'label' => 'ACTIVE REPORTS', 'count' => 1],
    ['icon' => 'fa-check-circle', 'color' => 'text-green-500', 'bg' => 'bg-green-50', 'label' => 'RESOLVED', 'count' => 2],
    ['icon' => 'fa-exclamation-circle', 'color' => 'text-purple-500', 'bg' => 'bg-purple-50', 'label' => 'TOTAL REPORTS', 'count' => 3]
];

$reports = [
    ['type' => 'L', 'type_color' => 'bg-citred', 'title' => 'Scientific Calculator', 'date' => '2/25/2026', 'location' => 'GLE Building', 'status' => 'NOT RESOLVED', 'status_color' => 'text-yellow-600 bg-yellow-100'],
    ['type' => 'L', 'type_color' => 'bg-citred', 'title' => 'School Id', 'date' => '2/26/2026', 'location' => 'RTL Building', 'status' => 'RESOLVED', 'status_color' => 'text-blue-600 bg-blue-100'],
    ['type' => 'F', 'type_color' => 'bg-green-500', 'title' => 'Laptop Charger', 'date' => '2/26/2026', 'location' => 'RTL Building', 'status' => 'RESOLVED', 'status_color' => 'text-blue-600 bg-blue-100']
];
?>

<div class="flex bg-[#F8FAFC] min-h-screen">
    
    <aside class="w-64 bg-citred fixed h-full flex flex-col z-20 shadow-xl">
        <div class="p-6 flex items-center gap-3 border-b border-white/10">
            <img src="images/cit-logo.png" class="w-10 h-10 object-contain bg-white rounded-full p-0.5 shadow-sm">
            <div class="text-white leading-tight">
                <p class="font-black text-[12px] tracking-wider uppercase">CIT University</p>
                <p class="font-bold text-[12px] opacity-90">LOST & FOUND</p>
            </div>
        </div>

        <nav class="mt-8 px-4 space-y-2.5">
            <a href="?page=dashboard" class="flex items-center gap-4 px-4 py-3.5 bg-white/20 text-white rounded-lg font-bold text-[15px] transition-all">
                <i class="fa-solid fa-table-cells-large w-5 text-center"></i> Dashboard
            </a>
            <a href="?page=report" class="flex items-center gap-4 px-4 py-3.5 text-white/70 hover:bg-white/10 hover:text-white rounded-lg font-bold text-[15px] transition-all">
                <i class="fa-solid fa-circle-plus w-5 text-center"></i> Report Item
            </a>
            <a href="?page=browse" class="flex items-center gap-4 px-4 py-3.5 text-white/70 hover:bg-white/10 hover:text-white rounded-lg font-bold text-[15px] transition-all">
                <i class="fa-solid fa-magnifying-glass w-5 text-center"></i> Browse Items
            </a>
        </nav>

        <div class="mt-auto p-6 border-t border-white/10 bg-black/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white font-bold border border-white/10">Q</div>
                <div class="text-white">
                    <p class="text-[13px] font-bold">Casidey Quibuyen</p>
                    <p class="text-[11px] opacity-60">Student Account</p>
                </div>
            </div>
        </div>
    </aside>

    <div class="flex-1 ml-64 flex flex-col h-screen">
        <header class="bg-white shadow-sm h-16 flex justify-between items-center px-8 border-b border-gray-100 shrink-0 z-10">
            <h1 class="text-xl font-bold text-gray-800">Student Dashboard</h1>
            
            <div class="flex items-center gap-5">
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-[14px] font-bold text-gray-800 leading-tight">Casidey Quibuyen</p>
                        <p class="text-[11px] text-gray-400 font-medium">Student</p>
                    </div>
                    <div class="bg-citred text-white w-9 h-9 flex justify-center items-center rounded-full text-sm font-bold shadow-sm">Q</div>
                </div>
                <div class="h-6 w-px bg-gray-200 mx-1"></div> 
                <a href="?page=landing" class="text-[13px] text-gray-500 font-bold hover:text-citred flex items-center gap-2">
                   [ <i class="fa-solid fa-arrow-right-from-bracket text-[10px]"></i> Log Out ]
                </a>
            </div>
        </header>

        <main class="p-8 w-full max-w-6xl mx-auto overflow-y-auto">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Welcome back, Casidey!</h2>
                <p class="text-[15px] text-gray-500">Here's an overview of your lost & found activity.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <?php foreach($stats as $stat): ?>
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

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 w-full">
                <div class="flex justify-between items-center mb-6 border-b border-gray-50 pb-4">
                    <h3 class="text-base font-bold text-gray-800 uppercase tracking-wide">Your Reports</h3>
                    <a href="?page=browse" class="text-xs text-citred font-bold hover:underline">View All →</a>
                </div>

                <div class="space-y-4">
                    <?php foreach($reports as $report): ?>
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-xl transition cursor-pointer group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 <?= $report['type_color'] ?> text-white font-bold rounded-lg flex items-center justify-center shadow-sm">
                                <?= $report['type'] ?>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-900 group-hover:text-citred transition-colors"><?= $report['title'] ?></p>
                                <p class="text-xs text-gray-400 mt-0.5 font-medium">
                                    <?= $report['date'] ?> • <?= $report['location'] ?>
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <span class="text-[10px] font-bold px-3 py-1 rounded-md <?= $report['status_color'] ?> uppercase tracking-tighter">
                                <?= $report['status'] ?>
                            </span>
                            <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-citred text-[10px] transition"></i>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>