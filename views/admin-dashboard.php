<?php require 'includes/header.php'; 

$reports = [['item' => 'LAPTOP CHARGER', 'rep_by' => 'Casidey Kizteen', 'type' => 'FOUND', 'type_color' => 'bg-green-500', 'category' => 'ELECTRONICS', 'location' => 'RTL Building', 'date' => '2/28/26', 'status' => 'NOT RESOLVED', 'status_color' => 'text-yellow-600 bg-yellow-100'],['item' => 'SCHOOL ID', 'rep_by' => 'Casidey Kizteen', 'type' => 'LOST', 'type_color' => 'bg-citred', 'category' => 'PERSONAL ITEMS', 'location' => 'RTL Building', 'date' => '2/27/26', 'status' => 'RESOLVED', 'status_color' => 'text-blue-600 bg-blue-100'],['item' => 'SCIENTIFIC CALCULATOR', 'rep_by' => 'Casidey Kizteen', 'type' => 'LOST', 'type_color' => 'bg-citred', 'category' => 'ELECTRONICS', 'location' => 'GLE Building', 'date' => '2/28/26', 'status' => 'NOT RESOLVED', 'status_color' => 'text-yellow-600 bg-yellow-100']
];
?>
<div class="flex bg-bglight min-h-screen">
    <!-- Admin Sidebar -->
    <aside class="w-64 bg-citred h-screen fixed left-0 top-0 text-white flex flex-col shadow-xl z-40">
        <div class="p-6 flex flex-col items-center border-b border-red-500/30 mb-4">
            <div class="w-12 h-12 bg-white p-1 rounded-full shadow-lg mb-2 flex items-center justify-center">
                <div class="w-full h-full bg-yellow-500 rounded-full flex items-center justify-center text-white text-xl"><i class="fa-solid fa-graduation-cap"></i></div>
            </div>
            <h2 class="text-center text-xs font-bold tracking-wider leading-tight">CIT UNIVERSITY<br>LOST & FOUND</h2>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <!-- Active State -->
            <a href="?page=admin" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-semibold bg-white/20 shadow-sm text-white transition"><i class="fa-solid fa-border-all w-5"></i> Dashboard</a>
            <!-- Inactive State -->
            <a href="?page=admin-manage" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-medium text-red-100 hover:bg-white/10 transition"><i class="fa-solid fa-box-open w-5"></i> Manage Items</a>
        </nav>
        <div class="p-4 border-t border-red-500/30 flex items-center gap-3 mt-auto bg-citred">
            <div class="w-8 h-8 bg-red-400 rounded-full flex items-center justify-center text-white"><i class="fa-solid fa-user-group"></i></div>
            <div>
                <p class="text-xs font-bold">Admin User</p>
                <p class="text-[10px] text-red-200">Admin</p>
            </div>
        </div>
    </aside>

    <div class="flex-1 ml-64 flex flex-col h-screen">
        <header class="bg-white shadow-sm h-16 flex justify-between items-center px-8 border-b border-gray-100 shrink-0">
            <h1 class="text-xl font-bold text-gray-900">Admin Dashboard</h1>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-800">Admin User <span class="bg-citred text-white w-7 h-7 inline-flex justify-center items-center rounded-full ml-1 text-xs">A</span></p>
                    <p class="text-[10px] text-gray-400">Admin</p>
                </div>
                <a href="?page=landing" class="text-xs text-gray-500 font-semibold hover:text-citred border-l border-gray-200 pl-4 ml-2"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</a>
            </div>
        </header>

        <main class="p-8 max-w-6xl w-full mx-auto overflow-y-auto">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Welcome back, Admin!</h2>
                <p class="text-sm text-gray-500">System overview and statistics</p>
            </div>

            <!-- BIGGER Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
                <div class="bg-white py-8 px-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-5 transition hover:shadow-md">
                    <div class="w-14 h-14 rounded-full border-2 border-red-100 text-red-400 flex items-center justify-center text-2xl"><i class="fa-solid fa-circle-exclamation"></i></div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">LOST ITEMS</p>
                        <p class="text-4xl font-black text-gray-800">1</p>
                    </div>
                </div>
                <div class="bg-white py-8 px-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-5 transition hover:shadow-md">
                    <div class="w-14 h-14 rounded-full border-2 border-green-100 text-green-500 flex items-center justify-center text-2xl"><i class="fa-regular fa-circle-check"></i></div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">FOUND ITEMS</p>
                        <p class="text-4xl font-black text-gray-800">2</p>
                    </div>
                </div>
                <div class="bg-white py-8 px-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-5 transition hover:shadow-md">
                    <div class="w-14 h-14 rounded-full border-2 border-blue-100 text-blue-500 flex items-center justify-center text-2xl"><i class="fa-regular fa-circle-check"></i></div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">RESOLVED</p>
                        <p class="text-4xl font-black text-gray-800">1</p>
                    </div>
                </div>
                <div class="bg-white py-8 px-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-5 transition hover:shadow-md">
                    <div class="w-14 h-14 rounded-full border-2 border-purple-100 text-purple-400 flex items-center justify-center text-2xl"><i class="fa-solid fa-cube"></i></div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">TOTAL ITEMS</p>
                        <p class="text-4xl font-black text-gray-800">3</p>
                    </div>
                </div>
            </div>

            <!-- BIGGER Recent Reports Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-900 text-lg">Recent Reports</h3>
                    <a href="?page=admin-manage" class="text-xs text-citred font-bold hover:underline">View All &rarr;</a>
                </div>

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
                            <?php foreach($reports as $r): ?>
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                <td class="py-5 px-4">
                                    <p class="font-bold text-gray-800 text-sm"><?= $r['item'] ?></p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">Rep. by <?= $r['rep_by'] ?></p>
                                </td>
                                <td class="py-5 px-4">
                                    <span class="text-[10px] font-bold px-3 py-1 rounded-full text-white <?= $r['type_color'] ?>"><?= $r['type'] ?></span>
                                </td>
                                <td class="py-5 px-4 text-xs text-gray-600 uppercase font-semibold tracking-wide"><?= $r['category'] ?></td>
                                <td class="py-5 px-4 text-xs text-gray-600"><?= $r['location'] ?></td>
                                <td class="py-5 px-4 text-xs text-gray-600"><?= $r['date'] ?></td>
                                <td class="py-5 px-4">
                                    <span class="text-[10px] font-bold px-2.5 py-1 rounded <?= $r['status_color'] ?>"><?= $r['status'] ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>