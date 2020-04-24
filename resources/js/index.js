
import $ from "jquery";

let current_page = 1;

$(document).ready(function () {

    $('div.more_button').click(() => {
        $('div.more_button').css('pointer-events','none');
        $('div.more_button p.loading').css('display', 'block');
        $('div.more_button p.more').css('display', 'none');

        current_page+=1;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'GET',
            url  : '/page/'+current_page,
            success : function (response) {
                $('div.currencies_container').append(response);

                $('div.more_button').css('display','flex');
                $('div.more_button').css('pointer-events','all');
                $('div.more_button p.loading').css('display', 'none');
                $('div.more_button p.more').css('display', 'block');
            }
        })
    });
});
