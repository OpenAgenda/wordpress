import { __ } from '@wordpress/i18n';

/**
 * The filter variations provider services.
 *
 * @type {WPBlockVariation[]}
 */
const variations = [
	{
		name: 'total',
		title: __( 'Total widget', 'openagenda' ),
		keywords: [
			__( 'Total widget', 'openagenda' ),
			__( 'total', 'openagenda' ),
			__( 'openagenda', 'openagenda' ),
		],
		description: __( 'Displays events total.', 'openagenda' ),
		attributes: { filter: 'total', shortcode: 'openagenda_filter_total' },
	},
	{
		name: 'active',
		title: __( 'Active filters', 'openagenda' ),
		keywords: [
			__( 'Active filters', 'openagenda' ),
			__( 'active', 'openagenda' ),
			__( 'filters', 'openagenda' ),
			__( 'openagenda', 'openagenda' ),
		],
		description: __( 'Displays active filters.', 'openagenda' ),
		attributes: { filter: 'active', shortcode: 'openagenda_filter_active' },
	},
	{
		name: 'search',
		title: __( 'Search filter', 'openagenda' ),
		keywords: [
			__( 'Search filter', 'openagenda' ),
			__( 'search', 'openagenda' ),
			__( 'filter', 'openagenda' ),
			__( 'openagenda', 'openagenda' ),
		],
		description: __( 'Displays a search input filter.', 'openagenda' ),
		attributes: { filter: 'search', shortcode: 'openagenda_filter_search' },
		isDefault: true,
	},
	{
		name: 'map',
		title: __( 'Map filter', 'openagenda' ),
		keywords: [
			__( 'Map filter', 'openagenda' ),
			__( 'map', 'openagenda' ),
			__( 'filter', 'openagenda' ),
			__( 'openagenda', 'openagenda' ),
		],
		description: __( 'Displays an event map.', 'openagenda' ),
		attributes: { filter: 'map', shortcode: 'openagenda_filter_map' },
		isDefault: false,
	},
	{
		name: 'choice',
		title: __( 'Choice filter', 'openagenda' ),
		keywords: [
			__( 'Choice filter', 'openagenda' ),
			__( 'choice', 'openagenda' ),
			__( 'filter', 'openagenda' ),
			__( 'openagenda', 'openagenda' ),
		],
		description: __( 'Displays a choice filter.', 'openagenda' ),
		attributes: { filter: 'choice', shortcode: 'openagenda_filter_choice' },
	},
	{
		name: 'calendar',
		title: __( 'Calendar filter', 'openagenda' ),
		keywords: [
			__( 'Calendar filter', 'openagenda' ),
			__( 'calendar', 'openagenda' ),
			__( 'date', 'openagenda' ),
			__( 'filter', 'openagenda' ),
		],
		description: __( 'Displays a calendar filter.', 'openagenda' ),
		attributes: {
			filter: 'calendar',
			shortcode: 'openagenda_filter_calendar',
		},
	},
	{
		name: 'ranges',
		title: __( 'Defined ranges filter', 'openagenda' ),
		keywords: [
			__( 'Defined ranges filter', 'openagenda' ),
			__( 'ranges', 'openagenda' ),
			__( 'date', 'openagenda' ),
			__( 'filter', 'openagenda' ),
		],
		description: __(
			'Displays defined date range shortcuts.',
			'openagenda'
		),
		attributes: { filter: 'ranges', shortcode: 'openagenda_filter_ranges' },
	},
	{
		name: 'relative',
		title: __( 'Upcoming filter', 'openagenda' ),
		keywords: [
			__( 'Upcoming filter', 'openagenda' ),
			__( 'upcoming', 'openagenda' ),
			__( 'relative', 'openagenda' ),
			__( 'filter', 'openagenda' ),
		],
		description: __( 'Displays an upcoming events filter.', 'openagenda' ),
		attributes: {
			filter: 'relative',
			shortcode: 'openagenda_filter_relative',
		},
	},
	{
		name: 'sort',
		title: __( 'Sort filter', 'openagenda' ),
		keywords: [
			__( 'Sort filter', 'openagenda' ),
			__( 'sort', 'openagenda' ),
			__( 'order', 'openagenda' ),
			__( 'filter', 'openagenda' ),
		],
		description: __( 'Displays event sorting options.', 'openagenda' ),
		attributes: { filter: 'sort', shortcode: 'openagenda_filter_sort' },
	},
	{
		name: 'submit',
		title: __( 'Filter submit button', 'openagenda' ),
		keywords: [
			__( 'Filter submit button', 'openagenda' ),
			__( 'submit', 'openagenda' ),
			__( 'button', 'openagenda' ),
			__( 'filter', 'openagenda' ),
		],
		description: __( 'Displays a button to apply filters.', 'openagenda' ),
		attributes: { filter: 'submit', shortcode: 'openagenda_filter_submit' },
	},
];

/**
 * Add `isActive` function to all `filter` variations, if not defined.
 * `isActive` function is used to find a variation match from a created
 *  Block by providing its attributes.
 */
variations.forEach( ( variation ) => {
	if ( variation.isActive ) {
		return;
	}
	variation.isActive = ( blockAttributes, variationAttributes ) =>
		blockAttributes.filter === variationAttributes.filter;
} );

export default variations;
