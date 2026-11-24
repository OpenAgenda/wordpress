import { __ } from '@wordpress/i18n';

export const getFilterData = (filter) => {
    if (!filter || !window.openagendaFilters) {
        return {};
    }

    const filterKey = filter.startsWith('openagenda_filter_')
        ? filter
        : `openagenda_filter_${filter}`;
    const filterData = window.openagendaFilters[filterKey] ?? {};
    const settings = filterData?.settings
        ? {
            title: {
                name: 'title',
                label: __('Filter title', 'openagenda'),
                type: 'text',
                default: filterData.label ?? '',
            },
            display_on_single: {
                name: 'display_on_single',
                label: __(
                    'Display filter on single event views ?',
                    'openagenda'
                ),
                type: 'checkbox',
                default: true,
            },
            dropdown: {
                name: 'dropdown',
                label: __('Display filter as a dropdown ?', 'openagenda'),
                type: 'checkbox',
                default: false,
            },
            ...filterData.settings,
        }
        : {};

    return {
        ...filterData,
        settings,
    };
};

export const getOptions = (options = {}) =>
    Object.entries(options).map(([value, label]) => ({
        label,
        value,
    }));