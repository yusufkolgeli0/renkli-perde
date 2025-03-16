<?php
include 'includes/header.php';


if (isset($_SESSION['success_message'])): ?>
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

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
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
                        <div class="col-md-8">
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

    <!-- Kategori Tabları -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-3">
                    <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                                Tüm Görseller
                            </button>
                        </li>
                        <!-- Kategori tabları JavaScript ile doldurulacak -->
                    </ul>
                    <div class="tab-content mt-4" id="categoryTabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel">
                            <div class="row gallery-masonry g-4" id="galleryGrid">
                                <!-- Görseller JavaScript ile doldurulacak -->
                            </div>
                        </div>
                        <!-- Kategori içerikleri JavaScript ile doldurulacak -->
                    </div>
                </div>
            </div>
        </div>
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

<!-- Silme Onay Diyalogu -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Görseli Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-exclamation-circle text-warning mb-3" style="font-size: 3rem;"></i>
                <h5 class="mb-3">Emin misiniz?</h5>
                <p class="text-muted mb-0">Bu görseli silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-danger px-4" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Sil
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toplu Silme Onay Diyalogu -->
<div class="modal fade" id="bulkDeleteConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Görselleri Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size: 3rem;"></i>
                <h5 class="mb-3">Toplu Silme İşlemi</h5>
                <p class="text-muted mb-0">Seçili görselleri silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.</p>
                <div class="mt-3 text-primary">
                    <strong class="selected-count">0</strong>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-danger px-4" id="confirmBulkDeleteBtn">
                    <i class="fas fa-trash me-2"></i>Seçilenleri Sil
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bildirim Toast -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="notificationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fas fa-info-circle me-2"></i>
            <strong class="me-auto">Bildirim</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>

<style>
/* Ana stil değişkenleri */
:root {
    --primary-color: #4e73df;
    --success-color: #1cc88a;
    --danger-color: #e74a3b;
    --background-light: #f8f9fc;
    --background-dark: #1a1a1a;
    --text-light: #5a5c69;
    --text-dark: #e9ecef;
    --card-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.gallery-masonry {
    columns: 6 200px;
    column-gap: 1rem;
    padding: 1rem;
    margin: 0 auto;
    max-width: 1800px;
}

.gallery-item {
    break-inside: avoid;
    margin-bottom: 1rem;
    position: relative;
    max-width: 250px;
}

.gallery-item .card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--card-shadow);
    transition: all 0.3s ease;
    margin-bottom: 0;
    background: var(--background-light);
}

.gallery-item .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
}

.gallery-item .card-img-top {
    aspect-ratio: 1;
    height: 200px;
    object-fit: cover;
    width: 100%;
}

.gallery-item .checkbox-wrapper {
    position: absolute;
    top: 10px;
    top: 8px;
    left: 8px;
    z-index: 10;
}

