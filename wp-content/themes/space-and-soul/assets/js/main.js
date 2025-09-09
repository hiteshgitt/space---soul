/**
 * Main JavaScript file for Space and Soul theme
 *
 * @package Space_And_Soul
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        initMobileMenu();
        initLazyLoading();
        initBackToTop();
        initSmoothScroll();
        initFormValidation();
        initPerformanceOptimizations();
    });

    // Mobile menu toggle
    function initMobileMenu() {
        $('.menu-toggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            $(this).addClass('active');
            $('#mobile-menu').addClass('active');
            $('body').addClass('menu-open');
        });

        // Close menu button
        $('.menu-close').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            closeMenu();
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation, .menu-toggle, #mobile-menu').length) {
                closeMenu();
            }
        });
        
        // Close menu when clicking on menu links
        $('#mobile-menu a').on('click', function() {
            closeMenu();
        });
        
        // Close menu on escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMenu();
            }
        });
        
        // Close menu function
        function closeMenu() {
                $('.menu-toggle').removeClass('active');
            $('#mobile-menu').removeClass('active');
                $('body').removeClass('menu-open');
            }
    }

    // Lazy loading for images
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        } else {
            // Fallback for older browsers
            document.querySelectorAll('img[data-src]').forEach(img => {
                img.src = img.dataset.src;
                img.classList.add('loaded');
            });
        }
    }

    // Back to top button
    function initBackToTop() {
        const backToTop = $('#back-to-top');
        
        if (backToTop.length) {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    backToTop.addClass('visible');
                } else {
                    backToTop.removeClass('visible');
                }
            });

            backToTop.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, 600);
            });
        }
    }

    // Smooth scroll for anchor links
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').on('click', function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
                let target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 600);
                    return false;
                }
            }
        });
    }

    // Form validation
    function initFormValidation() {
        $('form').on('submit', function(e) {
            const form = $(this);
            let isValid = true;

            // Required field validation
            form.find('[required]').each(function() {
                const field = $(this);
                if (!field.val().trim()) {
                    field.addClass('error');
                    isValid = false;
                } else {
                    field.removeClass('error');
                }
            });

            // Email validation
            form.find('input[type="email"]').each(function() {
                const field = $(this);
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (field.val() && !emailRegex.test(field.val())) {
                    field.addClass('error');
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                showNotification('Please fill in all required fields correctly.', 'error');
            }
        });
    }

    // Performance optimizations
    function initPerformanceOptimizations() {
        // Preload critical resources
        preloadCriticalResources();
        
        // Optimize images
        optimizeImages();
        
        // Defer non-critical JavaScript
        deferNonCriticalJS();
    }

    // Preload critical resources
    function preloadCriticalResources() {
        const criticalResources = [
            { href: spaceAndSoul.themeUrl + '/assets/css/critical.css', as: 'style' },
            { href: spaceAndSoul.themeUrl + '/assets/js/main.js', as: 'script' }
        ];

        criticalResources.forEach(resource => {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.href = resource.href;
            link.as = resource.as;
            document.head.appendChild(link);
        });
    }

    // Optimize images
    function optimizeImages() {
        // Add WebP support detection
        if (supportsWebP()) {
            $('img').each(function() {
                const img = $(this);
                const src = img.attr('src');
                if (src && !src.includes('.webp')) {
                    const webpSrc = src.replace(/\.(jpg|jpeg|png)$/i, '.webp');
                    img.attr('data-webp', webpSrc);
                }
            });
        }
    }

    // Check WebP support
    function supportsWebP() {
        const canvas = document.createElement('canvas');
        canvas.width = 1;
        canvas.height = 1;
        return canvas.toDataURL('image/webp').indexOf('data:image/webp') === 0;
    }

    // Defer non-critical JavaScript
    function deferNonCriticalJS() {
        const nonCriticalScripts = [
            '//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js',
            '//cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js'
        ];

        nonCriticalScripts.forEach(src => {
            const script = document.createElement('script');
            script.src = src;
            script.defer = true;
            document.head.appendChild(script);
        });
    }

    // Utility functions
    function showNotification(message, type = 'info') {
        const notification = $(`
            <div class="notification notification-${type}">
                <span class="notification-message">${message}</span>
                <button class="notification-close">&times;</button>
            </div>
        `);

        $('body').append(notification);

        setTimeout(() => {
            notification.addClass('show');
        }, 100);

        notification.find('.notification-close').on('click', function() {
            notification.removeClass('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        });

        setTimeout(() => {
            notification.removeClass('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    }

    // AJAX functions
    function loadMorePosts(page) {
        $.ajax({
            url: spaceAndSoul.ajaxUrl,
            type: 'POST',
            data: {
                action: 'load_more_posts',
                page: page,
                nonce: spaceAndSoul.nonce
            },
            beforeSend: function() {
                $('.load-more').addClass('loading');
            },
            success: function(response) {
                if (response.success) {
                    $('.posts-container').append(response.data.html);
                    $('.load-more').removeClass('loading');
                    
                    if (response.data.has_more) {
                        $('.load-more').show();
                    } else {
                        $('.load-more').hide();
                    }
                }
            },
            error: function() {
                $('.load-more').removeClass('loading');
                showNotification('Error loading more posts.', 'error');
            }
        });
    }

    // Event listeners
    $(document).on('click', '.load-more', function(e) {
        e.preventDefault();
        const page = $(this).data('page') || 2;
        loadMorePosts(page);
        $(this).data('page', page + 1);
    });

    // Button text scramble effect
    function initScrambleEffect() {
        // Use both jQuery and vanilla JS for better compatibility
        const buttons = document.querySelectorAll('.banner-button, .read-more, .button, .wp-block-button__link, .scramble-button');
        
        buttons.forEach(button => {
            const originalText = button.textContent.trim();
            let scrambleInterval = null;
            
            function startScramble() {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
                let iteration = 0;
                const totalFrames = 10; // Reduced to 10 frames for half duration
                
                // Clear any existing interval
                if (scrambleInterval) {
                    clearInterval(scrambleInterval);
                }
                
                scrambleInterval = setInterval(() => {
                    // Scramble ALL characters at once, not progressively
                    button.textContent = originalText
                        .split('')
                        .map((char, index) => {
                            // Only show original text in the last 2 frames
                            if (iteration >= totalFrames - 2) {
                                return originalText[index];
                            }
                            // Otherwise scramble all characters
                            return chars[Math.floor(Math.random() * chars.length)];
                        })
                        .join('');
                    
                    iteration++;
                    
                    if (iteration >= totalFrames) {
                        clearInterval(scrambleInterval);
                        button.textContent = originalText;
                        scrambleInterval = null;
                    }
                }, 50); // Same interval but half the frames
            }
            
            function stopScramble() {
                if (scrambleInterval) {
                    clearInterval(scrambleInterval);
                    scrambleInterval = null;
                }
                button.textContent = originalText;
            }
            
            // Remove existing listeners
            button.removeEventListener('mouseenter', startScramble);
            button.removeEventListener('mouseleave', stopScramble);
            
            // Add new listeners
            button.addEventListener('mouseenter', startScramble);
            button.addEventListener('mouseleave', stopScramble);
        });
    }

// Initialize scramble effect
initScrambleEffect();

// Mouse movement detection variables
let mouseMovementTimer = null;
let isMouseMoving = false;
let lastMousePosition = { x: 0, y: 0 };

// Optimized Interactive Blocks Grid Generation
function generateBlocks() {
    console.log('Generating blocks...');
    
    const grid = document.getElementById('blocksGrid');
    const banner = document.querySelector('.hero-banner');
    
    if (!grid) {
        console.log('Grid not found!');
        return;
    }
    
    if (!banner) {
        console.log('Banner not found!');
        return;
    }
    
    const containerWidth = banner.offsetWidth;
    const containerHeight = banner.offsetHeight;
    const blockSize = 30; // Consistent 30px block size as per CSS
    const gap = 2;
    const padding = 0; // No padding to prevent overflow
    
    const availableWidth = containerWidth - (padding * 2);
    const availableHeight = containerHeight - (padding * 2);
    
    // Calculate blocks to fill the entire width
    const blocksPerRow = Math.floor(availableWidth / (blockSize + gap));
    const blocksPerColumn = Math.floor(availableHeight / (blockSize + gap));
    const totalBlocks = blocksPerRow * blocksPerColumn;
    
    // Ensure we have enough blocks to cover the full area
    const minBlocksPerRow = Math.ceil(availableWidth / (blockSize + gap));
    const minBlocksPerColumn = Math.ceil(availableHeight / (blockSize + gap));
    const minTotalBlocks = minBlocksPerRow * minBlocksPerColumn;
    
    // Use the larger calculation to ensure full coverage
    const finalBlocksPerRow = Math.max(blocksPerRow, minBlocksPerRow);
    const finalBlocksPerColumn = Math.max(blocksPerColumn, minBlocksPerColumn);
    const finalTotalBlocks = finalBlocksPerRow * finalBlocksPerColumn;
    
    console.log(`Container: ${containerWidth}x${containerHeight}, Final Blocks: ${finalBlocksPerRow}x${finalBlocksPerColumn}, Total: ${finalTotalBlocks}`);
    
    // Clear existing blocks
    grid.innerHTML = '';
    
    // Set grid template columns dynamically
    grid.style.gridTemplateColumns = `repeat(${finalBlocksPerRow}, ${blockSize}px)`;
    grid.style.gridTemplateRows = `repeat(${finalBlocksPerColumn}, ${blockSize}px)`;
    
    // Create optimized blocks with movement-based highlighting
    for (let i = 0; i < finalTotalBlocks; i++) {
        const block = document.createElement('div');
        block.className = 'block';
        block.style.width = blockSize + 'px';
        block.style.height = blockSize + 'px';
        
        // Movement-based hover effect
        block.addEventListener('mouseenter', function() {
            if (isMouseMoving) {
                console.log('Block hovered during movement!');
                
                // Clear all previous highlights first
                document.querySelectorAll('.block').forEach(b => {
                    b.classList.remove('active');
                });
                
                const allBlocks = document.querySelectorAll('.block');
                const currentIndex = Array.from(allBlocks).indexOf(this);
                const row = Math.floor(currentIndex / finalBlocksPerRow);
                const col = currentIndex % finalBlocksPerRow;
                
                // Highlight surrounding blocks only during movement
                highlightSurroundingBlocks(row, col, finalBlocksPerRow, finalBlocksPerColumn, allBlocks);
            }
        });
        
        block.addEventListener('mouseleave', function() {
            // Don't remove highlights immediately - let movement timer handle it
        });
        
        grid.appendChild(block);
    }
    
    console.log(`Generated ${finalTotalBlocks} blocks successfully!`);
}

// Optimized surrounding blocks highlight function
function highlightSurroundingBlocks(centerRow, centerCol, blocksPerRow, blocksPerColumn, allBlocks) {
    console.log(`Highlighting blocks around row ${centerRow}, col ${centerCol}`);
    
    // Use requestAnimationFrame for smoother animations
    requestAnimationFrame(() => {
        for (let r = -1; r <= 1; r++) {
            for (let c = -1; c <= 1; c++) {
                const newRow = centerRow + r;
                const newCol = centerCol + c;
                
                if (newRow >= 0 && newRow < blocksPerColumn && newCol >= 0 && newCol < blocksPerRow) {
                    const index = newRow * blocksPerRow + newCol;
                    if (allBlocks[index]) {
                        const distance = Math.abs(r) + Math.abs(c);
                        const delay = distance * 15; // Reduced delay for faster response
                        
                        setTimeout(() => {
                            allBlocks[index].classList.add('active');
                            console.log(`Activated block at index ${index}`);
                        }, delay);
                    }
                }
            }
        }
    });
}

// Mouse movement detection functions
function initMouseMovementDetection() {
    const banner = document.querySelector('.hero-banner');
    if (!banner) return;
    
    // Track mouse movement
    banner.addEventListener('mousemove', function(e) {
        const currentX = e.clientX;
        const currentY = e.clientY;
        
        // Check if mouse has actually moved (not just jitter)
        const deltaX = Math.abs(currentX - lastMousePosition.x);
        const deltaY = Math.abs(currentY - lastMousePosition.y);
        
        if (deltaX > 2 || deltaY > 2) { // Minimum movement threshold
            isMouseMoving = true;
            lastMousePosition = { x: currentX, y: currentY };
            
            // Clear existing timer
            if (mouseMovementTimer) {
                clearTimeout(mouseMovementTimer);
            }
            
            // Set timer to stop highlighting after mouse stops moving
            mouseMovementTimer = setTimeout(() => {
                isMouseMoving = false;
                console.log('Mouse stopped moving - removing highlights');
                // Remove all highlights when mouse stops moving
                document.querySelectorAll('.block').forEach(b => {
                    b.classList.remove('active');
                });
            }, 100); // 100ms delay after mouse stops moving
        }
    });
    
    // Reset movement state when mouse leaves banner
    banner.addEventListener('mouseleave', function() {
        isMouseMoving = false;
        if (mouseMovementTimer) {
            clearTimeout(mouseMovementTimer);
        }
        // Remove all highlights when mouse leaves
        document.querySelectorAll('.block').forEach(b => {
            b.classList.remove('active');
        });
    });
}

// Initialize blocks with improved performance detection
function initInteractiveBlocks() {
    console.log('Initializing interactive blocks...');
    
    // More lenient device detection - only disable on very old devices
    const isVeryOldDevice = navigator.hardwareConcurrency <= 1 || 
                           (navigator.deviceMemory && navigator.deviceMemory <= 2);
    
    // Only disable on very old devices, not mobile devices
    if (isVeryOldDevice) {
        console.log('Very old device detected, disabling blocks');
        const grid = document.getElementById('blocksGrid');
        if (grid) {
            grid.style.display = 'none';
        }
        return;
    }
    
    console.log('Device is capable, enabling blocks');
    
    // Initialize mouse movement detection
    initMouseMovementDetection();
    
    // Generate blocks on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', generateBlocks);
    } else {
        generateBlocks();
    }
    
    // Throttled resize handler for better performance
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(generateBlocks, 250);
    });
}

// Initialize interactive blocks
initInteractiveBlocks();

// Fallback initialization after a delay to ensure everything is loaded
setTimeout(() => {
    console.log('Fallback initialization...');
    const grid = document.getElementById('blocksGrid');
    if (grid && grid.children.length === 0) {
        console.log('No blocks found, forcing generation...');
        generateBlocks();
    }
}, 1000);

// Banner Content Animation
function initBannerAnimation() {
    const bannerContent = document.querySelector('.banner-content');
    
    if (!bannerContent) {
        return;
    }
    
    // Add animation class after a short delay to ensure page is loaded
    setTimeout(() => {
        bannerContent.classList.add('animate');
    }, 100);
}

// Initialize banner animation
initBannerAnimation();

// Header Scroll Effect
function initHeaderScrollEffect() {
    const header = document.querySelector('.site-header');
    
    if (!header) {
        return;
    }
    
    let lastScrollY = window.scrollY;
    
    function updateHeader() {
        const currentScrollY = window.scrollY;
        
        if (currentScrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        lastScrollY = currentScrollY;
    }
    
    // Throttle scroll event for better performance
    let ticking = false;
    
    function onScroll() {
        if (!ticking) {
            requestAnimationFrame(() => {
                updateHeader();
                ticking = false;
            });
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', onScroll, { passive: true });
    
    // Initial check
    updateHeader();
}

// Initialize header scroll effect
initHeaderScrollEffect();
    
// Parallax and Text Animation Functions
function initParallaxEffects() {
    const parallaxImage = document.querySelector('.parallax-image');
    const textureImage = document.querySelector('.texture-image');
    const aboutSection = document.querySelector('.about-section');
    
    if (!parallaxImage || !textureImage || !aboutSection) return;
    
    let ticking = false;
    
    function updateParallax() {
        const rect = aboutSection.getBoundingClientRect();
        const scrolled = window.pageYOffset;
        
        // Calculate how much of the section is visible
        const sectionHeight = aboutSection.offsetHeight;
        const viewportHeight = window.innerHeight;
        const sectionTop = rect.top;
        const sectionBottom = rect.bottom;
        
        if (sectionTop < viewportHeight && sectionBottom > 0) {
            // Calculate progress through the section (0 to 1)
            const progress = Math.max(0, Math.min(1, (viewportHeight - sectionTop) / (viewportHeight + sectionHeight)));
            
            // Keep main image static (no transform)
            parallaxImage.style.transform = 'none';
            
            // Apply zoom effect only to texture overlay
            const zoomFactor = 1.0 + (progress * 0.8); // Zoom from 1.0x to 1.8x
            const translateY = progress * -30; // Slight vertical movement for parallax
            
            textureImage.style.transform = `scale(${zoomFactor}) translateY(${translateY}px)`;
        } else {
            // Reset transforms when section is not visible
            parallaxImage.style.transform = 'none';
            textureImage.style.transform = 'scale(1) translateY(0)';
        }
        
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', requestTick, { passive: true });
}

// Text Fill Animation
function initTextFillAnimation() {
    const textElements = document.querySelectorAll('.text-fill');
    const aboutSection = document.querySelector('.about-section');
    
    if (!textElements.length || !aboutSection) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
            setTimeout(() => {
                    entry.target.classList.add('animate');
                }, 200);
            }
        });
    }, {
        threshold: 0.3,
        rootMargin: '0px 0px -100px 0px'
    });
    
    textElements.forEach(element => {
        observer.observe(element);
    });
}

// Content Animation
function initContentAnimation() {
    const aboutDescription = document.querySelector('.about-description');
    const aboutActions = document.querySelector('.about-actions');
    const aboutSection = document.querySelector('.about-section');
    
    if (!aboutSection) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Animate description
                if (aboutDescription) {
                    setTimeout(() => {
                        aboutDescription.classList.add('animate');
                    }, 400);
                }
                
                // Animate action buttons
                if (aboutActions) {
            setTimeout(() => {
                        aboutActions.classList.add('animate');
                    }, 600);
                }
            }
        });
    }, {
        threshold: 0.2,
        rootMargin: '0px 0px -50px 0px'
    });
    
    observer.observe(aboutSection);
}

    // Scroll-based Character Color Animation
    function initScrollTextAnimation() {
        console.log('Initializing scroll text animation...');
        const scrollTextElements = document.querySelectorAll('.scroll-text');
        const aboutSection = document.querySelector('.about-section');
        
        console.log('Scroll text elements found:', scrollTextElements.length);
        console.log('About section found:', !!aboutSection);
        
        if (!scrollTextElements.length || !aboutSection) {
            console.log('Missing elements, returning...');
            return;
        }
        
        // Process each text element to create character structure
        scrollTextElements.forEach(element => {
            const text = element.getAttribute('data-text');
            if (!text) return;
            
            console.log('Processing text:', text.substring(0, 50) + '...');
            
            // Clear the element
            element.innerHTML = '';
            
            // Split text into words and characters
            const words = text.split(' ');
            words.forEach((word, wordIndex) => {
                const wordDiv = document.createElement('div');
                wordDiv.className = 'word';
                
                // Split word into characters
                const chars = word.split('');
                chars.forEach((char, charIndex) => {
                    const charDiv = document.createElement('div');
                    charDiv.className = 'char';
                    charDiv.textContent = char;
                    charDiv.style.animationDelay = `${(wordIndex * 0.1) + (charIndex * 0.05)}s`;
                    wordDiv.appendChild(charDiv);
                });
                
                element.appendChild(wordDiv);
                
                // Add space after word (except last word)
                if (wordIndex < words.length - 1) {
                    const spaceDiv = document.createElement('div');
                    spaceDiv.className = 'char';
                    spaceDiv.textContent = ' ';
                    spaceDiv.style.animationDelay = `${(wordIndex * 0.1) + (chars.length * 0.05)}s`;
                    element.appendChild(spaceDiv);
                }
            });
        });
        
        console.log('Character structure created');
        
        // Scroll-based color change
        function updateCharacterColors() {
            const rect = aboutSection.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            const sectionTop = rect.top;
            const sectionHeight = rect.height;
            
            // Calculate scroll progress through the section (0 to 1)
            const scrollProgress = Math.max(0, Math.min(1, (viewportHeight - sectionTop) / (viewportHeight + sectionHeight)));
            
            // Get all characters
            const allChars = aboutSection.querySelectorAll('.scroll-text .char');
            const totalChars = allChars.length;
            
            // Calculate how many characters should be white based on scroll progress
            const charsToAnimate = Math.floor(scrollProgress * totalChars);
            
            // Only log every 10th character to avoid spam
            if (charsToAnimate % 10 === 0) {
                console.log('Scroll progress:', scrollProgress, 'Chars to animate:', charsToAnimate, 'Total chars:', totalChars);
            }
            
            // Update character colors
            allChars.forEach((char, index) => {
                if (index < charsToAnimate) {
                    char.classList.add('animate');
                    char.style.color = '#ffffff'; // Force white color
        } else {
                    char.classList.remove('animate');
                    char.style.color = '#ffffff30'; // Force white 30% opacity
                }
            });
        }
        
        // Throttled scroll handler
        let ticking = false;
        function onScroll() {
            if (!ticking) {
                requestAnimationFrame(() => {
                    updateCharacterColors();
                    ticking = false;
                });
                ticking = true;
            }
        }
        
        window.addEventListener('scroll', onScroll, { passive: true });
        
        // Initial call
        updateCharacterColors();
    }

    // Services Sticky Images
    function initServicesStickyImages() {
        const serviceItems = document.querySelectorAll('.service-item');
        const serviceImages = document.querySelectorAll('.service-image');
        const servicesSection = document.querySelector('.services-section');
        const servicesImages = document.querySelector('.services-images');
        
        if (!serviceItems.length || !serviceImages.length || !servicesSection || !servicesImages) return;
        
        console.log('Initializing services sticky images...');
        
        // Set first service as active
        serviceItems[0].classList.add('active');
        
        // Control positioning within services section
        function handleFixedPosition() {
            const rect = servicesSection.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            const viewportWidth = window.innerWidth;
            const stickyTop = viewportHeight * 0.1; // 10vh
            const imageHeight = viewportHeight * 0.8; // 80vh in pixels
            
            // On mobile/tablet, use normal flow (no fixed positioning)
            if (viewportWidth <= 1024) {
                servicesImages.style.position = 'relative';
                servicesImages.style.top = 'auto';
                servicesImages.style.right = 'auto';
                servicesImages.style.left = 'auto';
                servicesImages.style.width = '100%';
                servicesImages.style.display = 'block';
                servicesImages.style.opacity = '1';
                return;
            }
            
            // Desktop: Only show images when services section is in view and has enough space
            if (rect.top < viewportHeight && rect.bottom > 0) {
                // Check if there's enough space for the images
                const availableSpace = rect.bottom - Math.max(rect.top, stickyTop);
                
                if (availableSpace >= imageHeight) {
                    servicesImages.style.display = 'block';
                    servicesImages.style.opacity = '1';
                    
                    if (rect.top <= stickyTop) {
                        // Section has reached sticky point, use fixed positioning
                        servicesImages.style.position = 'fixed';
                        servicesImages.style.top = stickyTop + 'px';
                    } else {
                        // Section hasn't reached sticky point yet, position relative to section
                        servicesImages.style.position = 'absolute';
                        servicesImages.style.top = (stickyTop - rect.top) + 'px';
                    }
                } else {
                    // Not enough space, hide images
                    servicesImages.style.display = 'none';
                    servicesImages.style.opacity = '0';
                }
            } else {
                // Hide images when section is not in view
                servicesImages.style.display = 'none';
                servicesImages.style.opacity = '0';
            }
        }
        
        // Scroll-based image switching using Intersection Observer
        function updateActiveService() {
            // Check which service is currently in viewport
            let activeIndex = 0;
            let maxVisibility = 0;
            
            serviceItems.forEach((item, index) => {
                const rect = item.getBoundingClientRect();
                const viewportHeight = window.innerHeight;
                
                // Calculate how much of the item is visible
                const itemTop = rect.top;
                const itemBottom = rect.bottom;
                const itemHeight = rect.height;
                
                // Calculate visibility percentage
                let visibility = 0;
                if (itemTop < viewportHeight && itemBottom > 0) {
                    const visibleTop = Math.max(0, itemTop);
                    const visibleBottom = Math.min(viewportHeight, itemBottom);
                    const visibleHeight = visibleBottom - visibleTop;
                    visibility = visibleHeight / itemHeight;
                }
                
                // Also check if item is in the center of viewport
                const centerDistance = Math.abs((itemTop + itemHeight / 2) - (viewportHeight / 2));
                const centerVisibility = Math.max(0, 1 - (centerDistance / (viewportHeight / 2)));
                
                // Combine visibility and center position
                const combinedVisibility = (visibility + centerVisibility) / 2;
                
                if (combinedVisibility > maxVisibility) {
                    maxVisibility = combinedVisibility;
                    activeIndex = index;
                }
                
                console.log(`Service ${index}: visibility=${visibility.toFixed(2)}, center=${centerVisibility.toFixed(2)}, combined=${combinedVisibility.toFixed(2)}`);
            });
            
            console.log('Active service:', activeIndex, 'Max visibility:', maxVisibility.toFixed(2));
            
            // Update service items
            serviceItems.forEach((item, index) => {
                if (index === activeIndex) {
                    item.classList.add('active');
                    item.style.opacity = '';
                } else {
                    item.classList.remove('active');
                    item.style.opacity = '';
                }
            });
            
            // Update images
            serviceImages.forEach((img, index) => {
                if (index === activeIndex) {
                    img.classList.add('active');
                    img.classList.remove('next', 'prev');
                    img.style.opacity = '';
                } else if (index > activeIndex) {
                    img.classList.remove('active', 'prev');
                    img.classList.add('next');
                    img.style.opacity = '';
        } else {
                    img.classList.remove('active', 'next');
                    img.classList.add('prev');
                    img.style.opacity = '';
                }
            });
        }
        
        // More responsive scroll handler
        let ticking = false;
        function onScroll() {
            if (!ticking) {
                requestAnimationFrame(() => {
                    // Image switching handled by CSS sticky positioning
                    updateActiveService();
                    ticking = false;
                });
                ticking = true;
            }
        }
        
        // Also listen for wheel events for more immediate response
        function onWheel() {
            if (!ticking) {
                requestAnimationFrame(() => {
                    // Image switching handled by CSS sticky positioning
                    updateActiveService();
                    ticking = false;
                });
                ticking = true;
            }
        }
        
        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('wheel', onWheel, { passive: true });
        
        // Initial call - no complex positioning needed with sticky
        updateActiveService();
        
        // Click handlers for service items
        serviceItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                // Remove active class from all items
                serviceItems.forEach(i => i.classList.remove('active'));
                // Add active class to clicked item
                item.classList.add('active');
                
                // Update images
                serviceImages.forEach((img, imgIndex) => {
                    if (imgIndex === index) {
                        img.classList.add('active');
                        img.classList.remove('next', 'prev');
                    } else if (imgIndex > index) {
                        img.classList.remove('active', 'prev');
                        img.classList.add('next');
                    } else {
                        img.classList.remove('active', 'next');
                        img.classList.add('prev');
                    }
                });
            });
        });
    }

    // Initialize all effects
    function initAboutSectionEffects() {
        initParallaxEffects();
        initTextFillAnimation();
        initScrollTextAnimation();
        initContentAnimation();
    }

    // Initialize services effects
    function initServicesEffects() {
        initServicesStickyImages();
    }

    // Projects Cards Horizontal Scroll Animation
    function initProjectsAnimation() {
        const projectCards = document.querySelectorAll('.project-card');
        const projectsSection = document.querySelector('.projects-section');
        const projectsStickyWrapper = document.querySelector('.projects-sticky-wrapper');
        const projectsGrid = document.querySelector('.projects-grid');
        const projectsContainer = document.querySelector('.projects-container');
        const projectsHeader = document.querySelector('.projects-header');
        
        if (!projectCards.length || !projectsSection || !projectsStickyWrapper || !projectsGrid || !projectsContainer || !projectsHeader) return;
        
        console.log('Initializing projects horizontal scroll animation...');
        
        // Calculate dimensions
        const cardWidth = 666; // Card width (updated to match CSS)
        const gap = 32; // 2rem gap
        const totalCardWidth = cardWidth + gap;
        const totalCards = projectCards.length;
        const visibleCards = 2; // Show 2.2 cards at a time
        
        // Calculate how much we need to scroll to show all cards
        const totalContentWidth = (totalCards * totalCardWidth) - gap; // Total width of all cards
        const containerWidth = projectsContainer.offsetWidth;
        
        // Calculate the width of visible cards (2.2 cards)
        // Use the actual container width instead of calculated visible width
        const visibleWidth = projectsContainer.offsetWidth - 64; // Subtract padding (2rem = 32px on each side)
        
        // Calculate max scroll distance with both CSS padding and JS buffer
        // CSS padding-right: 400px + JS buffer for extra space
        const rightBuffer = 600; // Increased buffer (400px CSS + 200px JS = 600px total)
        const maxScrollDistance = totalContentWidth - visibleWidth + rightBuffer;
        
        console.log('=== DEBUG INFO ===');
        console.log('Total cards:', totalCards);
        console.log('Card width:', cardWidth, 'Gap:', gap, 'Total card width:', totalCardWidth);
        console.log('Total content width (includes 400px CSS padding):', totalContentWidth);
        console.log('Container width:', containerWidth);
        console.log('Visible width (container - padding):', visibleWidth);
        console.log('Right buffer (JS):', rightBuffer);
        console.log('Max scroll distance:', maxScrollDistance);
        console.log('Total buffer: 400px (CSS) + 600px (JS) = 1000px total');
        console.log('==================');
        
        // Get the section's position in the document
        const sectionOffsetTop = projectsSection.offsetTop;
        const sectionHeight = projectsSection.offsetHeight;
        
        // Horizontal scroll based on page scroll
        function updateHorizontalScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const viewportHeight = window.innerHeight;
            
            // Calculate when section is in view
            const sectionStart = sectionOffsetTop;
            const sectionEnd = sectionOffsetTop + sectionHeight;
            
            // Check if we're in the section range
            if (scrollTop >= sectionStart && scrollTop <= sectionEnd) {
                // Calculate scroll progress through the section (0 to 1)
                const scrollRange = sectionHeight;
                const scrolledInSection = scrollTop - sectionStart;
                const scrollProgress = Math.max(0, Math.min(1, scrolledInSection / scrollRange));
                
                // Calculate horizontal scroll position
                let horizontalPosition = scrollProgress * maxScrollDistance;
                
                // Ensure we can reach the maximum scroll distance
                // If we're at the very end of the section, force it to max
                if (scrollTop >= sectionEnd - 10) { // 10px buffer from section end
                    horizontalPosition = maxScrollDistance;
                }
                
                // Apply horizontal scroll
                projectsGrid.style.transform = `translateX(-${horizontalPosition}px)`;
                
                console.log('Scroll top:', scrollTop.toFixed(1), 'Section start:', sectionStart.toFixed(1), 'Section end:', sectionEnd.toFixed(1));
                console.log('Scroll progress:', scrollProgress.toFixed(3), 'Horizontal position:', horizontalPosition.toFixed(1) + 'px', 'Max scroll:', maxScrollDistance.toFixed(1) + 'px');
                console.log('Progress percentage:', (scrollProgress * 100).toFixed(1) + '%');
            } else if (scrollTop < sectionStart) {
                // Before section - reset position
                projectsGrid.style.transform = 'translateX(0px)';
            } else {
                // After section - show last position
                projectsGrid.style.transform = `translateX(-${maxScrollDistance}px)`;
            }
        }
        
        // Smooth scroll handler
        let ticking = false;
        function onScroll() {
            if (!ticking) {
                requestAnimationFrame(() => {
                    updateHorizontalScroll();
                    ticking = false;
                });
                ticking = true;
            }
        }
        
        window.addEventListener('scroll', onScroll, { passive: true });
        
        // Add hover effects
        projectCards.forEach((card) => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'scale(1.02)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'scale(1)';
            });
        });
        
        // Initial call
        updateHorizontalScroll();
    }

    // Initialize about section effects
    initAboutSectionEffects();
    
    // Initialize services effects
    initServicesEffects();
    
    // Initialize headline effects
    initProjectsAnimation();
    
    // Test function removed for production performance
    
    // Re-initialize scramble effect for dynamically added content
    $(document).on('DOMNodeInserted', function() {
        setTimeout(initScrambleEffect, 100);
    });

    // Window load event
    $(window).on('load', function() {
        // Remove loading class
        $('body').removeClass('loading');
        
        // Initialize any components that need full page load
        initAfterLoad();
    });

    // Initialize after page load
    function initAfterLoad() {
        // Add any initialization that needs to happen after full page load
    }

    // Expose functions globally if needed
    window.spaceAndSoulTheme = {
        showNotification: showNotification,
        loadMorePosts: loadMorePosts
    };

})(jQuery);
