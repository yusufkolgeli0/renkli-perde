<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

try {
    // Filtreleri al
    $category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
    
    // Sorgu oluştur
    $query = "SELECT g.*, c.name as category_name 
              FROM gallery g 
              LEFT JOIN categories c ON g.category_id = c.id 
              WHERE 1=1";
    
    $params = [];
    
    // Kategori filtresi
    if ($category_id > 0) {
        $query .= " AND g.category_id = ?";
        $params[] = $category_id;
    }
    
    // Arama filtresi
    if ($search) {
        $query .= " AND (g.title LIKE ? OR g.description LIKE ?)";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
    }
    
    // Sıralama
    switch ($sort) {
        case 'oldest':
            $query .= " ORDER BY g.created_at ASC";
            break;
        case 'name':
            $query .= " ORDER BY g.title ASC";
            break;
        default: // newest
            $query .= " ORDER BY g.created_at DESC";
    }
    
    // Sorguyu çalıştır
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
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
?> 