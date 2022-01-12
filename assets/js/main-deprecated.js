'use strict';
if( oaData ) {
    jQuery( '[data-container-id="oa-wrapper"]' ).prepend('<div class="oa-notice-wrapper"></div>');
    window.oa = {
        onReloadWithPassed: (query) => {
            console.log('onWidgetUpdate',filter, update, query);

            if( ! oaData.isSingle ){
                jQuery( '[data-container-id="oa-wrapper"]' ).prepend(oaData.overlayHtml);
                if(query){
                    oa.getEvents( 'tags', query, query );
                }
            }
        },
        onWidgetUpdate: (filter, update, query) => {
            console.log('onWidgetUpdate',filter, update, query);
            jQuery( '[data-container-id="oa-wrapper"]' ).prepend(oaData.overlayHtml);
            oa.getEvents( filter, update, query );
        },
        getEvents: (filter, update, query) => {
            console.log('getEvents',filter, update, query);

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
                    console.log(data);
                    if (data.success) {
                        jQuery('[data-container-id="oa-wrapper"]').html( data.data.html );
                        jQuery('[data-container-id="oa-events-total"]').html( data.data.totalHtml );
                        if( data.data.updatedUrl ) window.history.replaceState( {}, '', data.data.updatedPath );
                    } else {
                        jQuery( '.oa-update-overlay' ).remove();
                        jQuery( '.oa-notice-wrapper' ).html( oaData.errorNotice );
                    }
                    return data;
                }
            );
        },


        // New usage for React filters
        // onLoad: async (values, aggregations, filtersRef, _form) => {
        //     console.log( 'onLoad', values, aggregations, filtersRef, _form);
        //     // try {
        //     //     const result = await loadEventList({ ...values, size: 0 }, aggregations);
        //     //     filtersRef.updateFiltersAndWidgets(values, result);
        //     // } catch (e) {
        //     //     console.log('onLoad error:', e);
        //     // }
        // },
        // onFilterChange: async (values, aggregations, filtersRef, _form) => {
        //     console.log( 'onFilterChange', values, aggregations, filtersRef, _form);
     
        //     try {
        //         jQuery( '[data-container-id="oa-wrapper"]' ).prepend(oaData.overlayHtml);
        //         // const result = await loadEventList(values, aggregations);

        //         // const data = await oa.getEvents( 'filter', values, [ ...aggregations, ...values ] );
        //         // console.log(data);
        //         // const result = await oa.getEvents2(values, aggregations);
        //         // console.log(result);
        //         // filtersRef.updateLocation(values);
        //         // filtersRef.updateFiltersAndWidgets(values, data.events);
        //     } catch (e) {
        //       console.log('onFilterChange error:', e);
        //     }
        // },
        // getEvents2: async ( values, aggregations = [] ) => {
        //     const formData = new FormData();
        //     const params = [ ...aggregations, values ];

        //     console.log(params);

        //     formData.append('nonce', oaData.nonce);
        //     formData.append('postId', oaData.postId);
        //     formData.append('action', 'update_events');
        //     formData.append('view', 'oaData.view');
        //     for ( const [name, value] of Object.entries(params)) {
        //         formData.append(name, value);
        //     }

        //     console.log(values, aggregations, formData);
            
        //     const result = await fetch( oaData.ajaxUrl, {
        //         method: "POST",
        //         body: formData
        //     } ).then( response => response.json() );
        //     return result;
        // },
    };
}