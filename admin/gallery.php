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

<style>
.gallery-masonry {
    columns: 8 140px;
    column-gap: 0.75rem;
    padding: 0.75rem;
    margin: 0 auto;
    max-width: 1800px;
}

.gallery-item {
    break-inside: avoid;
    margin-bottom: 0.75rem;
    display: inline-block;
    width: 100%;
    max-width: 200px;
}

.gallery-item .card {
    border: none;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    margin-bottom: 0;
    background: #fff;
}

.gallery-item .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.gallery-item .card-img-top {
    aspect-ratio: 1;
    height: 140px;
    object-fit: cover;
    width: 100%;
}

.gallery-item .card-body {
    padding: 0.5rem;
}

.gallery-item .card-title {
    font-size: 0.8rem;
    margin-bottom: 0.25rem;
    line-height: 1.2;
}

.gallery-item .card-text {
    font-size: 0.75rem;
    margin-bottom: 0;
    line-height: 1.2;
}

.gallery-item .btn-icon-only {
    width: 28px;
    height: 28px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
    background: rgba(255, 255, 255, 0.9);
    opacity: 0;
    transition: all 0.3s ease;
}

.empty-gallery-message {
    text-align: center;
    padding: 3rem;
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    border-radius: 12px;
    margin: 1rem;
}

.empty-gallery-message i {
    font-size: 3rem;
    color: #4e73df;
    margin-bottom: 1rem;
}

.empty-gallery-message p {
    font-size: 1.1rem;
    color: #6c757d;
    margin: 0;
}

/* Tab stilleri */
.nav-tabs {
    border: none;
    margin-bottom: 1rem;
    flex-wrap: nowrap;
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
    padding-bottom: 5px;
}

.nav-tabs::-webkit-scrollbar {
    display: none;
}

.nav-tabs .nav-item {
    margin: 0 0.25rem;
    white-space: nowrap;
}

.nav-tabs .nav-link {
    border: none;
    background: #f8f9fa;
    color: #6c757d;
    padding: 0.75rem 1.25rem;
    border-radius: 50px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
    background: #e9ecef;
    color: #4e73df;
}

.nav-tabs .nav-link.active {
    background: #4e73df;
    color: white;
}

.category-count {
    background: rgba(0,0,0,0.1);
    padding: 0.2rem 0.6rem;
    border-radius: 50px;
    font-size: 0.75rem;
    margin-left: 0.5rem;
}

/* Responsive düzenlemeler */
@media (min-width: 1600px) {
    .gallery-masonry {
        columns: 10 140px;
    }
}

@media (max-width: 1599px) {
    .gallery-masonry {
        columns: 8 140px;
    }
}

@media (max-width: 1399px) {
    .gallery-masonry {
        columns: 7 140px;
    }
}

@media (max-width: 1199px) {
    .gallery-masonry {
        columns: 6 140px;
    }
}

@media (max-width: 991px) {
    .gallery-masonry {
        columns: 5 140px;
    }
}

@media (max-width: 767px) {
    .gallery-masonry {
        columns: 4 140px;
    }
    
    .gallery-item .card-img-top {
        height: 140px;
    }
}

@media (max-width: 575px) {
    .gallery-masonry {
        columns: 3 140px;
    }
    
    .gallery-item .card-img-top {
        height: 140px;
    }
    
    .gallery-item .card-body {
        padding: 0.5rem;
    }
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

function loadGalleryByCategories(categories) {
    // Tüm görselleri yükle
    fetch('process/get_gallery.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const items = data.data;
                
                // Tüm görselleri ana grid'e ekle
                displayGalleryItems('galleryGrid', items);
                document.querySelector('#all-tab .category-count').textContent = `(${items.length})`;
                
                // Kategorilere göre görselleri dağıt
                categories.forEach(category => {
                    const categoryItems = items.filter(item => item.category_id === category.id);
                    displayGalleryItems(`gallery-cat-${category.id}`, categoryItems);
                    document.querySelector(`#cat-${category.id}-tab .category-count`).textContent = 
                        `(${categoryItems.length})`;
                });
            }
        })
        .catch(error => console.error('Error:', error));
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
                        <img src="../images/uploads/${item.image}" class="card-img-top" alt="${item.title}"
                             loading="lazy" onerror="this.src='assets/img/placeholder.jpg'">
                        <div class="position-absolute top-0 end-0 p-2">
                            <button class="btn btn-icon-only btn-light btn-sm rounded-circle shadow-sm me-1" 
                                    onclick="editGalleryItem(${item.id})" title="Düzenle">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-icon-only btn-light btn-sm rounded-circle shadow-sm" 
                                    onclick="deleteGalleryItem(${item.id})" title="Sil">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-truncate mb-1" title="${item.title}">${item.title}</h5>
                        <p class="text-muted small mb-2">${item.category_name || 'Kategorisiz'}</p>
                        ${item.description ? `<p class="card-text small text-truncate" title="${item.description}">${item.description}</p>` : ''}
                    </div>
                </div>
            </div>
        `;
    });
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
                    console.log('Görseller yüklenirken bir hata oluştu.');
                    console.log(data);
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