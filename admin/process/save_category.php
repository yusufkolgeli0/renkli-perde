<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

function generateSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', "-", $slug);
    $slug = trim($slug, '-');
    return $slug;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    try {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $slug = generateSlug($name);
        $image = null;

        // Resim yükleme işlemi
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                throw new Exception('Geçersiz dosya formatı');
            }

            $newFilename = uniqid() . '.' . $ext;
            $uploadPath = '../../images/categories/' . $newFilename;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                throw new Exception('Dosya yüklenemedi');
            }

            $image = $newFilename;
        }

        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // Update existing category
            $stmt = $db->prepare("UPDATE categories SET name = ?, description = ?, slug = ?" . ($image ? ", image = ?" : "") . " WHERE id = ?");
            $params = [$name, $description, $slug];
            if ($image) $params[] = $image;
            $params[] = $_POST['id'];
            $stmt->execute($params);
        } else {
            // Insert new category
            $stmt = $db->prepare("INSERT INTO categories (name, description, slug, image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $description, $slug, $image]);
        }

        echo json_encode([
            'success' => true,
            'message' => 'Kategori başarıyla kaydedildi'
        ]);
        exit;

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
        exit;
    }
}
?> 