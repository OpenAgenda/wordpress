import { useBlockProps } from '@wordpress/block-editor';
import { Notice } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import metadata from './block.json';
import Inspector from './inspector';

export default function Edit({ attributes, setAttributes }) {
	const { settings } = attributes;
	const { uid } = settings;

	if (!uid) {
		return <div {...useBlockProps()}>
			<Inspector
				attributes={attributes}
				setAttributes={setAttributes}
			/>
			<Notice status="info" isDismissible={false}>
				<p style={{ margin: '0' }}>
					{__('Please provide an agenda uid in the block settings.', 'openagenda')}
				</p>
			</Notice>
		</div>
	}

	return (
		<div {...useBlockProps()}>
			<Inspector
				attributes={attributes}
				setAttributes={setAttributes}
			/>
			<ServerSideRender
				block={metadata.name}
				attributes={attributes}
			/>
		</div>
	);
}
