<?php
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php include 'includes/header.php'; ?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php 
        echo $_SESSION['success_message'];
        unset($_SESSION['success_message']); 
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php 
        echo $_SESSION['error_message'];
        unset($_SESSION['error_message']); 
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="container-fluid py-4">
    <!-- İstatistik Kartları -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold text-muted">Toplam Görsel</p>
                                <h5 class="font-weight-bolder mb-0" id="totalImages">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Yükleniyor...</span>
                                    </div>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-images text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold text-muted">Toplam Kategori</p>
                                <h5 class="font-weight-bolder mb-0" id="totalCategories">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Yükleniyor...</span>
                                    </div>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="fas fa-folder text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold text-muted">Son Eklenen</p>
                                <h5 class="font-weight-bolder mb-0" id="lastUpload">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Yükleniyor...</span>
                                    </div>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="fas fa-clock text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold text-muted">Disk Kullanımı</p>
                                <h5 class="font-weight-bolder mb-0" id="diskUsage">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Yükleniyor...</span>
                                    </div>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="fas fa-hdd text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Başlık ve Yeni Ekle Butonu -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Galeri Yönetimi</h5>
                            <p class="text-sm mb-0 text-muted">Tüm görselleri bu sayfadan yönetebilirsiniz.</p>
                        </div>
                        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
                            <i class="fas fa-plus me-2"></i> Yeni Görsel Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted"><i class="fas fa-filter me-2"></i>Kategori Filtresi</label>
                            <select class="form-select" id="categoryFilter">
                                <option value="">Tüm Kategoriler</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted"><i class="fas fa-search me-2"></i>Arama</label>
                            <input type="text" class="form-control" id="searchFilter" placeholder="Başlık veya açıklama ara...">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted"><i class="fas fa-sort me-2"></i>Sıralama</label>
                            <select class="form-select" id="sortFilter">
                                <option value="newest">En Yeni</option>
                                <option value="oldest">En Eski</option>
                                <option value="name">İsme Göre</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Galeri Grid -->
    <div class="row g-4" id="galleryGrid">
        <!-- Görseller JavaScript ile doldurulacak -->
    </div>
</div>

<!-- Yeni Görsel Ekleme Modalı -->
<div class="modal fade" id="addGalleryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Görsel Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="galleryForm" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="galleryId">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="title">Başlık *</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="category_id">Kategori *</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Kategori Seçin</option>
                                    <!-- Kategoriler JavaScript ile doldurulacak -->
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Açıklama</label>
                                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="image">Görseller *</label>
                                <input type="file" class="form-control" id="image" name="images[]" accept="image/*" required multiple>
                                <small class="text-muted">Önerilen boyut: 1200x800px. Birden fazla görsel seçebilirsiniz.</small>
                            </div>
                            <div id="imagePreview" class="mt-3 row g-2">
                                <!-- Görsel önizlemeleri burada gösterilecek -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" onclick="saveGalleryItem()">Kaydet</button>
            </div>
        </div>
    </div>
</div>

<!-- Görsel Düzenleme Modalı -->
<div class="modal fade" id="editGalleryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Görseli Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editGalleryForm" enctype="multipart/form-data">
                    <input type="hidden" name="edit_id" id="editGalleryId">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="editTitle">Başlık *</label>
                                <input type="text" class="form-control" id="editTitle" name="title" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="editCategory">Kategori *</label>
                                <select class="form-control" id="editCategory" name="category_id" required>
                                    <option value="">Kategori Seçin</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="editDescription">Açıklama</label>
                                <textarea class="form-control" id="editDescription" name="description" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="editImage">Yeni Görsel</label>
                                <input type="file" class="form-control" id="editImage" name="image" accept="image/*">
                                <small class="text-muted">Sadece yeni görsel eklemek istiyorsanız seçin</small>
                            </div>
                            <div id="editImagePreview" class="mt-3 text-center">
                                <img src="" alt="Current Image" style="max-width: 100%; height: auto; border-radius: 8px;">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary" onclick="updateGalleryItem()">Güncelle</button>
            </div>
        </div>
    </div>
