import $ from 'jquery' ;

var new_value;
var target;


$(document).ready(function () {
    console.log('ready');
    let currencies = $('div.currency_container');
    let filters = $('div.filter');
    let current_page = 1;
    let current_filter = "all";
    let totalAmount = $('p.total_amount span');

    refreshOwned();
    orderCurrencies();
    refreshTotalAmount();
    refreshCurrencyTotalPrice();

    $('div.more_button').click(() => {

        $('div.more_button').addClass('loading');
        current_page+=1;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'GET',
            url  : '/portfolio/'+current_page,
            success : function (response) {

                $('div.currencies_container').append(response);
                $('div.more_button').removeClass('loading');

                currencies = $('div.currency_container');
                console.log(currencies);
                refreshOwned();
                orderCurrencies();
            }
        })
    });

    $(document).on('click', 'div.wrap,div.currencies_container', function(e) {
        if(e.target != this) return;
        $('input.amount').blur();
        $('input.amount').css('display','none');
        $('p.quantity').css('display','block');
        $('p.portfolio_currency_price').css('display','block');

    });






    $(document).on('click', 'div.currency_container' ,function () {

        $('input.amount').css('display','none');
        $('p.quantity,p.portfolio_currency_price').css('display','block');

        $(this).find('input.amount').css('display','block');
        $(this).find('input.amount').focus();
        $(this).find('p.quantity,p.portfolio_currency_price').css('display','none');
        console.log('clicked currency');

    });

    filters.click(function () {
        $('div.filter').removeClass('active');
        $(this).addClass('active');

        current_filter = $(this).attr('data-filter');
        applyFilter();

    });


    $(document).on("submit", "form",(event) => {

        event.preventDefault();
        target = $(event.currentTarget);
        let formData = {
            'name': $(event.currentTarget).find('input[name=name]').val(),
            'amount': $(event.currentTarget).find('input[name=amount]').val()
        };



        console.log(formData);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $(this).find('input[name=_token]').val()
            },
            type : 'POST',
            url  : 'portfolio-insert',
            data : formData,
            success : function () {

                console.log('success callback');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $(this).find('input[name=_token]').val()
                    },
                    type : 'GET',
                    url  : 'portfolio-refresh-currency/'+formData.name,
                    success : function (response) {
                        console.log({response});
                        if (response[0].amount !== undefined) {
                            new_value = response[0].amount;
                        } else {
                            new_value = 0;
                        }
                        target.siblings("p.quantity").text(new_value);
                        target.siblings("p.quantity, p.portfolio_currency_price").css('display','block');
                        target.find("input.amount").css('display','none');
                        target.find("input.amount").val('');
                        let price = parseFloat(target.parent("div.currency_container").attr("data-price"));
                        refreshTotalAmount();
                        refreshOwned();
                        applyFilter();
                        orderCurrencies();
                        refreshCurrencyTotalPrice();
                    }
                })
            },
        });
    });

    function refreshTotalAmount() {
        let total=0;
        $("div.currency_container", document.body).each(function () {
            total += parseFloat($(this).attr('data-price')) * parseFloat($(this).find("p.quantity").text());
        });
        console.log(total);
        totalAmount.text(total);
    }


    function refreshOwned() {
        $("div.currency_container", document.body).each(function () {
            if (parseFloat($(this).find('p.quantity').text()) !== 0) {
                $(this).attr('data-filter','owned');
            } else {
                $(this).attr('data-filter','other');
            }
        });
    }
    function refreshCurrencyTotalPrice() {

        $("div.currency_container", document.body).each(function () {
            let price = parseFloat($(this).attr('data-price')) * parseFloat($(this).find("p.quantity").text());
            $(this).find("p.portfolio_currency_price span").text(price);
        });
    }

    function applyFilter() {
        $("div.currency_container", document.body).each(function () {
           if (current_filter === "all") {
               $(this).css('display','flex');
           } else if (current_filter === "others" && $(this).attr("data-filter") === "other") {
               $(this).css('display','flex');
           } else if (current_filter === "owned" && $(this).attr("data-filter") === "owned") {
               $(this).css('display','flex');
           } else {
               $(this).css('display','none');
           }
        });
        if (current_filter === "others" || current_filter === "all") {
            $('div.more_button').css('display','flex');
        } else {
            $('div.more_button').css('display','none');
        }
    }

    function orderCurrencies() {

        $("div.currency_container", document.body).each(function (i) {
            $(this).css("order", $(this).attr("data-rank"));
            let duplicates = $("div.currency_container[data-rank=" + i + "]").toArray();
            if (duplicates.length > 1) {
                for (let i=1; i<duplicates.length; i++) {
                    duplicates[i].remove();
                }
            }
        });
    }
});
