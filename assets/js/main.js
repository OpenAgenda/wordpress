'use strict';

jQuery(document).ready( function($) {
    if(! oaData ) return;

    $( '[data-container-id="oa-wrapper"]' ).prepend('<div class="oa-notice-wrapper"></div>');
    
    window.oa = {
        onReloadWithPassed: (filter, update, query) => {},
        onWidgetUpdate: (filter, update, query) => {
            $( '[data-container-id="oa-wrapper"]' ).prepend(oaData.overlayHtml);
            
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
                        if( data.data.updatedUrl ) window.history.pushState( {}, '', data.data.updatedUrl );
                        $('[data-container-id="oa-wrapper"]').html( data.data.html );
                    } else {
                        $( '.oa-update-overlay' ).remove();
                        $( '.oa-notice-wrapper' ).html( oaData.errorNotice );
                    }
                }
            );
        }
    };
});