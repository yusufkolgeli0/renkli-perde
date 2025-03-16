<?php
session_start();

// Giriş yapılmamışsa login sayfasına yönlendir
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Renkli Perde Tasarım - Yönetim Paneli">
    <title>Yönetim Paneli - Renkli Perde Tasarım</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="assets/images/favicon.ico">
    <meta name="msapplication-TileImage" content="assets/images/favicon.ico">
    
    <!-- Stil dosyaları -->
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3>Yönetim Paneli</h3>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="dashboard.php"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                    <li><a href="categories.php"><i class="fas fa-tags"></i> Kategoriler</a></li>
                    <li><a href="gallery.php"><i class="fas fa-images"></i> Galeri Yönetimi</a></li>
                    <li><a href="about.php"><i class="fas fa-info-circle"></i> Hakkımızda Yönetimi</a></li>
                    <li><a href="contact.php"><i class="fas fa-envelope"></i> İletişim Yönetimi</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a></li>
                </ul>
            </nav>
        </div>

        <!-- Ana İçerik -->
        <div class="main-content">
            <!-- Üst Bar -->
            <div class="top-bar">
                <div class="toggle-sidebar">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="user-info">
                    <span>Hoş geldiniz, <?php echo $_SESSION['admin_username']; ?></span>
                </div>
            </div>

            <!-- Sayfa İçeriği -->
            <div class="content-area"> 