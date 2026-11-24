import { InspectorControls } from '@wordpress/block-editor';
import {
	CheckboxControl,
	PanelBody,
	RadioControl,
	SelectControl,
	TextareaControl,
	TextControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { getFilterData, getOptions } from './utils';

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
					const help = field.description || undefined;
					const label = field.label || name;
					const options = getOptions(field.options);

					switch (field.type || 'text') {
						case 'checkbox':
							return (
								<CheckboxControl
									key={key}
									label={label}
									help={help}
									checked={Boolean(value)}
									onChange={(nextValue) =>
										updateSetting(name, nextValue)
									}
								/>
							);
						case 'multi-checkbox':
							return (
								<fieldset
									key={key}
									className="openagenda-filter-multi-checkbox"
								>
									<legend>{label}</legend>
									{options.map((option) => (
										<CheckboxControl
											key={option.value}
											label={option.label}
											checked={
												Array.isArray(value) &&
												value.includes(option.value)
											}
											onChange={(checked) => {
												const currentValues =
													Array.isArray(value)
														? value
														: [];
												const nextValues = checked
													? [
														...currentValues,
														option.value,
													]
													: currentValues.filter(
														(selected) =>
															selected !==
															option.value
													);
												updateSetting(
													name,
													nextValues
												);
											}}
										/>
									))}
								</fieldset>
							);
						case 'select':
							return (
								<SelectControl
									key={key}
									label={field.label}
									help={help}
									value={value}
									options={[
										...(field.option_none
											? [
												{
													label: field.option_none,
													value: '',
												},
											]
											: []),
										...options,
									]}
									onChange={(nextValue) =>
										updateSetting(name, nextValue)
									}
								/>
							);
						case 'radio':
							return (
								<RadioControl
									key={key}
									label={field.label}
									help={help}
									selected={value}
									options={(field.options || []).map(
										(option) => ({
											label: option.label,
											value: option.value,
										})
									)}
									onChange={(nextValue) =>
										updateSetting(name, nextValue)
									}
								/>
							);
						case 'textarea':
							return (
								<TextareaControl
									key={key}
									label={field.label}
									help={help}
									value={value}
									onChange={(nextValue) =>
										updateSetting(name, nextValue)
									}
								/>
							);
						case 'number':
							return (
								<TextControl
									key={key}
									type="number"
									label={field.label}
									help={help}
									value={value}
									onChange={(nextValue) =>
										updateSetting(
											name,
											nextValue === ''
												? ''
												: Number(nextValue)
										)
									}
								/>
							);
						default:
							return (
								<TextControl
									key={key}
									label={field.label}
									help={help}
									value={value}
									onChange={(nextValue) =>
										updateSetting(name, nextValue)
									}
								/>
							);
					}
				})}
			</PanelBody>
		</InspectorControls>
	);
}