</div>

<style>
.gallery-card {
    position: relative;
    margin-bottom: 30px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.gallery-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.gallery-card-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    padding: 20px;
    color: white;
}

.gallery-card-title {
    font-size: 1.2rem;
    margin: 0;
    font-weight: 600;
}

.gallery-card-category {
    font-size: 0.9rem;
    opacity: 0.8;
    margin: 5px 0;
}

.gallery-card-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    gap: 5px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-card:hover .gallery-card-actions {
    opacity: 1;
}

.gallery-card-actions button {
    padding: 8px;
    border-radius: 50%;
    border: none;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.9);
    color: #333;
    cursor: pointer;
    transition: all 0.3s ease;
}

.gallery-card-actions button:hover {
    background: white;
    transform: scale(1.1);
}

.gallery-card-actions .edit-btn:hover {
    color: #2196F3;
}

.gallery-card-actions .delete-btn:hover {
    color: #F44336;
}

#imagePreview img, #editImagePreview img {
    max-height: 300px;
    width: auto;
}

.empty-gallery-message {
    text-align: center;
    padding: 40px;
    background: #f8f9fa;
    border-radius: 12px;
    margin: 20px 0;
}

.empty-gallery-message i {
    font-size: 3rem;
    color: #dee2e6;
    margin-bottom: 15px;
}

.empty-gallery-message p {
    font-size: 1.1rem;
    color: #6c757d;
    margin: 0;
}

.preview-image-container {
    position: relative;
    margin-bottom: 10px;
}

.preview-image-container img {
    border: 2px solid #dee2e6;
}

.preview-image-container .btn-danger {
    padding: 2px 6px;
    font-size: 12px;
    opacity: 0.8;
}

.preview-image-container .btn-danger:hover {
    opacity: 1;
}

.card {
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,.1);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 0 20px rgba(0,0,0,.15);
}

