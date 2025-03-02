<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

header('Content-Type: application/json');

try {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    
    // Validate inputs
    if (empty($name)) {
        throw new Exception('Kategori adı zorunludur.');
    }
    
    // Create slug from name
    $slug = strtolower(str_replace([' ', 'ı', 'ğ', 'ü', 'ş', 'ö', 'ç'], ['-', 'i', 'g', 'u', 's', 'o', 'c'], $name));
    
    // Handle image upload if exists
    $filename = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['image'];
        
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Sadece JPG, PNG ve GIF formatları desteklenmektedir.');
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        
        // Create categories directory if it doesn't exist
        $uploadDir = '../../images/categories/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $uploadPath = $uploadDir . $filename;
        
        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('Dosya yüklenirken bir hata oluştu.');
        }
    }
    
    if ($id) {
        // Update existing category
        if ($filename) {
            // Get old image to delete
            $stmt = $db->prepare("SELECT image FROM categories WHERE id = ?");
            $stmt->execute([$id]);
            $oldImage = $stmt->fetchColumn();
            
            // Delete old image if exists
            if ($oldImage) {
                $oldImagePath = '../../images/categories/' . $oldImage;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $stmt = $db->prepare("UPDATE categories SET name = ?, slug = ?, description = ?, image = ? WHERE id = ?");
            $stmt->execute([$name, $slug, $description, $filename, $id]);
        } else {
            $stmt = $db->prepare("UPDATE categories SET name = ?, slug = ?, description = ? WHERE id = ?");
            $stmt->execute([$name, $slug, $description, $id]);
        }
    } else {
        // Insert new category
        $stmt = $db->prepare("INSERT INTO categories (name, slug, description, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $slug, $description, $filename]);
        $id = $db->lastInsertId();
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Kategori başarıyla kaydedildi.',
        'data' => [
            'id' => $id,
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'image' => $filename
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 