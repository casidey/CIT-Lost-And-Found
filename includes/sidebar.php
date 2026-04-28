<!-- /lost-and-found/includes/sidebar.php -->
<?php $currentPage = isset($_GET['page']) ? $_GET['page'] : 'dashboard'; ?>

<aside class="w-64 bg-citred h-screen fixed left-0 top-0 text-white flex flex-col shadow-xl z-40">
    <div class="p-6 flex flex-col items-center border-b border-red-500/30 mb-4">
        <div class="w-12 h-12 bg-white p-1 rounded-full shadow-lg mb-2 flex items-center justify-center">
            <div class="w-full h-full bg-yellow-500 rounded-full flex items-center justify-center text-white text-xl"><i class="fa-solid fa-graduation-cap"></i></div>
        </div>
        <h2 class="text-center text-xs font-bold tracking-wider leading-tight">CIT UNIVERSITY<br>LOST & FOUND</h2>
    </div>

    <nav class="flex-1 px-4 space-y-2">
        <a href="?page=dashboard" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-medium transition <?= $currentPage == 'dashboard' ? 'bg-white/20 font-semibold shadow-sm text-white' : 'text-red-100 hover:bg-white/10' ?>">
            <i class="fa-solid fa-border-all w-5"></i> Dashboard
        </a>
        <a href="?page=report" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-medium transition <?= $currentPage == 'report' ? 'bg-white/20 font-semibold shadow-sm text-white' : 'text-red-100 hover:bg-white/10' ?>">
            <i class="fa-solid fa-circle-plus w-5"></i> Report Item
        </a>
        <a href="?page=browse" class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-medium transition <?= $currentPage == 'browse' ? 'bg-white/20 font-semibold shadow-sm text-white' : 'text-red-100 hover:bg-white/10' ?>">
            <i class="fa-solid fa-magnifying-glass w-5"></i> Browse Items
        </a>
    </nav>

    <div class="p-4 border-t border-red-500/30 flex items-center gap-3 mt-auto bg-citred">
        <div class="w-8 h-8 bg-red-400 rounded-full flex items-center justify-center text-white"><i class="fa-solid fa-user"></i></div>
        <div>
            <p class="text-xs font-bold">Casidey Quibuyen</p>
            <p class="text-[10px] text-red-200">Student</p>
        </div>
    </div>
</aside>