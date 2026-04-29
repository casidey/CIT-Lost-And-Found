<?php require 'includes/header.php'; ?>

<div class="flex bg-bglight min-h-screen">

    <aside class="w-64 bg-citred h-screen fixed left-0 top-0 text-white flex flex-col shadow-xl z-40">
        <div class="p-6 flex flex-col items-center border-b border-red-500/30 mb-4">
            <div class="w-12 h-12 bg-white p-1 rounded-full shadow-lg mb-2 flex items-center justify-center">
                <div class="w-full h-full bg-yellow-500 rounded-full flex items-center justify-center text-white text-xl"><i class="fa-solid fa-graduation-cap"></i></div>
            </div>
            <h2 class="text-center text-xs font-bold tracking-wider leading-tight">CIT UNIVERSITY<br>LOST & FOUND</h2>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="?page=guest" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-semibold bg-white/20 shadow-sm text-white transition"><i class="fa-solid fa-border-all w-5"></i> Dashboard</a>
            <a href="?page=browse" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-medium text-red-100 hover:bg-white/10 transition"><i class="fa-solid fa-magnifying-glass w-5"></i> Browse Items</a>
        </nav>
        <div class="p-4 border-t border-red-500/30 flex items-center gap-3 mt-auto bg-citred">
            <div class="w-8 h-8 bg-red-400 rounded-full flex items-center justify-center text-white"><i class="fa-solid fa-user"></i></div>
            <div>
                <p class="text-xs font-bold">Guest User</p>
                <p class="text-[10px] text-red-200">Guest</p>
            </div>
        </div>
    </aside>

    <div class="flex-1 ml-64 flex flex-col h-screen">
        <header class="bg-white shadow-sm h-16 flex justify-between items-center px-8 border-b border-gray-100 shrink-0">
            <h1 class="text-xl font-bold text-gray-800">Guest Dashboard</h1>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-800">Guest User <span class="bg-citred text-white w-7 h-7 inline-flex justify-center items-center rounded-full ml-1 text-xs">G</span></p>
                    <p class="text-[10px] text-gray-400">Guest</p>
                </div>
                <a href="?page=landing" class="text-xs text-gray-500 font-semibold hover:text-citred border-l border-gray-200 pl-4 ml-2"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</a>
            </div>
        </header>

        <main class="p-8 max-w-5xl w-full mx-auto overflow-y-auto">

            <div class="bg-[#EEF2F6] border border-[#E2E8F0] text-[#334155] p-4 rounded-xl flex gap-3 items-start mb-6">
                <i class="fa-solid fa-circle-exclamation text-[#64748B] mt-0.5 text-lg"></i>
                <div>
                    <h4 class="font-bold text-sm text-[#1E293B]">Welcome, Teknoys!</h4>
                    <p class="text-xs mt-1 leading-relaxed text-gray-600">You are viewing the CIT Lost & Found system as a guest. You can browse found items, but you cannot report items or claim them online. Please log in with your student or faculty account for full access.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white p-10 rounded-xl shadow-sm border border-gray-100 text-center flex flex-col items-center justify-center transition hover:shadow-md">
                    <div class="w-16 h-16 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-3xl mb-5 border border-green-100"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800">Browse Found Items</h3>
                    <p class="text-xs text-gray-500 mb-8 leading-relaxed">Check if your lost item has been found<br>and turned in to the office.</p>
                    <a href="?page=browse" class="bg-[#7A0000] hover:bg-red-900 text-white text-xs font-bold py-3 px-8 rounded-lg shadow transition">View Found Items &rarr;</a>
                </div>


                <div class="bg-white p-10 rounded-xl shadow-sm border border-gray-100 flex flex-col transition hover:shadow-md">
                    <h3 class="font-bold text-lg mb-8 text-center text-gray-800">System Statistics</h3>
                    <div class="flex justify-around items-center flex-1">
                        <div class="text-center">
                            <div class="w-14 h-14 bg-red-50 text-red-400 rounded-full flex items-center justify-center text-2xl mx-auto mb-3 border border-red-100"><i class="fa-solid fa-magnifying-glass"></i></div>
                            <p class="text-4xl font-black text-gray-800">1</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">Active Reports</p>
                        </div>
                        <div class="text-center">
                            <div class="w-14 h-14 bg-green-50 text-green-500 rounded-full flex items-center justify-center text-2xl mx-auto mb-3 border border-green-100"><i class="fa-solid fa-circle-check"></i></div>
                            <p class="text-4xl font-black text-gray-800">3</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">Total Returned</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>