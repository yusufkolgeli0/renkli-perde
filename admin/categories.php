<?php include 'includes/header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Kategori Formu -->
        <div class="col-12 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-gradient-dark p-3">
                    <h5 class="text-white mb-0" id="formTitle">
                        <i class="fas fa-folder-plus me-2"></i>
                        <span>Yeni Kategori Ekle</span>
                    </h5>
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

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                <span class="button-text">
                                    <i class="fas fa-save me-2"></i> Kaydet
                                </span>
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
                    <div id="categoriesList">
                        <!-- Kategoriler dinamik olarak yüklenecek -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-color: #4361ee;
    --secondary-color: #3f37c9;
    --success-color: #4bb543;
    --danger-color: #dc3545;
    --background-color: #f8f9fa;
    --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --transition-speed: 0.3s;
}

.card {
    border: none;
    box-shadow: var(--card-shadow);
    border-radius: 1rem;
    transition: transform var(--transition-speed), box-shadow var(--transition-speed);
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.form-control {
    padding: 0.875rem 1.125rem;
    border: 2px solid #e9ecef;
    border-radius: 0.75rem;
    transition: all var(--transition-speed);
    font-size: 0.95rem;
    width: 100%;
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 500;
    transition: all var(--transition-speed);
}

.btn-primary {
    background: var(--primary-color);
    border: none;
}

.btn-primary:hover {
    background: var(--secondary-color);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
}

.drop-zone {
    border: 2px dashed #e9ecef;
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    transition: all var(--transition-speed);
    background: var(--background-color);
    cursor: pointer;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.drop-zone:hover {
    border-color: var(--primary-color);
    background: rgba(67, 97, 238, 0.05);
}

.drop-zone::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(67, 97, 238, 0.1);
    transform: scale(0);
    border-radius: 1rem;
    transition: transform 0.3s ease;
}

.drop-zone:hover::before {
    transform: scale(1);
}

.drop-zone__content {
    position: relative;
    z-index: 1;
}

.drop-zone__content i {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.drop-zone__content span {
    font-size: 1rem;
    color: #6b7280;
}

.img-preview {
    width: 100%;
    height: 300px;
    object-fit: contain;
    border-radius: 1rem;
    box-shadow: var(--card-shadow);
    transition: all var(--transition-speed);
    background: var(--background-color);
    padding: 1rem;
}

#imagePreview {
    position: relative;
    background: var(--background-color);
    border-radius: 1rem;
    padding: 1rem;
    box-shadow: var(--card-shadow);
    transition: all var(--transition-speed);
}

#imagePreview:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.btn-remove-image {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: white;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--danger-color);
    transition: all var(--transition-speed);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    z-index: 10;
}

.category-card {
    border-radius: 1rem;
    overflow: hidden;
    transition: all var(--transition-speed);
    height: 240px;
    position: relative;
    background: white;
    box-shadow: var(--card-shadow);
    margin-bottom: 1.5rem;
    cursor: pointer;
}

.category-card.no-image {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 1rem;
}

.category-card.no-image::before {
    content: '\f07b';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    font-size: 3rem;
    color: #adb5bd;
}

.category-card.no-image::after {
    content: attr(data-name);
    color: #495057;
    font-size: 1.1rem;
    font-weight: 500;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 25px -5px rgba(0, 0, 0, 0.1);
}

.category-card img {
    height: 240px;
    object-fit: cover;
    width: 100%;
    transition: transform var(--transition-speed);
}

.category-card:hover img {
    transform: scale(1.1);
}

.category-card-overlay {
    background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.2) 100%);
    padding: 1.25rem;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    color: white;
    transform: translateY(0);
    transition: all var(--transition-speed);
}

.category-card:hover .category-card-overlay {
    background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.7) 50%, rgba(0,0,0,0.3) 100%);
}

