<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $name = $_POST['name'];
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

        $stmt = $db->prepare("INSERT INTO categories (name, image) VALUES (?, ?)");
        $stmt->execute([$name, $image]);

        $_SESSION['success_message'] = 'Kategori başarıyla eklendi';
        header('Location: ../categories.php');
        exit;

    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header('Location: ../categories.php');
        exit;
    }
}
?> 