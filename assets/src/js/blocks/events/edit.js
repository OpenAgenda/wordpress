import { useBlockProps } from '@wordpress/block-editor';
import { Notice, Spinner } from '@wordpress/components';
import { useEntityRecords } from '@wordpress/core-data';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import metadata from './block.json';
import './editor.scss';
import '/assets/js/main.js';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {import('@wordpress/element').WPElement} Element to render.
 */
export default function Edit({ attributes }) {
    const blockProps = useBlockProps();
    const { hasResolved, records } = useEntityRecords('postType', 'oa-calendar', { per_page: 1 });

    if (!hasResolved) {
        return <Spinner />;
    }

    const agenda = records[0] || null;
    if (!agenda) {
        return (
            <div {...blockProps}>
                <Notice status="warning" isDismissible={false}>
                    <p>{__('No agenda could be found. Setup a new agenda to display a preview.', 'openagenda')}</p>
                </Notice>
            </div>
        );
    }

    return (
        <ServerSideRender
            block={metadata.name}
            attributes={attributes}
        />
    );
}