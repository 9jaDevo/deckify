import './bootstrap';
import './plasma';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('DOMContentLoaded', () => {
    if (!window.Alpine.started) {
        Alpine.start();
    }
});
