<?php include 'includes/header.php'; ?>

<div class="dashboard">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Hoş Geldiniz</h2>
        </div>
        <p>Renkli Perde Tasarım yönetim paneline hoş geldiniz. Sol menüden yapmak istediğiniz işlemi seçebilirsiniz.</p>
    </div>

    <div class="stats-grid">
        <div class="card stat-card">
            <i class="fas fa-images"></i>
            <h3>Galeri</h3>
            <p>12 Görsel</p>
        </div>
        <div class="card stat-card">
            <i class="fas fa-envelope"></i>
            <h3>Mesajlar</h3>
            <p>5 Yeni Mesaj</p>
        </div>
        <div class="card stat-card">
            <i class="fas fa-eye"></i>
            <h3>Ziyaretçiler</h3>
            <p>1,234 Bu Ay</p>
        </div>
        <div class="card stat-card">
            <i class="fas fa-users"></i>
            <h3>Müşteriler</h3>
            <p>89 Aktif Müşteri</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Son Aktiviteler</h2>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Tarih</th>
                    <th>İşlem</th>
                    <th>Kullanıcı</th>
                    <th>Detay</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2024-03-20 14:30</td>
                    <td>Galeri Güncelleme</td>
                    <td>admin</td>
                    <td>2 yeni görsel eklendi</td>
                </tr>
                <tr>
                    <td>2024-03-20 11:15</td>
                    <td>İletişim Mesajı</td>
                    <td>Sistem</td>
                    <td>Yeni mesaj alındı</td>
                </tr>
                <tr>
                    <td>2024-03-19 16:45</td>
                    <td>İçerik Güncelleme</td>
                    <td>admin</td>
                    <td>Hakkımızda sayfası güncellendi</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.stat-card {
    text-align: center;
    padding: 20px;
}

.stat-card i {
    font-size: 2rem;
    color: #e74c3c;
    margin-bottom: 10px;
}

.stat-card h3 {
    margin-bottom: 5px;
    color: #333;
}

.stat-card p {
    color: #666;
    font-size: 1.1rem;
}
</style>

<?php include 'includes/footer.php'; ?> 