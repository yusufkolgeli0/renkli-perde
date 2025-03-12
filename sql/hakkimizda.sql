CREATE TABLE IF NOT EXISTS `hakkimizda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) NOT NULL,
  `icerik` text NOT NULL,
  `vizyon` text NOT NULL,
  `misyon` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Varsayılan içerik ekle
INSERT INTO `hakkimizda` (`baslik`, `icerik`, `vizyon`, `misyon`) VALUES
('Biz Kimiz?', 
'<p>2003 yılından bu yana perde sektörünün farklı alanlarında deneyim kazandık ve 2015 yılında Renkli Perde Tasarım adıyla perakende perde satış mağazamızı kurarak hizmet vermeye başladık. Müşterilerimize en iyi hizmeti sunabilmek için sürekli kendimizi geliştiriyor, vizyonumuzu genişletiyor ve kaliteyi ön planda tutuyoruz.</p>

<p>Ev ve ofis perde sistemlerinden, otel ve kurumsal projelere kadar geniş bir yelpazede hizmet veriyoruz. Tül perdelerden mekanik sistemlere kadar her türlü perde çözümünde, sektörde öncü markalarla iş birliği yaparak yaşam alanlarınıza şıklık ve konfor katıyoruz.</p>',
'Perde sektöründe yenilikçi tasarımlar ve üstün hizmet kalitesiyle öncü firma olmak, müşterilerimizin yaşam alanlarını estetik ve işlevsel çözümlerle donatarak, yaşam kalitelerini artırmak.',
'Müşterilerimize en kaliteli ürünleri, en uygun fiyatlarla sunmak, profesyonel hizmet anlayışımızla güvenilir çözüm ortağı olmak ve sektörde standartları yükseltmek.'); 