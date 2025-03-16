document.addEventListener('DOMContentLoaded', function() {
    // Mobil menü toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('nav');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            nav.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });
    }
    
    // Galeri filtreleme
    const filterButtons = document.querySelectorAll('.filter-buttons button');
    const galleryItems = document.querySelectorAll('.gallery-item');
    
    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Aktif buton sınıfını kaldır
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Tıklanan butona aktif sınıfı ekle
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                
                galleryItems.forEach(item => {
                    if (filter === 'all' || item.classList.contains(filter)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }
    
    // Form doğrulama
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            let isValid = true;
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const message = document.getElementById('message');
            
            // Basit doğrulama
            if (name.value.trim() === '') {
                isValid = false;
                showError(name, 'İsim alanı boş bırakılamaz');
            } else {
                removeError(name);
            }
            
            if (email.value.trim() === '') {
                isValid = false;
                showError(email, 'E-posta alanı boş bırakılamaz');
            } else if (!isValidEmail(email.value)) {
                isValid = false;
                showError(email, 'Geçerli bir e-posta adresi giriniz');
            } else {
                removeError(email);
            }
            
            if (message.value.trim() === '') {
                isValid = false;
                showError(message, 'Mesaj alanı boş bırakılamaz');
            } else {
                removeError(message);
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    // Yardımcı fonksiyonlar
    function showError(input, message) {
        const formControl = input.parentElement;
        const errorDiv = formControl.querySelector('.error-message') || document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.innerText = message;
        if (!formControl.querySelector('.error-message')) {
            formControl.appendChild(errorDiv);
        }
        input.classList.add('error');
    }
    
    function removeError(input) {
        const formControl = input.parentElement;
        const errorDiv = formControl.querySelector('.error-message');
        if (errorDiv) {
            formControl.removeChild(errorDiv);
        }
        input.classList.remove('error');
    }
    
    function isValidEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
}); 