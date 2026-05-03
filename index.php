<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = $_GET['page'] ?? 'landing';

// Pages that require login
$protected_pages = ['dashboard', 'report', 'browse', 'admin-dashboard', 'admin-manage'];

if (in_array($page, $protected_pages) && !isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit();
}

// Logout handler
if ($page === 'logout') {
    session_destroy();
    header("Location: index.php?page=login");
    exit();
}

// Route to the correct file
switch ($page) {

    case 'landing':
        include __DIR__ . '/views/landing.php';
        break;

    case 'login':
        include __DIR__ . '/auth/login.php';
        break;

    case 'dashboard':
        include __DIR__ . '/views/dashboard/dashboard.php'; 
        break;

    case 'report':
        include __DIR__ . '/views/dashboard/report-item.php';
        break;

    case 'browse':
        include __DIR__ . '/views/dashboard/browse.php';
        break;

    case 'guest-dashboard':
        include __DIR__ . '/views/guest-dashboard.php';
        break;

    case 'admin-dashboard':
        include __DIR__ . '/views/Admin Dashboard/admin-dashboard.php';
        break;
    case 'admin-manage':
        include __DIR__ . '/views/Admin Dashboard/admin-manage.php';
        break;
    case 'submit_claim':
        include __DIR__ . '/views/dashboard/submit_claim.php';
        break;
    case 'verification':
        include __DIR__ . '/views/dashboard/verification.php';
        break;
    default:
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        break;
}