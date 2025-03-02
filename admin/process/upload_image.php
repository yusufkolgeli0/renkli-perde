<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

header('Content-Type: application/json');

try {
    // Check if file was uploaded
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Dosya yüklenirken bir hata oluştu.');
    }

    $file = $_FILES['image'];
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $category = $_POST['category'] ?? '';

    // Validate inputs
    if (empty($title)) {
        throw new Exception('Başlık alanı zorunludur.');
    }

    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception('Sadece JPG, PNG ve GIF formatları desteklenmektedir.');
    }

    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $uploadPath = '../../images/' . $filename;

    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        throw new Exception('Dosya yüklenirken bir hata oluştu.');
    }

    // Save to database
    $stmt = $db->prepare("INSERT INTO gallery (image, title, description, category, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$filename, $title, $description, $category]);

    echo json_encode([
        'success' => true,
        'message' => 'Görsel başarıyla yüklendi.',
        'data' => [
            'id' => $db->lastInsertId(),
            'image' => $filename,
            'title' => $title,
            'description' => $description,
            'category' => $category
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