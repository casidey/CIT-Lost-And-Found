<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/db.php';

// ── Fetch all reports (public, no login needed) ─────────────────────────────
$items = [];
try {
    $stmt = $pdo->query("
        SELECT r.*, u.fullname AS reporter_name
        FROM tblreports r
        JOIN tblusers u ON r.user_id = u.id
        ORDER BY r.created_at DESC
    ");
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) { $items = []; }

$js_items = [];
foreach ($items as $item) {
    $type        = strtoupper($item['type']);
    $is_lost     = $type === 'LOST';
    $is_resolved = strtolower($item['status']) === 'resolved';

    $img_src = 'https://placehold.co/800x400/f3f4f6/9ca3af?text=No+Image';
    if (!empty($item['image'])) $img_src = 'uploads/reports/' . htmlspecialchars($item['image']);

    $js_items[] = [
        'id'           => (int)$item['id'],
        'type'         => $type,
        'type_color'   => $is_lost ? 'bg-red-500' : 'bg-green-500',
        'title'        => $item['title'],
        'category'     => strtoupper($item['category']),
        'date'         => date('n/j/Y', strtotime($item['created_at'])),
        'time'         => !empty($item['time_lost_found']) ? date('g:i A', strtotime($item['time_lost_found'])) : 'N/A',
        'location'     => $item['location'],
        'status'       => $is_resolved ? 'RESOLVED' : 'PENDING',
        'status_color' => $is_resolved ? 'text-blue-600 bg-blue-100' : 'text-yellow-600 bg-yellow-100',
        'img'          => $img_src,
        'reporter'     => $item['reporter_name'],
        'desc'         => $item['description'],
        'contact_info' => $item['contact_info'] ?? '',
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Items – CIT Lost & Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { citred: '#DC2626', citdarkred: '#b91c1c', bglight: '#F8FAFC' } } }
        }
    </script>
