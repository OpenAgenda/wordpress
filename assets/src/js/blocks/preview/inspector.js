import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import Field from '../components/field';

export default function Inspector({ attributes, setAttributes }) {
	const { settings = {} } = attributes;
	const settingFields = window.openagendaPreviewSettings ?? {};

	const updateSetting = (name, value) => {
		setAttributes({
			settings: {
				...settings,
				[name]: value,
			},
		});
	};

	return (
		<InspectorControls>
			<PanelBody title={__('Settings', 'openagenda')}>
				{Object.keys(settingFields).map((key) => {
					const field = settingFields[key];
					const name = field.name || key;
					const value = settings[name] ?? field.default ?? '';
					return (
						<Field
							key={key}
							field={field}
							name={name}
							value={value}
							onChange={(nextValue) =>
								updateSetting(name, nextValue)
							}
							multiCheckboxClassName="openagenda-preview-multi-checkbox"
						/>
					);
				})}
			</PanelBody>
		</InspectorControls>
	);
}
