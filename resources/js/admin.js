import './bootstrap';
import '../css/app.css';

document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    // Tambahkan logic toggle jika diperlukan
    if (toggle && sidebar) {
        toggle.addEventListener('click', function() {
            sidebar.classList.toggle('d-none');
        });
    }
});