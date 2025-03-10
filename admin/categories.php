<?php include 'includes/header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Kategori Formu -->
        <div class="col-12 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-gradient-dark p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-white mb-0" id="formTitle">
                            <i class="fas fa-folder-plus me-2"></i>
                            <span>Yeni Kategori Ekle</span>
                        </h5>
                        <div class="form-switch">
                            <input class="form-check-input" type="checkbox" id="autoReset" checked>
                            <label class="form-check-label text-white small" for="autoReset">Otomatik Temizle</label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="categoryForm" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="categoryId">
                        
                        <div class="form-group mb-4">
                            <label class="form-label d-flex justify-content-between">
                                <span>
                                    <i class="fas fa-tag me-2"></i>
                                    Kategori Adı <span class="text-danger">*</span>
                                </span>
                                <small class="text-muted" id="nameCount">0/100</small>
                            </label>
                            <input type="text" class="form-control" id="name" name="name" required 
                                   minlength="2" maxlength="100" placeholder="Örn: Salon Perdesi">
                            <div class="invalid-feedback">Kategori adı en az 2 karakter olmalıdır.</div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label d-flex justify-content-between">
                                <span>
                                    <i class="fas fa-align-left me-2"></i>
                                    Açıklama
                                </span>
                                <small class="text-muted" id="descriptionCount">0/500</small>
                            </label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="3" maxlength="500" placeholder="Kategori hakkında kısa bir açıklama yazın"></textarea>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fas fa-image me-2"></i>
                                    Kategori Görseli
                                </span>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    Maks. 2MB
                                </small>
                            </label>
                            <div class="drop-zone">
                                <input type="file" name="image" id="image" class="drop-zone__input" accept="image/*">
                                <div class="drop-zone__content">
                                    <i class="fas fa-cloud-upload-alt mb-2"></i>
                                    <span>Sürükle bırak veya seç</span>
                                </div>
                            </div>
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <div class="position-relative">
                                    <img src="" alt="Önizleme" class="img-preview">
                                    <button type="button" class="btn-remove-image" onclick="removeImage()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-grid gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <span class="button-text">
                                    <i class="fas fa-save me-2"></i> Kaydet
                                </span>
                            </button>
                            <button type="button" class="btn btn-light" onclick="resetForm()">
                                <i class="fas fa-undo me-2"></i> Temizle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Kategori Listesi -->
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header bg-white p-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <h5 class="mb-0">
                            <i class="fas fa-folder me-2"></i>
                            Kategoriler
                        </h5>
                        <div class="input-group" style="width: 300px;">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" 
                                   id="searchInput" placeholder="Kategori ara...">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4" id="categoriesList">
                        <!-- Kategoriler dinamik olarak yüklenecek -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,.05);
    height: 100%;
}

.form-control {
    padding: 0.75rem 1rem;
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78,115,223,.15);
}

.drop-zone {
    border: 2px dashed #e9ecef;
    border-radius: 0.5rem;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.2s ease;
    background: #f8f9fa;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 120px;
}

.drop-zone:hover {
    border-color: #4e73df;
    background: rgba(78,115,223,.05);
}

.drop-zone__content {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #6c757d;
}

.drop-zone__content i {
    font-size: 1.5rem;
}

.drop-zone__content span {
    font-size: 0.9rem;
}

.drop-zone__input {
    display: none;
}

.img-preview {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 0.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}

.btn-remove-image {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: rgba(255,255,255,.9);
    border: none;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #dc3545;
    transition: all 0.2s ease;
}

.btn-remove-image:hover {
    background: #dc3545;
    color: white;
    transform: scale(1.1);
}

.category-card {
    border-radius: 0.75rem;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    position: relative;
    background: #fff;
}

.category-card.no-image {
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    min-height: 200px;
}

.category-card.no-image .category-card-overlay {
    background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.4));
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,.1);
}

.category-card img {
    height: 200px;
    object-fit: cover;
    width: 100%;
}

