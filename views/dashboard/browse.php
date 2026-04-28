<?php 
require 'includes/header.php'; 

// Simulated dynamic data with extended details for the modal
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
        'question' => 'What brand is the laptop charger?' // Hidden question for found items
    ]
];
?>

<div class="flex bg-bglight min-h-screen">
    <?php require 'includes/sidebar.php'; ?>

    <div class="flex-1 ml-64 flex flex-col h-screen">
        <header class="bg-white shadow-sm h-16 flex justify-between items-center px-8 border-b border-gray-100 shrink-0 z-10">
            <h1 class="text-lg font-bold text-gray-800">Student Dashboard</h1>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-800">Casidey Quibuyen <span class="bg-citred text-white w-6 h-6 inline-flex justify-center items-center rounded-full ml-1 text-xs">Q</span></p>
                </div>
                <a href="?page=landing" class="text-xs text-gray-500 font-semibold hover:text-citred"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</a>
            </div>
        </header>

        <main class="p-8 w-full mx-auto overflow-y-auto">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <!-- Header & Filters -->
                <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Browse Items</h2>
                        <p class="text-sm text-gray-500">Find lost items or see what's been found.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                            <input type="text" placeholder="Search items..." class="pl-9 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-citred w-64">
                        </div>
                        <div class="flex bg-gray-100 rounded-md p-1">
                            <button class="bg-white text-gray-800 text-xs font-bold px-3 py-1.5 rounded shadow-sm">All</button>
                            <button class="text-gray-500 hover:text-gray-800 text-xs font-bold px-3 py-1.5 rounded">Lost</button>
                            <button class="text-gray-500 hover:text-gray-800 text-xs font-bold px-3 py-1.5 rounded">Found</button>
                        </div>
                    </div>
                </div>

                <!-- Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach($items as $index => $item): ?>
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition flex flex-col group">
                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                            <div class="absolute top-3 left-3 <?= $item['type_color'] ?> text-white text-[10px] font-bold px-2.5 py-1 rounded shadow-sm z-10 uppercase tracking-wide"><?= $item['type'] ?></div>
                            <img src="<?= $item['img'] ?>" alt="<?= $item['title'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-bold text-gray-800 text-sm"><?= $item['title'] ?></h3>
                                <span class="text-[9px] font-bold px-2 py-1 rounded <?= $item['status_color'] ?>"><?= $item['status'] ?></span>
                            </div>
                            <p class="text-[11px] text-gray-500 mb-4">Listed on <?= $item['date'] ?></p>
                            
                            <div class="mt-auto pt-3 border-t border-gray-100 flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 bg-citred text-white flex items-center justify-center rounded-full text-[9px] font-bold">C</div>
                                    <p class="text-[10px] text-gray-500">Rep. by Casidey</p>
                                </div>
                                <!-- Added onClick trigger -->
                                <button onclick="openModal(<?= $index ?>)" class="text-[10px] text-citred font-bold hover:underline">View Details</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- ========================================== -->
