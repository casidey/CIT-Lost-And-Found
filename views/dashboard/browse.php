<?php 
$active_page = 'browse'; 
require 'includes/header.php'; 


$items = [[
        'id' => 1,
        'type' => 'LOST', 
        'type_color' => 'bg-citred', 
        'title' => 'Scientific Calculator', 
        'category' => 'SCHOOL ITEMS',
        'date' => '2/28/2026', 
        'time' => '10:30 AM',
        'location' => 'GLE Building',
        'status' => 'NOT RESOLVED', 
        'status_color' => 'text-yellow-600 bg-yellow-100', 
        'img' => 'https://images.unsplash.com/photo-1611077544837-798835845c47?auto=format&fit=crop&q=80&w=800',
        'reporter' => 'Casidey Quibuyen',
        'desc' => 'Casio fx-991EX, lost in Room 305.'
    ],[
        'id' => 2,
        'type' => 'LOST', 
        'type_color' => 'bg-citred', 
        'title' => 'School Id', 
        'category' => 'PERSONAL ITEM',
        'date' => '2/27/2026', 
        'time' => '1:00 PM',
        'location' => 'RTL Building',
        'status' => 'RESOLVED', 
        'status_color' => 'text-blue-600 bg-blue-100', 
        'img' => 'https://images.unsplash.com/photo-1633265486064-086b219458ce?auto=format&fit=crop&q=80&w=800',
        'reporter' => 'Casidey Quibuyen',
        'desc' => 'School Id, lost in RTL hallway at the monoblock chair.'
    ],[
        'id' => 3,
        'type' => 'FOUND', 
        'type_color' => 'bg-green-500', 
        'title' => 'Laptop Charger', 
        'category' => 'ELECTRONICS',
        'date' => '2/28/2026', 
        'time' => '8:40 AM',
        'location' => 'RTL Building',
        'status' => 'NOT RESOLVED', 
        'status_color' => 'text-yellow-600 bg-yellow-100', 
        'img' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?auto=format&fit=crop&q=80&w=800',
        'reporter' => 'Casidey Quibuyen',
        'desc' => 'Laptop Charger, found in Room 300.',
        'question' => 'What brand is the laptop charger?'
    ]
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
            <a href="?page=dashboard" class="flex items-center gap-4 px-4 py-3.5 rounded-lg font-bold text-[15px] text-white/70 hover:bg-white/10 hover:text-white transition-all">
                <i class="fa-solid fa-table-cells-large w-5 text-center"></i> Dashboard
            </a>
            <a href="?page=report" class="flex items-center gap-4 px-4 py-3.5 rounded-lg font-bold text-[15px] text-white/70 hover:bg-white/10 hover:text-white transition-all">
                <i class="fa-solid fa-circle-plus w-5 text-center"></i> Report Item
            </a>
            <a href="?page=browse" class="flex items-center gap-4 px-4 py-3.5 bg-white/20 text-white rounded-lg font-bold text-[15px] transition-all">
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
            <h1 class="text-xl font-bold text-gray-800">Browse Items</h1>
            
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
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex flex-col md:flex-row justify-between md:items-center gap-6 mb-10">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-1">Browse Items</h2>
                        <p class="text-[15px] text-gray-500">Find lost items or see what's been found.</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                            <input type="text" placeholder="Search items..." class="pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-citred w-72 transition-all">
                        </div>
                        <div class="flex bg-gray-100 rounded-xl p-1.5 shadow-inner">
                            <button data-filter="ALL" class="filter-btn bg-white text-gray-900 text-[13px] font-bold px-5 py-2 rounded-lg shadow-sm transition-all">All</button>
                            <button data-filter="LOST" class="filter-btn text-gray-500 hover:text-gray-900 text-[13px] font-bold px-5 py-2 rounded-lg transition-all">Lost</button>
                            <button data-filter="FOUND" class="filter-btn text-gray-500 hover:text-gray-900 text-[13px] font-bold px-5 py-2 rounded-lg transition-all">Found</button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach($items as $index => $item): ?>
                    <div class="item-card bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col group" data-type="<?= $item['type'] ?>">
                        <div class="relative h-48 bg-gray-50 overflow-hidden">
                            <div class="absolute top-3 left-3 <?= $item['type_color'] ?> text-white text-[10px] font-bold px-3 py-1 rounded shadow-sm z-10 uppercase tracking-widest"><?= $item['type'] ?></div>
                            <img src="<?= $item['img'] ?>" alt="<?= $item['title'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-gray-900 text-[15px] mb-1 group-hover:text-citred transition-colors"><?= $item['title'] ?></h3>
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg w-max <?= $item['status_color'] ?> uppercase tracking-wider mb-3"><?= $item['status'] ?></span>
                            <p class="text-[12px] text-gray-400 font-medium mb-4"><?= $item['date'] ?></p>
                            
                            <div class="mt-auto pt-3 border-t border-gray-50 flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-citred text-white flex items-center justify-center rounded-full text-[10px] font-bold">C</div>
                                    <p class="text-[11px] text-gray-500 font-medium">Rep. by Casidey</p>
                                </div>
                                <button onclick="openModal(<?= $index ?>)" class="text-[12px] text-citred font-bold hover:underline">View Details</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    const filterBtns = document.querySelectorAll('.filter-btn');
    const itemCards = document.querySelectorAll('.item-card');
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-filter');
            filterBtns.forEach(b => {
                b.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
                b.classList.add('text-gray-500');
            });
            btn.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
            btn.classList.remove('text-gray-500');
            itemCards.forEach(card => {
                if (filter === 'ALL' || card.getAttribute('data-type') === filter) card.classList.remove('hidden');
                else card.classList.add('hidden');
            });
        });
    });
</script>
</body>
</html>