.category-card-overlay {
    background: linear-gradient(to top, rgba(0,0,0,0.9), rgba(0,0,0,0.5), transparent);
    padding: 1.5rem;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    color: white;
}

.category-card-title {
    font-size: 1.1rem;
    margin: 0 0 0.5rem 0;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.category-card-count {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 0.5rem;
}

.category-description {
    font-size: 0.85rem;
    opacity: 0.8;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}

.category-card-actions {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.category-card:hover .category-card-actions {
    opacity: 1;
}

.btn-icon {
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    background: white;
    border: none;
    box-shadow: 0 2px 5px rgba(0,0,0,.2);
}

.btn-icon:hover {
    transform: scale(1.1);
}

.btn-icon.edit:hover {
    background: #ffc107;
    color: white;
}

.btn-icon.delete:hover {
    background: #dc3545;
    color: white;
}

.empty-categories {
    padding: 4rem 2rem;
    text-align: center;
}

.empty-categories i {
    font-size: 5rem;
    color: #e9ecef;
    margin-bottom: 1.5rem;
}

#imagePreview img {
    border-radius: 0.5rem;
    box-shadow: 0 5px 15px rgba(0,0,0,.1);
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.invalid-feedback {
    font-size: 0.875rem;
}

.bg-gradient-dark {
    background: linear-gradient(45deg, #1a1c23, #3a3b45);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadCategories();
    setupImagePreview();
    setupSearchInput();
    setupDropZone();
    setupCharacterCount();
});

function setupSearchInput() {
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', debounce(searchCategories, 300));
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

function searchCategories() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    loadCategories(searchTerm);
}

function setupImagePreview() {
    const input = document.getElementById('image');
    const preview = document.getElementById('imagePreview');
    const img = preview.querySelector('img');

    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            preview.style.display = 'none';
        }
    });
}

function loadCategories(searchTerm = '') {
    console.log('Loading categories with search term:', searchTerm);
    
    fetch(`process/get_categories.php${searchTerm ? '?search=' + searchTerm : ''}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Categories data:', data);
            
            if (data.success) {
                const container = document.getElementById('categoriesList');
                container.innerHTML = '';
                
                if (data.data.length === 0) {
                    container.innerHTML = `
                        <div class="col-12">
                            <div class="empty-categories">
                                <i class="fas fa-folder-open"></i>
                                <p>Henüz kategori eklenmemiş.</p>
                            </div>
                        </div>
                    `;
                    return;
                }
                
                data.data.forEach(category => {
                    container.innerHTML += `
                        <div class="col-md-6 col-lg-4">
                            <div class="category-card shadow ${!category.image ? 'no-image' : ''}">
                                ${category.image ? `
                                    <img src="../images/categories/${category.image}" 
                                         alt="${category.name}">
                                ` : ''}
                                <div class="category-card-overlay">
                                    <h3 class="category-card-title">${category.name}</h3>
                                    <div class="category-card-count">
                                        <i class="fas fa-image me-1"></i> ${category.image_count || 0} Görsel
                                    </div>
                                    <div class="category-description">${category.description || ''}</div>
                                </div>
                                <div class="category-card-actions">
                                    <button class="btn-icon edit" onclick="editCategory(${category.id})" title="Düzenle">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-icon delete" onclick="deleteCategory(${category.id})" title="Sil">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                console.error('API returned success: false', data);
                showAlert('Kategoriler yüklenirken bir hata oluştu.', 'error');
            }
        })
        .catch(error => {
            console.error('Error loading categories:', error);
            showAlert('Kategoriler yüklenirken bir hata oluştu: ' + error.message, 'error');
        });
}

