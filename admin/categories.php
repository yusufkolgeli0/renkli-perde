<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title mb-0">Kategori Ekle</h3>
                </div>
                <div class="card-body">
                    <form id="categoryForm" action="process/save_category.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="categoryId">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Kategori Adı</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Açıklama</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Kategori Görseli</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="image-preview-container mt-2" style="display: none;">
                                <img src="" alt="Önizleme" id="imagePreview" class="img-fluid rounded">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">Temizle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title mb-0">Kategoriler</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Görsel</th>
                                    <th>Kategori Adı</th>
                                    <th>Açıklama</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody id="categoriesList">
                                <!-- Categories will be loaded dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.category-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}

.image-preview-container {
    max-width: 200px;
    margin-top: 10px;
}

#imagePreview {
    max-width: 100%;
    height: auto;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadCategories();
    setupImagePreview();
});

function setupImagePreview() {
    const imageInput = document.getElementById('image');
    const previewContainer = document.querySelector('.image-preview-container');
    const preview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });
}

function loadCategories() {
    fetch('process/get_categories.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tbody = document.getElementById('categoriesList');
                tbody.innerHTML = '';
                
                data.data.forEach(category => {
                    tbody.innerHTML += `
                        <tr>
                            <td>
                                <img src="${category.image ? '../images/categories/' + category.image : '../images/no-image.jpg'}" 
                                     alt="${category.name}" 
                                     class="category-image">
                            </td>
                            <td>${category.name}</td>
                            <td>${category.description || '-'}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editCategory(${category.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteCategory(${category.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }
        })
        .catch(error => console.error('Error:', error));
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
                
                if (category.image) {
                    document.querySelector('.image-preview-container').style.display = 'block';
                    document.getElementById('imagePreview').src = '../images/categories/' + category.image;
                }
            }
        })
        .catch(error => console.error('Error:', error));
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
            } else {
                alert('Hata: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function resetForm() {
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryId').value = '';
    document.querySelector('.image-preview-container').style.display = 'none';
}

// Form submission
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
            alert('Kategori başarıyla kaydedildi.');
            resetForm();
            loadCategories();
        } else {
            alert('Hata: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Bir hata oluştu!');
    });
});
</script>

<?php include 'includes/footer.php'; ?> 