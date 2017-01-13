<?php require_once("includes/header.php"); ?>
<?php
if(!$session->is_signed_in()){
    redirect("login.php");
}
?>

        <!-- Navigation -->
        <?php
           require_once("includes/topnav.php");
        ?>
        

        <div id="page-wrapper">

           <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin
                            <small>Dashboard</small>
                        </h1>
                        <!--snippet here-->
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-users fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo $session->count; ?></div>
                                                <div>New Views</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">

                                            <!--<span class="pull-left">View Details</span>-->
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-photo fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo Photo::find_total(); ?></div>
                                                <div>Photos</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="photos.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Total Photos in Gallery</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-user fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo User::find_total(); ?>

                                                </div>

                                                <div>Users</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="users.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Total Users</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-red">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-support fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?php echo Comment::find_total(); ?></div>
                                                <div>Comments</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="comments.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Total Comments</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>


                        </div> <!--First Row-->

                        <!--snippet end -->
                        <div class="row"><!--second Row..Google API here-->
                            <div id="piechart" style="width: 900px; height: 500px;"></div>
                        </div><!--end of second row end of Google API char here-->



                    </div>
                </div>
                <!-- /.row -->


            </div>

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['New views',     <?php echo $session->count; ?>],
            ['Comments',  <?php echo Comment::find_total(); ?>],
            ['Users',       <?php echo User::find_total(); ?>],
            ['Photos',   <?php echo Photo::find_total(); ?>]


        ]);

        var options = {
            title: 'Chart',
            legend:'none',
            backgroundColor:'transparent',
            pieSliceText:'label'

        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>
