import './bootstrap';
import './plasma';

import Alpine from 'alpinejs';
import Lenis from 'lenis';
import 'lenis/dist/lenis.css';

// Initialize Lenis Smooth Scrolling
const lenis = new Lenis({
    autoRaf: true,
    lerp: 0.1, // Adjust smoothness (lower = smoother)
    smoothWheel: true,
});

window.Alpine = Alpine;

// Initialize Alpine securely
document.addEventListener('DOMContentLoaded', () => {
    if (!window.Alpine.started) {
        Alpine.start();
    }
});
