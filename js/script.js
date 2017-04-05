$(function(){
    //Fill the database
    $('.fill-the-database').click(function(){
        var $this = $(this);
        $this.attr('disabled', true);
        NProgress.start() 
        $.ajax({
            url: 'script/fill-the-database.php',
            method: 'POST',
            data: {},
            dataType: 'JSON'
        }).done(function(data, textStatus, jqXHR){
            console.log(data);
        }).fail(function(jqXHR, textStatus, errorThrown){
            console.error(jqXHR);
        }).always(function(){
            $this.attr('disabled', false);
            NProgress.done() 
        });
    });
    //Create graphs
    getAllGraphs();
});

function getAllGraphs(){
    //Get the list of shows
    $.getJSON('json/shows.json', function(shows){
        console.log(shows);
    });
}