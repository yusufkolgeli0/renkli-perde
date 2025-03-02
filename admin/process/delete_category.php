<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

header('Content-Type: application/json');

try {
    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        throw new Exception('Geçersiz kategori ID\'si.');
    }

    // Get category image before deletion
    $stmt = $db->prepare("SELECT image FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    $image = $stmt->fetchColumn();

    if (!$image) {
        throw new Exception('Kategori bulunamadı.');
    }

    // Delete category image if exists
    if ($image) {
        $imagePath = '../../images/categories/' . $image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Delete category
    $stmt = $db->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode([
        'success' => true,
        'message' => 'Kategori başarıyla silindi.'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 