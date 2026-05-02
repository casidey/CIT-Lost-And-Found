<?php
// config/db.php

$host = 'localhost';
$dbname = 'cit_lost&found'; // Your specific DB name
$username = 'root'; 
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // In production, don't show the error message to users
    die("Database connection failed."); 
}