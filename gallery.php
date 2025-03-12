<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Category Filter -->
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h3 class="card-title mb-0">Kategoriler</h3>
                </div>
                <div class="card-body">
                    <div class="category-list" id="categoryList">
                        <!-- Categories will be loaded dynamically -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="col-md-9">
            <div class="gallery-grid" id="galleryGrid">
                <!-- Gallery items will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<style>
.category-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.category-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.category-item:hover {
    background: #f8f9fa;
}

.category-item.active {
    background: #e9ecef;
}

.category-item img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 4px;
    margin-right: 10px;
}

.category-info h4 {
    margin: 0;
    font-size: 1rem;
}

.category-info p {
    margin: 0;
    font-size: 0.8rem;
    color: #6c757d;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
}

.gallery-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.gallery-item:hover {
    transform: translateY(-5px);
}

.gallery-item img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.gallery-item-overlay {
    position: absolute;
    bottom: -100%;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.85);
    color: #fff;
    padding: 15px;
    transition: bottom 0.3s ease;
}

.gallery-item:hover .gallery-item-overlay {
    bottom: 0;
}

.gallery-item-overlay h3 {
    font-size: 1.1rem;
    margin-bottom: 5px;
}

.gallery-item-overlay p {
    font-size: 0.9rem;
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        padding: 15px;
    }
}

@media (max-width: 576px) {
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
        padding: 10px;
    }
}
</style>

<script>
let currentCategoryId = null;

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
                        <div class="category-item ${currentCategoryId === category.id ? 'active' : ''}" 
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

function loadGallery() {
    const url = currentCategoryId 
        ? `admin/process/get_gallery_items.php?category_id=${currentCategoryId}`
        : 'admin/process/get_gallery_items.php';
        
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById('galleryGrid');
                container.innerHTML = '';
                
                if (data.data.length === 0) {
                    container.innerHTML = '<div class="col-12 text-center"><p>Bu kategoride henüz görsel bulunmuyor.</p></div>';
                    return;
                }
                
                data.data.forEach(item => {
                    container.innerHTML += createGalleryItem(item);
                });
            }
        })
        .catch(error => console.error('Error:', error));
}

function createGalleryItem(item) {
    console.log('Item:', item); // Debug için
    
    let imagePath;
    if (item.image_missing) {
        imagePath = 'images/no-image.jpg';
    } else {
        imagePath = item.image.startsWith('category_') ? 
            `images/categories/${item.image}` : 
            `images/${item.image}`;
    }
    
    return `
        <div class="gallery-item">
            <img src="${imagePath}" 
                 alt="${item.title}"
                 loading="lazy"
                 onerror="this.src='images/no-image.jpg'">
            <div class="gallery-item-overlay">
                <h3>${item.title || ''}</h3>
                ${item.description ? `<p>${item.description}</p>` : ''}
                ${item.category_name ? `<small class="text-muted">${item.category_name}</small>` : ''}
            </div>
        </div>
    `;
}

function filterGallery(categoryId) {
    currentCategoryId = categoryId;
    
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

<?php include 'includes/footer.php'; ?> 