.icon-shape {
    width: 48px;
    height: 48px;
    background-position: center;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-gradient-primary {
    background: linear-gradient(45deg, #4e73df, #224abe);
}

.bg-gradient-success {
    background: linear-gradient(45deg, #1cc88a, #13855c);
}

.bg-gradient-warning {
    background: linear-gradient(45deg, #f6c23e, #dda20a);
}

.bg-gradient-info {
    background: linear-gradient(45deg, #36b9cc, #258391);
}

.icon-shape i {
    color: white;
}

.form-select, .form-control {
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    border-radius: 0.5rem;
    box-shadow: 0 1px 2px rgba(0,0,0,.05);
}

.form-select:focus, .form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78,115,223,.25);
}

.btn-primary {
    background: linear-gradient(45deg, #4e73df, #224abe);
    border: none;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #224abe, #1a3a97);
    transform: translateY(-2px);
}

.gallery-card {
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0,0,0,.1);
}

.gallery-card img {
    border-radius: 1rem 1rem 0 0;
}

.gallery-card-overlay {
    border-radius: 0 0 1rem 1rem;
}

.gallery-card-actions button {
    width: 40px;
    height: 40px;
    backdrop-filter: blur(5px);
}

.empty-gallery-message {
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    border-radius: 1rem;
    padding: 3rem;
}

.empty-gallery-message i {
    font-size: 4rem;
    color: #4e73df;
    margin-bottom: 1.5rem;
}

#imagePreview {
    gap: 1rem;
}

.preview-image-container {
    border-radius: 0.75rem;
    overflow: hidden;
}

.modal-content {
    border: none;
    border-radius: 1rem;
}

.modal-header {
    background: linear-gradient(45deg, #4e73df, #224abe);
    color: white;
    border-radius: 1rem 1rem 0 0;
}

.modal-header .btn-close {
    color: white;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.text-muted {
    color: #6c757d !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadStats();
    loadCategories();
    loadGallery();
    setupImagePreviews();
    setupFilters();
});

function setupImagePreviews() {
    // Yeni görsel ekleme önizlemesi
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        handleImagePreview(this, preview);
    });

    // Düzenleme görsel önizlemesi
    document.getElementById('editImage').addEventListener('change', function(e) {
        const preview = document.getElementById('editImagePreview');
        const img = preview.querySelector('img');
        handleSingleImagePreview(this, img, preview);
    });
}

function handleImagePreview(input, previewContainer) {
    previewContainer.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            const previewDiv = document.createElement('div');
            previewDiv.className = 'col-3 position-relative';
            
            reader.onload = function(e) {
                previewDiv.innerHTML = `
                    <div class="preview-image-container">
                        <img src="${e.target.result}" alt="Preview ${index + 1}" 
                             class="img-fluid rounded" style="width: 100%; height: 40px; object-fit: cover;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" 
                                onclick="removeImage(${index}, this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            }
            
            reader.readAsDataURL(file);
            previewContainer.appendChild(previewDiv);
        });
        
        previewContainer.style.display = 'flex';
    }
}

function removeImage(index, button) {
    const input = document.getElementById('image');
    const container = button.closest('.col-3');
    
    // FileList'i Array'e çevir ve seçili dosyayı kaldır
    const dt = new DataTransfer();
    const files = Array.from(input.files);
    files.splice(index, 1);
    files.forEach(file => dt.items.add(file));
    input.files = dt.files;
    
    // Önizleme görselini kaldır
    container.remove();
    
    // Tüm görseller kaldırıldıysa preview container'ı gizle
    if (input.files.length === 0) {
        document.getElementById('imagePreview').style.display = 'none';
    }
}

function handleSingleImagePreview(input, img, preview) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function loadCategories() {
    fetch('process/get_categories.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const categories = data.data;
                updateCategorySelects(categories);
            }
        })
        .catch(error => console.error('Error:', error));
}

function updateCategorySelects(categories) {
    const selects = ['category_id', 'editCategory', 'categoryFilter'];
    selects.forEach(selectId => {
        const select = document.getElementById(selectId);
        if (select) {
            select.innerHTML = '<option value="">Kategori Seçin</option>';
            categories.forEach(category => {
                select.innerHTML += `
                    <option value="${category.id}">${category.name}</option>
                `;
            });
        }
    });
}

function loadGallery() {
    const categoryId = document.getElementById('categoryFilter').value;
    const search = document.getElementById('searchFilter').value;
    const sort = document.getElementById('sortFilter').value;

    fetch(`process/get_gallery.php?category=${categoryId}&search=${search}&sort=${sort}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayGallery(data.data);
            }
        })
        .catch(error => console.error('Error:', error));
}

