import $ from 'jquery' ;

$(document).ready(function () {
    console.log('ready');

    $('div.currency_container').click(function () {

        $('input.amount').css('display','none');
        $('p.quantity').css('display','block');

        $(this).find('input.amount').css('display','inherit');
        $(this).find('input.amount').focus();
        $(this).find('p.quantity').css('display','none');

    });

});
