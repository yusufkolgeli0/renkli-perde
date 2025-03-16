<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renkli Perde Tasarım</title>
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <meta property="og:image" content="assets/images/logo.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main id="main-content">
        <section id="home" class="page-section active">
            <div class="hero-section">
                <div class="hero-content">
                    <p>Özel tasarım perdeler ile yaşam alanlarınızı güzelleştirin</p>
                    <a href="galeri.php" class="btn">Ürünlerimizi İnceleyin</a>
                </div>
            </div>
            <div class="features">
                <div class="container">
                    <div class="feature-box">
                        <i class="fas fa-star"></i>
                        <h3>Kaliteli Ürünler</h3>
                        <p>En kaliteli kumaşlar ve malzemeler</p>
                    </div>
                    <div class="feature-box">
                        <i class="fas fa-magic"></i>
                        <h3>Özel Tasarım</h3>
                        <p>Size özel tasarım ve ölçülendirme</p>
                    </div>
                    <div class="feature-box">
                        <i class="fas fa-truck"></i>
                        <h3>Hızlı Teslimat</h3>
                        <p>Güvenli ve hızlı montaj hizmeti</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="assets/js/main.js"></script>
</body>
</html> 