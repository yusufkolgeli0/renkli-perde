<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Kategori ID'sini al
$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kategori bilgilerini al
$category = null;
if ($category_id > 0) {
    $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$category_id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Eğer kategori bulunamadıysa ana sayfaya yönlendir
if (!$category && $category_id !== 0) {
    header('Location: galeri.php');
    exit;
}

$pageTitle = $category ? $category['name'] : 'Tüm Görseller';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Renkli Perde Tasarım</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/gallery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container-fluid py-5">
        <div class="category-header">
            <h1 class="category-title"><?php echo htmlspecialchars($pageTitle); ?></h1>
            <a href="galeri.php" class="back-button">
                <i class="fas fa-arrow-left"></i> Kategorilere Dön
            </a>
        </div>

        <div class="gallery-grid" id="galleryContainer">
            <?php
            // Galeri sorgusunu oluştur
            if ($category_id > 0) {
                $query = "SELECT g.*, c.name as category_name 
                         FROM gallery g 
                         LEFT JOIN categories c ON g.category_id = c.id 
                         WHERE g.category_id = ?
                         ORDER BY g.created_at DESC";
                $stmt = $db->prepare($query);
                $stmt->execute([$category_id]);
            } else {
                $query = "SELECT g.*, c.name as category_name 
                         FROM gallery g 
                         LEFT JOIN categories c ON g.category_id = c.id
                         ORDER BY g.created_at DESC";
                $stmt = $db->query($query);
            }
            
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
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="empty-gallery">
                    <i class="fas fa-image"></i>
                    <p>Bu kategoride henüz görsel bulunmuyor.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <style>
    .category-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        padding: 0 20px;
    }

    .category-title {
        color: var(--antracite);
        font-size: 2rem;
        font-weight: 600;
        margin: 0;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        background: var(--accent-color);
        color: var(--text-light);
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .back-button:hover {
        background: #2d7ed9;
        transform: translateX(-5px);
        color: var(--text-light);
    }

    .back-button i {
        margin-right: 8px;
    }

    .empty-gallery {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        background: #f8f9fa;
        border-radius: 16px;
        color: var(--text-muted);
    }

    .empty-gallery i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #dee2e6;
    }

    .empty-gallery p {
        font-size: 1.2rem;
        margin: 0;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        padding: 20px;
    }

    .gallery-item {
        position: relative;
        border-radius: 16px;
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

    @media (max-width: 768px) {
        .category-header {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .category-title {
            font-size: 1.75rem;
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            padding: 15px;
        }
    }

    @media (max-width: 576px) {
        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            padding: 10px;
        }

        .gallery-item-overlay {
            padding: 15px;
        }

        .gallery-item-overlay h3 {
            font-size: 1.1rem;
        }

        .gallery-item-overlay p {
            font-size: 0.85rem;
        }
    }
    </style>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 