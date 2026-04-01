import './bootstrap';
import './plasma';

import Alpine from 'alpinejs';
window.Alpine = Alpine;

// Initialize Alpine securely
document.addEventListener('DOMContentLoaded', () => {
    if (!window.Alpine.started) {
        Alpine.start();
    }
});
