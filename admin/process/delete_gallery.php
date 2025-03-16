<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

try {
    // ID kontrolü
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id <= 0) {
        throw new Exception('Geçersiz görsel ID\'si.');
    }
    
    // Görsel kontrolü
    $stmt = $db->prepare("SELECT * FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $gallery = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$gallery) {
        throw new Exception('Görsel bulunamadı.');
    }
    
    // Görseli sil
    if ($gallery['image'] && file_exists('../../images/uploads/' . $gallery['image'])) {
        unlink('../../images/uploads/' . $gallery['image']);
    }
    
    // Veritabanından sil
    $stmt = $db->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    
    // Başarılı yanıt
    echo json_encode([
        'success' => true,
        'message' => 'Görsel başarıyla silindi.'
    ]);

} catch (Exception $e) {
    // Hata durumunda
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 