<!-- VIEW DETAILS MODAL                         -->
<!-- ========================================== -->
<div id="itemModal" class="fixed inset-0 bg-black/60 z-[100] hidden items-center justify-center p-4 sm:p-6 opacity-0 transition-opacity duration-300">
    <!-- Modal Content Box -->
    <div class="bg-white rounded-[1.5rem] w-full max-w-4xl overflow-hidden relative flex flex-col max-h-[90vh] shadow-2xl transform scale-95 transition-transform duration-300" id="modalContent">
        
        <!-- Top Image & Close Button -->
        <div class="relative h-64 sm:h-72 shrink-0">
            <img id="m-img" src="" class="w-full h-full object-cover">
            <span id="m-type" class="absolute top-5 left-5 text-white text-xs font-bold px-4 py-1.5 rounded-md shadow uppercase tracking-wide"></span>
            <button onclick="closeModal()" class="absolute top-5 right-5 bg-white/90 hover:bg-white w-9 h-9 rounded-full flex items-center justify-center text-gray-800 shadow transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Scrollable Details -->
        <div class="p-8 overflow-y-auto">
            <!-- Header Titles -->
            <div class="mb-8">
                <h2 id="m-title" class="text-3xl font-bold text-gray-900 mb-3">Item Title</h2>
                <div class="flex items-center gap-2">
                    <span id="m-category" class="bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded">Category</span>
                    <span id="m-status" class="text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded">Status</span>
                </div>
            </div>

            <!-- Two Column Layout: Details vs Contact -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-8">
                <!-- Left Column: Details -->
                <div>
                    <h3 class="text-xs font-bold text-gray-900 mb-4 tracking-wider uppercase">Details</h3>
                    <div class="space-y-5">
                        <div class="flex gap-4 items-start">
                            <i class="fa-solid fa-location-dot mt-0.5 text-red-400 text-lg w-5 text-center"></i>
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide mb-0.5">Location</p>
                                <p id="m-location" class="text-sm font-semibold text-gray-900">Building Name</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start">
                            <i class="fa-regular fa-calendar mt-0.5 text-red-400 text-lg w-5 text-center"></i>
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide mb-0.5">Date & Time</p>
                                <p id="m-datetime" class="text-sm font-semibold text-gray-900">Date AT Time</p>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start">
                            <i class="fa-regular fa-user mt-0.5 text-red-400 text-lg w-5 text-center"></i>
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide mb-0.5">Reported By</p>
                                <p id="m-reporter" class="text-sm font-semibold text-gray-900">Name</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Contact Info / Verification -->
                <div>
                    <h3 class="text-xs font-bold text-gray-900 mb-4 tracking-wider uppercase">Contact Info</h3>
                    
                    <!-- View 1: Lost Item (Basic None Box) -->
                    <div id="m-contact-basic" class="hidden border border-gray-200 rounded-xl p-5">
                        <p class="font-bold text-gray-900 text-base mb-1">None</p>
                        <p class="text-[10px] text-gray-500 leading-relaxed">Please contact the reporter directly to claim this item or provide information</p>
                    </div>

                    <!-- View 2: Found Item (Verification Form) -->
                    <div id="m-contact-verify" class="hidden bg-[#F4F7FB] border border-blue-100 rounded-xl p-5">
                        <div class="flex items-center gap-2 mb-2 text-blue-700">
                            <i class="fa-solid fa-shield-halved text-lg"></i>
                            <h4 class="font-bold text-sm">Proof Before Claim</h4>
                        </div>
                        <p class="text-[10px] text-blue-800/70 mb-4 leading-relaxed">The finder has set a hidden question to verify the real owner</p>
                        
                        <div class="mb-3">
                            <label class="block text-[10px] font-bold text-gray-700 uppercase mb-1">Question:</label>
                            <input id="m-question" type="text" disabled class="w-full px-3 py-2 border border-gray-200 rounded bg-white text-xs font-medium text-gray-600 mb-2">
                            <input type="text" placeholder="Your answer..." class="w-full px-3 py-2 border border-gray-300 rounded bg-white text-xs focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        </div>
                        <button onclick="submitVerification()" class="w-full bg-[#0D6EFD] hover:bg-blue-700 text-white font-semibold py-2 rounded shadow-sm text-xs transition">Submit Answer for Verification</button>
                    </div>

                    <!-- View 3: Found Item (Verification Pending State) -->
                    <div id="m-contact-pending" class="hidden bg-[#FCFDF5] border border-[#E9EDC9] rounded-xl p-8 flex flex-col items-center justify-center text-center">
                        <i class="fa-regular fa-clock text-4xl text-[#94A3B8] mb-3"></i>
                        <h4 class="font-bold text-[#65A30D] text-sm mb-2">Verification Pending</h4>
                        <p class="text-[10px] text-[#65A30D]/80 leading-relaxed">Your answer has been sent to the finder. You will be able to see their contact info once they approve it.</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Description -->
            <div>
                <h3 class="text-xs font-bold text-gray-900 mb-3 tracking-wider uppercase">Description</h3>
                <div class="border border-gray-200 rounded-lg p-4">
                    <p id="m-desc" class="text-sm text-gray-600 leading-relaxed">Description goes here.</p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Encode PHP data to Javascript so we can use it dynamically in the modal -->
<script>
    const itemsData = <?= json_encode($items) ?>;
    const modal = document.getElementById('itemModal');
    const modalContent = document.getElementById('modalContent');
    
    // View sections
    const basicView = document.getElementById('m-contact-basic');
    const verifyView = document.getElementById('m-contact-verify');
    const pendingView = document.getElementById('m-contact-pending');

    function openModal(index) {
        const data = itemsData[index];

        // Populate basic text details
        document.getElementById('m-img').src = data.img;
        document.getElementById('m-title').textContent = data.title;
        document.getElementById('m-location').textContent = data.location;
        document.getElementById('m-datetime').textContent = data.date + ' AT ' + data.time;
        document.getElementById('m-reporter').textContent = data.reporter;
        document.getElementById('m-desc').textContent = data.desc;
        
        // Populate Top-Left Badge (Lost vs Found)
        const typeBadge = document.getElementById('m-type');
        typeBadge.textContent = data.type;
        typeBadge.className = `absolute top-5 left-5 text-white text-xs font-bold px-4 py-1.5 rounded-md shadow uppercase tracking-wide ${data.type_color}`;
        
        // Populate Small Tags (Category & Status)
        document.getElementById('m-category').textContent = data.category;
        const statusBadge = document.getElementById('m-status');
        statusBadge.textContent = data.status;
        statusBadge.className = `text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded ${data.status_color}`;

        // Reset right column views
        basicView.classList.add('hidden');
        verifyView.classList.add('hidden');
        pendingView.classList.add('hidden');

        // Logic based on Lost or Found
        if (data.type === 'LOST') {
            basicView.classList.remove('hidden');
        } else if (data.type === 'FOUND') {
            document.getElementById('m-question').value = data.question;
            verifyView.classList.remove('hidden');
        }

        // Show Modal with Animation
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        // Small delay to allow display:flex to apply before animating opacity
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 10);
    }

    function closeModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        
        // Wait for animation to finish before hiding
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300); // 300ms matches the Tailwind duration-300
    }

    // Function to simulate submitting the verification
    function submitVerification() {
        verifyView.classList.add('hidden');
        pendingView.classList.remove('hidden');
    }

    // Close modal if clicking outside the box
    modal.addEventListener('click', function(e) {
        if(e.target === modal) {
            closeModal();
        }
    });
</script>

</body>
</html>