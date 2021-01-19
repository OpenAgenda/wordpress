'use strict';
jQuery(document).ready( function($) {
    if(! oaData ) return;

    $( '[data-container-id="oa-wrapper"]' ).prepend('<div class="oa-notice-wrapper"></div>');
    
    window.oa = {
        onReloadWithPassed: (query) => {
            $( '[data-container-id="oa-wrapper"]' ).prepend(oaData.overlayHtml);
            if(query){
                oa.getEvents( 'tags', query, query );
            }
        },
        onWidgetUpdate: (filter, update, query) => {
            $( '[data-container-id="oa-wrapper"]' ).prepend(oaData.overlayHtml);
            oa.getEvents( filter, update, query );
        },
        getEvents: (filter, update, query) => {
            $.post(
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
                        $('[data-container-id="oa-wrapper"]').html( data.data.html );
                        if( data.data.updatedUrl ) window.history.replaceState( {}, '', data.data.updatedPath );
                    } else {
                        $( '.oa-update-overlay' ).remove();
                        $( '.oa-notice-wrapper' ).html( oaData.errorNotice );
                    }
                }
            );
        }
    };
});