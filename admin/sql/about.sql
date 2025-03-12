CREATE TABLE IF NOT EXISTS `about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255),
  `meta_description` text,
  `meta_keywords` varchar(255),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Varsayılan hakkımızda içeriği
INSERT INTO `about` (
    `title`,
    `content`,
    `meta_description`,
    `meta_keywords`,
    `status`
) VALUES (
    'Hayırlı Ramazanlar Hakkında',
    '<p>Hayırlı Ramazanlar, Müslüman kardeşlerimizin Ramazan ayını daha verimli ve manevi bir şekilde geçirmelerine yardımcı olmak için kurulmuş bir platformdur.</p>
    <p>Amacımız:</p>
    <ul>
        <li>Ramazan ayına özel duaları ve ayetleri bir arada sunmak</li>
        <li>Hadis-i şerifleri günlük olarak paylaşmak</li>
        <li>Ramazan ayına özel bilgilendirici içerikler sunmak</li>
        <li>Müslüman kardeşlerimizin manevi yolculuklarına katkıda bulunmak</li>
    </ul>',
    'Hayırlı Ramazanlar - Ramazan ayına özel dualar, ayetler ve hadisler sunan platform hakkında bilgi',
    'ramazan, oruç, dua, ayet, hadis, islam, müslüman, hakkımızda',
    1
); 