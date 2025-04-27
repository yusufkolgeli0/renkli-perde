
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `contact_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


LOCK TABLES `contact_settings` WRITE;
INSERT INTO `contact_settings` VALUES (1,'address','Mustafa Kemal Caddesi No:153/B Özkanlar-Bayraklı/İZMİR','2025-03-12 15:05:39','2025-03-12 15:05:39'),(2,'phone1','0232 966 43 39','2025-03-12 15:05:39','2025-03-12 15:05:39'),(3,'phone2','0533 491 69 99','2025-03-12 15:05:39','2025-03-12 15:05:39'),(4,'email','renkliperde@gmail.com','2025-03-12 15:05:39','2025-03-12 15:05:39'),(5,'map_embed','<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d390.5251016246657!2d27.196442!3d38.459925000000005!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14b97d4e672773f9%3A0xf7ebcda0fd2ed0ab!2sRenkli%20Perde%20Tasar%C4%B1m!5e0!3m2!1str!2str!4v1741791743646!5m2!1str!2str\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','2025-03-12 15:05:39','2025-03-12 15:23:22'),(6,'instagram_qr','instagram_qr.png','2025-03-12 15:05:39','2025-03-12 15:05:39'),(13,'map_lat','38.4237','2025-03-12 15:09:44','2025-03-12 15:09:44'),(14,'map_lng','27.1428','2025-03-12 15:09:44','2025-03-12 15:09:44');
UNLOCK TABLES;

CREATE TABLE `gallery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `gallery` WRITE;
UNLOCK TABLES;
CREATE TABLE `site_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


LOCK TABLES `site_settings` WRITE;
INSERT INTO `site_settings` VALUES (1,'about_content','<p>2003 yılından bu yana perde sektörünün farklı alanlarında deneyim kazandık ve 2015 yılında Renkli Perde Tasarım adıyla perakende perde satış mağazamızı kurarak hizmet vermeye başladık. Müşterilerimize en iyi hizmeti sunabilmek için sürekli kendimizi geliştiriyor, vizyonumuzu genişletiyor ve kaliteyi ön planda tutuyoruz.</p>\r\n\r\n<p>Ev ve ofis perde sistemlerinden, otel ve kurumsal projelere kadar geniş bir yelpazede hizmet veriyoruz. Tül perdelerden mekanik sistemlere kadar her türlü; perde çözümünde, sektörde öncü; markalarla iş birliği yaparak yaşam alanlarınıza şıklık ve konfor katıyoruz.</p>\r\n\r\n<p>Renkli Perde Tasarım, 2015 yılında Bünyamin Taran tarafından kurulmuş olup, aynı yıl Ahmet Barış\'ın da ekibe katılmasıyla satış ve satış sonrası hizmetlerde tam donanımlı bir yapıya kavuşmuştur. Müşteri memnuniyetini ön planda tutarak, her aşamada güvenilir ve profesyonel hizmet sunmaya devam ediyoruz.</p>','2025-03-12 14:36:13','2025-03-12 15:08:52');
