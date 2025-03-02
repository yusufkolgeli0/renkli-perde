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

    <div class="page-header">
        <div class="container">
            <h1>Galeri</h1>
            <p>En güzel perde tasarımlarımızı keşfedin</p>
        </div>
    </div>

    <section class="gallery">
        <div class="container">
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="images/perde1.jpg" alt="Perde 1">
                    <div class="gallery-item-info">
                        <h3>Modern Tasarım 1</h3>
                        <p>Şık ve modern tasarım</p>
                    </div>
                </div>

                <div class="gallery-item">
                    <img src="images/perde2.jpg" alt="Perde 2">
                    <div class="gallery-item-info">
                        <h3>Klasik Tasarım 1</h3>
                        <p>Zarif ve klasik tasarım</p>
                    </div>
                </div>

                <div class="gallery-item">
                    <img src="images/perde3.jpg" alt="Perde 3">
                    <div class="gallery-item-info">
                        <h3>Zebra Perde 1</h3>
                        <p>Modern zebra perde</p>
                    </div>
                </div>

                <div class="gallery-item">
                    <img src="images/perde4.jpg" alt="Perde 4">
                    <div class="gallery-item-info">
                        <h3>Modern Tasarım 2</h3>
                        <p>Çağdaş ve şık tasarım</p>
                    </div>
                </div>

                <div class="gallery-item">
                    <img src="images/perde5.jpg" alt="Perde 5">
                    <div class="gallery-item-info">
                        <h3>Klasik Tasarım 2</h3>
                        <p>Göz alıcı klasik tasarım</p>
                    </div>
                </div>

                <div class="gallery-item">
                    <img src="images/perde6.jpg" alt="Perde 6">
                    <div class="gallery-item-info">
                        <h3>Zebra Perde 2</h3>
                        <p>Fonksiyonel zebra perde</p>
                    </div>
                </div>

                <div class="gallery-item">
                    <img src="images/perde7.jpg" alt="Perde 7">
                    <div class="gallery-item-info">
                        <h3>Modern Tasarım 3</h3>
                        <p>Lüks modern tasarım</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script>
    let currentCategoryId = new URLSearchParams(window.location.search).get('category') || null;

    document.addEventListener('DOMContentLoaded', function() {
        loadCategories();
    });

    function loadCategories() {
        fetch('admin/process/get_categories.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const container = document.getElementById('categoryList');
                    container.innerHTML = `
                        <div class="category-item ${!currentCategoryId ? 'active' : ''}" onclick="filterGallery(null)">
                            <div class="category-info">
                                <h4>Tüm Kategoriler</h4>
                            </div>
                        </div>
                    `;
                    
                    data.data.forEach(category => {
                        container.innerHTML += `
                            <div class="category-item ${currentCategoryId === category.id.toString() ? 'active' : ''}" 
                                 onclick="filterGallery(${category.id})">
                                <img src="${category.image ? 'images/categories/' + category.image : 'images/no-image.jpg'}" 
                                     alt="${category.name}">
                                <div class="category-info">
                                    <h4>${category.name}</h4>
                                    <p>${category.description || ''}</p>
                                </div>
                            </div>
                        `;
                    });
                    
                    // Load gallery items after categories are loaded
                    loadGallery();
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function filterGallery(categoryId) {
        currentCategoryId = categoryId;
        
        // Update URL without reloading the page
        const url = new URL(window.location);
        if (categoryId) {
            url.searchParams.set('category', categoryId);
        } else {
            url.searchParams.delete('category');
        }
        window.history.pushState({}, '', url);
        
        // Update active state in category list
        document.querySelectorAll('.category-item').forEach(item => {
            item.classList.remove('active');
        });
        
        const selectedCategory = categoryId 
            ? document.querySelector(`.category-item[onclick="filterGallery(${categoryId})"]`)
            : document.querySelector('.category-item');
            
        if (selectedCategory) {
            selectedCategory.classList.add('active');
        }
        
        loadGallery();
    }
    </script>
</body>
</html> 