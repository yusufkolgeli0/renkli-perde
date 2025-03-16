<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Check if search parameter exists
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Arama terimini vurgulama fonksiyonu
function highlightSearchTerm($text, $searchTerm) {
    if (empty($searchTerm)) {
        return $text;
    }
    
    // HTML güvenliği için önce htmlspecialchars uygula
    $text = htmlspecialchars($text);
    $searchTerm = htmlspecialchars($searchTerm);
    
    // Büyük/küçük harf duyarsız arama için
    $pattern = '/(' . preg_quote($searchTerm, '/') . ')/i';
    $replacement = '<span class="highlight">$1</span>';
    
    return preg_replace($pattern, $replacement, $text);
}

// Başlıkları temizleme fonksiyonu
function cleanTitle($title) {
    // (1/3), (2/5) gibi ifadeleri temizle
    $title = preg_replace('/\s*\(\d+\/\d+\)\s*/', '', $title);
    
    // [1], [2] gibi ifadeleri temizle
    $title = preg_replace('/\s*\[\d+\]\s*/', '', $title);
    
    // (1), (2) gibi ifadeleri temizle
    $title = preg_replace('/\s*\(\d+\)\s*/', '', $title);
    
    // Başlık sonundaki fazla boşlukları temizle
    $title = trim($title);
    
    return $title;
}
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="assets/images/favicon.ico">
    <meta name="msapplication-TileImage" content="assets/images/favicon.ico">
    <title><?php echo !empty($search) ? 'Arama: ' . htmlspecialchars($search) . ' - ' : ''; ?>Galeri - Renkli Perde Tasarım</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/gallery.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container py-5">
        <!-- Başlık ve Açıklama -->
        <div class="gallery-header text-center">
            <div style="height: 80px;"></div>
            <?php if (!empty($search)): ?>
                <h1 class="h2 fw-bold">"<?php echo htmlspecialchars($search); ?>" İÇİN ARAMA SONUÇLARI</h1>
                <p>Arama sonuçlarını aşağıda görebilirsiniz.</p>
                <a href="galeri.php" class="btn btn-outline-primary mt-3">
                    <i class="fas fa-arrow-left"></i> Tüm Kategorilere Dön
                </a>
            <?php else: ?>
                <h1 class="h2 fw-bold">KATEGORİLER</h1>
            <?php endif; ?>
        </div>

        <?php if (!empty($search)): ?>
            <!-- Search Results -->
            <div class="search-results">
                <?php
                // Search in gallery items
                $stmt = $db->prepare("SELECT g.*, c.name as category_name 
                                     FROM gallery g 
                                     LEFT JOIN categories c ON g.category_id = c.id 
                                     WHERE g.title LIKE ? OR g.description LIKE ? OR c.name LIKE ?
                                     ORDER BY g.created_at DESC");
                $searchParam = "%{$search}%";
                $stmt->execute([$searchParam, $searchParam, $searchParam]);
                $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($searchResults) > 0): 
                ?>
                    <!-- Gallery Controls -->
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
                    
                    <div class="gallery-images-grid" id="searchResultsContainer">
                        <?php foreach ($searchResults as $item): 
                            // Arama teriminin nerede geçtiğini belirle
                            $matchType = '';
                            $matchText = '';
                            
                            // Temizlenmiş başlık
                            $cleanedTitle = cleanTitle($item['title']);
                            
                            // Başlıkta arama
                            if (stripos($cleanedTitle, $search) !== false) {
                                $matchType = 'title';
                                $matchText = $cleanedTitle;
                            } 
                            // Açıklamada arama
                            elseif (!empty($item['description']) && stripos($item['description'], $search) !== false) {
                                $matchType = 'description';
                                $matchText = $item['description'];
                            }
                            // Kategoride arama
                            elseif (!empty($item['category_name']) && stripos($item['category_name'], $search) !== false) {
                                $matchType = 'category';
                                $matchText = $item['category_name'];
                            }
                        ?>
                            <div class="gallery-image-item" data-date="<?php echo strtotime($item['created_at']); ?>">
                                <a href="images/uploads/<?php echo $item['image']; ?>" class="gallery-link" data-fancybox="gallery" data-caption="<?php echo htmlspecialchars(cleanTitle($item['title'])); ?>">
                                    <img src="images/uploads/<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars(cleanTitle($item['title'])); ?>" loading="lazy">
                                    <div class="gallery-item-overlay">
                                        <div class="gallery-item-info">
                                            <h3><?php echo highlightSearchTerm(cleanTitle($item['title']), $search); ?></h3>
                                            
                                            <?php if (!empty($item['category_name'])): ?>
                                                <span class="category"><?php echo highlightSearchTerm($item['category_name'], $search); ?></span>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($matchType)): ?>
                                                <div class="match-info">
                                                    <span class="match-label">Eşleşme: </span>
                                                    <?php if ($matchType == 'title'): ?>
                                                        <span class="match-type">Başlık</span>
                                                    <?php elseif ($matchType == 'description'): ?>
                                                        <span class="match-type">Açıklama</span>
                                                    <?php elseif ($matchType == 'category'): ?>
                                                        <span class="match-type">Kategori</span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($item['description'])): ?>
                                                <p class="item-description"><?php echo highlightSearchTerm(substr($item['description'], 0, 100), $search); ?><?php echo (strlen($item['description']) > 100) ? '...' : ''; ?></p>
                                            <?php endif; ?>
                                            
                                            <span class="view-image">
                                                <i class="fas fa-search-plus"></i> Büyüt
                                            </span>
                                        </div>
                                    </div>
                                </a>
                                <div class="gallery-item-title">
                                    <h4><?php echo highlightSearchTerm(cleanTitle($item['title']), $search); ?></h4>
                                    <?php if (!empty($item['category_name'])): ?>
                                        <span class="category-badge"><?php echo highlightSearchTerm($item['category_name'], $search); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-results">
                        <i class="fas fa-search fa-3x mb-3"></i>
                        <h3>Arama sonucu bulunamadı</h3>
                        <p>Farklı anahtar kelimelerle tekrar aramayı deneyin.</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Kategori Grid -->
            <div class="category-grid" style="margin-top: 60px;">
                <!-- Tüm Fotoğraflar Kartı -->
                <?php
                // Toplam fotoğraf sayısını al
                $stmt = $db->query("SELECT COUNT(*) as total FROM gallery");
                $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                ?>

                <?php
                $stmt = $db->query("SELECT c.*, (SELECT COUNT(*) FROM gallery WHERE category_id = c.id) as image_count FROM categories c ORDER BY name");
                while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $categoryImage = !empty($category['image']) ? 'images/uploads/categories/'.$category['image'] : 'assets/img/default-category.jpg';
                    ?>
                    <a href="kategori-detay.php?id=<?php echo $category['id']; ?>" class="category-card">
                        <div class="category-card-image">
                            <div class="category-card-bg" style="background-image: url('<?php echo $categoryImage; ?>');">
                                <div class="category-card-overlay">
                                    <div class="overlay-content">
                                        <span class="image-count">
                                            <i class="fas fa-images"></i>
                                            <?php echo $category['image_count']; ?> görsel
                                        </span>
                                        <span class="view-category">
                                            Kategoriyi Görüntüle <i class="fas fa-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="category-card-content">
                            <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                            <?php if (!empty($category['description'])): ?>
                                <p><?php echo htmlspecialchars($category['description']); ?></p>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php } ?>
            </div>
        <?php endif; ?>
    </div>

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

    /* Başlık Stilleri */
    .gallery-header {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
        position: relative;
    }

    @keyframes titleFloat {
        0%, 100% {
            transform: translateX(-50%) translateY(0);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        50% {
            transform: translateX(-50%) translateY(-5px);
            text-shadow: 4px 4px 8px rgba(0,0,0,0.2);
        }
    }

    @keyframes lineExpand {
        0% {
            transform: translateX(-50%) scaleX(0);
            opacity: 0;
        }
        100% {
            transform: translateX(-50%) scaleX(1);
            opacity: 1;
        }
    }

    .gallery-header h1 {
        color: #9ca3af;
        position: absolute;
        display: inline-block;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.03);
        margin: 0 auto;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1.75rem;
        animation: titleFloat 3s ease-in-out infinite;
        letter-spacing: 2px;
        transition: all 0.3s ease;
        cursor: pointer;
        padding: 10px 20px;
        border-radius: 8px;
    }

    .gallery-header h1:hover {
        color: #6b7280;
        transform: translateX(-50%) scale(1.02);
        letter-spacing: 3px;
        text-shadow: 3px 3px 6px rgba(0,0,0,0.08);
    }

    .gallery-header h1::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%) scaleX(0);
        width: 100px;
        height: 4px;
        background: #d1d5db;
        border-radius: 2px;
        animation: lineExpand 1.5s ease forwards;
        transition: all 0.5s ease;
    }

    .gallery-header h1:hover::after {
        background: linear-gradient(90deg, #d1d5db, #9ca3af);
        width: 140px;
        box-shadow: 0 2px 10px rgba(156, 163, 175, 0.15);
        height: 5px;
    }

    /* Kategori Grid */
    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        padding: 1rem;
    }

    /* Öne Çıkan Kart Stilleri */
    .featured-card {
        grid-column: 1 / -1;
        max-width: 100%;
        color: var(--light-color);
    }

    .featured-card .category-card-image {
        padding-top: 25%; /* Daha geniş bir görünüm */
    }

    .featured-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 2rem;
        background: linear-gradient(45deg, rgba(110,142,251,0.95), rgba(74,144,226,0.95));
        transition: var(--transition);
    }

    .featured-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        transition: var(--transition);
    }

    .featured-title {
        font-size: 2rem;
        font-weight: 600;
        margin: 0 0 0.5rem;
        color: var(--light-color);
    }

    .featured-count {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .featured-button {
        display: inline-block;
        padding: 0.8rem 1.5rem;
        background: rgba(255,255,255,0.2);
        border-radius: 25px;
        font-weight: 500;
        transition: var(--transition);
    }

    .featured-button i {
        margin-left: 0.5rem;
        transition: var(--transition);
    }

    .featured-card:hover .featured-content {
        background: linear-gradient(45deg, rgba(110,142,251,0.98), rgba(74,144,226,0.98));
    }

    .featured-card:hover .featured-icon {
        transform: scale(1.1);
    }

    .featured-card:hover .featured-button {
        background: rgba(255,255,255,0.3);
    }

    .featured-card:hover .featured-button i {
        transform: translateX(5px);
    }

    @media (max-width: 768px) {
        .featured-card .category-card-image {
            padding-top: 33.33%; /* 3:1 aspect ratio */
        }

        .featured-title {
            font-size: 1.75rem;
        }

        .featured-icon {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 576px) {
        .featured-card .category-card-image {
            padding-top: 50%; /* 2:1 aspect ratio */
        }

        .featured-title {
            font-size: 1.5rem;
        }

        .featured-icon {
            font-size: 2rem;
        }

        .featured-button {
            padding: 0.6rem 1.2rem;
        }
    }

    /* Kategori Kartları */
    .category-card {
        background: var(--light-color);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--box-shadow);
        text-decoration: none;
        color: var(--dark-color);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
    }

    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .category-card-image {
        position: relative;
        padding-top: 66.67%; /* 3:2 aspect ratio */
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
        transition: var(--transition);
    }

    .category-card:hover .category-card-bg {
        transform: scale(1.1);
    }

    .category-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, 
            rgba(0,0,0,0.8) 0%,
            rgba(0,0,0,0.4) 50%,
            rgba(0,0,0,0.1) 100%);
        opacity: 0;
        transition: var(--transition);
        display: flex;
        align-items: flex-end;
        padding: 1.5rem;
    }

    .category-card:hover .category-card-overlay {
        opacity: 1;
    }

    .overlay-content {
        color: var(--light-color);
        transform: translateY(20px);
        transition: var(--transition);
        width: 100%;
    }

    .category-card:hover .overlay-content {
        transform: translateY(0);
    }

    .image-count {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .image-count i {
        margin-right: 0.5rem;
    }

    .view-category {
        display: block;
        font-weight: 500;
        font-size: 1rem;
    }

    .view-category i {
        margin-left: 0.5rem;
        transition: var(--transition);
    }

    .category-card:hover .view-category i {
        transform: translateX(5px);
    }

    .category-card-content {
        padding: 1.5rem;
        background: var(--light-color);
        flex-grow: 1;
    }

    .category-card-content h3 {
        margin: 0 0 0.5rem;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark-color);
    }

    .category-card-content p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--secondary-color);
        line-height: 1.5;
    }

    /* Responsive Tasarım */
    @media (max-width: 768px) {
        .category-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .gallery-header {
            margin-bottom: 3rem;
        }

        .gallery-header h1 {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 576px) {
        .category-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .gallery-header h1 {
            font-size: 2rem;
        }

        .category-card-content {
            padding: 1rem;
        }
    }
    </style>

    <!-- Lightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <!-- Masonry JS -->
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    
    <script>
        // Initialize Fancybox
        document.addEventListener('DOMContentLoaded', function() {
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
            
            // Set search input value from URL parameter if exists
            const urlParams = new URLSearchParams(window.location.search);
            const searchParam = urlParams.get('search');
            if (searchParam) {
                const searchInput = document.getElementById('searchInput');
                if (searchInput) {
                    searchInput.value = searchParam;
                }
            }
            
            // Initialize Masonry for search results
            let msnry = null;
            const searchResultsContainer = document.getElementById('searchResultsContainer');
            
            if (searchResultsContainer) {
                // View Switching
                document.querySelectorAll('.view-options button').forEach(button => {
                    button.addEventListener('click', () => {
                        document.querySelectorAll('.view-options button').forEach(btn => btn.classList.remove('active'));
                        button.classList.add('active');
                        
                        if (button.dataset.view === 'masonry') {
                            searchResultsContainer.classList.add('masonry-layout');
                            initMasonry();
                        } else {
                            searchResultsContainer.classList.remove('masonry-layout');
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
                        
                        const items = Array.from(document.querySelectorAll('.gallery-image-item'));
                        items.sort((a, b) => {
                            if (button.dataset.sort === 'title') {
                                const titleA = a.querySelector('h3').textContent.trim();
                                const titleB = b.querySelector('h3').textContent.trim();
                                return titleA.localeCompare(titleB);
                            } else if (button.dataset.sort === 'oldest') {
                                return parseInt(a.dataset.date) - parseInt(b.dataset.date);
                            } else {
                                return parseInt(b.dataset.date) - parseInt(a.dataset.date);
                            }
                        });
                        
                        searchResultsContainer.innerHTML = '';
                        items.forEach(item => searchResultsContainer.appendChild(item));
                        
                        if (msnry) {
                            msnry.reloadItems();
                            msnry.layout();
                        }
                    });
                });
                
                function initMasonry() {
                    if (typeof Masonry !== 'undefined') {
                        msnry = new Masonry(searchResultsContainer, {
                            itemSelector: '.gallery-image-item',
                            columnWidth: '.gallery-image-item',
                            percentPosition: true,
                            transitionDuration: '0.3s'
                        });
                    } else {
                        // Masonry yüklenmemişse, yükleyelim
                        const script = document.createElement('script');
                        script.src = 'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js';
                        script.onload = function() {
                            initMasonry();
                        };
                        document.head.appendChild(script);
                    }
                }
            }
        });
    </script>

    <?php include 'includes/footer.php'; ?>
</body>
</html>