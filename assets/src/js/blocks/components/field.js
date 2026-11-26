import {
	CheckboxControl,
	RadioControl,
	SelectControl,
	TextareaControl,
	TextControl,
} from '@wordpress/components';

const getOptions = (options = {}) => {
	if (Array.isArray(options)) {
		return options.map((option) => ({
			label: option.label,
			value: option.value,
		}));
	}

	return Object.entries(options).map(([value, option]) => ({
		label: typeof option === 'string' ? option : option.label,
		value: typeof option === 'string' ? value : option.value ?? value,
	}));
};

export default function Field({
	field,
	name,
	value,
	onChange,
	multiCheckboxClassName,
}) {
	const help = field.description || undefined;
	const label = field.label || name;
	const options = getOptions(field.options);

	switch (field.type || 'text') {
		case 'checkbox':
			return (
				<CheckboxControl
					label={label}
					help={help}
					checked={Boolean(value)}
					onChange={onChange}
				/>
			);
		case 'multi-checkbox':
			return (
				<fieldset className={multiCheckboxClassName}>
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
								const currentValues = Array.isArray(value)
									? value
									: [];
								const nextValues = checked
									? [...currentValues, option.value]
									: currentValues.filter(
										(selected) =>
											selected !== option.value
									);
								onChange(nextValues);
							}}
						/>
					))}
				</fieldset>
			);
		case 'select':
			return (
				<SelectControl
					label={label}
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
					onChange={onChange}
				/>
			);
		case 'radio':
			return (
				<RadioControl
					label={label}
					help={help}
					selected={value}
					options={options}
					onChange={onChange}
				/>
			);
		case 'textarea':
			return (
				<TextareaControl
					label={label}
					help={help}
					value={value}
					onChange={onChange}
				/>
			);
		case 'number':
			return (
				<TextControl
					type="number"
					label={label}
					help={help}
					value={value}
					onChange={(nextValue) =>
						onChange(nextValue === '' ? '' : Number(nextValue))
					}
				/>
			);
		default:
			return (
				<TextControl
					label={label}
					help={help}
					value={value}
					onChange={onChange}
				/>
			);
	}
}
