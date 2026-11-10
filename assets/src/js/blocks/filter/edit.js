import ServerSideRender from '@wordpress/server-side-render';
import metadata from './block.json';
import FilterInspector from './inspector';


/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {import('@wordpress/element').WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
    return (
        <>
            <FilterInspector
                attributes={attributes}
                setAttributes={setAttributes}
            />
            <ServerSideRender
                block={metadata.name}
                attributes={attributes}
            />
        </>
    );
}