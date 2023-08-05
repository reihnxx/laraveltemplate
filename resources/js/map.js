// resources/js/map.js
import 'leaflet/dist/leaflet.css';
import L from 'leaflet';

// Inisialisasi peta
function initMap() {
    const map = L.map('map').setView([-7.597354, 110.949919], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    // Tambahkan marker atau komponen peta lainnya sesuai kebutuhan
    // Contoh:
    // L.marker([latitude, longitude]).addTo(map);
}

document.addEventListener('DOMContentLoaded', initMap);
