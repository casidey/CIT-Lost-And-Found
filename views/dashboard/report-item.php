<?php 
$active_page = 'report'; 
// require 'includes/header.php'; // Commented out for testing standalone
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Item</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        citred: '#DC2626', 
                        citdarkred: '#B91C1C', // Added for the button hover effect
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
            <a href="?page=dashboard" class="flex items-center gap-4 px-4 py-3.5 rounded-lg font-bold text-[15px] transition-all <?= ($active_page == 'dashboard') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' ?>">
                <i class="fa-solid fa-table-cells-large w-5 text-center"></i>
                Dashboard
            </a>
            <a href="?page=report" class="flex items-center gap-4 px-4 py-3.5 rounded-lg font-bold text-[15px] transition-all <?= ($active_page == 'report') ? 'bg-white/20 text-white shadow-sm' : 'text-white/70 hover:bg-white/10 hover:text-white' ?>">
                <i class="fa-solid fa-circle-plus w-5 text-center"></i>
                Report Item
            </a>
            <a href="?page=browse" class="flex items-center gap-4 px-4 py-3.5 rounded-lg font-bold text-[15px] transition-all <?= ($active_page == 'browse') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' ?>">
                <i class="fa-solid fa-magnifying-glass w-5 text-center"></i>
                Browse Items
            </a>
        </nav>

        <div class="mt-auto p-6 border-t border-white/10 bg-black/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white font-bold border border-white/10">Q</div>
                <div class="text-white">
                    <p class="text-[13px] font-bold">Casidey Quibuyen</p>
                    <p class="text-[11px] opacity-60">Student</p>
                </div>
            </div>
        </div>
    </aside>

    <div class="flex-1 ml-64 flex flex-col h-screen">
        
        <header class="bg-white shadow-sm h-16 flex justify-between items-center px-8 border-b border-gray-100 shrink-0 z-10">
            <h1 class="text-xl font-bold text-gray-800">Report Item</h1>
            
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

        <!-- Changed width to max-w-screen-2xl to perfectly match the Dashboard and Browse items wide layout -->
        <main class="p-8 w-full max-w-screen-2xl mx-auto overflow-y-auto flex-1 flex flex-col">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Report an Item</h2>
                <p class="text-[15px] text-gray-500">Submit details about a lost or found item.</p>
            </div>

            <div class="bg-white p-10 rounded-2xl shadow-sm border border-gray-100 flex-1">
                <form class="space-y-6" action="#" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="report_type" id="report_type" value="lost">

                    <div class="grid grid-cols-2 gap-5 mb-10">
                        <button type="button" id="btn-lost" class="bg-red-50 border-2 border-citred text-citred py-4 rounded-xl flex flex-col items-center justify-center transition-all shadow-sm">
                            <p class="font-bold text-[15px]">I lost something</p>
                            <p class="text-[11px] mt-0.5 opacity-80 font-medium tracking-wide">Report a missing item</p>
                        </button>
                        <button type="button" id="btn-found" class="bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 py-4 rounded-xl flex flex-col items-center justify-center transition-all">
                            <p class="font-bold text-[15px]">I Found something</p>
                            <p class="text-[11px] mt-0.5 opacity-80 font-medium tracking-wide">Report a found item</p>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[12px] font-bold text-gray-600 uppercase mb-2 tracking-wider">Item Name</label>
                            <div class="relative">
                                <i class="fa-solid fa-t absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                                <input type="text" placeholder="e.g., Blue AquaFlask" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-[15px] font-medium focus:outline-none focus:ring-2 focus:ring-citred/20 focus:border-citred transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-gray-600 uppercase mb-2 tracking-wider">Category</label>
                            <div class="relative">
                                <i class="fa-solid fa-tag absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                                <select class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-[15px] font-medium focus:outline-none focus:ring-2 focus:ring-citred/20 focus:border-citred text-gray-600 appearance-none bg-white transition-all">
                                    <option>Electronics</option>
                                    <option>Personal Items</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-gray-600 uppercase mb-2 tracking-wider">Date</label>
                            <div class="relative">
                                <i class="fa-regular fa-calendar absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                                <input type="date" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-[15px] font-medium focus:outline-none focus:ring-2 focus:ring-citred/20 focus:border-citred text-gray-600 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[12px] font-bold text-gray-600 uppercase mb-2 tracking-wider">Time</label>
                            <div class="relative">
                                <i class="fa-regular fa-clock absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                                <input type="time" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-[15px] font-medium focus:outline-none focus:ring-2 focus:ring-citred/20 focus:border-citred text-gray-600 transition-all">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[12px] font-bold text-gray-600 uppercase mb-2 tracking-wider">Location</label>
                        <div class="relative">
                            <i class="fa-solid fa-location-dot absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                            <input type="text" placeholder="e.g., Library 2nd Floor" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-[15px] font-medium focus:outline-none focus:ring-2 focus:ring-citred/20 focus:border-citred transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[12px] font-bold text-gray-600 uppercase mb-2 tracking-wider">Description</label>
                        <div class="relative">
                            <i class="fa-regular fa-file-lines absolute left-4 top-4 text-gray-400 text-sm"></i>
                            <textarea rows="3" placeholder="Provide detailed description (color, brand and more)..." class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-[15px] font-medium focus:outline-none focus:ring-2 focus:ring-citred/20 focus:border-citred transition-all"></textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[12px] font-bold text-gray-600 uppercase mb-2 tracking-wider">Contact Info (Optional)</label>
                        <input type="text" placeholder="Phone number or alternative email" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-[15px] font-medium focus:outline-none focus:ring-2 focus:ring-citred/20 focus:border-citred transition-all">
                    </div>

                    <div id="proof-section" class="hidden mt-8 border-t border-gray-100 pt-6">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid fa-shield-halved text-citred"></i>
                            <h4 class="font-bold text-[15px] text-gray-800">Proof Before Claim</h4>
                        </div>
                        <p class="text-[12px] text-gray-400 mb-5">Set a hidden question that only the real owner would know to prevent fake claims.</p>
                        
                        <div class="bg-blue-50/40 p-6 rounded-xl border border-blue-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase mb-1.5">Verification Question</label>
                                <input type="text" placeholder="e.g., What color is the wallet" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-medium outline-none focus:border-citred bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase mb-1.5">Secret Answer</label>
                                <input type="text" placeholder="e.g., Yellow" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm font-medium outline-none focus:border-citred bg-white transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="item-image" class="relative block border-2 border-dashed border-gray-200 rounded-2xl h-48 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition cursor-pointer overflow-hidden group">
                            <img id="image-preview" src="#" alt="Preview" class="hidden absolute inset-0 w-full h-full object-contain bg-white z-10 p-2">
                            <div id="placeholder-content" class="text-center">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm group-hover:scale-110 transition">
                                    <i class="fa-solid fa-arrow-up text-gray-400"></i>
                                </div>
                                <p class="text-[14px] font-bold text-gray-800">Click to upload image</p>
                                <p class="text-[11px] text-gray-400 mt-1 uppercase tracking-wide">PNG, JPEG up to 5MB</p>
                            </div>
                            <input type="file" id="item-image" accept="image/*" class="hidden">
                        </label>
                        <p id="remove-img" class="hidden text-right text-[12px] text-citred font-bold mt-2 cursor-pointer hover:underline">Remove image</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-50">
                        <button type="button" class="px-6 py-3 text-[15px] font-bold text-gray-500 hover:text-gray-800 transition">Cancel</button>
                        <button type="submit" class="px-8 py-3 bg-citred hover:bg-citdarkred text-white text-[15px] font-bold rounded-xl shadow-lg shadow-red-200 transition transform active:scale-95">Submit Report</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
    const btnLost = document.getElementById('btn-lost');
    const btnFound = document.getElementById('btn-found');
    const reportType = document.getElementById('report_type');
    const proofSection = document.getElementById('proof-section');

    const activeLostClasses =['bg-red-50', 'border-2', 'border-citred', 'text-citred'];
    const activeFoundClasses =['bg-green-50', 'border-2', 'border-green-500', 'text-green-800'];
    const inactiveClasses =['bg-white', 'border', 'border-gray-200', 'text-gray-500', 'hover:bg-gray-50'];

    btnLost.addEventListener('click', () => {
        reportType.value = 'lost';
        btnLost.classList.remove(...inactiveClasses); btnLost.classList.add(...activeLostClasses);
        btnFound.classList.remove(...activeFoundClasses); btnFound.classList.add(...inactiveClasses);
        proofSection.classList.add('hidden');
    });

    btnFound.addEventListener('click', () => {
        reportType.value = 'found';
        btnFound.classList.remove(...inactiveClasses); btnFound.classList.add(...activeFoundClasses);
        btnLost.classList.remove(...activeLostClasses); btnLost.classList.add(...inactiveClasses);
        proofSection.classList.remove('hidden');
    });

    const itemImageInput = document.getElementById('item-image');
    const imagePreview = document.getElementById('image-preview');
    const placeholderContent = document.getElementById('placeholder-content');
    const removeImgBtn = document.getElementById('remove-img');

    itemImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                placeholderContent.classList.add('hidden');
                removeImgBtn.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    removeImgBtn.addEventListener('click', () => {
        itemImageInput.value = "";
        imagePreview.src = "#";
        imagePreview.classList.add('hidden');
        placeholderContent.classList.remove('hidden');
        removeImgBtn.classList.add('hidden');
    });
</script>
</body>
</html>