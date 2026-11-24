import { useBlockProps } from '@wordpress/block-editor';
import { Notice, Spinner } from '@wordpress/components';
import { useEntityRecords } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import metadata from './block.json';
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param  root0            Block props.
 * @param  root0.attributes
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {import('@wordpress/element').WPElement} Element to render.
 */
export default function Edit({ attributes }) {
	const blockProps = useBlockProps();

	const { hasResolved, records } = useEntityRecords(
		'postType',
		'oa-calendar',
		{ per_page: 1 }
	);

	let agendaPostId = useSelect((select) => {
		const editor = select('core/editor');
		return 'oa-calendar' === editor.getEditedPostAttribute('type')
			? editor.getEditedPostAttribute('id')
			: 0;
	}, []);

	if (!hasResolved) {
		return <Spinner />;
	}

	if (0 === agendaPostId) {
		agendaPostId = records.length > 0 ? records[0]?.id : 0;
	}

	if (0 === agendaPostId) {
		return (
			<div {...blockProps}>
				<Notice status="warning" isDismissible={false}>
					<p style={{ margin: '0' }}>
						{__(
							'No agenda could be found. Setup a new agenda to display a preview of your events list.',
							'openagenda'
						)}
					</p>
				</Notice>
			</div>
		);
	}

	return (
		<div {...blockProps}>
			<ServerSideRender
				block={metadata.name}
				attributes={{ ...attributes, postId: agendaPostId }}
			/>
		</div>
	);
}
