class SidebarManager {
    constructor() {
        this.sidebar = document.getElementById('sidebar');
        this.navbar = document.getElementById('navbar');
        this.mainContent = document.getElementById('mainContent');
        this.overlay = document.getElementById('sidebarOverlay');
        this.sidebarToggle = document.getElementById('sidebarToggle');
        this.hamburgerIcon = document.getElementById('hamburgerIcon');
        this.closeIcon = document.getElementById('closeIcon');
        this.tooltip = document.getElementById('tooltip');

        this.isOpen = false;
        this.isCollapsed = false;
        this.isDesktop = window.innerWidth >= 1024;

        this.handleResize();
        this.updateLayout();
        this.init();
    }

    init() {
        this.sidebarToggle.addEventListener('click', () => this.handleToggle());
        this.overlay.addEventListener('click', () => this.closeMobile());
        window.addEventListener('resize', () => this.handleResize());

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen && !this.isDesktop) {
                this.closeMobile();
            }
        });

        this.initTooltips();
    }

    handleToggle() {
        if (this.isDesktop) {
            this.isCollapsed = !this.isCollapsed;
            this.updateSidebarState();
            this.updateLayout();
        } else {
            this.toggleMobile();
        }
    }

    updateSidebarState() {
        if (this.isCollapsed) {
            this.sidebar.classList.remove('sidebar-expanded');
            this.sidebar.classList.add('sidebar-collapsed');
        } else {
            this.sidebar.classList.remove('sidebar-collapsed');
            this.sidebar.classList.add('sidebar-expanded');
        }
    }

    updateLayout() {
        if (!this.isDesktop) return;

        if (this.isCollapsed) {
            this.navbar.classList.add('navbar-collapsed');
            this.mainContent.classList.add('content-collapsed');
        } else {
            this.navbar.classList.remove('navbar-collapsed');
            this.mainContent.classList.remove('content-collapsed');
        }
    }

    handleResize() {
        const wasDesktop = this.isDesktop;
        this.isDesktop = window.innerWidth >= 1024;

        if (this.isDesktop && !wasDesktop) {
            this.closeMobile();
            this.sidebar.classList.remove('-translate-x-full');
            this.sidebar.classList.add('translate-x-0');
            this.isOpen = true;
            this.updateLayout();
        } else if (!this.isDesktop && wasDesktop) {
            this.sidebar.classList.add('-translate-x-full');
            this.sidebar.classList.remove('translate-x-0');
            this.isOpen = false;
            this.isCollapsed = false;
            this.updateSidebarState();
            this.navbar.classList.remove('navbar-expanded', 'navbar-collapsed');
            this.mainContent.classList.remove('content-expanded', 'content-collapsed');
        }
    }

    toggleMobile() {
        if (this.isOpen) {
            this.closeMobile();
        } else {
            this.openMobile();
        }
    }

    openMobile() {
        this.isOpen = true;
        this.sidebar.classList.remove('-translate-x-full');
        this.sidebar.classList.add('translate-x-0');
        this.overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        this.hamburgerIcon.classList.add('hidden');
        this.closeIcon.classList.remove('hidden');
        this.sidebarToggle.setAttribute('aria-expanded', 'true');
    }

    closeMobile() {
        this.isOpen = false;
        this.sidebar.classList.add('-translate-x-full');
        this.sidebar.classList.remove('translate-x-0');
        this.overlay.classList.add('hidden');
        this.hamburgerIcon.classList.remove('hidden');
        this.closeIcon.classList.add('hidden');
        this.sidebarToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    initTooltips() {
        const sidebarItems = document.querySelectorAll('.sidebar-item[data-tooltip]');

        sidebarItems.forEach(item => {
            item.addEventListener('mouseenter', (e) => {
                if (this.isCollapsed && this.isDesktop) {
                    this.showTooltip(e.target.closest('.sidebar-item'), e.target.closest('.sidebar-item').getAttribute('data-tooltip'));
                }
            });

            item.addEventListener('mouseleave', () => {
                this.hideTooltip();
            });
        });
    }

    showTooltip(element, text) {
        const rect = element.getBoundingClientRect();
        this.tooltip.textContent = text;
        this.tooltip.style.left = rect.right + 10 + 'px';
        this.tooltip.style.top = rect.top + (rect.height / 2) - (this.tooltip.offsetHeight / 2) + 'px';
        this.tooltip.classList.remove('opacity-0');
        this.tooltip.classList.add('opacity-100');
    }

    hideTooltip() {
        this.tooltip.classList.remove('opacity-100');
        this.tooltip.classList.add('opacity-0');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new SidebarManager();
});
