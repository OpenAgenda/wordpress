<?php
/**
 * Sample arguments for wp_insert_post()
 * Allows to add an agenda to db.
 *
 * @package Openagenda
 *
 * @return array<string,mixed> Arguments.
 */

return array(
	'post_title'  => 'Sample Agenda - Cité des Sciences',
	'post_status' => 'publish',
	'post_type'   => 'oa-calendar',
	'meta_input'  => array(
		'oa-calendar-uid'      => '76126842',
		'oa-calendar-per-page' => 10,
	),
);
