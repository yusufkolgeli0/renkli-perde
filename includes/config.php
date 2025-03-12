<?php
// Veritabanı bağlantı bilgileri
define('DB_HOST', 'db');
define('DB_NAME', 'renkli_perde_db');
define('DB_USER', 'root');
define('DB_PASS', 'root_password'); // MAMP için varsayılan şifre

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// File upload settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Time zone
date_default_timezone_set('Europe/Istanbul');
?> 
