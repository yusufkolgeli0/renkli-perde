-- İletişim ayarları tablosu
CREATE TABLE IF NOT EXISTS contact_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(255) NOT NULL UNIQUE,
    value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Varsayılan iletişim bilgileri
INSERT INTO contact_settings (setting_key, value) VALUES 
('address', 'Mustafa Kemal Caddesi No:153/B Özkanlar-Bayraklı/İZMİR'),
('phone1', '0232 966 43 39'),
('phone2', '0533 491 69 99'),
('email', 'renkliperde@gmail.com'),
('map_embed', '<iframe src="GOOGLE_MAP_EMBED_URL" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'),
('instagram_qr', 'instagram_qr.png')
ON DUPLICATE KEY UPDATE value = VALUES(value);