.category-card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.category-card-count {
    font-size: 0.85rem;
    opacity: 0.9;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.category-card-count i {
    font-size: 0.9rem;
    color: var(--primary-color);
}

.category-description {
    font-size: 0.9rem;
    opacity: 0.8;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}

.category-card-actions {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    display: flex;
    gap: 0.5rem;
    opacity: 0;
    transform: translateY(-10px);
    transition: all var(--transition-speed);
    z-index: 10;
}

.category-card:hover .category-card-actions {
    opacity: 1;
    transform: translateY(0);
}

.btn-action {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: all var(--transition-speed);
    background: rgba(255, 255, 255, 0.9);
    color: #6b7280;
    backdrop-filter: blur(8px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.btn-action:hover {
    transform: translateY(-2px);
}

.btn-action.edit:hover {
    background: var(--primary-color);
    color: white;
}

.btn-action.delete:hover {
    background: var(--danger-color);
    color: white;
}

.btn-action i {
    font-size: 1rem;
}

/* Categories grid layout */
#categoriesList {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
    padding: 0.5rem;
}

@media (max-width: 768px) {
    #categoriesList {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .category-card {
        height: 200px;
    }
    
    .category-card img {
        height: 200px;
    }
    
    .category-card-overlay {
        padding: 1rem;
    }
}

/* Empty state styling */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--background-color);
    border-radius: 1.25rem;
    border: 2px dashed #e9ecef;
}

.empty-state i {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1.5rem;
}

.empty-state p {
    font-size: 1.1rem;
    color: #6c757d;
    margin-bottom: 0;
}

/* Form validation styles */
.form-control.is-invalid {
    border-color: var(--danger-color);
    background-image: none;
}

.form-control.is-valid {
    border-color: var(--success-color);
    background-image: none;
}

/* Loading states */
.btn-loading {
    position: relative;
    pointer-events: none;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    top: calc(50% - 10px);
    left: calc(50% - 10px);
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Accessibility improvements */
.form-control:focus,
.btn:focus,
.drop-zone:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.25);
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    :root {
        --background-color: #1a1a1a;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
    }
    
    .card {
        background: #2d2d2d;
    }
    
    .form-control {
        background: #2d2d2d;
        border-color: #404040;
        color: #fff;
    }
    
    .drop-zone {
        background: #2d2d2d;
        border-color: #404040;
    }
    
    .drop-zone__content span {
        color: #a0aec0;
    }
    
    #imagePreview {
        background: #2d2d2d;
    }
    
    .img-preview {
        background: #2d2d2d;
    }
}

/* Notification styles */
.notification {
    position: fixed;
    top: 1rem;
    right: 1rem;
    padding: 1rem 1.5rem;
    border-radius: 0.75rem;
    background: white;
    box-shadow: var(--card-shadow);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transform: translateX(150%);
    transition: transform 0.3s ease;
    z-index: 1000;
}

.notification.show {
    transform: translateX(0);
}

.notification.success {
    border-left: 4px solid var(--success-color);
}

.notification.error {
    border-left: 4px solid var(--danger-color);
}

.notification i {
    font-size: 1.25rem;
}

.notification.success i {
    color: var(--success-color);
}

.notification.error i {
    color: var(--danger-color);
}

/* Confirmation Dialog */
.confirm-dialog {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all var(--transition-speed);
    z-index: 1000;
}

.confirm-dialog.show {
    opacity: 1;
    visibility: visible;
}

.confirm-dialog-content {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    width: 90%;
    max-width: 400px;
    transform: translateY(-20px);
    transition: transform var(--transition-speed);
}

.confirm-dialog.show .confirm-dialog-content {
    transform: translateY(0);
}

.confirm-dialog-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.confirm-dialog-actions button {
    flex: 1;
}

@media (prefers-color-scheme: dark) {
    .notification {
        background: #2d2d2d;
        color: white;
    }
    
    .confirm-dialog-content {
        background: #2d2d2d;
        color: white;
    }
    
    .btn-action {
        background: #2d2d2d;
        color: #a0aec0;
    }
}
</style>

<div id="notification" class="notification">
    <i class="fas"></i>
    <span></span>
</div>

<div id="confirmDialog" class="confirm-dialog">
    <div class="confirm-dialog-content">
        <h5 class="mb-3">Kategoriyi Sil</h5>
        <p>Bu kategoriyi silmek istediğinizden emin misiniz?</p>
        <div class="confirm-dialog-actions">
            <button class="btn btn-light" onclick="closeConfirmDialog()">İptal</button>
            <button class="btn btn-danger" onclick="confirmDelete()">Sil</button>
        </div>
    </div>
