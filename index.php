<?php
include('pre-requisite.php');
?>

<DOCTYPE html>
    <html lang="en">
    <head>
        <?php include('head.php'); ?>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand">ESGI</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="https://github.com/younessadmi/mongoProject" class="btn btn-link">
                                <i class="fa fa-github fa-2x" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li>
                            <a class="btn btn-link fill-the-database" data-toggle="tooltip" data-placement="bottom" title="Update DB">
                                <i class="fa fa-database fa-2x" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    En savoir plus sur le projet
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" style="text-align:right">
                    <p class="label label-default" id="number-of-tweets"><?php echo getNumberOfTweets();?></p>
                    <br><br><br>
                </div>
            </div>
            <div class="row">
                <!-- Graph -->
                 <div class="col-sm-12 col-md-12">
                    <div class="graph">
                       <select class="tweet-per-hour-by-show">
                          <option selected>All</option>
                           <?php foreach(getListOfShows() as $hashtag){?>
                               <option><?php echo $hashtag;?></option>
                           <?php }?>
                       </select>
                        <div id="tweet-per-hour-by-show">
                            <p class="graph-title">Tweets per hour</p>
                            <i class="fa fa-circle-o-notch fa-spin fa-fw"></i><span class="sr-only">Loading...</span>
                        </div>
                     </div>
                 </div>
             </div>
             <div class="row">
                <!-- Graph -->
                <div class="col-sm-12 col-md-12">
                    <div class="graph">
                        <div id="number-of-occurence-by-show">
                            <p class="graph-title">Number of occurence by show</p>
                            <i class="fa fa-circle-o-notch fa-spin fa-fw"></i><span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Graph -->
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="graph">
                        <div id="tweets-by-language">
                            <p class="graph-title">Tweets by language</p>
                            <i class="fa fa-circle-o-notch fa-spin fa-fw"></i><span class="sr-only">Loading...</span>
                        </div>
                     </div>
                 </div>
             </div>
            <script src="js/jquery/jquery-3.2.0.min.js"></script>
            <script src="js/bootstrap/bootstrap.min.js"></script>
            <script src="js/nprogress/nprogress.js"></script>
            <script src="https://code.highcharts.com/stock/highstock.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>

            <script src="js/script.js"></script>
        </body>
        </html>
