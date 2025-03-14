'use strict';
document.addEventListener('DOMContentLoaded', e => {
	const rootElement = document.querySelector(':root');
	wp.customize('openagenda_customizer[main_color]',
		function (value) {
			value.bind(function (to) {
				rootElement.style.setProperty("--oa-main-color", to);
			});
		}
	);
});