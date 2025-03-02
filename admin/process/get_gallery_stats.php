<?php
require_once '../../includes/config.php';
require_once '../../includes/db.php';

header('Content-Type: application/json');

try {
    // Toplam görsel sayısı
    $stmt = $db->query("SELECT COUNT(*) as total FROM gallery");
    $total_images = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Toplam kategori sayısı
    $stmt = $db->query("SELECT COUNT(*) as total FROM categories");
    $total_categories = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Son yüklenen görsel tarihi
    $stmt = $db->query("SELECT created_at FROM gallery ORDER BY created_at DESC LIMIT 1");
    $last_upload_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $last_upload = $last_upload_data ? date('d.m.Y H:i', strtotime($last_upload_data['created_at'])) : 'Henüz görsel yok';

    // Disk kullanımı hesaplama
    function get_directory_size($path) {
        $total_size = 0;
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                if (is_file($path . '/' . $file)) {
                    $total_size += filesize($path . '/' . $file);
                }
                if (is_dir($path . '/' . $file)) {
                    $total_size += get_directory_size($path . '/' . $file);
                }
            }
        }
        return $total_size;
    }

    function format_size($size) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    $images_path = '../../images';
    $disk_usage = format_size(get_directory_size($images_path));

    echo json_encode([
        'success' => true,
        'total_images' => $total_images,
        'total_categories' => $total_categories,
        'last_upload' => $last_upload,
        'disk_usage' => $disk_usage
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'İstatistikler alınırken bir hata oluştu: ' . $e->getMessage()
    ]);
} 