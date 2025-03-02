<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

header('Content-Type: application/json');

try {
    // Form verilerini al
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
    
    // Zorunlu alan kontrolleri
    if (empty($title)) {
        throw new Exception('Başlık boş olamaz.');
    }
    
    if ($category_id <= 0) {
        throw new Exception('Lütfen bir kategori seçin.');
    }
    
    // Kategori kontrolü
    $stmt = $db->prepare("SELECT id FROM categories WHERE id = ?");
    $stmt->execute([$category_id]);
    if (!$stmt->fetch()) {
        throw new Exception('Seçilen kategori bulunamadı.');
    }
    
    // Görsel yükleme işlemi
    $image_name = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Dosya boyutu kontrolü (max 5MB)
        if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
            throw new Exception('Görsel boyutu 5MB\'dan büyük olamaz.');
        }

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['image']['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime_type, $allowed_types)) {
            throw new Exception('Sadece JPG, PNG ve GIF formatları desteklenmektedir.');
        }
        
        // Benzersiz dosya adı oluştur
        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $image_name = uniqid('gallery_') . '.' . $extension;
        $upload_path = '../../images/' . $image_name;
        
        // Dizin kontrolü
        $upload_dir = '../../images';
        if (!file_exists($upload_dir)) {
            if (!mkdir($upload_dir, 0777, true)) {
                throw new Exception('Dizin oluşturulamadı.');
            }
        }
        
        if (!is_writable($upload_dir)) {
            throw new Exception('Dizin yazılabilir değil.');
        }
        
        // Dosyayı yükle
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
            throw new Exception('Görsel yüklenirken bir hata oluştu. Hata kodu: ' . $_FILES['image']['error']);
        }
    }
    
    // Veritabanı işlemi
    if ($id > 0) {
        // Güncelleme
        if ($image_name) {
            // Eski görseli sil
            $stmt = $db->prepare("SELECT image FROM gallery WHERE id = ?");
            $stmt->execute([$id]);
            $old_image = $stmt->fetchColumn();
            if ($old_image && file_exists('../../images/' . $old_image)) {
                unlink('../../images/' . $old_image);
            }
            
            // Yeni görsel ile güncelle
            $stmt = $db->prepare("UPDATE gallery SET title = ?, description = ?, category_id = ?, image = ? WHERE id = ?");
            $stmt->execute([$title, $description, $category_id, $image_name, $id]);
        } else {
            // Görsel olmadan güncelle
            $stmt = $db->prepare("UPDATE gallery SET title = ?, description = ?, category_id = ? WHERE id = ?");
            $stmt->execute([$title, $description, $category_id, $id]);
        }
    } else {
        // Yeni kayıt için görsel zorunlu
        if (!$image_name) {
            throw new Exception('Lütfen bir görsel seçin.');
        }
        
        // Yeni kayıt
        $stmt = $db->prepare("INSERT INTO gallery (title, description, category_id, image, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$title, $description, $category_id, $image_name]);
    }
    
    // Başarılı yanıt
    echo json_encode([
        'success' => true,
        'message' => 'Görsel başarıyla kaydedildi.'
    ]);

} catch (Exception $e) {
    // Hata durumunda
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 