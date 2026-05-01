<?php 
$active_page = 'browse'; 
// require 'includes/header.php'; // Commented out for standalone testing


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
        'question' => 'What is the color of the item?' // Added question for Verification
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Items</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        citred: '#DC2626', 
                    }
                }
            }
        }
    </script>
</head>
<body>
<div class="flex bg-[#F8FAFC] min-h-screen">
    
    <aside class="w-64 bg-citred fixed h-full flex flex-col z-20 shadow-xl">
        <div class="p-6 flex items-center gap-3 border-b border-white/10">
            <img src="images/cit-logo.png" class="w-10 h-10 object-contain bg-white rounded-full p-0.5 shadow-sm" alt="Logo">
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

        <main class="p-8 w-full max-w-screen-2xl mx-auto overflow-y-auto">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 min-h-[calc(100vh-8rem)]">
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
                    <div class="item-card bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col group cursor-pointer" data-type="<?= $item['type'] ?>" onclick="openModal(<?= $index ?>)">
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
                                    <p class="text-[11px] text-gray-500 font-medium">Rep. by <?= explode(' ', $item['reporter'])[0] ?></p>
                                </div>
                                <button class="text-[12px] text-citred font-bold hover:underline">View Details</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- ITEM MODAL -->
<div id="itemModal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-4xl rounded-2xl overflow-hidden shadow-2xl relative flex flex-col max-h-[90vh]">
        <!-- Close Button -->
        <button onclick="closeModal()" class="absolute top-4 right-4 z-20 w-8 h-8 bg-white text-gray-600 hover:text-gray-900 rounded-full flex items-center justify-center shadow-md transition-all">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>

        <!-- Banner Image -->
        <div class="relative h-64 bg-gray-100 shrink-0">
            <div id="modalTypeBadge" class="absolute top-4 left-4 text-white text-[10px] font-bold px-3 py-1.5 rounded shadow-sm z-10 uppercase tracking-widest"></div>
            <img id="modalImg" src="" alt="Item Image" class="w-full h-full object-cover">
        </div>

        <!-- Content -->
        <div class="p-8 overflow-y-auto">
            <div class="mb-6">
                <h2 id="modalTitle" class="text-2xl font-bold text-gray-900 mb-2">Item Title</h2>
                <div class="flex items-center gap-2">
                    <span id="modalCategory" class="text-[10px] font-bold px-2.5 py-1 rounded bg-gray-100 text-gray-600 uppercase tracking-wider">CATEGORY</span>
                    <span id="modalStatus" class="text-[10px] font-bold px-2.5 py-1 rounded uppercase tracking-wider">STATUS</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Left: Details -->
                <div>
                    <h3 class="text-[12px] font-bold text-gray-800 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Details</h3>
                    <div class="space-y-5">
                        <div class="flex gap-4">
                            <i class="fa-solid fa-location-dot text-citred mt-1"></i>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Location</p>
                                <p id="modalLocation" class="text-sm font-bold text-gray-900">Location Name</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <i class="fa-regular fa-calendar text-citred mt-1"></i>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Date & Time</p>
                                <p id="modalDateTime" class="text-sm font-bold text-gray-900">Date at Time</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <i class="fa-regular fa-user text-citred mt-1"></i>
                            <div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Reported By</p>
                                <p id="modalReporter" class="text-sm font-bold text-gray-900">Reporter Name</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Dynamic Section (Contact Info / Verification) -->
                <div>
                    <h3 class="text-[12px] font-bold text-gray-800 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Contact Info</h3>
                    
                    <!-- Dynamic Box container -->
                    <div id="dynamicContentBox">
                        <!-- Content injected via JS based on type -->
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mt-8 pt-6 border-t border-gray-100">
                <h3 class="text-[12px] font-bold text-gray-800 uppercase tracking-widest mb-3">Description</h3>
                <div class="border border-gray-200 rounded-xl p-4 text-sm text-gray-600 bg-gray-50">
                    <p id="modalDesc"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Load PHP items array into JS
    const itemsData = <?= json_encode($items) ?>;
    const itemModal = document.getElementById('itemModal');
    let currentItemIndex = null;

    // Filter Buttons logic
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

    // Modal Logic
    function openModal(index) {
        currentItemIndex = index;
        const item = itemsData[index];
        
        // Populate static details
        document.getElementById('modalImg').src = item.img;
        document.getElementById('modalTitle').textContent = item.title;
        document.getElementById('modalCategory').textContent = item.category;
        document.getElementById('modalLocation').textContent = item.location;
        document.getElementById('modalDateTime').textContent = `${item.date} AT ${item.time}`;
        document.getElementById('modalReporter').textContent = item.reporter;
        document.getElementById('modalDesc').textContent = item.desc;
        
        // Set Badge (Lost/Found)
        const typeBadge = document.getElementById('modalTypeBadge');
        typeBadge.textContent = item.type;
        typeBadge.className = `absolute top-4 left-4 text-white text-[10px] font-bold px-3 py-1.5 rounded shadow-sm z-10 uppercase tracking-widest ${item.type_color}`;

        // Set Status Badge
        const statusBadge = document.getElementById('modalStatus');
        statusBadge.textContent = item.status;
        statusBadge.className = `text-[10px] font-bold px-2.5 py-1 rounded uppercase tracking-wider ${item.status_color}`;

        // Handle Dynamic Right Section
        const dynamicBox = document.getElementById('dynamicContentBox');
        
        if (item.type === 'LOST') {
            // Standard Contact Info box for LOST items
            dynamicBox.innerHTML = `
                <div class="border border-gray-200 rounded-xl p-5 shadow-sm">
                    <p class="font-bold text-gray-900 mb-1">None</p>
                    <p class="text-[11px] text-gray-400">Please contact the reporter directly to claim this item or provide information.</p>
                </div>
            `;
        } else if (item.type === 'FOUND') {
            // Proof Before Claim for FOUND items
            dynamicBox.innerHTML = `
                <div class="bg-[#F4F6FB] border border-[#E2E8F0] rounded-xl p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fa-solid fa-shield-halved text-blue-600"></i>
                        <h4 class="font-bold text-[14px] text-blue-900">Proof Before Claim</h4>
                    </div>
                    <p class="text-[11px] text-blue-600/80 mb-5 leading-relaxed">The finder has set a hidden question to verify the real owner.</p>
                    
                    <div class="mb-4">
                        <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Question:</label>
                        <p class="text-sm font-bold text-gray-900 bg-white border border-gray-200 px-3 py-2 rounded-lg">${item.question || 'Describe the item in detail.'}</p>
                    </div>
                    
                    <input type="text" id="verificationAnswer" placeholder="Your answer..." class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm outline-none focus:border-blue-500 mb-3 shadow-sm">
                    <button onclick="submitVerification()" class="w-full bg-[#1D4ED8] hover:bg-blue-800 text-white font-bold text-[12px] py-2.5 rounded-lg transition-all shadow-sm">Submit Answer for Verification</button>
                </div>
            `;
        }

        itemModal.classList.remove('hidden');
    }

    function closeModal() {
        itemModal.classList.add('hidden');
    }

    function submitVerification() {
        // Change the dynamic box into the "Pending" state
        const dynamicBox = document.getElementById('dynamicContentBox');
        
        dynamicBox.innerHTML = `
            <div class="bg-[#FAFAF5] border border-[#EAEAB5] rounded-xl p-6 text-center shadow-sm">
                <i class="fa-regular fa-clock text-[#A1A142] text-2xl mb-3 block"></i>
                <h4 class="font-bold text-[14px] text-[#8C8C27] mb-2">Verification Pending</h4>
                <p class="text-[11px] text-[#A1A142] leading-relaxed px-2">Your answer has been sent to the finder. You will be able to see their contact info once they approve it.</p>
            </div>
        `;
    }

    // Close modal when clicking outside the box
    itemModal.addEventListener('click', (e) => {
        if (e.target === itemModal) {
            closeModal();
        }
    });
</script>
</body>
</html>