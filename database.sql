-- Kategoriler tablosu
CREATE TABLE IF NOT EXISTS `categories` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `description` text,
    `image` varchar(255),
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Galeri tablosu
CREATE TABLE IF NOT EXISTS `gallery` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `description` text,
    `image` varchar(255) NOT NULL,
    `category_id` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SELECT @@global.time_zone, @@session.time_zone;

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