function editCategory(id) {
    fetch(`process/get_category.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const category = data.data;
                document.getElementById('categoryId').value = category.id;
                document.getElementById('name').value = category.name;
                document.getElementById('description').value = category.description || '';
                document.getElementById('formTitle').textContent = 'Kategori Düzenle';
                
                if (category.image) {
                    const preview = document.getElementById('imagePreview');
                    preview.querySelector('img').src = `../images/categories/${category.image}`;
                    preview.style.display = 'block';
                }
                
                // Forma scroll
                document.querySelector('.card').scrollIntoView({ behavior: 'smooth' });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Kategori bilgileri yüklenirken bir hata oluştu.', 'error');
        });
}

function deleteCategory(id) {
    if (confirm('Bu kategoriyi silmek istediğinizden emin misiniz?')) {
        fetch(`process/delete_category.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadCategories();
                showAlert('Kategori başarıyla silindi.', 'success');
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Kategori silinirken bir hata oluştu.', 'error');
        });
    }
}

function resetForm() {
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryId').value = '';
    document.getElementById('formTitle').textContent = 'Yeni Kategori Ekle';
    const imagePreview = document.getElementById('imagePreview');
    imagePreview.style.display = 'none';
    imagePreview.querySelector('img').src = '';
}

function setupDropZone() {
    const dropZone = document.querySelector('.drop-zone');
    const input = dropZone.querySelector('.drop-zone__input');

    dropZone.addEventListener('click', () => input.click());

    input.addEventListener('change', (e) => {
        if (input.files.length) {
            updateDropZone(input.files[0]);
        }
    });

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('drag-over');
    });

    ['dragleave', 'dragend'].forEach(type => {
        dropZone.addEventListener(type, (e) => {
            dropZone.classList.remove('drag-over');
        });
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('drag-over');

        if (e.dataTransfer.files.length) {
            input.files = e.dataTransfer.files;
            updateDropZone(e.dataTransfer.files[0]);
        }
    });
}

function updateDropZone(file) {
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById('imagePreview');
            preview.querySelector('img').src = e.target.result;
            preview.style.display = 'block';
            document.querySelector('.drop-zone').style.display = 'none';
        };
        reader.readAsDataURL(file);
    } else {
        showAlert('Lütfen geçerli bir görsel dosyası seçin.', 'error');
    }
}

function removeImage() {
    const input = document.getElementById('image');
    const preview = document.getElementById('imagePreview');
    input.value = '';
    preview.style.display = 'none';
    preview.querySelector('img').src = '';
    document.querySelector('.drop-zone').style.display = 'flex';
}

function setupCharacterCount() {
    const name = document.getElementById('name');
    const nameCounter = document.getElementById('nameCount');
    const description = document.getElementById('description');
    const descriptionCounter = document.getElementById('descriptionCount');

    function updateCount(element, counter, max) {
        const count = element.value.length;
        counter.textContent = `${count}/${max}`;
        counter.classList.toggle('text-danger', count > max - 10);
    }

    name.addEventListener('input', () => updateCount(name, nameCounter, 100));
    description.addEventListener('input', () => updateCount(description, descriptionCounter, 500));
}

document.getElementById('categoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const buttonText = submitBtn.querySelector('.button-text');
    const formData = new FormData(this);
    
    // Form validasyonu
    const name = formData.get('name').trim();
    if (name.length < 2) {
        showAlert('Kategori adı en az 2 karakter olmalıdır.', 'error');
        return;
    }
    
    // Yükleme durumunu göster
    submitBtn.disabled = true;
    buttonText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Kaydediliyor...';
    
    fetch('process/save_category.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            buttonText.innerHTML = '<i class="fas fa-check me-2"></i> Kaydedildi';
            
            showAlert('Kategori başarıyla kaydedildi.', 'success');
            if (document.getElementById('autoReset').checked) {
                resetForm();
            }
            loadCategories();
            
            // Reset button state after 2 seconds
            setTimeout(() => {
                buttonText.innerHTML = '<i class="fas fa-save me-2"></i> Kaydet';
            }, 2000);
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Bir hata oluştu!', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        if (!data.success) {
            buttonText.innerHTML = '<i class="fas fa-save me-2"></i> Kaydet';
        }
    });
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
</script>

<?php include 'includes/footer.php'; ?> 