$(function(){
    //Fill the database
    $('.fill-the-database').click(function(){
        var $this = $(this);
        $this.attr('disabled', true);
        NProgress.start();
        $.ajax({
            url: 'script/fill-the-database.php',
            method: 'POST',
            data: {},
            dataType: 'JSON'
        }).done(function(nbTweets, textStatus, jqXHR){
            $('#number-of-tweets').html(nbTweets);

            buildChart('number-of-occurence-by-show', 'number-of-occurence-by-show');
            buildChart('tweets-by-language', 'tweets-by-language');
            buildChart('user-background-color', 'user-background-color');
            buildChart('tweet-per-hour-by-show', 'tweet-per-hour-by-show', $('select.tweet-per-hour-by-show').val());
        }).fail(function(jqXHR, textStatus, errorThrown){
            console.error(jqXHR);
        }).always(function(){
            $this.attr('disabled', false);
            NProgress.done()
        });
    });

    //Number of occurence by show
    $.getJSON('json/shows.json').then(function(shows){
        buildChart('number-of-occurence-by-show', 'number-of-occurence-by-show');
        buildChart('tweets-by-language', 'tweets-by-language');
        buildChart('user-background-color', 'user-background-color');
        buildChart('tweet-per-hour-by-show', 'tweet-per-hour-by-show', $('select.tweet-per-hour-by-show').val());
    });
    //Enable tooltips
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });
    //Tweets per hour by show
    $('select.tweet-per-hour-by-show').change(function(){
        var hashtag = $(this).val();
        buildChart('tweet-per-hour-by-show', 'tweet-per-hour-by-show', hashtag);
    });
    //Smooth scroll
    $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top-75
                }, 1000);
                return false;
            }
        }
    });
});

function buildChart(container, graph_type, hashtag, highstock){
    var hashtag = (hashtag == undefined)? null:hashtag;
    var highstock = (highstock == undefined)? false:true;

    var graph_types = {
        'number-of-occurence-by-show': 'script/number-of-occurence-by-show.php',
        'tweets-by-language': 'script/tweets-by-language.php',
        'tweet-per-hour-by-show': 'script/tweet-per-hour-by-show.php',
        'user-background-color': 'script/user-background-color.php'
    };

    if(highstock == true){
        NProgress.start();
    }

    $.ajax({
        url: graph_types[graph_type],
        method: 'POST',
        data: { hashtag: hashtag},
        dataType: 'JSON'
    }).done(function(options, textStatus, jqXHR){
        if(highstock == false){
            Highcharts.chart(container, options);
        }else{
            Highcharts.stockChart(container, options);
        }
    }).fail(function(jqXHR, textStatus, errorThrown){
        console.error(jqXHR);
    }).always(function(){
        NProgress.done()
    });
}