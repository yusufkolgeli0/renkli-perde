<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini al
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $subject = strip_tags(trim($_POST["subject"]));
    $message = strip_tags(trim($_POST["message"]));

    // E-posta başlığı
    $email_subject = "Yeni İletişim Formu Mesajı: $subject";

    // E-posta içeriği
    $email_content = "İsim: $name\n";
    $email_content .= "E-posta: $email\n";
    $email_content .= "Telefon: $phone\n\n";
    $email_content .= "Mesaj:\n$message\n";

    // E-posta başlıkları
    $email_headers = "From: $name <$email>";

    // E-postayı gönder
    if (mail("info@renkliperdetasarim.com", $email_subject, $email_content, $email_headers)) {
        // Başarılı gönderim
        header("Location: iletisim.php?status=success");
        exit;
    } else {
        // Başarısız gönderim
        header("Location: iletisim.php?status=error");
        exit;
    }
} else {
    // POST isteği değilse ana sayfaya yönlendir
    header("Location: index.php");
    exit;
} 