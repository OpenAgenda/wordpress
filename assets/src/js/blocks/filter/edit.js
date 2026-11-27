import { useBlockProps } from '@wordpress/block-editor';
import { Notice, Spinner } from '@wordpress/components';
import { useEntityRecords } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { __, sprintf } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import metadata from './block.json';
import './editor.scss';
import FilterInspector from './inspector';
import { getFilterData } from './utils';


/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param  root0
 * @param  root0.attributes
 * @param  root0.setAttributes
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {import('@wordpress/element').WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();
	const { filter } = attributes;
	const filterData = getFilterData(filter);
	const filterLabel = filterData.label ?? filter;

	const agendaPostType = window.openagendaPostType ?? 'oa-calendar';

	const { hasResolved, records } = useEntityRecords(
		'postType',
		agendaPostType,
		{ per_page: 1 }
	);

	let agendaPostId = useSelect((select) => {
		const editor = select('core/editor');
		return agendaPostType === editor.getEditedPostAttribute('type')
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
				<FilterInspector
					attributes={attributes}
					setAttributes={setAttributes}
				/>
				<Notice status="warning" isDismissible={false}>
					<p style={{ margin: '0' }}>
						{__(
							'No agenda could be found. Setup a new agenda to display a preview of the filter.',
							'openagenda'
						)}
					</p>
				</Notice>
			</div>
		);
	}

	return (
		<div {...blockProps}>
			<FilterInspector
				attributes={attributes}
				setAttributes={setAttributes}
			/>
			<Notice status="info" isDismissible={false}>
				<p style={{ margin: '0' }}>
					{sprintf(
						/* translators: %s: Filter label. */
						__(
							'%s filter: Filters are not initialized in the admin area. Please check your frontend.',
							'openagenda'
						),
						filterLabel
					)}
				</p>
			</Notice>
			<ServerSideRender
				block={metadata.name}
				attributes={{ ...attributes, postId: agendaPostId }}
			/>
		</div>
	);
}
