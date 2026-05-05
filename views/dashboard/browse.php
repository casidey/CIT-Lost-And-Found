<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit();
}

require_once __DIR__ . '/../../config/db.php';

$active_page = 'browse';

$stmt = $pdo->prepare("SELECT * FROM tblusers WHERE id = ? LIMIT 1");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) { session_destroy(); header("Location: index.php?page=login"); exit(); }

$full_name     = htmlspecialchars($user['fullname']);
$role          = htmlspecialchars($user['role']);
$user_id       = (int)$_SESSION['user_id'];
$avatar_letter = strtoupper(mb_substr($full_name, 0, 1));


// Fetch all reports
$items = [];
try {
    $stmt2 = $pdo->query("SELECT r.*, u.fullname AS reporter_name FROM tblreports r JOIN tblusers u ON r.user_id = u.id ORDER BY r.created_at DESC");
    $items = $stmt2->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) { $items = []; }

// Claims already submitted by this user
$my_claims = [];
try {
    $sc = $pdo->prepare("SELECT report_id, status FROM tblverification_requests WHERE claimant_id = ?");
    $sc->execute([$user_id]);
    foreach ($sc->fetchAll() as $c) $my_claims[$c['report_id']] = $c['status'];
} catch (Exception $e) {}

// Build JS array
$js_items = [];
foreach ($items as $item) {
    $type        = strtoupper($item['type']);
    $is_lost     = $type === 'LOST';
    $is_resolved = strtolower($item['status']) === 'resolved';
    $rid         = (int)$item['id'];

    $img_src = 'https://placehold.co/800x400/f3f4f6/9ca3af?text=No+Image';
    if (!empty($item['image'])) $img_src = 'uploads/reports/' . htmlspecialchars($item['image']);

    $js_items[] = [
        'id'           => $rid,
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
        'reporter_id'  => (int)$item['user_id'],
        'desc'         => $item['description'],
        'contact_info' => $item['contact_info'] ?? '',
        'question'     => $item['verification_question'] ?? '',
        'is_own'       => ((int)$item['user_id'] === $user_id),
        'is_resolved'  => $is_resolved,
        'claim_status' => $my_claims[$rid] ?? null,
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
        tailwind.config = { theme: { extend: { colors: { citred: '#DC2626', citdarkred: '#b91c1c' } } } }
    </script>
</head>
<body>
<div class="flex bg-[#F8FAFC] min-h-screen">

    <aside class="w-64 bg-citred fixed h-full flex flex-col z-20 shadow-xl">
        <div class="p-6 flex items-center gap-3 border-b border-white/10">
            <img src="images/cit-logo.png" class="w-10 h-10 object-contain bg-white rounded-full p-0.5 shadow-sm" alt="Logo">
            <div class="text-white leading-tight">
                <p class="font-black text-[12px] tracking-wider uppercase">CIT University</p>
                <p class="font-bold text-[12px] opacity-90">LOST &amp; FOUND</p>
            </div>
        </div>
        <nav class="mt-8 px-4 space-y-2.5">
            <a href="index.php?page=dashboard" class="flex items-center gap-4 px-4 py-3.5 text-white/70 hover:bg-white/10 hover:text-white rounded-lg font-bold text-[15px] transition-all">
                <i class="fa-solid fa-table-cells-large w-5 text-center"></i> Dashboard
            </a>
            <a href="index.php?page=report" class="flex items-center gap-4 px-4 py-3.5 text-white/70 hover:bg-white/10 hover:text-white rounded-lg font-bold text-[15px] transition-all">
                <i class="fa-solid fa-circle-plus w-5 text-center"></i> Report Item
            </a>
            <a href="index.php?page=browse" class="flex items-center gap-4 px-4 py-3.5 bg-white/20 text-white rounded-lg font-bold text-[15px] transition-all">
                <i class="fa-solid fa-magnifying-glass w-5 text-center"></i> Browse Items
            </a>
        </nav>
        <div class="mt-auto p-6 border-t border-white/10 bg-black/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white font-bold border border-white/10"><?= $avatar_letter ?></div>
                <div class="text-white overflow-hidden">
                    <p class="text-[13px] font-bold truncate"><?= $full_name ?></p>
                    <p class="text-[11px] opacity-60 capitalize"><?= $role ?></p>
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
                        <p class="text-[14px] font-bold text-gray-800 leading-tight"><?= $full_name ?></p>
                        <p class="text-[11px] text-gray-400 font-medium capitalize"><?= $role ?></p>
                    </div>
                    <div class="bg-citred text-white w-9 h-9 flex justify-center items-center rounded-full text-sm font-bold shadow-sm"><?= $avatar_letter ?></div>
                </div>
                <div class="h-6 w-px bg-gray-200 mx-1"></div>
                <a href="index.php?page=logout" class="text-[13px] text-gray-500 font-bold hover:text-citred flex items-center gap-2">
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
                    <a href="index.php?page=report" class="bg-citred hover:bg-citdarkred text-white font-bold text-sm px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all shadow-sm mt-4">
                        <i class="fa-solid fa-circle-plus"></i> Report an Item
                    </a>
                </div>
                <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="itemsGrid">
                    <?php foreach ($js_items as $index => $item): ?>
                    <div class="item-card bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col group cursor-pointer"
                         data-type="<?= $item['type'] ?>"
                         data-title="<?= strtolower(htmlspecialchars($item['title'])) ?>"
                         onclick="openModal(<?= $index ?>)">
                        <div class="relative h-48 bg-gray-50 overflow-hidden">
                            <div class="absolute top-3 left-3 <?= $item['type_color'] ?> text-white text-[10px] font-bold px-3 py-1 rounded shadow-sm z-10 uppercase tracking-widest"><?= $item['type'] ?></div>
                            <img src="<?= $item['img'] ?>" alt="<?= htmlspecialchars($item['title']) ?>"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 onerror="this.src='https://placehold.co/800x400/f3f4f6/9ca3af?text=No+Image'">
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-gray-900 text-[15px] mb-1 group-hover:text-citred transition-colors"><?= htmlspecialchars($item['title']) ?></h3>
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg w-max <?= $item['status_color'] ?> uppercase tracking-wider mb-3"><?= $item['status'] ?></span>
                            <p class="text-[12px] text-gray-400 font-medium mb-1"><i class="fa-regular fa-calendar mr-1"></i><?= $item['date'] ?></p>
                            <p class="text-[12px] text-gray-400 font-medium mb-4"><i class="fa-solid fa-location-dot mr-1"></i><?= htmlspecialchars($item['location']) ?></p>
                            <div class="mt-auto pt-3 border-t border-gray-50 flex justify-between items-center">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-citred text-white flex items-center justify-center rounded-full text-[10px] font-bold"><?= strtoupper(mb_substr($item['reporter'], 0, 1)) ?></div>
                                    <p class="text-[11px] text-gray-500 font-medium">Rep. by <?= htmlspecialchars(explode(' ', $item['reporter'])[0]) ?></p>
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

<!-- MODAL -->
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
                <div>
                    <h3 class="text-[12px] font-bold text-gray-800 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Details</h3>
                    <div class="space-y-5">
                        <div class="flex gap-4"><i class="fa-solid fa-location-dot text-citred mt-1"></i><div><p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Location</p><p id="modalLocation" class="text-sm font-bold text-gray-900"></p></div></div>
                        <div class="flex gap-4"><i class="fa-regular fa-calendar text-citred mt-1"></i><div><p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Date & Time</p><p id="modalDateTime" class="text-sm font-bold text-gray-900"></p></div></div>
                        <div class="flex gap-4"><i class="fa-regular fa-user text-citred mt-1"></i><div><p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-0.5">Reported By</p><p id="modalReporter" class="text-sm font-bold text-gray-900"></p></div></div>
                    </div>
                </div>
                <div>
                    <h3 id="dynamicSectionTitle" class="text-[12px] font-bold text-gray-800 uppercase tracking-widest border-b border-gray-100 pb-2 mb-4">Contact Info</h3>
                    <div id="dynamicContentBox"></div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100">
                <h3 class="text-[12px] font-bold text-gray-800 uppercase tracking-widest mb-3">Description</h3>
                <div class="border border-gray-200 rounded-xl p-4 text-sm text-gray-600 bg-gray-50"><p id="modalDesc"></p></div>
            </div>

            <!-- Mark as Found banner (only injected for own LOST items) -->
            <div id="markFoundBanner"></div>
        </div>
    </div>
</div>

<script>
const itemsData  = <?= json_encode(array_values($js_items)) ?>;
const currentUID = <?= $user_id ?>;
const itemModal  = document.getElementById('itemModal');

// Filter
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => { b.classList.remove('bg-white','text-gray-900','shadow-sm'); b.classList.add('text-gray-500'); });
        btn.classList.add('bg-white','text-gray-900','shadow-sm'); btn.classList.remove('text-gray-500');
        filterCards();
    });
});
document.getElementById('searchInput').addEventListener('input', filterCards);

