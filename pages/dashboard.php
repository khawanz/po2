<?php
// HEADER
include_once 'header.php';
?>

    <div id="wrapper">

        <?php
        // NAVIGATION
        include_once 'navigation.php';
        ?>

        <?php
        
        require_once dirname(__DIR__) . '/controller/DashboardController.php';        

        $dashboardController = new DashboardController();
        $totalOrderByStatus = $dashboardController->displayStatusOrder();
        $new = $totalOrderByStatus['new'];
        $booked = $totalOrderByStatus['booked'];
        $onProgress = $totalOrderByStatus['onProgress'];
        $done = $totalOrderByStatus['done'];
        
        ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>                   
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $new ?></div>
                                    <div>New Purchase Order!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
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
                                    <i class="fa fa-list-alt fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $booked; ?></div>
                                    <div>PO - DP Paid!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
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
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $onProgress; ?></div>
                                    <div>In Progress!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
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
                                    <i class="fa fa-credit-card fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $done; ?></div>
                                    <div>PO Done!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- BAR AND DONUT CHART -->
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> PO Total
                            <div class="pull-right">
                                <div class="btn-group">
                                    <select id="select-order-bar">
                                        <option value="year">yearly</option>
                                        <option value="month">monthly</option>
                                        <option value="week">weekly</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">                            
                            <div id="order-bar-chart"></div>                            
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Total Day Left
                        </div>
                        <div class="panel-body">
                            <div id="donut-chart"></div>
                            <a href="#" class="btn btn-default btn-block">View Details</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>                   
                </div>
                <!-- /.col-lg-4 -->
            </div>
            
            <!-- AREA CHART -->
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Ordered Items
                            <div class="pull-right">
                                <div class="btn-group">
                                    <select id="select-item-area">
                                        <option value="year">yearly</option>
                                        <option value="month">monthly</option>
                                        <option value="week">weekly</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="item-area-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Purchased Items
                            <div class="pull-right">
                                <div class="btn-group">
                                    <select id="select-inventory-area">
                                        <option value="year">yearly</option>
                                        <option value="month">monthly</option>
                                        <option value="week">weekly</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="inventory-area-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
<?php
   // donut chart (order IN still in progress)
   $totalDay = $dashboardController->displayDonut();   
   $totalDayData = json_encode($totalDay);
?>
  <script>
      var totalDayData = <?php echo $totalDayData ?>;console.log('total', totalDayData);
  </script> 
  
<?php
include_once 'footer.php';

