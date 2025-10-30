/**
 * ARKFleet Dark Mode Toggle
 * Manages dark mode state with localStorage persistence
 */

(function() {
    'use strict';

    const DARK_MODE_KEY = 'arkfleet_dark_mode';
    const body = document.body;
    const navbar = document.querySelector('.main-header');
    const sidebar = document.querySelector('.main-sidebar');

    function applyDarkMode() {
        body.classList.add('dark-mode');
        
        if (navbar) {
            navbar.classList.remove('navbar-white', 'navbar-light');
            navbar.classList.add('navbar-dark');
        }
        
        if (sidebar) {
            sidebar.classList.remove('sidebar-light-primary');
            sidebar.classList.add('sidebar-dark-primary');
        }
        
        updateToggleIcon(true);
    }

    function applyLightMode() {
        body.classList.remove('dark-mode');
        
        // Keep navbar and sidebar dark even in light mode
        if (navbar) {
            navbar.classList.remove('navbar-white', 'navbar-light');
            navbar.classList.add('navbar-dark');
        }
        
        if (sidebar) {
            sidebar.classList.remove('sidebar-light-primary');
            sidebar.classList.add('sidebar-dark-primary');
        }
        
        updateToggleIcon(false);
    }

    function updateToggleIcon(isDark) {
        const toggleButton = document.getElementById('darkModeToggle');
        if (toggleButton) {
            const icon = toggleButton.querySelector('i');
            if (icon) {
                if (isDark) {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                    toggleButton.title = 'Switch to Light Mode';
                } else {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                    toggleButton.title = 'Switch to Dark Mode';
                }
            }
        }
    }

    function toggleDarkMode() {
        const isDarkMode = body.classList.contains('dark-mode');
        
        if (isDarkMode) {
            applyLightMode();
            localStorage.setItem(DARK_MODE_KEY, 'false');
        } else {
            applyDarkMode();
            localStorage.setItem(DARK_MODE_KEY, 'true');
        }
    }

    function initDarkMode() {
        const savedMode = localStorage.getItem(DARK_MODE_KEY);
        
        if (savedMode === 'true') {
            applyDarkMode();
        } else {
            applyLightMode();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initDarkMode();
        
        const toggleButton = document.getElementById('darkModeToggle');
        if (toggleButton) {
            toggleButton.addEventListener('click', function(e) {
                e.preventDefault();
                toggleDarkMode();
            });
        }
    });

    if (document.readyState === 'loading') {
        initDarkMode();
    }
})();

