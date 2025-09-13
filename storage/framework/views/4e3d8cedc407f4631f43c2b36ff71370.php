
<div id="screenLoader" class="fixed inset-0 z-[9999] bg-white flex items-center justify-center transition-opacity duration-500">
    <div class="text-center">
        <div class="relative">
            
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-primary mx-auto mb-4">
                <img src="<?php echo e(asset('assets/images/logo/YI_Logo.png')); ?>" alt="Loading..." 
                     class="h-12 w-12 object-contain absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            </div>
            
            <div class="text-primary font-semibold text-lg mb-2">Loading...</div>
            
            <div class="flex justify-center space-x-1">
                <div class="w-2 h-2 bg-primary rounded-full animate-bounce"></div>
                <div class="w-2 h-2 bg-primary rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                <div class="w-2 h-2 bg-primary rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
            </div>
        </div>
    </div>
</div>

<script>
    class ScreenLoader {
        constructor() {
            this.loader = document.getElementById('screenLoader');
            this.init();
        }

        init() {
            // Hide loader when page is fully loaded
            window.addEventListener('load', () => {
                this.hideLoader();
            });

            // Hide loader when DOM is ready (fallback)
            if (document.readyState === 'complete') {
                this.hideLoader();
            }

            // Show loader on navigation
            this.showLoaderOnNavigation();
        }

        showLoader() {
            if (this.loader) {
                this.loader.style.opacity = '1';
                this.loader.style.pointerEvents = 'auto';
            }
        }

        hideLoader() {
            if (this.loader) {
                this.loader.style.opacity = '0';
                this.loader.style.pointerEvents = 'none';
                // Remove from DOM after animation
                setTimeout(() => {
                    if (this.loader && this.loader.style.opacity === '0') {
                        this.loader.remove();
                    }
                }, 500);
            }
        }

        showLoaderOnNavigation() {
            // Show loader on link clicks
            document.addEventListener('click', (e) => {
                const link = e.target.closest('a');
                if (link && link.href && !link.href.includes('#') && !link.href.includes('javascript:') && !e.ctrlKey && !e.metaKey) {
                    // Don't show loader for same-page links or external links
                    if (link.href !== window.location.href && link.href.startsWith(window.location.origin)) {
                        this.showLoader();
                    }
                }
            });

            // Show loader on form submissions
            document.addEventListener('submit', (e) => {
                if (e.target.tagName === 'FORM') {
                    this.showLoader();
                }
            });

            // Show loader on browser back/forward
            window.addEventListener('beforeunload', () => {
                this.showLoader();
            });
        }
    }

    // Initialize screen loader when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        new ScreenLoader();
    });
</script>

 <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/screen-loader.blade.php ENDPATH**/ ?>