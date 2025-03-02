<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

header('Content-Type: application/json');

try {
    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        throw new Exception('Geçersiz görsel ID\'si.');
    }

    // Get image filename before deletion
    $stmt = $db->prepare("SELECT image FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $image = $stmt->fetchColumn();

    if (!$image) {
        throw new Exception('Görsel bulunamadı.');
    }

    // Delete from database
    $stmt = $db->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->execute([$id]);

    // Delete file from server
    $imagePath = '../../images/' . $image;
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Görsel başarıyla silindi.'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 