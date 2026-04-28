<?php require 'includes/header.php'; ?>

<!-- Navbar -->
<nav class="bg-white shadow-sm py-4 px-8 flex justify-between items-center w-full fixed top-0 z-50">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center text-white font-bold"><i class="fa-solid fa-graduation-cap"></i></div>
        <span class="font-bold text-sm leading-tight">CIT UNIVERSITY<br>LOST & FOUND</span>
    </div>
    <div class="hidden md:flex gap-6 text-sm font-semibold text-gray-600">
        <a href="#" class="hover:text-citred">HOME</a>
        <a href="#" class="hover:text-citred">HOW IT WORKS</a>
        <a href="#" class="hover:text-citred">FEATURES</a>
    </div>
    <a href="?page=login" class="bg-citred hover:bg-citdarkred text-white text-sm font-semibold py-2 px-6 rounded shadow">LOG IN</a>
</nav>

<!-- Hero Section -->
<main class="mt-24 max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center min-h-[70vh]">
    <div>
        <span class="bg-red-100 text-citred text-xs font-bold px-2 py-1 rounded mb-4 inline-block tracking-wide uppercase">← CIT Lost & Found</span>
        <h1 class="text-5xl font-black text-gray-900 leading-tight mb-4">LOST AND FOUND FOR <span class="text-citred">CIT UNIVERSITY</span></h1>
        <p class="text-gray-500 text-sm mb-8 leading-relaxed max-w-md">Our University Lost and Found System is a centralized web-based platform designed to help students and staff easily report, search, and recover lost belongings within the campus.</p>
        <div class="flex gap-4">
            <a href="?page=login" class="bg-citred hover:bg-citdarkred text-white text-sm font-bold py-3 px-6 rounded shadow flex items-center gap-2">GET STARTED <i class="fa-solid fa-arrow-right"></i></a>
            <a href="#" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-bold py-3 px-6 rounded shadow-sm">LEARN MORE</a>
        </div>
    </div>
    <div class="relative">
        <div class="absolute inset-0 bg-blue-50 rounded-3xl transform rotate-3 scale-105 -z-10"></div>
        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=800" alt="Students" class="rounded-3xl shadow-xl object-cover h-[400px] w-full">
    </div>
</main>

<?php 
// Dynamic Data for Features
$features = [['icon' => 'fa-shield-halved', 'title' => 'SECURE AND VERIFIED SYSTEM', 'desc' => 'Only registered university students and staff can access the system, reducing false reports.'],['icon' => 'fa-bolt', 'title' => 'FAST AND ORGANIZED PROCESS', 'desc' => 'All reports are stored in one centralized database, making it easier to search.'],['icon' => 'fa-check-circle', 'title' => 'HIGHER CHANCE OF RECOVERY', 'desc' => 'With detailed reporting and image uploads, items have a greater chance of being returned.']
];
?>

<!-- Features Section -->
<section class="max-w-6xl mx-auto px-6 py-16 text-center">
    <p class="text-citred text-xs font-bold uppercase tracking-widest mb-2">Why Use Lost & Found</p>
    <h2 class="text-3xl font-bold mb-10">A Smarter Way to Find What's Lost</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php foreach($features as $feature): ?>
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-left">
            <div class="w-10 h-10 bg-red-50 text-citred flex items-center justify-center rounded-lg mb-4 text-xl"><i class="fa-solid <?= $feature['icon'] ?>"></i></div>
            <h3 class="font-bold text-sm mb-2"><?= $feature['title'] ?></h3>
            <p class="text-gray-500 text-xs leading-relaxed"><?= $feature['desc'] ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>

</body>
</html>