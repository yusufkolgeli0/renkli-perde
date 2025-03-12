<?php
include 'includes/header.php';

// Veritabanı bağlantısı
require_once '../includes/config.php';
require_once '../includes/db.php';

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Metin içeriklerini güncelle
        $stmt = $db->prepare("UPDATE contact_settings SET value = ? WHERE setting_key = ?");
        
        $textFields = ['address', 'phone1', 'phone2', 'email', 'map_embed'];
        foreach ($textFields as $field) {
            if (isset($_POST[$field])) {
                $stmt->execute([$_POST[$field], $field]);
            }
        }

        // QR kod resmini güncelle
        if (isset($_FILES['instagram_qr']) && $_FILES['instagram_qr']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['instagram_qr']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {
                $target_dir = "../images/";
                $new_filename = "instagram_qr." . $ext;
                $target_file = $target_dir . $new_filename;

                if (move_uploaded_file($_FILES['instagram_qr']['tmp_name'], $target_file)) {
                    $stmt->execute([$new_filename, 'instagram_qr']);
                }
            }
        }

        $success_message = "İletişim bilgileri başarıyla güncellendi.";
    } catch (PDOException $e) {
        $error_message = "Güncelleme sırasında bir hata oluştu: " . $e->getMessage();
    }
}

// Mevcut iletişim bilgilerini al
try {
    $stmt = $db->query("SELECT * FROM contact_settings");
    $settings = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $settings[$row['setting_key']] = $row['value'];
    }
} catch (PDOException $e) {
    $error_message = "Veri çekme sırasında bir hata oluştu: " . $e->getMessage();
    $settings = [];
}
?>

