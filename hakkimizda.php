<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hakkımızda - Renkli Perde Tasarım</title>
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="assets/images/favicon.ico">
    <meta name="msapplication-TileImage" content="assets/images/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php 
    include 'includes/header.php';
    require_once 'includes/config.php';
    require_once 'includes/db.php';

    // Hakkımızda içeriğini veritabanından al
    try {
        $stmt = $db->prepare("SELECT value FROM site_settings WHERE setting_key = 'about_content'");
        $stmt->execute();
        $about_content = $stmt->fetchColumn();
    } catch (PDOException $e) {
        $about_content = "İçerik yüklenirken bir hata oluştu.";
    }
    ?>

    <section class="about-section">
        <div class="container">
            <div class="about-grid">
                <div class="about-content">
                    <?php echo $about_content; ?>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 