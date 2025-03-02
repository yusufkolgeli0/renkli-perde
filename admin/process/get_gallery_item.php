<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

try {
    // ID kontrolü
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id <= 0) {
        throw new Exception('Geçersiz görsel ID\'si.');
    }
    
    // Görseli getir
    $stmt = $db->prepare("SELECT g.*, c.name as category_name 
                         FROM gallery g 
                         LEFT JOIN categories c ON g.category_id = c.id 
                         WHERE g.id = ?");
    $stmt->execute([$id]);
    $gallery = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$gallery) {
        throw new Exception('Görsel bulunamadı.');
    }
    
    // Başarılı yanıt
    echo json_encode([
        'success' => true,
        'data' => $gallery
    ]);

} catch (Exception $e) {
    // Hata durumunda
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 