.gallery-item .form-check-input {
    width: 18px;
    height: 18px;
    background-color: rgba(255, 255, 255, 0.9);
    border: 2px solid rgba(255, 255, 255, 0.9);
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.gallery-item .form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.gallery-item .card-actions {
    position: absolute;
    top: 8px;
    right: 8px;
    display: flex;
    gap: 6px;
    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.gallery-item .card:hover .card-actions {
    opacity: 1;
    transform: translateY(0);
}

.gallery-item .btn-action {
    width: 28px;
    height: 28px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(4px);
    border: none;
    color: var(--text-light);
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    font-size: 0.85rem;
}

.gallery-item .btn-action:hover {
    transform: translateY(-2px);
}

.gallery-item .btn-action.edit:hover {
    background: var(--primary-color);
    color: white;
}

.gallery-item .btn-action.delete:hover {
    background: var(--danger-color);
    color: white;
}

.gallery-item .card-body {
    padding: 0.75rem;
}

.gallery-item .card-title {
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 0.4rem;
    color: var(--text-light);
    line-height: 1.3;
}

.gallery-item .category-badge {
    font-size: 0.7rem;
    padding: 3px 6px;
    border-radius: 4px;
    background: rgba(78, 115, 223, 0.1);
    color: var(--primary-color);
    display: inline-block;
    margin-bottom: 0.4rem;
}

.gallery-item .card-text {
    font-size: 0.75rem;
    color: var(--text-light);
    margin: 0;
    line-height: 1.4;
}

/* Responsive düzenlemeler */
@media (min-width: 1600px) {
    .gallery-masonry {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    }
}

@media (max-width: 768px) {
    .gallery-masonry {
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 0.75rem;
        padding: 0.75rem;
    }

    .gallery-item .card-img-top {
        height: 120px;
    }

    .gallery-item .card-body {
        padding: 0.5rem;
    }
}

/* Karanlık mod stilleri */
@media (prefers-color-scheme: dark) {
    :root {
        --background-light: #2d2d2d;
        --text-light: #e9ecef;
        --card-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .gallery-item .card {
        background: var(--background-light);
    }
    
    .gallery-item .card-title,
    .gallery-item .card-text {
        color: var(--text-dark);
    }
    
    .gallery-item .category-badge {
        background: rgba(78, 115, 223, 0.2);
        color: #89CFF0;
    }
    
    .gallery-item .btn-action {
        background: rgba(45, 45, 45, 0.9);
        color: var(--text-dark);
    }
    
    .nav-tabs .nav-link {
        background: var(--background-light);
        color: var(--text-dark);
    }
    
    .nav-tabs .nav-link:hover {
        background: #3d3d3d;
    }
    
    .nav-tabs .nav-link.active {
        background: var(--primary-color);
        color: white;
    }
    
    .modal-content {
        background: var(--background-light);
        color: var(--text-dark);
    }
    
    .text-muted {
        color: #adb5bd !important;
    }
    
    .form-check-input {
        background-color: rgba(45, 45, 45, 0.9);
        border-color: rgba(255, 255, 255, 0.2);
    }
}

/* Bulk Actions Bar */
.bulk-actions-bar {
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%) translateY(100px);
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 1rem 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    gap: 1rem;
    z-index: 1000;
    transition: transform 0.3s ease;
}

.bulk-actions-bar.show {
    transform: translateX(-50%) translateY(0);
}

.bulk-actions-bar .selected-count {
    font-weight: 500;
    color: var(--primary-color);
}

@media (prefers-color-scheme: dark) {
    .bulk-actions-bar {
        background: rgba(45, 45, 45, 0.95);
        color: var(--text-dark);
    }
}

/* Toast Bildirimleri */
.toast {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.toast.success {
    border-left: 4px solid var(--success-color);
}

.toast.error {
    border-left: 4px solid var(--danger-color);
}

@media (prefers-color-scheme: dark) {
    .toast {
        background: var(--background-light);
        color: var(--text-dark);
    }
    
    .toast-header {
        background: #3d3d3d;
        color: var(--text-dark);
    }
}
</style>

<!-- Bulk Actions Bar -->
<div class="bulk-actions-bar">
    <span class="selected-count">0 görsel seçildi</span>
    <button class="btn btn-danger" onclick="showBulkDeleteConfirm()">
        <i class="fas fa-trash me-2"></i>Seçilenleri Sil
    </button>
</div>

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
                updateCategoryTabs(categories);
                loadGalleryByCategories(categories);
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

function updateCategoryTabs(categories) {
    const tabList = document.getElementById('categoryTabs');
    const tabContent = document.getElementById('categoryTabContent');
    
    // Tüm Görseller tab'ını güncelle
    const allTab = tabList.querySelector('#all-tab');
    if (allTab) {
        allTab.innerHTML = `
            Tüm Görseller
            <span class="category-count">(0)</span>
        `;
    }
    
    // Mevcut kategori tablarını temizle (Tüm Görseller hariç)
    Array.from(tabList.children).forEach(tab => {
        if (tab.querySelector('button').id !== 'all-tab') {
            tab.remove();
        }
    });
    
    // Kategori tablarını oluştur
    categories.forEach(category => {
        // Tab butonunu oluştur
        const tabButton = document.createElement('li');
        tabButton.className = 'nav-item';
        tabButton.role = 'presentation';
        tabButton.innerHTML = `
            <button class="nav-link" id="cat-${category.id}-tab" data-bs-toggle="tab" 
                    data-bs-target="#cat-${category.id}" type="button" role="tab">
                ${category.name}
                <span class="category-count">(0)</span>
            </button>
        `;
        tabList.appendChild(tabButton);
        
        // Tab içeriğini oluştur
        const tabPane = document.createElement('div');
        tabPane.className = 'tab-pane fade';
        tabPane.id = `cat-${category.id}`;
        tabPane.role = 'tabpanel';
        tabPane.innerHTML = `
            <div class="row gallery-masonry g-4" id="gallery-cat-${category.id}"></div>
        `;
        tabContent.appendChild(tabPane);
    });
}

async function loadGalleryByCategories(categories) {
    // Yükleniyor göstergesi
    document.querySelectorAll('.gallery-masonry').forEach(grid => {
        grid.innerHTML = '<div class="text-center w-100 py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Yükleniyor...</span></div></div>';
    });

    try {
        const response = await fetch('process/get_gallery.php');
        const data = await response.json();

        if (!data.success) {
            throw new Error('Galeri yüklenemedi');
        }

        const items = data.data;
        
        // Tüm görselleri ana grid'e ekle
        displayGalleryItems('galleryGrid', items);
        const allCountElement = document.querySelector('#all-tab .category-count');
        if (allCountElement) {
            allCountElement.textContent = `(${items.length})`;
        }
        
        // Kategorilere göre görselleri dağıt
        categories.forEach(category => {
            const categoryItems = items.filter(item => item.category_id === category.id);
            displayGalleryItems(`gallery-cat-${category.id}`, categoryItems);
            const countElement = document.querySelector(`#cat-${category.id}-tab .category-count`);
            if (countElement) {
                countElement.textContent = `(${categoryItems.length})`;
            }
        });

        return items;
    } catch (error) {
        console.error('Error loading gallery by categories:', error);
        throw error;
    }
}

async function loadGallery() {
    try {
        // Kategorileri yükle
        const categoryResponse = await fetch('process/get_categories.php');
        const categoryData = await categoryResponse.json();
        
        if (!categoryData.success) {
            throw new Error('Kategoriler yüklenemedi');
        }
        
        const categories = categoryData.data;
        updateCategorySelects(categories);
        updateCategoryTabs(categories);
        
        // Galeriyi yükle
        return await loadGalleryByCategories(categories);
    } catch (error) {
        console.error('Error loading gallery:', error);
        showNotification('Galeri yüklenirken bir hata oluştu.', 'error');
        throw error;
    }
}

function displayGalleryItems(containerId, items) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    container.innerHTML = '';

    if (items.length === 0) {
        container.innerHTML = `
            <div class="empty-gallery-message">
                <i class="fas fa-images"></i>
                <p>Bu kategoride henüz görsel bulunmuyor.</p>
            </div>
        `;
        return;
    }

    items.forEach(item => {
        container.innerHTML += `
            <div class="gallery-item">
                <div class="card">
                    <div class="position-relative">
                        <div class="checkbox-wrapper">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       onchange="handleItemSelection(${item.id}, this)"
                                       ${selectedItems.has(item.id) ? 'checked' : ''}>
                            </div>
                        </div>
                        <img src="../images/uploads/${item.image}" class="card-img-top" alt="${item.title}"
                             loading="lazy" onerror="this.src='assets/img/placeholder.jpg'">
                        <div class="card-actions">
                            <button class="btn-action edit" onclick="editGalleryItem(${item.id})" title="Düzenle">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-action delete" onclick="deleteGalleryItem(${item.id})" title="Sil">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-truncate" title="${item.title}">${item.title}</h5>
                        <span class="category-badge">${item.category_name || 'Kategorisiz'}</span>
                        ${item.description ? `<p class="card-text text-truncate" title="${item.description}">${item.description}</p>` : ''}
                    </div>
                </div>
            </div>
        `;
    });
}

function handleItemSelection(id, checkbox) {
    if (checkbox.checked) {
        selectedItems.add(id);
    } else {
        selectedItems.delete(id);
    }
    updateBulkActionsBar();
}

function updateBulkActionsBar() {
    const count = selectedItems.size;
    const bulkActionsBar = document.querySelector('.bulk-actions-bar');
    
    if (count > 0) {
        bulkActionsBar.classList.add('show');
        document.querySelectorAll('.selected-count').forEach(element => {
            element.textContent = `${count} görsel seçildi`;
        });
    } else {
        bulkActionsBar.classList.remove('show');
    }
}

// Filtre fonksiyonlarını güncelle
function setupFilters() {
    document.getElementById('searchFilter').addEventListener('keyup', debounce(() => {
        const searchTerm = document.getElementById('searchFilter').value.toLowerCase();
        const sortValue = document.getElementById('sortFilter').value;
        
        fetch(`process/get_gallery.php?search=${searchTerm}&sort=${sortValue}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Aktif tab'ı bul
                    const activeTab = document.querySelector('.nav-link.active');
                    const activeTabId = activeTab.getAttribute('data-bs-target').replace('#', '');
                    
                    if (activeTabId === 'all') {
                        displayGalleryItems('galleryGrid', data.data);
                    } else {
                        const categoryId = activeTabId.replace('cat-', '');
                        const filteredItems = data.data.filter(item => 
                            item.category_id === parseInt(categoryId)
                        );
                        displayGalleryItems(`gallery-${activeTabId}`, filteredItems);
                    }
                }
            });
    }, 300));

    document.getElementById('sortFilter').addEventListener('change', () => {
        const searchTerm = document.getElementById('searchFilter').value.toLowerCase();
        const sortValue = document.getElementById('sortFilter').value;
        
        fetch(`process/get_gallery.php?search=${searchTerm}&sort=${sortValue}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadGalleryByCategories(data.categories || []);
                }
            });
    });
}

function saveGalleryItem() {
    const form = document.getElementById('galleryForm');
    const formData = new FormData(form);
    
    // Form kontrollerini yap...
    const title = formData.get('title');
    const category = formData.get('category_id');
    const images = document.getElementById('image').files;

    if (!title || !category || images.length === 0) {
        showNotification('Lütfen tüm gerekli alanları doldurun.', 'error');
        return;
    }

    // Yükleme başladı
    const saveButton = document.querySelector('[onclick="saveGalleryItem()"]');
    const originalText = saveButton.innerHTML;
    saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Yükleniyor...';
    saveButton.disabled = true;

    const totalImages = images.length;
    let successCount = 0;
    let uploadPromises = [];

    Array.from(images).forEach((file, index) => {
        const singleFormData = new FormData();
        singleFormData.append('title', title + (totalImages > 1 ? ` (${index + 1}/${totalImages})` : ''));
        singleFormData.append('description', formData.get('description'));
        singleFormData.append('category_id', category);
        singleFormData.append('image', file);

        const uploadPromise = fetch('process/save_gallery.php', {
            method: 'POST',
            body: singleFormData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                successCount++;
            }
            return data;
        });

        uploadPromises.push(uploadPromise);
    });

    Promise.all(uploadPromises)
        .then(() => {
            if (successCount > 0) {
                // Önce galeriyi güncelle
                return loadGallery().then(() => {
                    $('#addGalleryModal').modal('hide');
                    form.reset();
                    document.getElementById('imagePreview').innerHTML = '';
                    document.getElementById('imagePreview').style.display = 'none';
                    showNotification(`${successCount} görsel başarıyla yüklendi.`, 'success');
                    loadStats(); // İstatistikleri güncelle
                });
            } else {
                throw new Error('Görseller yüklenirken bir hata oluştu.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification(error.message || 'Görseller yüklenirken bir hata oluştu.', 'error');
        })
        .finally(() => {
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
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
                document.getElementById('editImagePreview').querySelector('img').src = `../images/uploads/${item.image}`;
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
            showNotification('Görsel başarıyla güncellendi.', 'success');
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Bir hata oluştu!', 'error');
    });
}

let deleteItemId = null;

function deleteGalleryItem(id) {
    deleteItemId = id;
    const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    modal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
    if (!deleteItemId) return;
    
    const btn = this;
    const originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Siliniyor...';
    
    try {
        const response = await fetch(`process/delete_gallery.php?id=${deleteItemId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        
        if (!data || !data.success) {
            throw new Error(data.message || 'Silme işlemi başarısız oldu.');
        }

        // Modal'ı kapat
        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'));
        if (modal) {
            modal.hide();
        }

        // Galeriyi güncelle
        await loadGallery();
        
        // Bildirimi göster ve istatistikleri güncelle
        showNotification('Görsel başarıyla silindi.', 'success');
        loadStats();

    } catch (error) {
        console.error('Error:', error);
        showNotification(error.message || 'Görsel silinirken bir hata oluştu.', 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
        deleteItemId = null;
    }
});

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

let isSelectMode = false;
let selectedItems = new Set();

function toggleSelectMode() {
    isSelectMode = !isSelectMode;
    document.querySelector('.gallery-masonry').classList.toggle('gallery-select-mode');
    document.querySelector('.bulk-actions').classList.toggle('show');
    if (!isSelectMode) {
        selectedItems.clear();
        updateSelectedCount();
    }
}

function toggleItemSelection(id, element) {
    if (!isSelectMode) return;
    
    const card = element.closest('.card');
    if (selectedItems.has(id)) {
        selectedItems.delete(id);
        card.classList.remove('selected');
    } else {
        selectedItems.add(id);
        card.classList.add('selected');
    }
    updateSelectedCount();
}

function updateSelectedCount() {
    const count = selectedItems.size;
    document.querySelectorAll('.selected-count').forEach(el => {
        el.innerHTML = `<strong>${count}</strong> görsel seçildi`;
    });
}

function cancelSelection() {
    isSelectMode = false;
    selectedItems.clear();
    document.querySelector('.gallery-masonry').classList.remove('gallery-select-mode');
    document.querySelector('.bulk-actions').classList.remove('show');
    document.querySelectorAll('.card.selected').forEach(card => {
        card.classList.remove('selected');
    });
    updateSelectedCount();
}

function showBulkDeleteConfirm() {
    if (selectedItems.size === 0) {
        showNotification('Lütfen silmek istediğiniz görselleri seçin.', 'error');
        return;
    }
    const modal = new bootstrap.Modal(document.getElementById('bulkDeleteConfirmModal'));
    modal.show();
}

document.getElementById('confirmBulkDeleteBtn').addEventListener('click', function() {
    if (selectedItems.size === 0) return;
    
    const btn = this;
    const originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Siliniyor...';
    
    const deletePromises = Array.from(selectedItems).map(id => 
        fetch(`process/delete_gallery.php?id=${id}`, { method: 'DELETE' })
            .then(response => response.json())
    );
    
    Promise.all(deletePromises)
        .then(results => {
            const successCount = results.filter(r => r.success).length;
            bootstrap.Modal.getInstance(document.getElementById('bulkDeleteConfirmModal')).hide();
            
            if (successCount > 0) {
                showNotification(`${successCount} görsel başarıyla silindi.`, 'success');
                loadGallery();
                cancelSelection();
            } else {
                showNotification('Görseller silinirken bir hata oluştu.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Bir hata oluştu.', 'error');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        });
});

function showNotification(message, type = 'success') {
    const toast = document.getElementById('notificationToast');
    toast.classList.remove('success', 'error');
    toast.classList.add(type);
    toast.querySelector('.toast-body').textContent = message;
    
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
}
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?> 
</html> 