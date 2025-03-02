<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

try {
    // Arama terimi
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    
    // Sorgu oluştur
    $query = "SELECT c.*, 
              (SELECT COUNT(*) FROM gallery WHERE category_id = c.id) as image_count 
              FROM categories c";
    
    $params = [];
    if ($search) {
        $query .= " WHERE c.name LIKE ? OR c.description LIKE ?";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
    }
    
    $query .= " ORDER BY c.name ASC";
    
    // Sorguyu çalıştır
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Başarılı yanıt
    echo json_encode([
        'success' => true,
        'data' => $categories
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