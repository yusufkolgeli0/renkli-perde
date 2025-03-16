document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('nav');
    
    if (menuToggle && nav) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            nav.classList.toggle('active');
            menuToggle.classList.toggle('active');
            console.log('Menu clicked', nav.classList.contains('active')); // Debug için
        });

        // Menü öğelerine tıklandığında menüyü kapat
        const menuItems = document.querySelectorAll('nav ul li a');
        menuItems.forEach(item => {
            item.addEventListener('click', () => {
                nav.classList.remove('active');
                menuToggle.classList.remove('active');
            });
        });

        // Sayfa scroll olduğunda menüyü kapat
        window.addEventListener('scroll', () => {
            if(nav.classList.contains('active')) {
                nav.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        });
    }
}); 