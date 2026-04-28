<?php
// /lost-and-found/index.php
session_start();

// Simple Router
$page = isset($_GET['page']) ? $_GET['page'] : 'landing';

// Define base URL for assets
define('BASE_URL', '/lost-and-found');

switch ($page) {
    case 'login':
        require 'auth/login.php';
        break;
    case 'dashboard':
        require 'views/dashboard/index.php';
        break;
    case 'report':
        require 'views/dashboard/report-item.php';
        break;
    case 'browse':
        require 'views/dashboard/browse.php';
        break;
    case 'admin':
        require 'views/admin-dashboard.php';
        break;
    case 'admin-manage':
        require 'views/admin-manage.php';
        break;
    case 'guest':
        require 'views/guest-dashboard.php';
        break;
    case 'landing':
    default:
        require 'views/landing.php';
        break;
}
?>