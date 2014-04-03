$(document).ready(function() {
    start_button_set();
    change_radio_on_buttonclick();
    calculate_on_change();
});

function change_radio_on_buttonclick() {
    $('.btn').button().on('click', function() {
        setActiveTranspositon(this.id);
    })
}

function setActiveTranspositon(element)
{
    if(element === 'distance')
    {
        $('#Act_transposition_2').prop('checked', false);
        $('#Act_transposition_1').prop('checked', true);
        $('.rate').hide('fast');
        $('.distance').show('fast');
        calculate_summ($('.distance'));
    }
    if(element === 'rate')
    {
        $('#Act_transposition_1').prop('checked', false);
        $('#Act_transposition_2').prop('checked', true);
        $('.distance').hide('fast');
        $('.rate').show('fast');
        calculate_summ($('.rate'));
    }
}

function start_button_set() {
    $('input[name="Act[transposition]"]').each(function () {
        var checkInput = $(this);
        if (checkInput.val() === '1' && checkInput.is(':checked')) {
            $('#distance').addClass('active');
            setActiveTranspositon('distance');
        }
        if(checkInput.val() === '2' && checkInput.is(':checked')) {
            $('#rate').addClass('active');
            setActiveTranspositon('rate');
        }
    });
}

function calculate_summ(elem) {
    var values = elem.find('input');
    $('#summ').empty();
    val1 = parseFloat($(values[0]).val().replace(",", "."));
    val2 = parseFloat($(values[1]).val().replace(",", "."));
    console.log((val1 * val2), val1, val2);
    $('#summ').text((Math.round(val1 * val2*100)/100).toFixed(2) + ' грн');
}

function calculate_on_change() {
    $('#Act_price_by_km, #Act_distance, #Act_count_transportation, #Act_price_by_transportation').change(function () {
        calculate_summ($(this).parents('.panel'));
    });
//    $('#Act_distance').change();
//    $('#Act_count_transportation').change();
//    $('#Act_price_by_transportation').change();
}

