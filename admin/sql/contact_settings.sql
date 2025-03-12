CREATE TABLE IF NOT EXISTS `contact_settings` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `phone1` varchar(20) NOT NULL,
    `phone2` varchar(20) DEFAULT NULL,
    `email` varchar(100) NOT NULL,
    `address` text NOT NULL,
    `instagram` varchar(255) NOT NULL,
    `maps_embed` text NOT NULL,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; 