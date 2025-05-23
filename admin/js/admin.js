document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle
    const toggleSidebar = document.querySelector('.toggle-sidebar');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (toggleSidebar) {
        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    }

    // Dosya yükleme önizleme
    const imageInputs = document.querySelectorAll('.image-upload');
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const preview = this.parentElement.querySelector('.image-preview');
            if(preview) {
                const file = this.files[0];
                if(file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            }
        });
    });

    // Form doğrulama
    const forms = document.querySelectorAll('form.validate');
    
    if (forms.length > 0) {
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (field.value.trim() === '') {
                        isValid = false;
                        showError(field, 'Bu alan boş bırakılamaz');
                    } else {
                        removeError(field);
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    }
    
    // Yardımcı fonksiyonlar
    function showError(input, message) {
        const formGroup = input.closest('.form-group');
        const errorDiv = formGroup.querySelector('.error-message') || document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.innerText = message;
        if (!formGroup.querySelector('.error-message')) {
            formGroup.appendChild(errorDiv);
        }
        input.classList.add('error');
    }
    
    function removeError(input) {
        const formGroup = input.closest('.form-group');
        const errorDiv = formGroup.querySelector('.error-message');
        if (errorDiv) {
            formGroup.removeChild(errorDiv);
        }
        input.classList.remove('error');
    }
    
    // Onay kutusu
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    if (deleteButtons.length > 0) {
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Bu öğeyi silmek istediğinizden emin misiniz?')) {
                    e.preventDefault();
                }
            });
        });
    }

    // Dashboard Animasyonları
    // Stat kartları için animasyon
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        // Kartları sırayla görünür yap
        setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            requestAnimationFrame(() => {
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            });
        }, index * 100);
    });

    // Dinamik arka plan efekti
    const dashboard = document.querySelector('.dashboard');
    if (dashboard) {
        let mouseX = 0;
        let mouseY = 0;

        dashboard.addEventListener('mousemove', (e) => {
            const rect = dashboard.getBoundingClientRect();
            mouseX = e.clientX - rect.left;
            mouseY = e.clientY - rect.top;

            // Gradient'i fare pozisyonuna göre güncelle
            const gradientX = (mouseX / rect.width) * 100;
            const gradientY = (mouseY / rect.height) * 100;
            
            dashboard.style.background = `radial-gradient(circle at ${gradientX}% ${gradientY}%, 
                rgba(54, 54, 54, 0.2) 0%, 
                rgba(28, 28, 28, 0.2) 50%, 
                transparent 70%)`;
        });

        // Fare dashboard'dan çıktığında arka planı sıfırla
        dashboard.addEventListener('mouseleave', () => {
            dashboard.style.background = 'none';
        });
    }

    // Tablo satırları için hover efekti
    const tableRows = document.querySelectorAll('.table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.style.transform = 'scale(1.01)';
            row.style.transition = 'transform 0.2s ease';
        });

        row.addEventListener('mouseleave', () => {
            row.style.transform = 'scale(1)';
        });
    });

    // İstatistik sayılarını canlandır
    const statNumbers = document.querySelectorAll('.stat-card p');
    statNumbers.forEach(stat => {
        const finalNumber = parseInt(stat.textContent);
        let currentNumber = 0;
        const duration = 1000; // 1 saniye
        const steps = 20;
        const increment = finalNumber / steps;
        const stepDuration = duration / steps;

        const animate = () => {
            currentNumber = Math.min(currentNumber + increment, finalNumber);
            stat.textContent = Math.round(currentNumber).toString();

            if (currentNumber < finalNumber) {
                setTimeout(animate, stepDuration);
            }
        };

        animate();
    });
}); 