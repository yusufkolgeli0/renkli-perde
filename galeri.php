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
                <div class="categories-wrapper">
                    <h3 class="categories-title">Kategoriler</h3>
                    <div class="categories-list" id="categoryList">
                        <div class="category-item active" data-category="all">
                            <span>Tüm Kategoriler</span>
                        </div>
                        <!-- Kategoriler dinamik olarak buraya yüklenecek -->
                    </div>
                </div>
            </div>

            <!-- Galeri Grid -->
            <div class="col-md-9">
                <div class="row g-4" id="galleryGrid">
                    <!-- Galeri öğeleri dinamik olarak buraya yüklenecek -->
                </div>
            </div>
        </div>
    </div>

    <style>
    .categories-wrapper {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .categories-title {
        font-size: 1.2rem;
        color: #333;
        padding: 20px;
        margin: 0;
        border-bottom: 1px solid #eee;
    }

    .categories-list {
        padding: 15px 0;
    }

    .category-item {
        padding: 12px 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        color: #555;
        position: relative;
    }

    .category-item:hover {
        background: #f8f9fa;
        color: #007bff;
    }

    .category-item.active {
        background: #f8f9fa;
        color: #007bff;
        font-weight: 500;
    }

    .category-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #007bff;
    }

    .category-item span {
        margin-left: 10px;
    }

    .gallery-item {
        margin-bottom: 20px;
    }

    .gallery-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
    }

    .gallery-card:hover {
        transform: translateY(-5px);
    }

    .gallery-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .gallery-info {
        padding: 15px;
    }

    .gallery-title {
        font-size: 1.1rem;
        color: #333;
        margin: 0 0 5px 0;
    }

    .gallery-category {
        font-size: 0.9rem;
        color: #666;
    }

    @media (max-width: 768px) {
        .categories-wrapper {
            margin-bottom: 20px;
        }
        
        .categories-list {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding: 10px;
            -webkit-overflow-scrolling: touch;
        }
        
        .category-item {
            flex: 0 0 auto;
            padding: 8px 15px;
            margin-right: 10px;
            border-radius: 20px;
            background: #f8f9fa;
            white-space: nowrap;
        }
        
        .category-item.active {
            background: #007bff;
            color: #fff;
        }
        
        .category-item.active::before {
            display: none;
        }
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        loadCategories();
        loadGallery();
    });

    function loadCategories() {
        fetch('admin/process/get_categories.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const categoryList = document.getElementById('categoryList');
                    const urlParams = new URLSearchParams(window.location.search);
                    const currentCategory = urlParams.get('category') || 'all';

                    data.data.forEach(category => {
                        const isActive = currentCategory === category.id.toString();
                        categoryList.innerHTML += `
                            <div class="category-item ${isActive ? 'active' : ''}" 
                                 data-category="${category.id}"
                                 onclick="filterGallery(${category.id})">
                                <span>${category.name}</span>
                            </div>
                        `;
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function filterGallery(categoryId) {
        // Update active state
        document.querySelectorAll('.category-item').forEach(item => {
            item.classList.remove('active');
        });
        
        const selectedCategory = categoryId === null ? 
            document.querySelector('[data-category="all"]') :
            document.querySelector(`[data-category="${categoryId}"]`);
            
        if (selectedCategory) {
            selectedCategory.classList.add('active');
        }

        // Update URL
        const url = new URL(window.location);
        if (categoryId) {
            url.searchParams.set('category', categoryId);
        } else {
            url.searchParams.delete('category');
        }
        window.history.pushState({}, '', url);

        loadGallery();
    }

    function loadGallery() {
        const urlParams = new URLSearchParams(window.location.search);
        const categoryId = urlParams.get('category');
        
        let url = 'admin/process/get_gallery_items.php';
        if (categoryId && categoryId !== 'all') {
            url += `?category_id=${categoryId}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const galleryGrid = document.getElementById('galleryGrid');
                    galleryGrid.innerHTML = '';

                    if (data.data.length === 0) {
                        galleryGrid.innerHTML = `
                            <div class="col-12">
                                <div class="alert alert-info">
                                    Bu kategoride henüz görsel bulunmuyor.
                                </div>
                            </div>
                        `;
                        return;
                    }

                    data.data.forEach(item => {
                        galleryGrid.innerHTML += `
                            <div class="col-md-4">
                                <div class="gallery-card">
                                    <img src="images/${item.image}" 
                                         class="gallery-image" 
                                         alt="${item.title}">
                                    <div class="gallery-info">
                                        <h3 class="gallery-title">${item.title}</h3>
                                        <div class="gallery-category">${item.category_name}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    }
    </script>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 