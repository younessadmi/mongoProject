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
        }).done(function(data, textStatus, jqXHR){
            buildChart('number-of-occurence-by-show', 'number-of-occurence-by-show');
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
    });
});

function buildChart(container, graph_type){
    var graph_types = {
        'number-of-occurence-by-show': 'script/number-of-occurence-by-show.php'
    };

    $.ajax({
        url: graph_types[graph_type],
        method: 'POST',
        data: {},
        dataType: 'JSON'
    }).done(function(options, textStatus, jqXHR){
        Highcharts.chart(container, options);
    }).fail(function(jqXHR, textStatus, errorThrown){
        console.error(jqXHR);
    }).always(function(){
        NProgress.done() 
    });
}
