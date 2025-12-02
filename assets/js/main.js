// Dental Landing Theme JS
(function(){
    // ===== HERO SLIDER =====
    var heroSlides = document.querySelectorAll('.mlt-hero-slide');
    var heroDots = document.querySelectorAll('.mlt-hero-dot');
    var heroPrev = document.querySelector('.mlt-hero-prev');
    var heroNext = document.querySelector('.mlt-hero-next');
    var currentSlide = 0;
    var slideAutoplayInterval = null;

    function showSlide(n) {
        if (n >= heroSlides.length) currentSlide = 0;
        if (n < 0) currentSlide = heroSlides.length - 1;
        
        heroSlides.forEach(function(slide) { slide.classList.remove('active'); });
        heroDots.forEach(function(dot) { dot.classList.remove('active'); });
        
        if (heroSlides.length > 0) {
            heroSlides[currentSlide].classList.add('active');
        }
        if (heroDots.length > 0 && heroDots[currentSlide]) {
            heroDots[currentSlide].classList.add('active');
        }
    }

    function nextSlide() {
        currentSlide++;
        showSlide(currentSlide);
        resetAutoplay();
    }

    function prevSlide() {
        currentSlide--;
        showSlide(currentSlide);
        resetAutoplay();
    }

    function goToSlide(n) {
        currentSlide = n;
        showSlide(currentSlide);
        resetAutoplay();
    }

    function autoplay() {
        if (heroSlides.length > 1) {
            slideAutoplayInterval = setInterval(function() {
                currentSlide++;
                showSlide(currentSlide);
            }, 5000); // 5 second interval
        }
    }

    function resetAutoplay() {
        if (slideAutoplayInterval) {
            clearInterval(slideAutoplayInterval);
        }
        autoplay();
    }

    // Event listeners for slider controls
    if (heroPrev) {
        heroPrev.addEventListener('click', prevSlide);
    }
    if (heroNext) {
        heroNext.addEventListener('click', nextSlide);
    }

    heroDots.forEach(function(dot, index) {
        dot.addEventListener('click', function() {
            goToSlide(index);
        });
    });

    // Initialize hero slider
    if (heroSlides.length > 0) {
        showSlide(currentSlide);
        autoplay();
        
        // Pause autoplay on mouse over hero
        var heroContainer = document.querySelector('.mlt-hero');
        if (heroContainer) {
            heroContainer.addEventListener('mouseenter', function() {
                if (slideAutoplayInterval) {
                    clearInterval(slideAutoplayInterval);
                }
            });
            heroContainer.addEventListener('mouseleave', resetAutoplay);
        }
    }

    // Mobile Menu Toggle
    var menuToggle = document.getElementById('mlt-menu-toggle');
    var navMenu = document.getElementById('mlt-nav-menu');
    
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function(){
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
        
        // Close menu when clicking on a link
        var navLinks = navMenu.querySelectorAll('a');
        navLinks.forEach(function(link){
            link.addEventListener('click', function(){
                menuToggle.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e){
            if (!e.target.closest('.mlt-header')) {
                menuToggle.classList.remove('active');
                navMenu.classList.remove('active');
            }
        });
    }

    // Smooth scroll for anchor links
    document.addEventListener('click', function(e){
        var t = e.target.closest('a');
        if (!t) return;
        var href = t.getAttribute('href');
        if (href && href.startsWith('#') && href.length > 1) {
            var el = document.querySelector(href);
            if (el) {
                e.preventDefault();
                el.scrollIntoView({behavior:'smooth'});
                // Close mobile menu if open
                if (menuToggle) {
                    menuToggle.classList.remove('active');
                    navMenu.classList.remove('active');
                }
            }
        }
    });

    // Simple reveal on scroll
    var ritems = document.querySelectorAll('.mlt-feature, .mlt-plan, .mlt-testimonial, .mlt-service-card, .mlt-team-member');
    function reveal() {
        var h = window.innerHeight;
        ritems.forEach(function(it){
            if (!it.classList.contains('revealed')) {
                var r = it.getBoundingClientRect();
                if (r.top < h - 60) {
                    it.style.opacity = '1';
                    it.style.transform = 'translateY(0)';
                    it.classList.add('revealed');
                }
            }
        });
    }
    ritems.forEach(function(it){ 
        it.style.opacity = '0'; 
        it.style.transform = 'translateY(12px)'; 
        it.style.transition = 'all 600ms cubic-bezier(0.34, 1.56, 0.64, 1)';
    });
    window.addEventListener('scroll', reveal, { passive: true });
    window.addEventListener('load', reveal);
    reveal(); // Trigger on initial load
})();
