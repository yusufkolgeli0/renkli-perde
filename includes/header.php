<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header>
    <div class="container">
        <div class="logo">
            <a href="index.php">
                <img src="images/logo.png" alt="Renkli Perde Tasarım Logo">
            </a>
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