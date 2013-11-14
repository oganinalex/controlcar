jQuery(function ($) {
    start_button_set();
    change_radio_on_buttonclick();
});

function start_button_set() {
    $('input[name="Act[transposition]"]').each(function () {
        var checkInput = $(this);
        $('button','div.btn-group[data-toggle]').each(function () {
            if ($(this).val() === checkInput.val() && checkInput.is(':checked')) {
                $(this).addClass('active');
            }
        });
    });
}

function change_radio_on_buttonclick() {
    $('div.btn-group[data-toggle]').each(function () {
        var group = $(this);
        $('button', group).each(function () {
            var button = $(this);
            button.on('click', function () {
                $('input[name="Act[transposition]"]').each(function () {
                    $(this).attr('checked', false);
                    if ($(this).val() === button.val()) {
                        $(this).prop('checked', true);
                        $(this).attr('checked', true);
                    }
                });
            });
        });
    });
}


