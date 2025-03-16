<?php
$current_page = basename($_SERVER['PHP_SELF']);
$base_url = '/';  // Base URL'i tanımla
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Renkli Perde Tasarım - Kaliteli ve Şık Perde Tasarımları">
    <title>Renkli Perde Tasarım - <?php echo ucfirst(str_replace(['.php', '-'], ['', ' '], $current_page)); ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="assets/images/favicon.ico">
    <meta name="msapplication-TileImage" content="assets/images/favicon.ico">
    
    <!-- Stil dosyaları -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <a href="index.php">
                <img src="/assets/images/logo.png" alt="Renkli Perde Tasarım Logo">
            </a>
        </div>
        <div class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
        <nav>
            <ul>
                <li><a href="index.php" <?php echo ($current_page == 'index.php') ? 'class="active"' : ''; ?>><i class="fas fa-home"></i> Anasayfa</a></li>
                <li><a href="galeri.php" <?php echo ($current_page == 'galeri.php') ? 'class="active"' : ''; ?>><i class="fas fa-images"></i> Galeri</a></li>
                <li><a href="hakkimizda.php" <?php echo ($current_page == 'hakkimizda.php') ? 'class="active"' : ''; ?>><i class="fas fa-info-circle"></i> Biz Kimiz</a></li>
                <li><a href="iletisim.php" <?php echo ($current_page == 'iletisim.php') ? 'class="active"' : ''; ?>><i class="fas fa-envelope"></i> İletişim</a></li>
            </ul>
        </nav>
    </div>
</header> 