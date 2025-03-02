<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

header('Content-Type: application/json');

try {
    $category_id = $_GET['category_id'] ?? null;
    
    $query = "SELECT g.*, c.name as category_name, c.slug as category_slug 
              FROM gallery g 
              LEFT JOIN categories c ON g.category_id = c.id";
              
    if ($category_id) {
        $query .= " WHERE g.category_id = ?";
        $params = [$category_id];
    } else {
        $params = [];
    }
    
    $query .= " ORDER BY g.created_at DESC";
    
    if ($category_id) {
        $stmt = $db->prepare($query);
        $stmt->execute($params);
    } else {
        $stmt = $db->query($query);
    }
    
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $items
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Galeri öğeleri yüklenirken bir hata oluştu.'
    ]);
}
?> 