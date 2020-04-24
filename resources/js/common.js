import $ from "jquery";

$(document).ready(function () {

    $('div.arrow_container').click( () => {
        if (pageYOffset !== 0 && $("html, body").is(':animated') === false) {
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }
    });
});
