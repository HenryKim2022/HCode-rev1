// import $ from 'jquery';
import './bootstrap';

// Import PhotoSwipe CSS
import 'photoswipe/dist/photoswipe.css';
import PhotoSwipeLightbox from 'photoswipe/lightbox';
import PhotoSwipe from 'photoswipe';


import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();



import PerfectScrollbar from 'perfect-scrollbar';
import 'perfect-scrollbar/css/perfect-scrollbar.css';



// Function to initialize PhotoSwipe
function initPhotoSwipe() {
    document.querySelectorAll('.pswp-gallery').forEach((gallery) => {
        const lightbox = new PhotoSwipeLightbox({
            gallery: gallery,
            children: 'a',
            pswpModule: PhotoSwipe,
            showAnimationDuration: 150,
            hideAnimationDuration: 333,
            bgOpacity: 0.8,
            captionContent: true,
            closeButton: true,
        });
        lightbox.init();
    });
}
// Listen for a custom event to reinitialize PhotoSwipe
document.addEventListener('photoswipe:init', () => {
    initPhotoSwipe();
});
document.addEventListener('DOMContentLoaded', function () {
    // Initialize PhotoSwipe on page load
    initPhotoSwipe();
});
// ENDOF: PHOTOSWIPE LIGHTBOX



document.addEventListener('DOMContentLoaded', function () {
    const xcontainers = document.querySelectorAll('.x-scrollable');
    xcontainers.forEach(xcontainer => {
        if (xcontainer) {
            new PerfectScrollbar(xcontainer, {
                suppressScrollX: false, // Enable horizontal scroll
                suppressScrollY: true    // Disable vertical scroll
            });

            let startX, startY;
            xcontainer.addEventListener('touchstart', (event) => {
                startX = event.touches[0].clientX; // Get initial touch position
                startY = event.touches[0].clientY; // Get initial touch position
            });

            let isScrollingVertically = false;
            xcontainer.addEventListener('touchmove', (event) => {
                console.log('touchmove event triggered');
                const moveX = event.touches[0].clientX - startX;
                const moveY = event.touches[0].clientY - startY;

                // If user is trying to move vertically (more than horizontally)
                if (Math.abs(moveY) > Math.abs(moveX)) {
                    console.log('vertical touch move detected');
                    event.preventDefault(); // Prevent default scrolling behavior
                    event.stopPropagation(); // Stop horizontal scrolling
                    // Allow the page to scroll
                    window.scrollTo(0, window.scrollY - moveY);

                    // Disable horizontal scrollbar if not already disabled
                    if (!isScrollingVertically) {
                        isScrollingVertically = true;
                        xcontainer.style.overflowX = 'hidden';
                    }
                } else {
                    // Re-enable horizontal scrollbar if it was previously disabled
                    if (isScrollingVertically) {
                        isScrollingVertically = false;
                        xcontainer.style.overflowX = 'auto';
                    }
                }
            });

            // Re-enable horizontal scrollbar when user stops scrolling
            document.addEventListener('touchend', () => {
                if (isScrollingVertically) {
                    isScrollingVertically = false;
                    xcontainer.style.overflowX = 'auto';
                }
            });
            document.body.addEventListener('touchmove', (event) => {
                console.log('touchmove event received by document.body');
            });
            // Disable vertical scrolling
            xcontainer.addEventListener('wheel', (event) => {
                if (event.deltaY !== 0 && event.target === xcontainer) {
                    event.preventDefault();
                }
            });

            xcontainer.addEventListener('mousewheel', (event) => {
                if (event.wheelDeltaY !== 0 && event.target === xcontainer) {
                    event.preventDefault();
                }
            });
        }
    });

    const ycontainers = document.querySelectorAll('.y-scrollable');
    ycontainers.forEach(ycontainer => {
        if (ycontainer) {
            new PerfectScrollbar(ycontainer, {
                suppressScrollX: true, // Disable horizontal scroll
                suppressScrollY: false    // Enable vertical scroll
            });

            let startY;
            ycontainer.addEventListener('touchstart', (event) => {
                startY = event.touches[0].clientY; // Get initial touch position
            });
            ycontainer.addEventListener('touchmove', (event) => {
                const moveY = event.touches[0].clientY - startY;
                // If user is trying to scroll horizontally (more than vertically)
                if (Math.abs(moveY) < Math.abs(event.touches[0].clientX - ycontainer.getBoundingClientRect().left)) {
                    event.stopPropagation(); // Stop vertical scrolling
                    ycontainer.scrollLeft += moveY; // Scroll horizontally
                }
            });
        }
    });
    // ENDOF: X AND Y SCROLLABLE


    let currentZIndex = 1050; // Start with Bootstrap's default modal z-index
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('show.bs.modal', function () {
            // Increment z-index for each modal
            currentZIndex += 10;
            modal.style.zIndex = currentZIndex;
            // Handle nested modals
            const parentModal = modal.closest('.modal');
            if (parentModal) {
                // Ensure the child modal has a higher z-index than the parent modal
                modal.style.zIndex = parseInt(window.getComputedStyle(parentModal).zIndex) + 10;
            }
            // Adjust backdrop z-index to match the modal's z-index
            const modalBackdrop = document.querySelector('.modal-backdrop');
            if (modalBackdrop) {
                modalBackdrop.style.zIndex = currentZIndex - 1; // Backdrop should be just below the modal
            }
        });
        modal.addEventListener('hidden.bs.modal', function () {
            modal.style.zIndex = ''; // Reset z-index when modal is hidden
        });
    });
    // ENDOF: Z-INDEX FOR ALL MODALS & BACKDROPS


    document.querySelectorAll('.modal').forEach(modal => {
        // Find the trigger element for this modal
        const modalTrigger = document.querySelector(`[data-bs-target="#${modal.id}"]`);
        // Focus management when the modal is shown
        modal.addEventListener('shown.bs.modal', function () {
            const closeButton = modal.querySelector('.btn-close');
            if (closeButton) {
                closeButton.focus(); // Move focus to the close button
            }
        });
        // Return focus to the trigger element when the modal is hidden
        modal.addEventListener('hidden.bs.modal', function () {
            if (modalTrigger) {
                modalTrigger.focus(); // Return focus to the trigger element
            }
        });
        // Trap focus inside the modal
        modal.addEventListener('show.bs.modal', function () {
            const focusableElements = modal.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            const firstElement = focusableElements[0];
            const lastElement = focusableElements[focusableElements.length - 1];
            modal.addEventListener('keydown', function (e) {
                if (e.key === 'Tab') {
                    if (e.shiftKey && document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus(); // Wrap focus to the last element
                    } else if (!e.shiftKey && document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus(); // Wrap focus to the first element
                    }
                }
            });
        });
    });
    // ENDOF: CLOSE BUTTONS FOR ALL MODALS






});


