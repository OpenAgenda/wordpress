'use strict';
document.addEventListener('DOMContentLoaded', () => {
	const elem = document.querySelector('.event-map');
	const coords = [elem.getAttribute('latitude'), elem.getAttribute('longitude')];
	const map = L.map('event-map').setView(coords, 13);

	L.tileLayer(elem.getAttribute('tiles'), {
		attribution: elem.getAttribute('attribution'),
	}).addTo(map);
	L.marker(coords, {
		icon: L.icon({
			iconUrl: '//cdn.openagenda.com/static/markerIcon.png',
			iconSize: [18, 25],
			iconAnchor: [9, 25],
		}),
	}).addTo(map);
});
