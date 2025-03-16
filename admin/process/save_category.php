<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

try {
    // Form verilerini al
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    
    // Kategori adı kontrolü
    if (empty($name)) {
        throw new Exception('Kategori adı boş olamaz.');
    }
    
    // Görsel yükleme işlemi
    $image_name = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowed_types)) {
            throw new Exception('Sadece JPG, PNG ve GIF formatları desteklenmektedir.');
        }
        
        // Benzersiz dosya adı oluştur
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = uniqid('category_') . '.' . $extension;
        $upload_path = '../../images/uploads/categories/' . $image_name;
        
        // Dizin kontrolü
        if (!is_dir('../../images/uploads/categories')) {
            mkdir('../../images/uploads/categories', 0777, true);
        }
        
        // Dosyayı yükle
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
            throw new Exception('Görsel yüklenirken bir hata oluştu.');
        }
    }
    
    // Veritabanı işlemi
    if ($id > 0) {
        // Güncelleme
        if ($image_name) {
            // Eski görseli sil
            $stmt = $db->prepare("SELECT image FROM categories WHERE id = ?");
            $stmt->execute([$id]);
            $old_image = $stmt->fetchColumn();
            if ($old_image && file_exists('../../images/uploads/categories/' . $old_image)) {
                unlink('../../images/uploads/categories/' . $old_image);
            }
            
            // Yeni görsel ile güncelle
            $stmt = $db->prepare("UPDATE categories SET name = ?, description = ?, image = ? WHERE id = ?");
            $stmt->execute([$name, $description, $image_name, $id]);
        } else {
            // Görsel olmadan güncelle
            $stmt = $db->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
            $stmt->execute([$name, $description, $id]);
        }
    } else {
        // Yeni kayıt
        $stmt = $db->prepare("INSERT INTO categories (name, description, image) VALUES (?, ?, ?)");
        $stmt->execute([$name, $description, $image_name]);
    }
    
    // Başarılı yanıt
    echo json_encode([
        'success' => true,
        'message' => 'Kategori başarıyla kaydedildi.'
    ]);

} catch (Exception $e) {
    // Hata durumunda
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 