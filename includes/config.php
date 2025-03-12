<?php
// Veritabanı bağlantı bilgileri
define('DB_HOST', 'localhost');     // Veritabanı sunucusu
define('DB_NAME', 'renkli_perde'); // Veritabanı adı
define('DB_USER', 'root');         // Veritabanı kullanıcı adı - Kendi kullanıcı adınızla değiştirin
define('DB_PASS', '12345678');             // Veritabanı şifresi - Kendi şifrenizle değiştirin

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// File upload settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Time zone
date_default_timezone_set('Europe/Istanbul');
?> 
