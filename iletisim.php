<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim - Renkli Perde Tasarım</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="page-header">
        <div class="container">
            <h1>İletişim</h1>
            <p>Bizimle iletişime geçin</p>
        </div>
    </div>

    <section class="contact-section">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info">
                    <h2>İletişim Bilgileri</h2>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h3>Adres</h3>
                            <p>Örnek Mahallesi, Örnek Sokak No:123<br>İstanbul, Türkiye</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h3>Telefon</h3>
                            <p>+90 555 123 4567</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3>E-posta</h3>
                            <p>info@renkliperdetasarim.com</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h3>Çalışma Saatleri</h3>
                            <p>Pazartesi - Cumartesi: 09:00 - 18:00<br>Pazar: Kapalı</p>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <h2>Mesaj Gönderin</h2>
                    <form action="process_contact.php" method="POST">
                        <div class="form-group">
                            <label for="name">Adınız Soyadınız</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-posta Adresiniz</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Telefon Numaranız</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Konu</label>
                            <input type="text" id="subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Mesajınız</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn">Mesaj Gönder</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="map-section">
        <div class="container">
            <h2>Konum</h2>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3008.443928507194!2d28.97206231541454!3d41.03701897929822!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cab7650656bd63%3A0x8ca058b28c20b6c3!2zVGFrc2ltIE1leWRhbsSxLCBHw7xtw7zFn3N1eXUsIDM0NDM1IEJleW_En2x1L8Swc3RhbmJ1bA!5e0!3m2!1str!2str!4v1647789145619!5m2!1str!2str" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 