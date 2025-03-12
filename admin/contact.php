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
        
        $textFields = ['address', 'phone1', 'phone2', 'email', 'map_embed', 'map_lat', 'map_lng'];
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

// Varsayılan koordinatlar (İzmir merkez)
$default_lat = $settings['map_lat'] ?? '38.4237';
$default_lng = $settings['map_lng'] ?? '27.1428';
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
                            <p class="card-text text-muted">İşletmenizin iletişim bilgilerini buradan güncelleyebilirsiniz.</p>
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
                        <div class="card-header bg-transparent border-0">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                Temel Bilgiler
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Adres -->
                            <div class="mb-4">
                                <label for="address" class="form-label text-dark fw-medium">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>Adres
                                </label>
                                <textarea class="form-control form-control-lg shadow-none" 
                                    id="address" 
                                    name="address" 
                                    rows="3" 
                                    placeholder="İşletmenizin açık adresini girin"><?php echo htmlspecialchars($settings['address'] ?? ''); ?></textarea>
                            </div>

                            <!-- Telefonlar -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="phone1" class="form-label text-dark fw-medium">
                                        <i class="fas fa-phone me-2 text-primary"></i>Sabit Telefon
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-phone"></i></span>
                                        <input type="tel" 
                                            class="form-control form-control-lg shadow-none" 
                                            id="phone1" 
                                            name="phone1" 
                                            placeholder="0232 XXX XX XX"
                                            value="<?php echo htmlspecialchars($settings['phone1'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone2" class="form-label text-dark fw-medium">
                                        <i class="fas fa-mobile-alt me-2 text-primary"></i>Mobil Telefon
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-mobile-alt"></i></span>
                                        <input type="tel" 
                                            class="form-control form-control-lg shadow-none" 
                                            id="phone2" 
                                            name="phone2" 
                                            placeholder="05XX XXX XX XX"
                                            value="<?php echo htmlspecialchars($settings['phone2'] ?? ''); ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- E-posta -->
                            <div class="mb-4">
                                <label for="email" class="form-label text-dark fw-medium">
                                    <i class="fas fa-envelope me-2 text-primary"></i>E-posta
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-envelope"></i></span>
                                    <input type="email" 
                                        class="form-control form-control-lg shadow-none" 
                                        id="email" 
                                        name="email" 
                                        placeholder="ornek@sirketiniz.com"
                                        value="<?php echo htmlspecialchars($settings['email'] ?? ''); ?>">
                                </div>
                            </div>

                            <!-- Instagram QR Kodu -->
                            <div class="mb-4">
                                <label for="instagram_qr" class="form-label text-dark fw-medium">
                                    <i class="fab fa-instagram me-2 text-primary"></i>Instagram QR Kodu
                                </label>
                                <div class="qr-upload-area">
                                    <input type="file" 
                                        class="form-control form-control-lg shadow-none" 
                                        id="instagram_qr" 
                                        name="instagram_qr" 
                                        accept="image/*">
                                    
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
                        <div class="card-header bg-transparent border-0">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-map me-2 text-primary"></i>
                                Konum Bilgisi
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info border-0 shadow-sm">
                                <i class="fas fa-info-circle me-2"></i>
                                Harita üzerinde işletmenizin konumunu seçin. Marker'ı sürükleyerek konumu ayarlayabilirsiniz.
                            </div>
                            
                            <!-- Harita -->
                            <div id="map" style="height: 400px; border-radius: 10px;" class="mb-3 shadow-sm"></div>
                            
                            <!-- Gizli input'lar -->
                            <input type="hidden" id="map_lat" name="map_lat" value="<?php echo $default_lat; ?>">
                            <input type="hidden" id="map_lng" name="map_lng" value="<?php echo $default_lng; ?>">
                            <input type="hidden" id="map_embed" name="map_embed" value="<?php echo htmlspecialchars($settings['map_embed'] ?? ''); ?>">
                            
                            <!-- Konum Arama -->
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-search"></i></span>
                                <input type="text" 
                                    class="form-control form-control-lg shadow-none" 
                                    id="searchAddress" 
                                    placeholder="Adres ara...">
                                <button class="btn btn-primary" type="button" id="searchButton">
                                    <i class="fas fa-search"></i> Ara
                                </button>
                            </div>

                            <!-- Koordinatlar -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0">Enlem</span>
                                        <input type="text" class="form-control shadow-none" id="lat_display" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0">Boylam</span>
                                        <input type="text" class="form-control shadow-none" id="lng_display" readonly>
                                    </div>
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
                        <div class="card-body text-end">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-save me-2"></i>Değişiklikleri Kaydet
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
}

