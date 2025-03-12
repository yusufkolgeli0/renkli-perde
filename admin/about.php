<?php
include 'includes/header.php';

// Veritabanı bağlantısı
require_once '../includes/config.php';
require_once '../includes/db.php';

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // HTML etiketlerine izin ver ama zararlı kodları temizle
    $about_content = strip_tags($_POST['about_content'], '<p><br><strong><em><ul><li><h2><h3>');
    
    try {
        // Hakkımızda içeriğini güncelle
        $stmt = $db->prepare("UPDATE site_settings SET value = ? WHERE setting_key = 'about_content'");
        $stmt->execute([$about_content]);
        
        $success_message = "Hakkımızda içeriği başarıyla güncellendi.";
    } catch (PDOException $e) {
        $error_message = "Güncelleme sırasında bir hata oluştu: " . $e->getMessage();
    }
}

// Mevcut hakkımızda içeriğini al
try {
    $stmt = $db->prepare("SELECT value FROM site_settings WHERE setting_key = 'about_content'");
    $stmt->execute();
    $about_content = $stmt->fetchColumn();
} catch (PDOException $e) {
    $error_message = "Veri çekme sırasında bir hata oluştu: " . $e->getMessage();
    $about_content = "";
}
?>

<div class="content-area">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Hakkımızda Sayfası Yönetimi</h5>
                        <p class="card-text">Bu sayfadan "Biz Kimiz" bölümünün içeriğini düzenleyebilirsiniz.</p>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php echo $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card editing-card">
                    <div class="card-body">
                        <form method="POST" action="" id="aboutForm">
                            <div class="format-buttons">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-secondary" onclick="insertTag('h2')" title="Başlık 2">
                                        <i class="fas fa-heading"></i> H2
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="insertTag('h3')" title="Başlık 3">
                                        <i class="fas fa-heading"></i> H3
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="insertTag('p')" title="Paragraf">
                                        <i class="fas fa-paragraph"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="insertTag('strong')" title="Kalın">
                                        <i class="fas fa-bold"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="insertTag('em')" title="İtalik">
                                        <i class="fas fa-italic"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="insertList()" title="Liste">
                                        <i class="fas fa-list-ul"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="insertBreak()" title="Satır Sonu">
                                        <i class="fas fa-level-down-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <textarea class="form-control" id="about_content" name="about_content" 
                                placeholder="İçeriğinizi buraya yazın..."><?php echo htmlspecialchars($about_content); ?></textarea>
                            <div class="btn-action-group d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Değişiklikleri Kaydet
                                </button>
                                <button type="button" class="btn btn-secondary btn-lg" onclick="updatePreview()">
                                    <i class="fas fa-eye me-2"></i>Önizlemeyi Güncelle
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle me-2"></i>
                            Yardım
                        </h5>
                        <hr>
                        <div class="help-content">
                            <p><strong>Kullanabileceğiniz Düğmeler:</strong></p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-heading me-2"></i> H2/H3: Ana ve alt başlıklar ekler</li>
                                <li><i class="fas fa-paragraph me-2"></i> Yeni paragraf ekler</li>
                                <li><i class="fas fa-bold me-2"></i> Metni kalın yapar</li>
                                <li><i class="fas fa-italic me-2"></i> Metni italik yapar</li>
                                <li><i class="fas fa-list-ul me-2"></i> Liste oluşturur</li>
                                <li><i class="fas fa-level-down-alt me-2"></i> Satır sonu ekler</li>
                            </ul>
                            <p class="mb-0"><strong>İpucu:</strong> Metni seçip düğmelere tıklayarak etiketleri kolayca ekleyebilirsiniz.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Önizleme -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card preview-card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-eye me-2"></i>
                            Canlı Önizleme
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="preview-content" id="preview">
                            <?php echo $about_content; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.preview-content {
    padding: 30px;
    background: #ffffff;
    border-radius: 8px;
    min-height: 200px;
    box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
    font-family: 'Arial', sans-serif;
    line-height: 1.6;
    color: #333;
}

.preview-content h2 {
    font-size: 24px;
    color: #2c3e50;
    margin: 25px 0 15px;
    font-weight: 600;
}

