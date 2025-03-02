<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header>
    <div class="container">
        <div class="logo">
            <a href="index.php">
                <h1>Renkli Perde Tasarım</h1>
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php" <?php echo ($current_page == 'index.php') ? 'class="active"' : ''; ?>>Anasayfa</a></li>
                <li><a href="galeri.php" <?php echo ($current_page == 'galeri.php') ? 'class="active"' : ''; ?>>Galeri</a></li>
                <li><a href="hakkimizda.php" <?php echo ($current_page == 'hakkimizda.php') ? 'class="active"' : ''; ?>>Biz Kimiz</a></li>
                <li><a href="iletisim.php" <?php echo ($current_page == 'iletisim.php') ? 'class="active"' : ''; ?>>İletişim</a></li>
            </ul>
        </nav>
    </div>
</header> 