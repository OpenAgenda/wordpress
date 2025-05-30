jQuery(document).ready(function ($) {
	var elem = $('.event-map');
	var coords = [elem.attr('latitude'), elem.attr('longitude')];
	var map = L.map('event-map').setView(coords, 13);
	L.tileLayer(elem.attr('tiles'), { attribution: elem.attr('attribution') }
	).addTo(map);
	L.marker(coords,
		{
			icon: L.icon(
				{
					iconUrl: '//s3-eu-west-1.amazonaws.com/cibulstatic/markerIcon.png',
					iconSize: [18, 25],
					iconAnchor: [9, 25]
				}
			)
		}
	).addTo(map);
}
);