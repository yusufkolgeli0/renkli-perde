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
$pageTitle = $category ? $category['name'] : 'Tüm Görseller';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Renkli Perde Tasarım</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/gallery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content container">
            <nav class="breadcrumb">
                <a href="galeri.php">Galeri</a>
                <i class="fas fa-chevron-right"></i>
                <span><?php echo htmlspecialchars($pageTitle); ?></span>
            </nav>
            <div class="hero-info">
                <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
                <?php if ($category && !empty($category['description'])): ?>
                    <p class="hero-description"><?php echo htmlspecialchars($category['description']); ?></p>
                <?php endif; ?>
                <div class="hero-meta">
                    <span class="image-count">
                        <i class="fas fa-images"></i>
                        <?php echo count($gallery_items); ?> Görsel
                    </span>
                    <a href="galeri.php" class="back-button">
                        <i class="fas fa-arrow-left"></i> Kategorilere Dön
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <?php if (count($gallery_items) > 0): ?>

            <!-- Gallery Grid -->
            <div class="gallery-controls">
                <div class="gallery-filters">
                    <button class="active" data-sort="newest">En Yeni</button>
                    <button data-sort="oldest">En Eski</button>
                    <button data-sort="title">İsme Göre</button>
                </div>
                <div class="view-options">
                    <button class="active" data-view="grid">
                        <i class="fas fa-th"></i>
                    </button>
                    <button data-view="masonry">
                        <i class="fas fa-th-large"></i>
                    </button>
                </div>
            </div>

            <div class="gallery-grid" id="galleryContainer">
                <?php foreach ($gallery_items as $item): ?>
                <div class="gallery-item" data-fancybox="gallery" 
                     data-src="images/uploads/<?php echo htmlspecialchars($item['image']); ?>"
                     data-caption="<?php echo htmlspecialchars($item['title']); ?>"
                     data-date="<?php echo strtotime($item['created_at']); ?>">
                    <img src="images/uploads/<?php echo htmlspecialchars($item['image']); ?>" 
                         alt="<?php echo htmlspecialchars($item['title']); ?>"
                         loading="lazy">
                    <div class="gallery-item-overlay">
                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                        <?php if (!empty($item['description'])): ?>
                            <p><?php echo htmlspecialchars($item['description']); ?></p>
                        <?php endif; ?>
                        <span class="view-image">
                            <i class="fas fa-search-plus"></i> Büyüt
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-gallery">
                <i class="fas fa-image"></i>
                <p>Bu kategoride henüz görsel bulunmuyor.</p>
                <a href="galeri.php" class="btn btn-primary mt-3">Diğer Kategorileri Keşfet</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Lightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <!-- Masonry JS -->
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

    <script>
        // Initialize Swiper
        const swiper = new Swiper('.swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            }
        });

        // Initialize Fancybox
        Fancybox.bind('[data-fancybox="gallery"]', {
            dragToClose: false,
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [
                        "zoomIn",
                        "zoomOut",
                        "toggle1to1",
                        "rotateCCW",
                        "rotateCW",
                        "flipX",
                        "flipY",
                    ],
                    right: ["slideshow", "thumbs", "close"],
                },
            }
        });

        // Initialize Masonry
        let msnry = null;
        const grid = document.querySelector('.gallery-grid');
        
        function initMasonry() {
            msnry = new Masonry(grid, {
                itemSelector: '.gallery-item',
                columnWidth: '.gallery-item',
                percentPosition: true,
                transitionDuration: '0.3s'
            });
        }

        // View Switching
        document.querySelectorAll('.view-options button').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.view-options button').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                if (button.dataset.view === 'masonry') {
                    grid.classList.add('masonry-layout');
                    initMasonry();
                } else {
                    grid.classList.remove('masonry-layout');
                    if (msnry) {
                        msnry.destroy();
                        msnry = null;
                    }
                }
            });
        });

        // Sorting
        document.querySelectorAll('.gallery-filters button').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.gallery-filters button').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                const items = Array.from(document.querySelectorAll('.gallery-item'));
                items.sort((a, b) => {
                    if (button.dataset.sort === 'title') {
                        return a.querySelector('h3').textContent.localeCompare(b.querySelector('h3').textContent);
                    } else if (button.dataset.sort === 'oldest') {
                        return a.dataset.date - b.dataset.date;
                    } else {
                        return b.dataset.date - a.dataset.date;
                    }
                });

                grid.innerHTML = '';
                items.forEach(item => grid.appendChild(item));
                
                if (msnry) {
                    msnry.reloadItems();
                    msnry.layout();
                }
            });
        });
    </script>

    <style>
    :root {
        --primary-color: #4a90e2;
        --secondary-color: #6c757d;
        --dark-color: #2c3338;
        --light-color: #ffffff;
        --border-radius: 15px;
        --box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        --transition: all 0.3s ease;
    }

    /* Hero Section */
    .hero-section {
        color: var(--light-color);
        padding: 4rem 0;
        margin-bottom: 3rem;
    }

    .hero-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .breadcrumb {
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .breadcrumb a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        transition: var(--transition);
    }

    .breadcrumb a:hover {
        color: var(--light-color);
    }

    .breadcrumb i {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.6);
    }

    .hero-info h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .hero-description {
        font-size: 1.2rem;
        opacity: 0.9;
        max-width: 600px;
        margin-bottom: 2rem;
    }

    .hero-meta {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .image-count {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.1rem;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1.5rem;
        background: rgba(255,255,255,0.2);
        border-radius: 25px;
        color: var(--light-color);
        text-decoration: none;
        transition: var(--transition);
    }

    .back-button:hover {
        background: rgba(255,255,255,0.3);
        transform: translateX(-5px);
    }

    /* Featured Carousel */
    .featured-carousel {
        margin-bottom: 4rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 2rem;
        text-align: center;
    }

    .swiper {
        padding: 2rem 1rem;
    }

    .featured-item {
        position: relative;
        border-radius: var(--border-radius);
        overflow: hidden;
        aspect-ratio: 16/9;
    }

    .featured-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .featured-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 2rem;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: var(--light-color);
        transform: translateY(100%);
        transition: var(--transition);
    }

    .featured-item:hover .featured-overlay {
        transform: translateY(0);
    }

    .featured-item:hover img {
        transform: scale(1.1);
    }

    /* Gallery Controls */
    .gallery-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 0 1rem;
    }

    .gallery-filters {
        display: flex;
        gap: 1rem;
    }

    .gallery-filters button,
    .view-options button {
        background: none;
        border: none;
        padding: 0.5rem 1rem;
        cursor: pointer;
        color: var(--secondary-color);
        transition: var(--transition);
    }

    .gallery-filters button.active,
    .view-options button.active {
        color: var(--primary-color);
        font-weight: 600;
    }

    .view-options {
        display: flex;
        gap: 0.5rem;
    }

    /* Gallery Grid */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        padding: 20px;
    }

    .gallery-grid.masonry-layout {
        display: block;
    }

    .gallery-item {
        position: relative;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--box-shadow);
        cursor: pointer;
    }

    .masonry-layout .gallery-item {
        width: calc(33.333% - 20px);
        margin: 10px;
        float: left;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .gallery-item-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1.5rem;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        color: var(--light-color);
        transform: translateY(100%);
        transition: var(--transition);
    }

    .gallery-item:hover .gallery-item-overlay {
        transform: translateY(0);
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .view-image {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
        padding: 0.5rem 1rem;
        background: rgba(255,255,255,0.2);
        border-radius: 20px;
        font-size: 0.9rem;
    }

    /* Empty Gallery */
    .empty-gallery {
        text-align: center;
        padding: 4rem 2rem;
        background: #f8f9fa;
        border-radius: var(--border-radius);
        color: var(--secondary-color);
    }

    .empty-gallery i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #dee2e6;
    }

    .empty-gallery p {
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .masonry-layout .gallery-item {
            width: calc(50% - 20px);
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 3rem 0;
        }

        .hero-info h1 {
            font-size: 2.5rem;
        }

        .hero-description {
            font-size: 1.1rem;
        }

        .hero-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .gallery-controls {
            flex-direction: column;
            gap: 1rem;
        }

        .gallery-filters {
            width: 100%;
            justify-content: center;
        }

        .view-options {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .masonry-layout .gallery-item {
            width: calc(100% - 20px);
        }

        .hero-info h1 {
            font-size: 2rem;
        }

        .section-title {
            font-size: 1.75rem;
        }

        .gallery-filters {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
    </style>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 