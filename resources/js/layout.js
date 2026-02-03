document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const contentWrapper = document.getElementById('contentWrapper');
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const userMenu = document.getElementById('userMenu');
    const userDropdown = document.getElementById('userDropdown');
    
    function toggleSidebar() {
        const isActive = sidebar.classList.toggle('active');
        contentWrapper.classList.toggle('sidebar-active', isActive);
        sidebarOverlay.classList.toggle('active', isActive);
        
        localStorage.setItem('sidebarActive', isActive);
    }
    
    function closeSidebar() {
        sidebar.classList.remove('active');
        contentWrapper.classList.remove('sidebar-active');
        sidebarOverlay.classList.remove('active');
        localStorage.setItem('sidebarActive', false);
    }
    
    function initSidebar() {
        const savedState = localStorage.getItem('sidebarActive');
        
        if (savedState === 'true') {
            sidebar.classList.add('active');
            contentWrapper.classList.add('sidebar-active');
        } else {
            sidebar.classList.remove('active');
            contentWrapper.classList.remove('sidebar-active');
            sidebarOverlay.classList.remove('active');
            if (savedState === null) {
                localStorage.setItem('sidebarActive', false);
            }
        }
        
        sidebarOverlay.addEventListener('click', closeSidebar);
    }
    
    function initUserMenu() {
        userMenu.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });
        
        document.addEventListener('click', function(e) {
            if (!userMenu.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });
        
        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    function initResponsive() {
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && sidebarOverlay.classList.contains('active')) {
                closeSidebar();
            }
        });
    }
    
    function initActiveLink() {
        const sidebarLinks = document.querySelectorAll('.sidebar a');
        
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                sidebarLinks.forEach(l => l.classList.remove('active-link'));
                this.classList.add('active-link');
                
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });
    }
    
    function init() {
        initSidebar();
        initUserMenu();
        initResponsive();
        initActiveLink();
        
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleSidebar();
        });
    }
    
    init();
});