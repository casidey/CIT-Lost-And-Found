<?php require 'includes/header.php'; ?>

<div class="flex bg-bglight min-h-screen">
    <?php require 'includes/sidebar.php'; ?>

    <div class="flex-1 ml-64 flex flex-col h-screen">
        <!-- Header code remains the same... -->
        <header class="bg-white shadow-sm h-16 flex justify-between items-center px-8 border-b border-gray-100 shrink-0">
            <h1 class="text-lg font-bold text-gray-800">Faculty Dashboard</h1>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-800">Froilan Cando <span class="bg-citred text-white w-6 h-6 inline-flex justify-center items-center rounded-full ml-1 text-xs">F</span></p>
                </div>
                <a href="?page=landing" class="text-xs text-gray-500 font-semibold hover:text-citred"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</a>
            </div>
        </header>

        <main class="p-8 max-w-4xl w-full mx-auto overflow-y-auto">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Report an Item</h2>
                <p class="text-sm text-gray-500">Submit details about a lost or found item.</p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <form class="space-y-5" action="#" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="report_type" id="report_type" value="lost">

                    <!-- Updated Buttons with subtitles -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <button type="button" id="btn-lost" class="bg-red-50 border-2 border-citred text-citred py-3 rounded-lg flex flex-col items-center justify-center transition duration-200">
                            <p class="font-bold text-sm">I lost something</p>
                            <p class="text-[10px] mt-0.5 opacity-80 font-medium">Report a missing item</p>
                        </button>
                        <button type="button" id="btn-found" class="bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 py-3 rounded-lg flex flex-col items-center justify-center transition duration-200">
                            <p class="font-bold text-sm">I Found something</p>
                            <p class="text-[10px] mt-0.5 opacity-80 font-medium">Report a found item</p>
                        </button>
                    </div>

                    <!-- Inputs with Icons inside -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Item Name</label>
                            <div class="relative">
                                <i class="fa-solid fa-t absolute left-3.5 top-2.5 text-gray-400 text-sm"></i>
                                <input type="text" placeholder="e.g., Blue AquaFlask" class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-citred">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Category</label>
                            <div class="relative">
                                <i class="fa-solid fa-tag absolute left-3.5 top-2.5 text-gray-400 text-sm"></i>
                                <select class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-citred text-gray-600 appearance-none">
                                    <option>Electronics</option>
                                    <option>Personal Items</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Date</label>
                            <div class="relative">
                                <i class="fa-regular fa-calendar absolute left-3.5 top-2.5 text-gray-400 text-sm"></i>
                                <input type="date" class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-citred text-gray-600">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Time</label>
                            <div class="relative">
                                <i class="fa-regular fa-clock absolute left-3.5 top-2.5 text-gray-400 text-sm"></i>
                                <input type="time" class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-citred text-gray-600">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Description</label>
                        <div class="relative">
                            <i class="fa-regular fa-file-lines absolute left-3.5 top-3 text-gray-400 text-sm"></i>
                            <textarea rows="3" placeholder="Provide detailed description (color, brand and more)..." class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-citred"></textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Contact Info (Optional)</label>
                        <input type="text" placeholder="Phone number or alternative email" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-citred">
                    </div>

                    <!-- NEW: Proof Before Claim Section -->
                    <div class="mt-6 border-t border-gray-100 pt-5">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-shield-halved text-citred"></i>
                            <h4 class="font-bold text-sm text-gray-800">Proof Before Claim</h4>
                        </div>
                        <p class="text-[10px] text-gray-400 mb-4">Set a hidden question that only the real owner would know to prevent fake claims.</p>
                        
                        <div class="bg-blue-50/40 p-4 rounded-lg border border-blue-100 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase mb-1">Verification Question</label>
                                <input type="text" placeholder="e.g., What color is the wallet" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-citred bg-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-600 uppercase mb-1">Secret Answer</label>
                                <input type="text" placeholder="e.g., Yellow" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-citred bg-white">
                            </div>
                        </div>
                    </div>

                    <!-- Image Upload (Keep from previous updates) -->
                    <div class="mt-4">
                        <label for="item-image" class="block border-2 border-dashed border-gray-300 rounded-lg p-6 text-center bg-gray-50 hover:bg-gray-100 transition cursor-pointer">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-2"><i class="fa-solid fa-arrow-up text-gray-500"></i></div>
                            <p id="upload-text" class="text-xs font-bold text-gray-800">Click to upload image</p>
                            <p class="text-[10px] text-gray-400 mt-1">PNG, JPEG up to 5MB</p>
                            <input type="file" id="item-image" class="hidden">
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" class="px-5 py-2 text-sm font-bold text-gray-500 hover:text-gray-700">Cancel</button>
                        <button type="submit" class="px-6 py-2 bg-citred hover:bg-citdarkred text-white text-sm font-bold rounded shadow-sm transition">Submit Report</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
    // Exact same JS as before for Tabs!
    const btnLost = document.getElementById('btn-lost');
    const btnFound = document.getElementById('btn-found');
    const reportType = document.getElementById('report_type');

    const activeLostClasses =['bg-red-50', 'border-2', 'border-citred', 'text-citred'];
    const activeFoundClasses =['bg-green-50', 'border-2', 'border-green-500', 'text-green-800'];
    const inactiveClasses =['bg-white', 'border', 'border-gray-200', 'text-gray-500', 'hover:bg-gray-50'];

    btnLost.addEventListener('click', () => {
        reportType.value = 'lost';
        btnLost.classList.remove(...inactiveClasses); btnLost.classList.add(...activeLostClasses);
        btnFound.classList.remove(...activeFoundClasses); btnFound.classList.add(...inactiveClasses);
    });

    btnFound.addEventListener('click', () => {
        reportType.value = 'found';
        btnFound.classList.remove(...inactiveClasses); btnFound.classList.add(...activeFoundClasses);
        btnLost.classList.remove(...activeLostClasses); btnLost.classList.add(...inactiveClasses);
    });
</script>
</body>
</html>