</head>
<body class="bg-bglight">
<div class="flex bg-bglight min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-citred h-screen fixed left-0 top-0 text-white flex flex-col shadow-xl z-40">
        <div class="p-6 flex flex-col items-center border-b border-red-500/30 mb-4">
            <div class="w-14 h-14 bg-white rounded-full shadow-lg mb-3 flex items-center justify-center p-1">
                <img src="images/cit-logo.png" alt="CIT Logo" class="w-full h-full object-contain">
            </div>
            <h2 class="text-center text-xs font-bold tracking-wider leading-tight">CIT UNIVERSITY<br>LOST &amp; FOUND</h2>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="index.php?page=guest-dashboard"
               class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-medium text-red-100 hover:bg-white/10 transition">
                <i class="fa-solid fa-border-all w-5"></i> Dashboard
            </a>
            <a href="index.php?page=guest-browse"
               class="flex items-center gap-3 px-4 py-2.5 rounded text-sm font-semibold bg-white/20 shadow-sm text-white transition">
                <i class="fa-solid fa-magnifying-glass w-5"></i> Browse Items
            </a>
        </nav>
        <div class="p-4 border-t border-red-500/30 flex items-center gap-3 mt-auto">
            <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center text-white border border-white/20">
                <i class="fa-solid fa-user text-sm"></i>
            </div>
            <div>
                <p class="text-xs font-bold">Guest User</p>
                <p class="text-[10px] text-red-200">Guest</p>
            </div>
        </div>
    </aside>

    <div class="flex-1 ml-64 flex flex-col h-screen">

        <!-- Header -->
        <header class="bg-white shadow-sm h-16 flex justify-between items-center px-8 border-b border-gray-100 shrink-0">
            <h1 class="text-xl font-bold text-gray-800">Browse Items</h1>
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-800">
                        Guest User
                        <span class="bg-citred text-white w-7 h-7 inline-flex justify-center items-center rounded-full ml-1 text-xs">G</span>
                    </p>
                    <p class="text-[10px] text-gray-400">Guest</p>
                </div>
                <a href="index.php?page=landing" class="text-xs text-gray-500 font-semibold hover:text-citred border-l border-gray-200 pl-4 ml-2">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Exit
                </a>
            </div>
        </header>

        <main class="p-8 w-full max-w-screen-2xl mx-auto overflow-y-auto">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 min-h-[calc(100vh-8rem)]">

                <!-- Guest notice -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex gap-3 items-start mb-8">
                    <i class="fa-solid fa-lock text-amber-500 mt-0.5"></i>
                    <p class="text-xs text-amber-800 font-medium leading-relaxed">
                        You are browsing as a guest. You can view item details, but claiming items requires a
                        <a href="index.php?page=login" class="font-bold underline hover:text-amber-900">student or faculty account</a>.
                    </p>
                </div>

                <!-- Search & Filter -->
                <div class="flex flex-col md:flex-row justify-between md:items-center gap-6 mb-10">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-1">Browse Items</h2>
                        <p class="text-[15px] text-gray-500">Find lost items or see what's been found.</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-gray-400 text-sm"></i>
                            <input type="text" id="searchInput" placeholder="Search items..."
                                   class="pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-citred w-72 transition-all">
                        </div>
                        <div class="flex bg-gray-100 rounded-xl p-1.5 shadow-inner">
                            <button data-filter="ALL"   class="filter-btn bg-white text-gray-900 text-[13px] font-bold px-5 py-2 rounded-lg shadow-sm transition-all">All</button>
                            <button data-filter="LOST"  class="filter-btn text-gray-500 hover:text-gray-900 text-[13px] font-bold px-5 py-2 rounded-lg transition-all">Lost</button>
                            <button data-filter="FOUND" class="filter-btn text-gray-500 hover:text-gray-900 text-[13px] font-bold px-5 py-2 rounded-lg transition-all">Found</button>
                        </div>
                    </div>
                </div>

                <?php if (empty($items)): ?>
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-box-open text-2xl text-gray-300"></i>
                    </div>
                    <p class="text-[15px] font-bold text-gray-400 mb-1">No items reported yet</p>
                    <p class="text-[13px] text-gray-400">Check back later or log in to report an item.</p>
                </div>
                <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="itemsGrid">
                    <?php foreach ($js_items as $index => $item): ?>
                    <div class="item-card bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col group cursor-pointer"
                         data-type="<?= $item['type'] ?>"
                         data-title="<?= strtolower(htmlspecialchars($item['title'])) ?>"
                         onclick="openModal(<?= $index ?>)">
                        <div class="relative h-48 bg-gray-50 overflow-hidden">
                            <div class="absolute top-3 left-3 <?= $item['type_color'] ?> text-white text-[10px] font-bold px-3 py-1 rounded shadow-sm z-10 uppercase tracking-widest">
                                <?= $item['type'] ?>
                            </div>
                            <img src="<?= $item['img'] ?>" alt="<?= htmlspecialchars($item['title']) ?>"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 onerror="this.src='https://placehold.co/800x400/f3f4f6/9ca3af?text=No+Image'">
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-gray-900 text-[15px] mb-1 group-hover:text-citred transition-colors">
                                <?= htmlspecialchars($item['title']) ?>
                            </h3>
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg w-max <?= $item['status_color'] ?> uppercase tracking-wider mb-3">
                                <?= $item['status'] ?>
                            </span>
                            <p class="text-[12px] text-gray-400 font-medium mb-1">
                                <i class="fa-regular fa-calendar mr-1"></i><?= $item['date'] ?>
                            </p>
                            <p class="text-[12px] text-gray-400 font-medium mb-4">
                                <i class="fa-solid fa-location-dot mr-1"></i><?= htmlspecialchars($item['location']) ?>
                            </p>
                            <div class="mt-auto pt-3 border-t border-gray-50 flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-citred text-white flex items-center justify-center rounded-full text-[10px] font-bold">
                                        <?= strtoupper(mb_substr($item['reporter'], 0, 1)) ?>
                                    </div>
                                    <p class="text-[11px] text-gray-500 font-medium">
                                        Rep. by <?= htmlspecialchars(explode(' ', $item['reporter'])[0]) ?>
                                    </p>
                                </div>
                                <button class="text-[12px] text-citred font-bold hover:underline">View Details</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div id="noResults" class="hidden flex-col items-center justify-center py-16 text-center">
                    <i class="fa-solid fa-magnifying-glass text-3xl text-gray-200 mb-4"></i>
                    <p class="text-[15px] font-bold text-gray-400">No items match your search.</p>
                </div>
                <?php endif; ?>

            </div>
        </main>
    </div>
</div>

