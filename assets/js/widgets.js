(function ($) {
    $(document).on('widget-added', function (e, $control) {
        const $filterSelect = $control.find('.openagenda-filter-field');
        const $additionalSettings = $control.find('.openagenda-additional-settings');
        if ($filterSelect) {
            toggleSettings();
            $filterSelect.on('change', toggleSettings);
        }

        const $choiceSelect = $control.find('.openagenda-filter-choice-field');
        if ($choiceSelect) {
            toggleChoiceFilterAdditionalField();
            $choiceSelect.on('change', toggleChoiceFilterAdditionalField);
        }

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

        function toggleChoiceFilterAdditionalField() {
            if ('additional_field' !== $choiceSelect.val()) {
                $control.find('.openagenda-filter-choice-field + p').hide();
            } else {
                $control.find('.openagenda-filter-choice-field + p').show();
            }
        }
    });
})(jQuery);