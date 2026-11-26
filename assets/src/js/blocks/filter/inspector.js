import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import Field from '../components/field';
import { getFilterData } from './utils';

export default function FilterInspector({ attributes, setAttributes }) {
	const { filter, filterSettings = {} } = attributes;
	const filterData = getFilterData(filter);
	const settingFields = filterData.settings ?? {};

	if (Object.keys(settingFields).length === 0) {
		return null;
	}

	const updateSetting = (name, value) => {
		setAttributes({
			filterSettings: {
				...filterSettings,
				[name]: value,
			},
		});
	};
	return (
		<InspectorControls>
			<PanelBody title={__('Filter settings', 'openagenda')}>
				{Object.keys(settingFields).map((key) => {
					const field = settingFields[key];
					const name = field.name || key;
					const value = filterSettings[name] || field.default || '';
					return (
						<Field
							key={key}
							field={field}
							name={name}
							value={value}
							onChange={(nextValue) =>
								updateSetting(name, nextValue)
							}
							multiCheckboxClassName="openagenda-filter-multi-checkbox"
						/>
					);
				})}
			</PanelBody>
		</InspectorControls>
	);
}
