<?php 
require 'includes/header.php'; 

// Simulated dynamic data
$stats = [['icon' => 'fa-clock', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50', 'label' => 'ACTIVE REPORTS', 'count' => 1],['icon' => 'fa-check-circle', 'color' => 'text-green-500', 'bg' => 'bg-green-50', 'label' => 'RESOLVED', 'count' => 2],['icon' => 'fa-box-archive', 'color' => 'text-purple-500', 'bg' => 'bg-purple-50', 'label' => 'TOTAL REPORTS', 'count' => 3]
];

$reports =[['type' => 'L', 'type_color' => 'bg-citred', 'title' => 'Scientific Calculator', 'date' => '2/28/2026', 'location' => 'GLE Building', 'status' => 'NOT RESOLVED', 'status_color' => 'text-yellow-600 bg-yellow-100'],['type' => 'L', 'type_color' => 'bg-citred', 'title' => 'School Id', 'date' => '2/27/2026', 'location' => 'RTL Building', 'status' => 'RESOLVED', 'status_color' => 'text-blue-600 bg-blue-100'],['type' => 'F', 'type_color' => 'bg-green-500', 'title' => 'Laptop Charger', 'date' => '2/28/2026', 'location' => 'RTL Building', 'status' => 'NOT RESOLVED', 'status_color' => 'text-yellow-600 bg-yellow-100']
];
?>

<div class="flex bg-bglight min-h-screen">
    <?php require 'includes/sidebar.php'; ?>

    <div class="flex-1 ml-64 flex flex-col h-screen">
        <!-- Top Navbar -->
        <header class="bg-white shadow-sm h-16 flex justify-between items-center px-8 border-b border-gray-100 shrink-0">
            <h1 class="text-lg font-bold text-gray-800">Student Dashboard</h1>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-800">Casidey Quibuyen <span class="bg-citred text-white w-6 h-6 inline-flex justify-center items-center rounded-full ml-1 text-xs">Q</span></p>
                    <p class="text-[10px] text-gray-400">Student</p>
                </div>
                <a href="?page=landing" class="text-xs text-gray-500 font-semibold hover:text-citred"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-8 max-w-6xl w-full mx-auto overflow-y-auto">
            <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-1">Welcome back, Casidey!</h2>
                <p class="text-sm text-gray-500">Here's an overview of your lost & found activity.</p>
            </div>

            <!-- Bigger Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <?php foreach($stats as $stat): ?>
                <div class="bg-white py-8 px-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-5 transition hover:shadow-md">
                    <div class="w-14 h-14 rounded-full <?= $stat['bg'] ?> <?= $stat['color'] ?> flex items-center justify-center text-2xl">
                        <i class="fa-solid <?= $stat['icon'] ?>"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1"><?= $stat['label'] ?></p>
                        <p class="text-4xl font-black text-gray-800"><?= $stat['count'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Your Reports -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-800">Your Reports</h3>
                    <a href="?page=report" class="text-xs text-citred font-bold hover:underline">View All →</a>
                </div>

                <div class="space-y-4">
                    <?php foreach($reports as $report): ?>
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-lg transition border border-transparent hover:border-gray-100 cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 <?= $report['type_color'] ?> text-white font-bold rounded flex items-center justify-center text-lg shadow-sm"><?= $report['type'] ?></div>
                            <div>
                                <p class="font-bold text-sm text-gray-800"><?= $report['title'] ?></p>
                                <p class="text-[11px] text-gray-400 mt-0.5"><?= $report['date'] ?> • <?= $report['location'] ?></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-md <?= $report['status_color'] ?>"><?= $report['status'] ?></span>
                            <i class="fa-solid fa-chevron-right text-gray-300 text-xs"></i>
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