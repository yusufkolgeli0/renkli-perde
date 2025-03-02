<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

header('Content-Type: application/json');

try {
    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        throw new Exception('Geçersiz kategori ID\'si.');
    }

    $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        throw new Exception('Kategori bulunamadı.');
    }

    echo json_encode([
        'success' => true,
        'data' => $category
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 