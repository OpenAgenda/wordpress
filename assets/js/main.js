'use strict';
if (oaData) {
    const oaWrapper = document.querySelector('[data-container-id="oa-wrapper"]');
    oaWrapper.insertAdjacentHTML('afterbegin', '<div class="oa-notice-wrapper"></div>');
    window.oa = {
        res: oaData.res,
        agendaUid: oaData.agendaUid,
        locale: oaData.locale,
        query: window.location.search,
        page: parseInt(oaData.page) || 1,
        size: parseInt(oaData.size),
        observer: null,
        values: {},
        aggregations: {},
        onLoad: async (values, aggregations, filtersRef, _form) => {
            oa.setupObserver();
            try {
                oa.values = values
                oa.aggregations = aggregations
                const result = await oa.getEvents({ ...values, size: 0 }, aggregations);
                filtersRef.updateLocation(values);
                filtersRef.updateFiltersAndWidgets(values, result);
            } catch (e) {
                console.log('onLoad error: ', e);
            }
        },
        onFilterChange: async (values, aggregations, filtersRef, _form) => {
            oa.values = values
            oa.aggregations = aggregations
            oa.page = 1
            oaWrapper.insertAdjacentHTML('afterbegin', oaData.overlayHtml);
            try {
                if (oaData.isSingle && oaData.listUrl) {
                    if (values.context) delete values.context;
                    const url = `${oaData.listUrl}?${Qs.stringify(values)}`;
                    window.location.href = url;
                } else {
                    const result = await oa.getEvents(values, aggregations);
                    if (result.success && result.html) {
                        oa.updateHTML(oaWrapper, result.html);
                        oa.setupObserver();
                        const url = `${oaData.listUrl}`;
                        history.pushState(null, document.title, url);
                        filtersRef.updateLocation(values);
                        filtersRef.updateFiltersAndWidgets(values, result);
                    }
                }
            } catch (e) {
                console.log('onFilterChange error: ', e);
            }
        },
        setupObserver: () => {
            const eventsWrapper = document.querySelector('[data-container-id="oa-events"],.oa-event-grid,.oa-event-list');
            if (eventsWrapper && oaData.infiniteScroll && !oaData.isSingle) {
                if (oa.observer !== null) {
                    oa.observer.unobserve(oa.observed);
                    oa.observer = null;
                }
                oa.observed = eventsWrapper.querySelector('.oa-event:last-child');
                if (!oa.observed) return;
                oa.observer = new IntersectionObserver(oa.onIntersect, {});
                oa.observer.observe(oa.observed);
            }
        },
        onIntersect: (entries, observer) => {
            entries.forEach(async entry => {
                if (!entry.isIntersecting) return;
                const loaded = await oa.loadMore();
                if (loaded) oa.setupObserver();
            });
        },
        loadMore: async () => {
            try {
                oa.page += 1
                const result = await oa.getEvents(oa.values, oa.aggregations, { 'isLoadingMore': true });
                if (result.success && result.html) {
                    const eventsWrapper = document.querySelector('[data-container-id="oa-events"],.oa-event-grid,.oa-event-list');
                    eventsWrapper.insertAdjacentHTML('beforeend', result.html);
                }
            } catch (e) {
                console.log('loadMore error: ', e);
                return false;
            }
            return true;
        },
        getEvents: async (values, aggregations = [], additionnal_args = []) => {
            const args = {
                postId: oaData.postId,
                action: oaData.action,
                view: oaData.view,
                page: parseInt(window.oa.page),
                size: parseInt(window.oa.size),
                ...additionnal_args
            }
            const url = `${oaData.ajaxUrl}?${Qs.stringify({ ...args, ...values, aggregations })}`;
            const result = await fetch(url).then(response => response.json());
            return result;
        },
        updateHTML: (element, html) => {
            element.innerHTML = html;
        }
    };
}