</div>

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
    fetch(`process/get_categories.php${searchTerm ? '?search=' + searchTerm : ''}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById('categoriesList');
                container.innerHTML = '';
                
                if (data.data.length === 0) {
                    container.innerHTML = `
                        <div style="grid-column: 1 / -1;">
                            <div class="empty-state">
                                <i class="fas fa-folder-open"></i>
                                <p>Henüz kategori eklenmemiş.</p>
                            </div>
                        </div>
                    `;
                    return;
                }
                
                data.data.forEach(category => {
                    container.innerHTML += `
                        <div class="category-card ${!category.image ? 'no-image' : ''}" 
                             ${!category.image ? `data-name="${category.name}"` : ''}>
                            ${category.image ? `
                                <img src="../images/uploads/categories/${category.image}" 
                                     alt="${category.name}"
                                     loading="lazy">
                            ` : ''}
                            <div class="category-card-overlay">
                                <h3 class="category-card-title">${category.name}</h3>
                                <div class="category-card-count">
                                    <i class="fas fa-image"></i>
                                    <span>${category.image_count || 0} Görsel</span>
                                </div>
                                ${category.description ? `
                                    <div class="category-description">${category.description}</div>
                                ` : ''}
                            </div>
                            <div class="category-card-actions">
                                <button class="btn-action edit" onclick="editCategory(${category.id})" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action delete" onclick="showConfirmDialog(${category.id})" title="Sil">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
            } else {
                showNotification('Kategoriler yüklenirken bir hata oluştu.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Kategoriler yüklenirken bir hata oluştu.', 'error');
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
                    preview.querySelector('img').src = `../images/uploads/categories/${category.image}`;
                    preview.style.display = 'block';
                }
                
                // Forma scroll
                document.querySelector('.card').scrollIntoView({ behavior: 'smooth' });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Kategori bilgileri yüklenirken bir hata oluştu.', 'error');
        });
}

let deleteId = null;

function showNotification(message, type) {
    const notification = document.getElementById('notification');
    notification.className = `notification ${type}`;
    notification.querySelector('i').className = `fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}`;
    notification.querySelector('span').textContent = message;
    
    notification.classList.add('show');
    
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}

function showConfirmDialog(id) {
    deleteId = id;
    document.getElementById('confirmDialog').classList.add('show');
}

function closeConfirmDialog() {
    document.getElementById('confirmDialog').classList.remove('show');
    deleteId = null;
}

function confirmDelete() {
    if (deleteId) {
        deleteCategory(deleteId);
        closeConfirmDialog();
    }
}

function deleteCategory(id) {
    fetch(`process/delete_category.php?id=${id}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadCategories();
            showNotification('Kategori başarıyla silindi.', 'success');
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Kategori silinirken bir hata oluştu.', 'error');
    });
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
            preview.style.opacity = '0';
            document.querySelector('.drop-zone').style.display = 'none';
            
            // Smooth fade in animation
            setTimeout(() => {
                preview.style.opacity = '1';
            }, 50);
        };
        reader.readAsDataURL(file);
    } else {
        showNotification('Lütfen geçerli bir görsel dosyası seçin.', 'error');
    }
}

function removeImage() {
    const preview = document.getElementById('imagePreview');
    const dropZone = document.querySelector('.drop-zone');
    
    // Smooth fade out animation
    preview.style.opacity = '0';
    
    setTimeout(() => {
        preview.style.display = 'none';
        preview.querySelector('img').src = '';
        document.getElementById('image').value = '';
        
        // Show drop zone with fade in
        dropZone.style.opacity = '0';
        dropZone.style.display = 'flex';
        setTimeout(() => {
            dropZone.style.opacity = '1';
        }, 50);
    }, 300);
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
    
    if (formData.get('name').trim().length < 2) {
        showNotification('Kategori adı en az 2 karakter olmalıdır.', 'error');
        return;
    }
    
    submitBtn.disabled = true;
    buttonText.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Kaydediliyor...';
    
    fetch('process/save_category.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Kategori başarıyla kaydedildi.', 'success');
            loadCategories();
            resetForm();
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Bir hata oluştu!', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        buttonText.innerHTML = '<i class="fas fa-save me-2"></i> Kaydet';
    });
});

// Smooth search filtering
let searchTimeout;
document.getElementById('searchInput').addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        // Implement your search logic here
        const searchTerm = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.category-card');
        
        cards.forEach(card => {
            const title = card.querySelector('.category-title').textContent.toLowerCase();
            const description = card.querySelector('.category-description')?.textContent.toLowerCase() || '';
            
            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                card.style.display = '';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50);
            } else {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });
    }, 300);
});
</script>

<?php include 'includes/footer.php'; ?> 