<div class="content-area">
    <div class="container-fluid">
        <!-- Başlık Kartı -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <div class="feature-icon-large d-inline-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10 rounded-3 me-3">
                            <i class="fas fa-map-marked-alt fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="card-title mb-1">İletişim Bilgileri Yönetimi</h4>
                            <p class="card-text text-muted mb-0">İşletmenizin iletişim bilgilerini buradan güncelleyebilirsiniz.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data" id="contactForm">
            <div class="row">
                <!-- Sol Kolon - İletişim Bilgileri -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 pt-4">
                            <h5 class="card-title d-flex align-items-center mb-0">
                                <span class="icon-circle bg-primary bg-opacity-10 text-primary me-2">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                                Temel Bilgiler
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Adres -->
                            <div class="form-group mb-4">
                                <label for="address" class="form-label d-flex align-items-center">
                                    <span class="icon-circle bg-primary bg-opacity-10 text-primary me-2">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <span>Adres Bilgisi</span>
                                </label>
                                <div class="input-wrapper">
                                    <textarea 
                                        class="form-control form-control-lg shadow-none" 
                                        id="address" 
                                        name="address" 
                                        rows="3" 
                                        placeholder="Örn: Mustafa Kemal Caddesi No:153/B Özkanlar-Bayraklı/İZMİR"
                                    ><?php echo htmlspecialchars($settings['address'] ?? ''); ?></textarea>
                                    <div class="focus-border"></div>
                                </div>
                            </div>

                            <!-- Telefonlar -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone1" class="form-label d-flex align-items-center">
                                            <span class="icon-circle bg-primary bg-opacity-10 text-primary me-2">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                            <span>Sabit Telefon</span>
                                        </label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text border-0 bg-light">
                                                <i class="fas fa-phone text-primary"></i>
                                            </span>
                                            <input type="tel" 
                                                class="form-control shadow-none" 
                                                id="phone1" 
                                                name="phone1" 
                                                placeholder="0232 XXX XX XX"
                                                value="<?php echo htmlspecialchars($settings['phone1'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone2" class="form-label d-flex align-items-center">
                                            <span class="icon-circle bg-primary bg-opacity-10 text-primary me-2">
                                                <i class="fas fa-mobile-alt"></i>
                                            </span>
                                            <span>Mobil Telefon</span>
                                        </label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text border-0 bg-light">
                                                <i class="fas fa-mobile-alt text-primary"></i>
                                            </span>
                                            <input type="tel" 
                                                class="form-control shadow-none" 
                                                id="phone2" 
                                                name="phone2" 
                                                placeholder="05XX XXX XX XX"
                                                value="<?php echo htmlspecialchars($settings['phone2'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- E-posta -->
                            <div class="form-group mb-4">
                                <label for="email" class="form-label d-flex align-items-center">
                                    <span class="icon-circle bg-primary bg-opacity-10 text-primary me-2">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <span>E-posta Adresi</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text border-0 bg-light">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </span>
                                    <input type="email" 
                                        class="form-control shadow-none" 
                                        id="email" 
                                        name="email" 
                                        placeholder="ornek@sirketiniz.com"
                                        value="<?php echo htmlspecialchars($settings['email'] ?? ''); ?>">
                                </div>
                            </div>

                            <!-- Instagram QR Kodu -->
                            <div class="form-group mb-4">
                                <label for="instagram_qr" class="form-label d-flex align-items-center">
                                    <span class="icon-circle bg-primary bg-opacity-10 text-primary me-2">
                                        <i class="fab fa-instagram"></i>
                                    </span>
                                    <span>Instagram QR Kodu</span>
                                </label>
                                <div class="qr-upload-area">
                                    <div class="custom-file-upload">
                                        <input type="file" 
                                            class="form-control form-control-lg shadow-none" 
                                            id="instagram_qr" 
                                            name="instagram_qr" 
                                            accept="image/*">
                                        <label for="instagram_qr" class="file-label">
                                            <i class="fas fa-cloud-upload-alt me-2"></i>
                                            QR Kod Yükle
                                        </label>
                                    </div>
                                    
                                    <?php if (!empty($settings['instagram_qr'])): ?>
                                        <div class="mt-3 text-center p-3 bg-light rounded">
                                            <img src="../images/<?php echo htmlspecialchars($settings['instagram_qr']); ?>" 
                                                alt="Instagram QR Kod" 
                                                class="img-thumbnail qr-preview"
                                                style="max-height: 200px;">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sağ Kolon - Harita -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 pt-4">
                            <h5 class="card-title d-flex align-items-center mb-0">
                                <span class="icon-circle bg-primary bg-opacity-10 text-primary me-2">
                                    <i class="fas fa-map"></i>
                                </span>
                                Google Harita Yerleştirme
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info border-0 shadow-sm mb-4">
                                <div class="d-flex">
                                    <div class="alert-icon me-3">
                                        <i class="fas fa-info-circle fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="alert-heading mb-2">Harita Kodu Nasıl Eklenir?</h6>
                                        <ol class="mb-0">
                                            <li>Google Haritalar'da işletmenizin konumunu bulun</li>
                                            <li>"Paylaş" butonuna tıklayın</li>
                                            <li>"Haritayı yerleştir" seçeneğini seçin</li>
                                            <li>Size verilen iframe kodunu aşağıdaki alana yapıştırın</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <!-- Harita Kodu -->
                            <div class="form-group mb-4">
                                <label for="map_embed" class="form-label d-flex align-items-center">
                                    <span class="icon-circle bg-primary bg-opacity-10 text-primary me-2">
                                        <i class="fas fa-code"></i>
                                    </span>
                                    <span>Harita Yerleştirme Kodu</span>
                                </label>
                                <div class="input-wrapper">
                                    <textarea 
                                        class="form-control form-control-lg shadow-none code-area" 
                                        id="map_embed" 
                                        name="map_embed" 
                                        rows="6" 
                                        placeholder='<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'
                                    ><?php echo htmlspecialchars($settings['map_embed'] ?? ''); ?></textarea>
                                    <div class="focus-border"></div>
                                </div>
                                <small class="form-text text-muted mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Google Haritalar'dan aldığınız iframe kodunu buraya yapıştırın
                                </small>
                            </div>

                            <!-- Harita Önizleme -->
                            <div class="map-preview-container">
                                <label class="form-label d-flex align-items-center">
                                    <span class="icon-circle bg-primary bg-opacity-10 text-primary me-2">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    <span>Harita Önizleme</span>
                                </label>
                                <div class="map-preview rounded shadow-sm" id="mapPreview">
                                    <?php echo $settings['map_embed'] ?? ''; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kaydet Butonu -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-end py-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">
                                <i class="fas fa-save me-2"></i>
                                Değişiklikleri Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
