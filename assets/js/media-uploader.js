/**
 * Handle media upload settings
 */
document.addEventListener(
	'DOMContentLoaded',
	e => {
		const mediaFields = document.querySelectorAll( '.media-upload-field' );
    if ( ! mediaFields) {
        return;
    }
    mediaFields.forEach(
		mediaField => {
            let frame;
            const updateButton             = mediaField.querySelector( '.media-upload-button' );
            const removeButton             = mediaField.querySelector( '.media-remove-button' );
            const preview                  = mediaField.querySelector( '.media-field-preview' );
            const inputField               = mediaField.querySelector( '.media-input-field' );
            updateButton.addEventListener(
					'click',
					e => {
                    frame                  = wp.media(
                            {
							title: updateButton.dataset.update,
							multiple: false,
							button: {
								text: updateButton.dataset.update,
							},
							}
                        );
					frame.on(
						'select',
						e => {
							const attachment       = frame.state().get( 'selection' ).first();
							inputField.value       = attachment.id;
							updateButton.innerHTML = updateButton.dataset.update
							preview.innerHTML  = ` < img src = ${attachment.attributes.sizes.thumbnail.url} alt = ${attachment.attributes.alt} / > `
							removeButton.classList.remove( 'hidden' );
							frame.close();
						}
					);
					frame.open();
					}
				);
		removeButton.addEventListener(
            'click',
            e => {
					frame             = null;
					preview.innerHTML = ``;
					inputField.value  = 0;
					removeButton.classList.add( 'hidden' );
            }
        );
		}
		);
	}
);