.preview-content h3 {
    font-size: 20px;
    color: #34495e;
    margin: 20px 0 12px;
    font-weight: 600;
}

.preview-content p {
    margin-bottom: 15px;
    font-size: 16px;
    line-height: 1.7;
}

.preview-content strong {
    color: #2c3e50;
    font-weight: 600;
}

.preview-content em {
    color: #34495e;
}

.preview-content ul {
    margin: 15px 0;
    padding-left: 20px;
}

.preview-content li {
    margin-bottom: 8px;
    line-height: 1.6;
}

.preview-content br {
    margin: 10px 0;
    display: block;
    content: "";
}

.card-header.bg-light {
    background-color: #f8f9fa !important;
    border-bottom: 2px solid #e9ecef;
}

.card-header .card-title {
    color: #2c3e50;
    font-weight: 600;
}

/* Textarea için yeni stiller */
textarea#about_content {
    min-height: 500px;
    padding: 30px 40px;
    font-family: 'Arial', sans-serif;
    font-size: 18px;
    line-height: 2;
    color: #333;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
    resize: vertical;
    letter-spacing: 0.3px;
    width: 100%;
}

textarea#about_content:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    outline: none;
}

/* Düzenleme kartı için stiller */
.editing-card {
    border: none;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.editing-card .card-body {
    padding: 25px;
    background: #f8f9fa;
}

.format-buttons {
    position: sticky;
    top: 0;
    z-index: 100;
    background: #f8f9fa;
    padding: 15px;
    border-bottom: 1px solid #dee2e6;
    border-radius: 8px 8px 0 0;
    margin: -25px -25px 20px -25px;
}

.format-buttons .btn-group {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 6px;
    overflow: hidden;
}

.format-buttons .btn {
    padding: 0.6rem 1.2rem;
    font-size: 1rem;
    border: none;
    background: white;
    color: #495057;
    transition: all 0.2s ease;
}

.format-buttons .btn:hover {
    background: #e9ecef;
    color: #212529;
}

.format-buttons .btn:active {
    background: #dee2e6;
}

.btn-action-group {
    padding: 20px 0 0 0;
    border-top: 1px solid #dee2e6;
    margin-top: 20px;
}

.help-content {
    font-size: 0.9rem;
}

.help-content ul li {
    margin-bottom: 0.5rem;
}

.sticky-top {
    z-index: 99;
}

/* Önizleme kartı için ek stiller */
.preview-card {
    border: none;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.preview-card .card-header {
    padding: 15px 20px;
}

.preview-card .card-body {
    padding: 0;
    background: #f8f9fa;
}

/* Responsive düzenlemeler */
@media (max-width: 768px) {
    .preview-content {
        padding: 20px;
    }
    
    .preview-content h2 {
        font-size: 22px;
    }
    
    .preview-content h3 {
        font-size: 18px;
    }
    
    .preview-content p {
        font-size: 15px;
    }
    
    textarea#about_content {
        font-size: 16px;
        padding: 20px;
        line-height: 1.8;
    }
}
</style>

<script>
function insertTag(tag) {
    const textarea = document.getElementById('about_content');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    const replacement = `<${tag}>${selectedText}</${tag}>`;
    
    textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
    updatePreview();
}

function insertList() {
    const textarea = document.getElementById('about_content');
    const start = textarea.selectionStart;
    const listTemplate = '<ul>\n  <li>Liste öğesi 1</li>\n  <li>Liste öğesi 2</li>\n  <li>Liste öğesi 3</li>\n</ul>';
    
    textarea.value = textarea.value.substring(0, start) + listTemplate + textarea.value.substring(start);
    updatePreview();
}

function insertBreak() {
    const textarea = document.getElementById('about_content');
    const start = textarea.selectionStart;
    textarea.value = textarea.value.substring(0, start) + '<br>' + textarea.value.substring(start);
    updatePreview();
}

function updatePreview() {
    const content = document.getElementById('about_content').value;
    document.getElementById('preview').innerHTML = content;
}

// Otomatik önizleme güncellemesi
let previewTimeout;
document.getElementById('about_content').addEventListener('input', function() {
    clearTimeout(previewTimeout);
    previewTimeout = setTimeout(updatePreview, 500);
});
</script>

<?php include 'includes/footer.php'; ?>