:root {
    --primary-color: #0d6efd;
    --primary-hover: #0b5ed7;
    --transition: all 0.3s ease;
}

.content-area {
    padding: 2rem 0;
}

/* Kart Stilleri */
.card {
    transition: var(--transition);
    border-radius: 15px;
}

.card:hover {
    transform: translateY(-2px);
}

.card-header {
    border-bottom: none;
}

/* Form Elemanları */
.form-control {
    padding: 0.75rem 1rem;
    font-size: 1rem;
    border-radius: 10px;
    border: 1px solid #dee2e6;
    transition: var(--transition);
    background-color: #f8f9fa;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    background-color: #fff;
}

.input-group-text {
    border-radius: 10px 0 0 10px;
    border: none;
    padding: 0.75rem 1rem;
}

.input-group .form-control {
    border-radius: 0 10px 10px 0;
}

.form-control-lg {
    font-size: 1rem;
}

/* Özel Input Wrapper */
.input-wrapper {
    position: relative;
}

.input-wrapper .focus-border {
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background-color: var(--primary-color);
    transition: var(--transition);
    transform: translateX(-50%);
}

.input-wrapper .form-control:focus + .focus-border {
    width: 100%;
}

/* Buton Stilleri */
.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    transition: var(--transition);
    font-weight: 500;
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background-color: var(--primary-hover);
    border-color: var(--primary-hover);
    transform: translateY(-2px);
}

.btn-lg {
    font-size: 1.1rem;
}

/* İkon Daire */
.icon-circle {
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 1rem;
}

.feature-icon-large {
    width: 64px;
    height: 64px;
}

/* QR Kod Alanı */
.qr-preview {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    transition: var(--transition);
}

.qr-preview:hover {
    transform: scale(1.02);
}

.custom-file-upload {
    position: relative;
    overflow: hidden;
}

.custom-file-upload input[type="file"] {
    position: absolute;
    left: -9999px;
}

.custom-file-upload .file-label {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 10px;
    cursor: pointer;
    transition: var(--transition);
    width: 100%;
    text-align: center;
    color: #6c757d;
}

.custom-file-upload .file-label:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    background: #f8f9fa;
}

/* Alert Stilleri */
.alert {
    border-radius: 10px;
    padding: 1rem;
}

.alert-icon {
    min-width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.alert ol {
    padding-left: 1.2rem;
    margin-bottom: 0;
}

.alert ol li {
    margin-bottom: 0.5rem;
    line-height: 1.5;
}

.alert ol li:last-child {
    margin-bottom: 0;
}

/* Harita Önizleme */
.map-preview-container {
    margin-top: 2rem;
}

.map-preview {
    position: relative;
    width: 100%;
    min-height: 400px;
    background: #f8f9fa;
    border-radius: 10px;
    overflow: hidden;
    transition: var(--transition);
}

.map-preview:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}

.map-preview iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

/* Code Area */
.code-area {
    font-family: 'Courier New', Courier, monospace;
    font-size: 0.9rem !important;
    line-height: 1.5;
}

/* Form Label */
.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .content-area {
        padding: 1rem 0;
    }
    
    .form-control-lg {
        font-size: 16px;
    }
    
    .map-preview {
        min-height: 300px;
    }
    
    .icon-circle {
        width: 32px;
        height: 32px;
        font-size: 0.9rem;
    }
    
    .btn-lg {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }
}
</style>

<script>
// Harita önizlemeyi güncelle
document.getElementById('map_embed').addEventListener('input', function() {
    document.getElementById('mapPreview').innerHTML = this.value;
});

// Dosya yükleme önizlemesi
document.getElementById('instagram_qr').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.querySelector('.qr-preview');
            if (!preview) {
                const newPreview = document.createElement('div');
                newPreview.className = 'mt-3 text-center p-3 bg-light rounded';
                newPreview.innerHTML = `
                    <img src="${e.target.result}" 
                        alt="Instagram QR Kod" 
                        class="img-thumbnail qr-preview"
                        style="max-height: 200px;">`;
                document.querySelector('.qr-upload-area').appendChild(newPreview);
            } else {
                preview.src = e.target.result;
            }
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>

<?php include 'includes/footer.php'; ?> 