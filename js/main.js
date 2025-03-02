document.addEventListener('DOMContentLoaded', function() {
    // Header scroll efekti
    const header = document.querySelector('header');
    let lastScroll = 0;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        if (currentScroll <= 0) {
            header.classList.remove('scroll-up');
            return;
        }

        if (currentScroll > lastScroll && !header.classList.contains('scroll-down')) {
            // Aşağı scroll
            header.classList.remove('scroll-up');
            header.classList.add('scroll-down');
        } else if (currentScroll < lastScroll && header.classList.contains('scroll-down')) {
            // Yukarı scroll
            header.classList.remove('scroll-down');
            header.classList.add('scroll-up');
        }
        lastScroll = currentScroll;
    });

    // Form gönderim durumu kontrolü
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'success') {
        showNotification('Mesajınız başarıyla gönderildi!', 'success');
    } else if (status === 'error') {
        showNotification('Mesaj gönderilirken bir hata oluştu. Lütfen tekrar deneyin.', 'error');
    }

    // Sayfa geçişlerini yönet
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.page-section');

    // Sayfa yüklendiğinde URL'deki hash'e göre ilgili bölümü göster
    const hash = window.location.hash || '#home';
    showSection(hash.substring(1));

    // Navigasyon linklerine tıklama olaylarını ekle
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionId = this.getAttribute('href').substring(1);
            showSection(sectionId);
            window.location.hash = sectionId;
        });
    });

    // Bölüm gösterme fonksiyonu
    function showSection(sectionId) {
        // Aktif nav linkini güncelle
        navLinks.forEach(link => {
            if (link.getAttribute('href') === '#' + sectionId) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });

        // Aktif bölümü göster
        sections.forEach(section => {
            if (section.id === sectionId) {
                section.classList.add('active');
                section.style.opacity = '0';
                section.style.display = 'block';
                setTimeout(() => {
                    section.style.opacity = '1';
                }, 50);
            } else {
                section.classList.remove('active');
                section.style.display = 'none';
            }
        });
    }

    // Sayfa kaydırma animasyonu
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 70,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Galeri resimlerini yükle
    const galleryGrid = document.querySelector('.gallery-grid');
    if (galleryGrid) {
        const images = [
            'perde1.jpg', 'perde2.jpg', 'perde3.jpg', 
            'perde4.jpg', 'perde5.jpg', 'perde6.jpg', 'perde7.jpg'
        ];

        images.forEach(image => {
            const imgContainer = document.createElement('div');
            imgContainer.className = 'gallery-item';
            
            const img = document.createElement('img');
            img.src = `images/${image}`;
            img.alt = 'Perde Örneği';
            
            imgContainer.appendChild(img);
            galleryGrid.appendChild(imgContainer);
        });
    }

    // İletişim formu gönderimi
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Form gönderimi işlemleri burada yapılacak
            alert('Mesajınız gönderildi! En kısa sürede size dönüş yapacağız.');
            this.reset();
        });
    }
});

// Bildirim gösterme fonksiyonu
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // 3 saniye sonra bildirimi kaldır
    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Mobil menü toggle
const menuToggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('nav');

if (menuToggle) {
    menuToggle.addEventListener('click', () => {
        nav.classList.toggle('active');
        menuToggle.classList.toggle('active');
    });
} 