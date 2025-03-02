<?php include 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title mb-0">Kategori Ekle/Düzenle</h3>
                </div>
                <div class="card-body">
                    <form id="categoryForm" action="process/save_category.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="categoryId">
                        <div class="form-group mb-3">
                            <label for="name">Kategori Adı</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Açıklama</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="image">Kategori Görseli</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div id="imagePreview" class="mt-2" style="display:none;">
                                <img src="" alt="Önizleme" class="img-thumbnail" style="max-height: 150px;">
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
                                <!-- Kategoriler dinamik olarak yüklenecek -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadCategories();
    setupImagePreview();
});

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
                                     style="width: 50px; height: 50px; object-fit: cover;">
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
                    const preview = document.getElementById('imagePreview');
                    preview.querySelector('img').src = `../images/categories/${category.image}`;
                    preview.style.display = 'block';
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
    document.getElementById('imagePreview').style.display = 'none';
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