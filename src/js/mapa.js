(function() {
	if(document.querySelector('#map')) {
		document.addEventListener('DOMContentLoaded', () => {
			const lat = 41.6688966734123, 
				lng = -0.9064870182907812,
				zoom = 16;
			const map = L.map('map').setView([lat, lng], zoom);

			L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);

			L.marker([lat, lng]).addTo(map)
				.bindPopup(`
					<h2 class="mapa__heading">DevWebCamp</h2>
					<p class="mapa__texto">Palacio de Congresos de Zaragoza</p>
				`)
				.openPopup();
		});
		
	}
})();
