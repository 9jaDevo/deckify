import './bootstrap';
import './plasma';

import Alpine from 'alpinejs';
// Removed Lenis due to scroll conflict with BG

window.Alpine = Alpine;

// Initialize Alpine securely
document.addEventListener('DOMContentLoaded', () => {
    if (!window.Alpine.started) {
        Alpine.start();
    }
});
