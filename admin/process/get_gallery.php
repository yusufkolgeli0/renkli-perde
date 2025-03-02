<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

header('Content-Type: application/json');

try {
    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
    
    $query = "SELECT * FROM gallery";
    $params = [];
    
    if ($category_id) {
        $query .= " WHERE category_id = ?";
        $params[] = $category_id;
    }
    
    $query .= " ORDER BY id DESC";
    
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => $items
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 