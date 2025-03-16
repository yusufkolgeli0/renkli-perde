<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim - Renkli Perde Tasarım</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .map-qr-section {
            padding: 40px 0;
            background-color: #f9f9f9;
        }
        .map-qr-container {
            display: flex;
            gap: 30px;
            align-items: flex-start;
        }
        .map-container {
            flex: 2;
        }
        .qr-container {
            flex: 1;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .qr-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .qr-container img {
            max-width: 100%;
            height: auto;
        }
        .qr-description {
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }
        @media (max-width: 768px) {
            .map-qr-container {
                flex-direction: column;
            }
            .map-container, .qr-container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="contact-section">
        <div class="container">
            <div class="contact-info">
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h3>Adres</h3>
                        <p>Mustafa Kemal Caddesi No:153/B<br>Özkanlar-Bayraklı/İZMİR</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <div>
                        <h3>Telefon</h3>
                        <p>0232 966 43 39<br>0533 491 69 99</p>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <h3>E-posta</h3>
                        <p>renkliperde@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="map-qr-section">
        <div class="container">
            <div class="map-qr-container">
                <div class="map-container">
                    <h2>Konum</h2>
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d273.11463585777034!2d27.196204108374054!3d38.45985923771262!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14b97d4e672773f9%3A0xf7ebcda0fd2ed0ab!2sRenkli%20Perde%20Tasar%C4%B1m!5e0!3m2!1str!2str!4v1741354897821!5m2!1str!2str" 
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="qr-container">
                    <h2>İletişim Bilgilerimiz</h2>
                    <img src="assets/images/qr-code.png" alt="İletişim Bilgileri QR Kodu">
                    <p class="qr-description">QR kodu telefonunuzla tarayarak iletişim bilgilerimizi rehberinize kaydedebilirsiniz.</p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 