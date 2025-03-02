<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

header('Content-Type: application/json');

try {
    $stmt = $db->query("SELECT * FROM categories ORDER BY name ASC");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $categories
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Kategoriler yüklenirken bir hata oluştu.'
    ]);
}
?> 