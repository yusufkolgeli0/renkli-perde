CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_title` varchar(255) NOT NULL,
  `site_description` text,
  `site_keywords` varchar(255),
  `site_logo` varchar(255),
  `site_favicon` varchar(255),
  `facebook_url` varchar(255),
  `twitter_url` varchar(255),
  `instagram_url` varchar(255),
  `youtube_url` varchar(255),
  `whatsapp_number` varchar(20),
  `email` varchar(255),
  `phone` varchar(20),
  `address` text,
  `location` varchar(255),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Varsayılan veri ekleme
INSERT INTO `site_settings` (
    `site_title`, 
    `site_description`, 
    `site_keywords`, 
    `facebook_url`, 
    `twitter_url`, 
    `instagram_url`, 
    `youtube_url`, 
    `whatsapp_number`,
    `email`,
    `phone`,
    `address`,
    `location`
) VALUES (
    'Hayırlı Ramazanlar',
    'Hayırlı Ramazanlar - Ramazan ayına özel dualar, ayetler ve hadisler',
    'ramazan, oruç, dua, ayet, hadis, islam, müslüman',
    'https://facebook.com/hayirlaramazanlar',
    'https://twitter.com/hayirlaramazanlar',
    'https://instagram.com/hayirlaramazanlar',
    'https://youtube.com/hayirlaramazanlar',
    '+905551234567',
    'info@hayirlaramazanlar.com',
    '+902161234567',
    'Örnek Mahallesi, Örnek Sokak No:1\nKadıköy/İstanbul',
    '41.0082,29.0237'
); 