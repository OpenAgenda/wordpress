import { __ } from '@wordpress/i18n';


/**
 * The filter variations provider services.
 *
 * @type {WPBlockVariation[]}
 */
const variations = [
    {
        name: 'total',
        title: __('Total widget', 'openagenda'),
        keywords: [__('Total widget', 'openagenda'), __('total', 'openagenda'), __('openagenda', 'openagenda')],
        description: __('Displays events total.', 'openagenda'),
        attributes: { filter: 'total' },
    },
    {
        name: 'active',
        title: __('Active filters', 'openagenda'),
        keywords: [__('Active filters', 'openagenda'), __('active', 'openagenda'), __('filters', 'openagenda'), __('openagenda', 'openagenda')],
        description: __('Displays active filters.', 'openagenda'),
        attributes: { filter: 'active' },
    },
    {
        name: 'search',
        title: __('Search filter', 'openagenda'),
        keywords: [__('Search filter', 'openagenda'), __('search', 'openagenda'), __('filter', 'openagenda'), __('openagenda', 'openagenda')],
        description: __('Displays a search input filter.', 'openagenda'),
        attributes: { filter: 'search' },
        isDefault: true,
    },
];

/**
 * Add `isActive` function to all `filter` variations, if not defined.
 * `isActive` function is used to find a variation match from a created
 *  Block by providing its attributes.
 */
variations.forEach((variation) => {
    if (variation.isActive) {
        return;
    }
    variation.isActive = (blockAttributes, variationAttributes) =>
        blockAttributes.providerNameSlug ===
        variationAttributes.providerNameSlug;
});

export default variations;