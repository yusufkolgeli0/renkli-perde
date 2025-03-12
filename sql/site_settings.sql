-- Site ayarları tablosu
CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(255) NOT NULL UNIQUE,
    value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Hakkımızda içeriği için varsayılan veri
INSERT INTO site_settings (setting_key, value) VALUES 
('about_content', '<p>2003 yılından bu yana perde sektörünün farklı alanlarında deneyim kazandık ve 2015 yılında Renkli Perde Tasarım adıyla perakende perde satış mağazamızı kurarak hizmet vermeye başladık. Müşterilerimize en iyi hizmeti sunabilmek için sürekli kendimizi geliştiriyor, vizyonumuzu genişletiyor ve kaliteyi ön planda tutuyoruz.</p>

<p>Ev ve ofis perde sistemlerinden, otel ve kurumsal projelere kadar geniş bir yelpazede hizmet veriyoruz. Tül perdelerden mekanik sistemlere kadar her türlü perde çözümünde, sektörde öncü markalarla iş birliği yaparak yaşam alanlarınıza şıklık ve konfor katıyoruz.</p>

<p>Renkli Perde Tasarım, 2015 yılında Bünyamin Taran tarafından kurulmuş olup, aynı yıl Ahmet Barış''ın da ekibe katılmasıyla satış ve satış sonrası hizmetlerde tam donanımlı bir yapıya kavuşmuştur. Müşteri memnuniyetini ön planda tutarak, her aşamada güvenilir ve profesyonel hizmet sunmaya devam ediyoruz.</p>')
ON DUPLICATE KEY UPDATE value = VALUES(value); 