function displayGallery(items) {
    const container = document.getElementById('galleryGrid');
    container.innerHTML = '';

    if (items.length === 0) {
        container.innerHTML = `
            <div class="col-12">
                <div class="empty-gallery-message">
                    <i class="fas fa-images"></i>
                    <p>Henüz görsel eklenmemiş.</p>
                </div>
            </div>
        `;
        return;
    }

    items.forEach(item => {
        container.innerHTML += `
            <div class="col-md-4 col-lg-3">
                <div class="gallery-card">
                    <img src="../images/${item.image}" alt="${item.title}">
                    <div class="gallery-card-overlay">
                        <h3 class="gallery-card-title">${item.title}</h3>
                        <div class="gallery-card-category">${item.category_name || 'Kategorisiz'}</div>
                    </div>
                    <div class="gallery-card-actions">
                        <button class="edit-btn" onclick="editGalleryItem(${item.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="delete-btn" onclick="deleteGalleryItem(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
}

function setupFilters() {
    const filters = ['categoryFilter', 'searchFilter', 'sortFilter'];
    filters.forEach(filterId => {
        document.getElementById(filterId).addEventListener('change', loadGallery);
    });

    document.getElementById('searchFilter').addEventListener('keyup', debounce(loadGallery, 300));
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function saveGalleryItem() {
    const form = document.getElementById('galleryForm');
    const formData = new FormData(form);
    
    // Form verilerini kontrol et
    const title = formData.get('title');
    const category = formData.get('category_id');
    const images = document.getElementById('image').files;

    if (!title) {
        showAlert('Lütfen başlık giriniz.', 'error');
        return;
    }

    if (!category) {
        showAlert('Lütfen kategori seçiniz.', 'error');
        return;
    }

    if (images.length === 0) {
        showAlert('Lütfen en az bir görsel seçiniz.', 'error');
        return;
    }

    // Yükleme başladı
    const saveButton = document.querySelector('[onclick="saveGalleryItem()"]');
    const originalText = saveButton.innerHTML;
    saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Yükleniyor...';
    saveButton.disabled = true;

    // Her bir görsel için ayrı bir kayıt oluştur
    const totalImages = images.length;
    let processedImages = 0;
    let successCount = 0;

    Array.from(images).forEach((file, index) => {
        const singleFormData = new FormData();
        singleFormData.append('title', title + (totalImages > 1 ? ` (${index + 1}/${totalImages})` : ''));
        singleFormData.append('description', formData.get('description'));
        singleFormData.append('category_id', category);
        singleFormData.append('image', file);

        fetch('process/save_gallery.php', {
            method: 'POST',
            body: singleFormData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                successCount++;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            processedImages++;
            
            // Tüm görseller işlendiyse
            if (processedImages === totalImages) {
                if (successCount > 0) {
                    $('#addGalleryModal').modal('hide');
                    form.reset();
                    document.getElementById('imagePreview').style.display = 'none';
                    loadGallery();
                    showAlert(`${successCount} görsel başarıyla yüklendi.`, 'success');
                } else {
                    showAlert('Görseller yüklenirken bir hata oluştu.', 'error');
                }
                
                // Yükleme bitti
                saveButton.innerHTML = originalText;
                saveButton.disabled = false;
            }
        });
    });
}

function editGalleryItem(id) {
    fetch(`process/get_gallery_item.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = data.data;
                document.getElementById('editGalleryId').value = item.id;
                document.getElementById('editTitle').value = item.title;
                document.getElementById('editCategory').value = item.category_id;
                document.getElementById('editDescription').value = item.description || '';
                document.getElementById('editImagePreview').querySelector('img').src = `../images/${item.image}`;
                $('#editGalleryModal').modal('show');
            }
        })
        .catch(error => console.error('Error:', error));
}

function updateGalleryItem() {
    const form = document.getElementById('editGalleryForm');
    const formData = new FormData(form);

    fetch('process/update_gallery.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#editGalleryModal').modal('hide');
            loadGallery();
            showAlert('Görsel başarıyla güncellendi.', 'success');
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Bir hata oluştu!', 'error');
    });
}

function deleteGalleryItem(id) {
    if (confirm('Bu görseli silmek istediğinizden emin misiniz?')) {
        fetch(`process/delete_gallery.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadGallery();
                showAlert('Görsel başarıyla silindi.', 'success');
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Bir hata oluştu!', 'error');
        });
    }
}

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alertDiv.style.zIndex = '9999';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

// İstatistik verilerini yükle
function loadStats() {
    fetch('process/get_gallery_stats.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('totalImages').textContent = data.total_images;
                document.getElementById('totalCategories').textContent = data.total_categories;
                document.getElementById('lastUpload').textContent = data.last_upload;
                document.getElementById('diskUsage').textContent = data.disk_usage;
            }
        })
        .catch(error => console.error('Error:', error));
}
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?> 
</html> 