<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Seçili kategoriyi al
$selected_category = isset($_GET['category']) ? $_GET['category'] : 'all';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - Renkli Perde Tasarım</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/gallery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container-fluid py-5">
        <div class="row">
            <!-- Kategori Sidebar -->
            <div class="col-md-3">
                <div class="category-sidebar">
                    <h4 class="category-title">KATEGORİLER</h4>
                    <div class="category-cards">
                        <a href="kategori-detay.php" class="category-card <?php echo $selected_category == 'all' ? 'active' : ''; ?>">
                            <div class="category-card-image">
                                <div class="category-card-bg" style="background-image: url('assets/img/all-categories.jpg');">
                                    <div class="category-card-overlay"></div>
                                </div>
                            </div>
                            <div class="category-card-content">
                                <h5>Tüm Görseller</h5>
                            </div>
                        </a>
                        
                        <?php
                        $stmt = $db->query("SELECT * FROM categories ORDER BY name");
                        while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $isActive = $selected_category == $category['id'] ? 'active' : '';
                            $categoryImage = !empty($category['image']) ? 'images/categories/'.$category['image'] : 'assets/img/default-category.jpg';
                            ?>
                            <a href="kategori-detay.php?id=<?php echo $category['id']; ?>" 
                               class="category-card <?php echo $isActive; ?>">
                                <div class="category-card-image">
                                    <div class="category-card-bg" style="background-image: url('<?php echo $categoryImage; ?>');">
                                        <div class="category-card-overlay"></div>
                                    </div>
                                </div>
                                <div class="category-card-content">
                                    <h5><?php echo htmlspecialchars($category['name']); ?></h5>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- Galeri Grid -->
            <div class="col-md-9">
                <div class="gallery-grid" id="galleryContainer">
                    <?php
                    // Galeri sorgusunu oluştur
                    $query = "SELECT g.*, c.name as category_name 
                             FROM gallery g 
                             LEFT JOIN categories c ON g.category = c.name";
                    
                    if ($selected_category != 'all') {
                        $query = "SELECT g.*, c.name as category_name 
                                 FROM gallery g 
                                 LEFT JOIN categories c ON g.category = c.name 
                                 WHERE c.id = :category_id";
                    }
                    
                    try {
                        $stmt = $db->prepare($query);
                        
                        if ($selected_category != 'all') {
                            $stmt->bindParam(':category_id', $selected_category);
                        }
                        
                        $stmt->execute();
                        $gallery_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        if (count($gallery_items) > 0) {
                            foreach ($gallery_items as $item) {
                                ?>
                                <div class="gallery-item">
                                    <img src="images/<?php echo htmlspecialchars($item['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['title']); ?>">
                                    <div class="gallery-item-overlay">
                                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                        <?php if (!empty($item['description'])): ?>
                                            <p><?php echo htmlspecialchars($item['description']); ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($item['category'])): ?>
                                            <p class="category-name">
                                                <small><?php echo htmlspecialchars($item['category']); ?></small>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div class="text-center w-100"><p>Bu kategoride henüz görsel bulunmuyor.</p></div>';
                        }
                    } catch (PDOException $e) {
                        echo '<div class="text-center w-100"><p>Veriler yüklenirken bir hata oluştu.</p></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Antrasit Tema Renkleri */
    :root {
        --antracite: #2c3338;
        --antracite-light: #3a4149;
        --antracite-dark: #1e2428;
        --accent-color: #4a90e2;
        --text-light: #ffffff;
        --text-muted: #a0a6ab;
    }

    /* Kategori Sidebar Stilleri */
    .category-sidebar {
        background: var(--text-light);
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .category-title {
        color: var(--antracite);
        font-size: 1.5rem;
        font-weight: 500;
        margin-bottom: 2rem;
        text-align: center;
        letter-spacing: -0.5px;
    }

    .category-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .category-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: #fff;
        border: 1px solid rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
    }

    .category-card-image {
        position: relative;
        aspect-ratio: 1;
        overflow: hidden;
    }

    .category-card-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .category-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 0.2),
            rgba(0, 0, 0, 0.4)
        );
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .category-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border-color: transparent;
    }

    .category-card:hover .category-card-overlay {
        opacity: 1;
    }

    .category-card:hover .category-card-bg {
        transform: scale(1.08);
    }

    .category-card-content {
        padding: 16px;
        text-align: center;
        background: linear-gradient(135deg, #6e8efb, #4a90e2);
        position: relative;
        overflow: hidden;
    }

    .category-card-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, 
            rgba(110, 142, 251, 0.8), 
            rgba(74, 144, 226, 0.8)
        );
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .category-card h5 {
        color: var(--text-light);
        margin: 0;
        font-size: 1.1rem;
        font-weight: 500;
        line-height: 1.4;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .category-card:nth-child(3n+1) .category-card-content {
        background: linear-gradient(135deg, #FF6B6B, #FF8E8E);
    }

    .category-card:nth-child(3n+2) .category-card-content {
        background: linear-gradient(135deg, #4ECDC4, #45B7AF);
    }

    .category-card:nth-child(3n+3) .category-card-content {
        background: linear-gradient(135deg, #6E8EFB, #4A90E2);
    }

    .category-card:hover .category-card-content::before {
        opacity: 1;
    }

    .category-card.active .category-card-content {
        background: linear-gradient(135deg, var(--accent-color), #2d7ed9);
    }

    .category-card.active .category-card-content::before {
        background: linear-gradient(135deg,
            rgba(74, 144, 226, 0.9),
            rgba(45, 126, 217, 0.9)
        );
    }

    .category-card.active h5 {
        color: var(--text-light);
        transform: scale(1.05);
    }

    .category-card.active {
        border: 2px solid var(--accent-color);
        box-shadow: 0 10px 25px rgba(74, 144, 226, 0.15);
    }

    .category-card.active .category-card-overlay {
        background: linear-gradient(
            135deg,
            rgba(74, 144, 226, 0.85),
            rgba(74, 144, 226, 0.95)
        );
        opacity: 1;
    }

    /* Responsive Tasarım */
    @media (min-width: 1400px) {
        .category-card-content {
            padding: 20px;
        }
        
        .category-card h5 {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 1200px) {
        .category-cards {
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 992px) {
        .category-cards {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .category-sidebar {
            padding: 25px;
        }
    }

    @media (max-width: 768px) {
        .category-sidebar {
            margin-bottom: 30px;
        }
        
        .category-cards {
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        
        .category-card-content {
            padding: 14px;
        }
        
        .category-card h5 {
            font-size: 0.95rem;
        }
    }

    @media (max-width: 576px) {
        .category-sidebar {
            padding: 20px;
        }
        
        .category-cards {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        
        .category-card-content {
            padding: 12px;
        }
        
        .category-card h5 {
            font-size: 0.9rem;
        }
    }

    /* Galeri Grid Stilleri */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        padding: 20px;
    }

    .gallery-item {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        aspect-ratio: 1;
        transform: translateY(0);
        transition: all 0.3s ease;
    }

    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-item-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: white;
        padding: 20px;
        transform: translateY(100%);
        transition: transform 0.4s ease;
    }

    .gallery-item:hover .gallery-item-overlay {
        transform: translateY(0);
    }

    .gallery-item-overlay h3 {
        font-size: 1.2rem;
        margin: 0 0 8px 0;
        font-weight: 600;
    }

    .gallery-item-overlay p {
        font-size: 0.9rem;
        margin: 0;
        opacity: 0.9;
        line-height: 1.4;
    }

    .category-name {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid rgba(255,255,255,0.2);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Boş Galeri Mesajı Stili */
    .empty-gallery {
        text-align: center;
        padding: 40px;
        background: #f8f9fa;
        border-radius: 15px;
        color: #6c757d;
    }

    .empty-gallery p {
        font-size: 1.1rem;
        margin: 10px 0;
    }

    .empty-gallery i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #dee2e6;
    }
    </style>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 