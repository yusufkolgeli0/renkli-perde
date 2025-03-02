<?php include 'includes/header.php'; ?>

<div class="gallery-management container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title mb-0">Galeri Yönetimi</h2>
            <button class="btn btn-primary" onclick="toggleUploadForm()">
                <i class="fas fa-plus"></i> Yeni Görsel Ekle
            </button>
        </div>

        <!-- Upload Form -->
        <div id="uploadForm" style="display: none;" class="upload-form">
            <form action="process/upload_image.php" method="POST" enctype="multipart/form-data" id="imageUploadForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Görsel Seçin</label>
                            <input type="file" id="image" name="image" class="form-control image-upload" accept="image/*" required>
                        </div>
                        <div class="image-preview-container text-center mb-3">
                            <img src="" alt="Önizleme" id="imagePreview" class="image-preview img-fluid rounded" style="display: none; max-height: 200px;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Başlık</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Açıklama</label>
                            <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select id="category" name="category_id" class="form-select" required>
                                <option value="">Kategori Seçin</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group text-end">
                    <button type="button" class="btn btn-secondary" onclick="toggleUploadForm()">İptal</button>
                    <button type="submit" class="btn btn-primary ms-2">Yükle</button>
                </div>
            </form>
        </div>

        <!-- Gallery Grid -->
        <div class="gallery-grid admin-gallery" id="galleryContainer">
            <!-- Gallery items will be loaded dynamically -->
        </div>
    </div>
</div>

<style>
.gallery-management {
    padding: 20px;
}

.upload-form {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 5px;
    margin-bottom: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
    height: 200px;
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
    margin-bottom: 10px;
}

.gallery-item-actions {
    display: flex;
    gap: 10px;
}

.btn-edit, .btn-delete {
    padding: 5px 10px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-edit {
    background: #ffc107;
    color: #000;
}

.btn-delete {
    background: #dc3545;
    color: #fff;
}

.btn-edit:hover, .btn-delete:hover {
    transform: scale(1.05);
}

.image-preview-container {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 4px;
    border: 2px dashed #dee2e6;
}

@media (max-width: 768px) {
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        padding: 15px;
    }
    
    .gallery-item-overlay {
        padding: 10px;
    }
    
    .gallery-item-overlay h3 {
        font-size: 1rem;
    }
    
    .gallery-item-overlay p {
        font-size: 0.8rem;
    }
}

@media (max-width: 576px) {
    .gallery-management {
        padding: 10px;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
        padding: 10px;
    }
}
</style>

<script>
// Toggle upload form
function toggleUploadForm() {
    const form = document.getElementById('uploadForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

// Initialize the gallery
document.addEventListener('DOMContentLoaded', function() {
    loadGallery();
    setupImagePreview();
    loadCategoryOptions();
});

function loadGallery() {
    fetch('process/get_gallery_items.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('galleryContainer');
            container.innerHTML = '';
            
            data.forEach(item => {
                container.innerHTML += createGalleryItem(item);
            });
            
            // Add event listeners for edit and delete buttons
            setupGalleryActions();
        })
        .catch(error => console.error('Error loading gallery:', error));
}

function createGalleryItem(item) {
    return `
        <div class="gallery-item" data-id="${item.id}">
            <img src="../images/${item.image}" alt="${item.title}">
            <div class="gallery-item-overlay">
                <h3>${item.title}</h3>
                <p>${item.description}</p>
                <div class="gallery-item-actions">
                    <button class="btn btn-edit" onclick="editItem(${item.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-delete" onclick="deleteItem(${item.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
}

function setupGalleryActions() {
    // Form submission
    document.getElementById('imageUploadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('process/upload_image.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Görsel başarıyla yüklendi!');
                this.reset();
                document.getElementById('imagePreview').style.display = 'none';
                toggleUploadForm();
                loadGallery();
            } else {
                alert('Hata: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Bir hata oluştu!');
        });
    });
}

function editItem(id) {
    // Implement edit functionality
    console.log('Edit item:', id);
}

function deleteItem(id) {
    if (confirm('Bu görseli silmek istediğinizden emin misiniz?')) {
        fetch(`process/delete_image.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadGallery();
            } else {
                alert('Hata: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function loadCategoryOptions() {
    fetch('process/get_categories.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('category');
                const currentValue = select.value;
                
                // Clear existing options except the first one
                while (select.options.length > 1) {
                    select.remove(1);
                }
                
                // Add new options
                data.data.forEach(category => {
                    const option = new Option(category.name, category.id);
                    select.add(option);
                });
                
                // Restore selected value if it exists
                if (currentValue) {
                    select.value = currentValue;
                }
            }
        })
        .catch(error => console.error('Error:', error));
}
</script>

<?php include 'includes/footer.php'; ?> 