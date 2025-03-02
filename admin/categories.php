<?php include 'includes/header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Kategori Formu -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0" id="formTitle">Yeni Kategori Ekle</h3>
                </div>
                <div class="card-body">
                    <form id="categoryForm" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="categoryId">
                        <div class="form-group mb-3">
                            <label for="name">Kategori Adı *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Açıklama</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="image">Kategori Görseli</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Önerilen boyut: 800x600px</small>
                            <div id="imagePreview" class="mt-3 text-center" style="display: none;">
                                <img src="" alt="Preview" style="max-width: 100%; height: auto; border-radius: 8px;">
                            </div>
                        </div>
                        <div class="form-group d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="fas fa-save"></i> Kaydet
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Temizle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Kategori Listesi -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Kategoriler</h3>
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control" id="searchInput" placeholder="Kategori ara...">
                            <button class="btn btn-outline-secondary" type="button" onclick="searchCategories()">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">Görsel</th>
                                    <th>Kategori Adı</th>
                                    <th>Açıklama</th>
                                    <th style="width: 120px;">Görsel Sayısı</th>
                                    <th style="width: 100px;">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody id="categoriesList">
                                <!-- Kategoriler dinamik olarak yüklenecek -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.table th {
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
}

.category-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-icon {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.btn-icon:hover {
    transform: translateY(-2px);
}

.category-count {
    font-weight: 600;
    color: #6c757d;
}

.empty-message {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.empty-message i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #dee2e6;
}

#imagePreview img {
    max-height: 200px;
    width: auto;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.category-description {
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

@media (max-width: 768px) {
    .category-description {
        max-width: 150px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadCategories();
    setupImagePreview();
    setupSearchInput();
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
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
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
                const tbody = document.getElementById('categoriesList');
                tbody.innerHTML = '';
                
                if (data.data.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5">
                                <div class="empty-message">
                                    <i class="fas fa-folder-open"></i>
                                    <p>Henüz kategori eklenmemiş.</p>
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }
                
                data.data.forEach(category => {
                    tbody.innerHTML += `
                        <tr>
                            <td>
                                <img src="${category.image ? '../images/categories/' + category.image : '../images/no-image.jpg'}" 
                                     alt="${category.name}" 
                                     class="category-image">
                            </td>
                            <td>${category.name}</td>
                            <td>
                                <div class="category-description" title="${category.description || ''}">
                                    ${category.description || '-'}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="category-count">${category.image_count || 0}</span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-icon btn-warning" onclick="editCategory(${category.id})" title="Düzenle">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-icon btn-danger" onclick="deleteCategory(${category.id})" title="Sil">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Kategoriler yüklenirken bir hata oluştu.', 'error');
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

document.getElementById('categoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('process/save_category.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Kategori başarıyla kaydedildi.', 'success');
            resetForm();
            loadCategories();
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Bir hata oluştu!', 'error');
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