function filterCards() {
    const filter = document.querySelector('.filter-btn.bg-white')?.getAttribute('data-filter') || 'ALL';
    const search = document.getElementById('searchInput').value.toLowerCase();
    let visible  = 0;
    document.querySelectorAll('.item-card').forEach(card => {
        const ok = (filter === 'ALL' || card.getAttribute('data-type') === filter) && card.getAttribute('data-title').includes(search);
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

    const dynamicBox   = document.getElementById('dynamicContentBox');
    const sectionTitle = document.getElementById('dynamicSectionTitle');
    const markFoundBanner = document.getElementById('markFoundBanner');
    markFoundBanner.innerHTML = ''; // reset

    // ── OWN item ─────────────────────────────────────────────────────────────
    if (item.is_own) {
        sectionTitle.textContent = 'Your Report';
        dynamicBox.innerHTML = `
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 text-center">
                <i class="fa-solid fa-circle-check text-green-500 text-2xl mb-2 block"></i>
                <p class="font-bold text-gray-700 text-sm">This is your report.</p>
                <p class="text-[11px] text-gray-400 mt-1">Others can see this and submit a claim.</p>
            </div>`;

        // Show "Mark as Found" banner only for OWN LOST items that are NOT yet resolved
        if (item.type === 'LOST' && !item.is_resolved) {
            markFoundBanner.innerHTML = `
                <div class="mt-6 bg-green-50 border border-green-200 rounded-xl p-5 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 text-green-600 flex items-center justify-center rounded-lg">
                            <i class="fa-solid fa-circle-check text-lg"></i>
                        </div>
                        <div>
                            <p class="font-bold text-green-800 text-sm">Did you find your item?</p>
                            <p class="text-[11px] text-green-600 mt-0.5">Click below to mark this report as resolved and notify the admin.</p>
                        </div>
                    </div>
                    <button onclick="markAsFound(${item.id})"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold text-sm px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all shadow-sm shrink-0">
                        <i class="fa-solid fa-check"></i> Mark as Found
                    </button>
                </div>`;
        }

    // ── LOST (someone else's) ────────────────────────────────────────────────
    } else if (item.type === 'LOST') {
        sectionTitle.textContent = 'Contact Info';
        dynamicBox.innerHTML = item.contact_info
            ? `<div class="border border-gray-200 rounded-xl p-5 shadow-sm"><p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Reporter's Contact</p><p class="font-bold text-gray-900 text-sm">${item.contact_info}</p><p class="text-[11px] text-gray-400 mt-2">Reach out if you've found this item.</p></div>`
            : `<div class="border border-gray-200 rounded-xl p-5 shadow-sm"><p class="font-bold text-gray-700 text-sm mb-1">No contact info provided.</p><p class="text-[11px] text-gray-400">Please contact the reporter through other means.</p></div>`;

    // ── FOUND (someone else's) — claim form ──────────────────────────────────
    } else {
        sectionTitle.textContent = 'Claim This Item';

        if (item.claim_status === 'approved') {
            dynamicBox.innerHTML = `
                <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                    <i class="fa-solid fa-circle-check text-green-500 text-2xl mb-2 block"></i>
                    <h4 class="font-bold text-green-700 text-sm mb-1">Ownership Verified by Finder</h4>
                    <p class="text-[11px] text-green-600">${item.contact_info ? 'Contact: <strong>' + item.contact_info + '</strong>' : 'Please contact the reporter directly to claim this item.'}</p>
                </div>`;
        } else if (item.claim_status === 'pending') {
            dynamicBox.innerHTML = pendingHTML();
        } else if (item.claim_status === 'declined') {
            dynamicBox.innerHTML = `
                <div class="bg-red-50 border border-red-200 rounded-xl p-5 text-center mb-3">
                    <i class="fa-solid fa-circle-xmark text-red-400 text-xl mb-1 block"></i>
                    <p class="font-bold text-red-600 text-sm">Your previous claim was declined.</p>
                    <p class="text-[11px] text-red-400 mt-1">You may try again below.</p>
                </div>${buildClaimForm(item)}`;
        } else {
            dynamicBox.innerHTML = buildClaimForm(item);
        }
    }

    itemModal.classList.remove('hidden');
}

function pendingHTML() {
    return `<div class="bg-[#FAFAF5] border border-[#EAEAB5] rounded-xl p-6 text-center">
        <i class="fa-regular fa-clock text-[#A1A142] text-2xl mb-3 block"></i>
        <h4 class="font-bold text-[14px] text-[#8C8C27] mb-2">Verification Pending</h4>
        <p class="text-[11px] text-[#A1A142] leading-relaxed px-2">Your answer has been sent to the finder. You'll see their contact info once they approve.</p>
    </div>`;
}

function buildClaimForm(item) {
    return `<div class="bg-[#F4F6FB] border border-[#E2E8F0] rounded-xl p-6">
        <div class="flex items-center gap-2 mb-3">
            <i class="fa-solid fa-shield-halved text-blue-600"></i>
            <h4 class="font-bold text-[14px] text-blue-900">Proof Before Claim</h4>
        </div>
        <p class="text-[11px] text-blue-600/80 mb-5 leading-relaxed">Answer the finder's verification question to prove ownership.</p>
        <div class="mb-4">
            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Question:</label>
            <p class="text-sm font-bold text-gray-900 bg-white border border-gray-200 px-3 py-2 rounded-lg">${item.question || 'Describe the item in detail.'}</p>
        </div>
        <input type="text" id="verificationAnswer" placeholder="Your answer..."
               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm outline-none focus:border-blue-500 mb-3 shadow-sm">
        <button onclick="submitVerification(${item.id})"
                class="w-full bg-[#1D4ED8] hover:bg-blue-800 text-white font-bold text-[12px] py-2.5 rounded-lg transition-all shadow-sm">
            Submit Answer for Verification
        </button>
    </div>`;
}

function submitVerification(reportId) {
    const answer = document.getElementById('verificationAnswer')?.value?.trim();
    if (!answer) { alert('Please enter your answer.'); return; }

    fetch('index.php?page=submit_claim', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `report_id=${reportId}&answer=${encodeURIComponent(answer)}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const idx = itemsData.findIndex(i => i.id === reportId);
            if (idx !== -1) itemsData[idx].claim_status = 'pending';
            document.getElementById('dynamicContentBox').innerHTML = pendingHTML();
        } else {
            alert(data.message || 'Something went wrong.');
        }
    })
    .catch(() => alert('Network error. Please try again.'));
}

function markAsFound(reportId) {
    if (!confirm('Mark this item as found? This will notify the admin and close the report.')) return;

    fetch('index.php?page=mark_found', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `report_id=${reportId}`
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Update in-memory state
            const idx = itemsData.findIndex(i => i.id === reportId);
            if (idx !== -1) { itemsData[idx].is_resolved = true; itemsData[idx].status = 'RESOLVED'; itemsData[idx].status_color = 'text-blue-600 bg-blue-100'; }

            // Update the banner to a success message
            document.getElementById('markFoundBanner').innerHTML = `
                <div class="mt-6 bg-green-50 border border-green-200 rounded-xl p-5 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-green-500 text-2xl"></i>
                    <div>
                        <p class="font-bold text-green-700 text-sm">Marked as Found!</p>
                        <p class="text-[11px] text-green-600 mt-0.5">The admin has been notified. This report is now resolved.</p>
                    </div>
                </div>`;

            // Update status badge in modal
            const statusBadge = document.getElementById('modalStatus');
            statusBadge.textContent = 'RESOLVED';
            statusBadge.className   = 'text-[10px] font-bold px-2.5 py-1 rounded uppercase tracking-wider text-blue-600 bg-blue-100';
        } else {
            alert(data.message || 'Something went wrong.');
        }
    })
    .catch(() => alert('Network error. Please try again.'));
}

function closeModal() { itemModal.classList.add('hidden'); }
itemModal.addEventListener('click', e => { if (e.target === itemModal) closeModal(); });
</script>
</body>
</html>