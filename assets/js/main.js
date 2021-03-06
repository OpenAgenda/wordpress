'use strict';
if( oaData ) {
    jQuery( '[data-container-id="oa-wrapper"]' ).prepend('<div class="oa-notice-wrapper"></div>');
    window.oa = {
        onReloadWithPassed: (query) => {
            if( ! oaData.isSingle ){
                jQuery( '[data-container-id="oa-wrapper"]' ).prepend(oaData.overlayHtml);
                if(query){
                    oa.getEvents( 'tags', query, query );
                }
            }
        },
        onWidgetUpdate: (filter, update, query) => {
            jQuery( '[data-container-id="oa-wrapper"]' ).prepend(oaData.overlayHtml);
            oa.getEvents( filter, update, query );
        },
        getEvents: (filter, update, query) => {
            jQuery.post(
                oaData.ajaxUrl,
                {         
                    nonce: oaData.nonce,     
                    postId: oaData.postId,   
                    action: "update_events",
                    view: oaData.view,
                    filter,
                    update,
                    query  
                },
                function(data) {
                    if (data.success) {
                        jQuery('[data-container-id="oa-wrapper"]').html( data.data.html );
                        jQuery('[data-container-id="oa-events-total"]').html( data.data.totalHtml );
                        if( data.data.updatedUrl ) window.history.replaceState( {}, '', data.data.updatedPath );
                    } else {
                        jQuery( '.oa-update-overlay' ).remove();
                        jQuery( '.oa-notice-wrapper' ).html( oaData.errorNotice );
                    }
                }
            );
        }
    };
}