.content-area {
    padding: 2rem 0;
}

.card {
    transition: all 0.3s ease;
}

.form-control {
    padding: 0.75rem 1rem;
    font-size: 1rem;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

.input-group-text {
    border-radius: 8px 0 0 8px;
    border: 1px solid #dee2e6;
}

.form-control-lg {
    font-size: 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background-color: var(--primary-hover);
    border-color: var(--primary-hover);
}

.feature-icon-large {
    width: 64px;
    height: 64px;
}

.qr-preview {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

.qr-upload-area {
    position: relative;
}

.alert {
    border-radius: 8px;
}

#map {
    transition: all 0.3s ease;
}

#map:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

@media (max-width: 768px) {
    .content-area {
        padding: 1rem 0;
    }
    
    .form-control-lg {
        font-size: 16px; /* iOS için minimum font boyutu */
    }
    
    #map {
        height: 300px;
    }
}
</style>

<!-- Google Maps JavaScript -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places"></script>
<script>
let map;
let marker;
let geocoder;
let searchBox;

function initMap() {
    // Harita başlangıç noktası
    const defaultLocation = {
        lat: parseFloat(document.getElementById('map_lat').value),
        lng: parseFloat(document.getElementById('map_lng').value)
    };

    // Harita oluşturma
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: defaultLocation,
        mapTypeControl: true,
        streetViewControl: true,
        fullscreenControl: true,
        styles: [
            {
                featureType: "poi",
                elementType: "labels",
                stylers: [{ visibility: "off" }]
            }
        ]
    });

    // Marker oluşturma
    marker = new google.maps.Marker({
        position: defaultLocation,
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP
    });

    // Geocoder ve SearchBox
    geocoder = new google.maps.Geocoder();
    const searchInput = document.getElementById('searchAddress');
    searchBox = new google.maps.places.SearchBox(searchInput);

    // Marker sürüklendiğinde
    google.maps.event.addListener(marker, 'dragend', function() {
        updateLocation(marker.getPosition());
    });

    // Haritaya tıklandığında
    google.maps.event.addListener(map, 'click', function(event) {
        marker.setPosition(event.latLng);
        updateLocation(event.latLng);
    });

    // Arama kutusu değiştiğinde
    searchBox.addListener('places_changed', function() {
        const places = searchBox.getPlaces();
        if (places.length === 0) return;

        const place = places[0];
        if (!place.geometry) return;

        // Haritayı konuma taşı
        map.setCenter(place.geometry.location);
        marker.setPosition(place.geometry.location);
        updateLocation(place.geometry.location);
    });

    // Başlangıçta koordinatları göster
    updateDisplayCoordinates(defaultLocation);
}

// Konum güncelleme fonksiyonu
function updateLocation(location) {
    // Koordinatları güncelle
    document.getElementById('map_lat').value = location.lat();
    document.getElementById('map_lng').value = location.lng();
    updateDisplayCoordinates(location);

    // Embed kodunu güncelle
    const embedCode = `<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3!2d${location.lng()}!3d${location.lat()}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQzJzEyLjAiTiAyOcKwNTEnMzIuNCJF!5e0!3m2!1str!2str!4v1234567890!5m2!1str!2str" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
    document.getElementById('map_embed').value = embedCode;
}

// Koordinatları görüntüleme fonksiyonu
function updateDisplayCoordinates(location) {
    document.getElementById('lat_display').value = location.lat().toFixed(6);
    document.getElementById('lng_display').value = location.lng().toFixed(6);
}

// Arama butonu tıklandığında
document.getElementById('searchButton').addEventListener('click', function() {
    const address = document.getElementById('searchAddress').value;
    geocoder.geocode({ address: address }, function(results, status) {
        if (status === 'OK') {
            const location = results[0].geometry.location;
            map.setCenter(location);
            marker.setPosition(location);
            updateLocation(location);
        }
    });
});

// Haritayı başlat
window.onload = initMap;
</script>

<?php include 'includes/footer.php'; ?> 