<!-- MODAL — view only, no claim form -->
<div id="itemModal" class="fixed inset-0 bg-black/60 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-4xl rounded-2xl overflow-hidden shadow-2xl relative flex flex-col max-h-[90vh]">
        <button onclick="closeModal()" class="absolute top-4 right-4 z-20 w-8 h-8 bg-white text-gray-600 hover:text-gray-900 rounded-full flex items-center justify-center shadow-md transition-all">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>

        <div class="relative h-64 bg-gray-100 shrink-0">
            <div id="modalTypeBadge" class="absolute top-4 left-4 text-white text-[10px] font-bold px-3 py-1.5 rounded shadow-sm z-10 uppercase tracking-widest"></div>
            <img id="modalImg" src="" alt="Item Image" class="w-full h-full object-cover"
                 onerror="this.src='https://placehold.co/800x400/f3f4f6/9ca3af?text=No+Image'">
        </div>

        <div class="p-8 overflow-y-auto">
            <div class="mb-6">
                <h2 id="modalTitle" class="text-2xl font-bold text-gray-900 mb-2"></h2>
                <div class="flex items-center gap-2">
                    <span id="modalCategory" class="text-[10px] font-bold px-2.5 py-1 rounded bg-gray-100 text-gray-600 uppercase tracking-wider"></span>
                    <span id="modalStatus"   class="text-[10px] font-bold px-2.5 py-1 rounded uppercase tracking-wider"></span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Details -->
                <div>
                    <h3 class="text-[12px] font-bold text-gray-800 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Details</h3>
                    <div class="space-y-5">
                        <div class="flex gap-4">
                            <i class="fa-solid fa-location-dot text-citred mt-1"></i>
                            <div><p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Location</p><p id="modalLocation" class="text-sm font-bold text-gray-900"></p></div>
                        </div>
                        <div class="flex gap-4">
                            <i class="fa-regular fa-calendar text-citred mt-1"></i>
                            <div><p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Date & Time</p><p id="modalDateTime" class="text-sm font-bold text-gray-900"></p></div>
                        </div>
                        <div class="flex gap-4">
                            <i class="fa-regular fa-user text-citred mt-1"></i>
                            <div><p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Reported By</p><p id="modalReporter" class="text-sm font-bold text-gray-900"></p></div>
                        </div>
                    </div>
                </div>

                <!-- Guest lock notice instead of claim form -->
                <div>
                    <h3 class="text-[12px] font-bold text-gray-800 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Claim This Item</h3>
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 flex flex-col items-center text-center gap-3">
                        <i class="fa-solid fa-lock text-amber-400 text-2xl"></i>
                        <p class="font-bold text-amber-800 text-sm">Login Required</p>
                        <p class="text-[11px] text-amber-700 leading-relaxed">You need a student or faculty account to claim items.</p>
                        <a href="index.php?page=login"
                           class="bg-citred hover:bg-citdarkred text-white font-bold text-xs px-5 py-2 rounded-lg transition shadow-sm">
                            Log In to Claim
                        </a>
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
const itemsData = <?= json_encode(array_values($js_items)) ?>;
const itemModal = document.getElementById('itemModal');

// Filter
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('bg-white','text-gray-900','shadow-sm');
            b.classList.add('text-gray-500');
        });
        btn.classList.add('bg-white','text-gray-900','shadow-sm');
        btn.classList.remove('text-gray-500');
        filterCards();
    });
});
document.getElementById('searchInput').addEventListener('input', filterCards);

function filterCards() {
    const filter = document.querySelector('.filter-btn.bg-white')?.getAttribute('data-filter') || 'ALL';
    const search = document.getElementById('searchInput').value.toLowerCase();
    let visible  = 0;
    document.querySelectorAll('.item-card').forEach(card => {
        const ok = (filter === 'ALL' || card.getAttribute('data-type') === filter)
                && card.getAttribute('data-title').includes(search);
        card.classList.toggle('hidden', !ok);
        if (ok) visible++;
    });
    const nr = document.getElementById('noResults');
    if (nr) { nr.classList.toggle('hidden', visible > 0); nr.classList.toggle('flex', visible === 0); }
}

// Modal
function openModal(index) {
    const item = itemsData[index];
    document.getElementById('modalImg').src              = item.img;
    document.getElementById('modalTitle').textContent    = item.title;
    document.getElementById('modalCategory').textContent = item.category;
    document.getElementById('modalLocation').textContent = item.location;
    document.getElementById('modalDateTime').textContent = `${item.date} AT ${item.time}`;
    document.getElementById('modalReporter').textContent = item.reporter;
    document.getElementById('modalDesc').textContent     = item.desc;

    const typeBadge = document.getElementById('modalTypeBadge');
    typeBadge.textContent = item.type;
    typeBadge.className   = `absolute top-4 left-4 text-white text-[10px] font-bold px-3 py-1.5 rounded shadow-sm z-10 uppercase tracking-widest ${item.type_color}`;

    const statusBadge = document.getElementById('modalStatus');
    statusBadge.textContent = item.status;
    statusBadge.className   = `text-[10px] font-bold px-2.5 py-1 rounded uppercase tracking-wider ${item.status_color}`;

    itemModal.classList.remove('hidden');
}

function closeModal() { itemModal.classList.add('hidden'); }
itemModal.addEventListener('click', e => { if (e.target === itemModal) closeModal(); });
</script>
</body>
</html>