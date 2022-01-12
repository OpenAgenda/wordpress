(function ($) {
    $(document).on('widget-added', function (e, $control) {
        const $filterSelect = $control.find('.openagenda-filter-field');
        if ($filterSelect) {
            const $additionalSettings = $control.find('.openagenda-additional-settings');
            function toggleSettings(){
                let filterValue = $filterSelect.val();
                $additionalSettings.each(function (index, settings) {
                    if (filterValue === settings.dataset['filter']) {
                        $( settings ).show();
                    } else {
                        $( settings ).hide();
                    }
                });
            }
            toggleSettings();
            $filterSelect.on('change', toggleSettings);
        }

        const $choiceSelect = $control.find('.openagenda-filter-choice-field');
        if ($choiceSelect) {
            function toggleAdditionalField() {
                if ('additional_field' !== $choiceSelect.val()) {
                    $control.find('.openagenda-filter-choice-field + p').hide();
                } else {
                    $control.find('.openagenda-filter-choice-field + p').show();
                }
            }
            toggleAdditionalField();
            $choiceSelect.on('change', toggleAdditionalField);
        }
    });
})(jQuery);