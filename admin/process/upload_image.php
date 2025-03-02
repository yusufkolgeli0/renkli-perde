<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

header('Content-Type: application/json');

try {
    // Gerekli alanları kontrol et
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Dosya yüklenirken bir hata oluştu.');
    }

    if (!isset($_POST['category_id']) || empty($_POST['category_id'])) {
        throw new Exception('Kategori seçimi zorunludur.');
    }

    $file = $_FILES['image'];
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $category_id = $_POST['category_id'];

    // Dosya tipini kontrol et
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception('Sadece JPG, PNG ve GIF formatları desteklenmektedir.');
    }

    // Benzersiz dosya adı oluştur
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $uploadPath = '../../images/' . $filename;

    // Dosyayı yükle
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        throw new Exception('Dosya yüklenirken bir hata oluştu.');
    }

    // Kategori adını al
    $stmt = $db->prepare("SELECT name FROM categories WHERE id = ?");
    $stmt->execute([$category_id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    $categoryName = $category ? $category['name'] : '';

    // Veritabanına kaydet
    $stmt = $db->prepare("INSERT INTO gallery (image, title, description, category) VALUES (?, ?, ?, ?)");
    $stmt->execute([$filename, $title, $description, $categoryName]);

    echo json_encode([
        'success' => true,
        'message' => 'Görsel başarıyla yüklendi.',
        'data' => [
            'id' => $db->lastInsertId(),
            'image' => $filename,
            'title' => $title,
            'description' => $description,
            'category' => $categoryName
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>