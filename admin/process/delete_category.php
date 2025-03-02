<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

header('Content-Type: application/json');

try {
    // ID kontrolü
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id <= 0) {
        throw new Exception('Geçersiz kategori ID\'si.');
    }
    
    // Kategori kontrolü
    $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$category) {
        throw new Exception('Kategori bulunamadı.');
    }
    
    // İlişkili görselleri kontrol et
    $stmt = $db->prepare("SELECT COUNT(*) FROM gallery WHERE category_id = ?");
    $stmt->execute([$id]);
    $imageCount = $stmt->fetchColumn();
    
    if ($imageCount > 0) {
        throw new Exception('Bu kategoriye ait görseller bulunduğu için silinemez.');
    }
    
    // Kategori görselini sil
    if ($category['image'] && file_exists('../../images/categories/' . $category['image'])) {
        unlink('../../images/categories/' . $category['image']);
    }
    
    // Kategoriyi sil
    $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    
    // Başarılı yanıt
    echo json_encode([
        'success' => true,
        'message' => 'Kategori başarıyla silindi.'
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