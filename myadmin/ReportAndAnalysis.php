<?php
include ("header.php");
?>
<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1">Sales Reports & Analytics</h3>
        
        <!-- Date Range Filter -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Select Date Range
            </div>
            <div class="panel-body">
                <form class="form-inline" method="post">
                    <div class="form-group">
                        <label>From:</label>
                        <input type="date" class="form-control" name="start_date">
                    </div>
                    <div class="form-group">
                        <label>To:</label>
                        <input type="date" class="form-control" name="end_date">
                    </div>
                    <button type="submit" class="btn btn-primary">Apply</button>
                </form>
            </div>
        </div>
        
        <!-- Sales Summary -->
        <div class="col_3">
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-dollar icon-rounded"></i>
                    <div class="stats">
                        <h5><strong>$12,850</strong></h5>
                        <span>Total Revenue</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-shopping-cart user1 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong>45</strong></h5>
                        <span>Total Orders</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-pie-chart user2 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong>$285</strong></h5>
                        <span>Avg. Order Value</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-users dollar1 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong>18</strong></h5>
                        <span>New Customers</span>
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        
        <!-- Sales Chart -->
        <div class="col-md-12 span_7">
            <div class="content_bottom">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Monthly Sales Trend</h4>
                        </div>
                        <div class="panel-body">
                            <div id="sales_chart" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
        
        <!-- Top Products -->
        <div class="col-md-6 span_8">
            <div class="activity_box">
                <h3>Top Selling Products</h3>
                <div class="scrollbar" id="style-2">
                    <?php
                    // Replace with your actual database query
                    $topProducts = [
                        ['name' => 'Diamond Engagement Ring', 'sales' => '$4,250', 'units' => 5],
                        ['name' => 'Gold Chain Necklace', 'sales' => '$2,890', 'units' => 7],
                        ['name' => 'Pearl Earrings', 'sales' => '$1,750', 'units' => 10],
                        ['name' => 'Silver Bracelet', 'sales' => '$1,250', 'units' => 8],
                        ['name' => 'Ruby Pendant', 'sales' => '$980', 'units' => 3]
                    ];
                    
                    foreach ($topProducts as $index => $product) {
                        echo '<div class="activity-row">';
                        echo '<div class="col-xs-1"><i class="fa fa-gem text-info"></i></div>';
                        echo '<div class="col-xs-7 activity-desc">';
                        echo '<h5>'.$product['name'].'</h5>';
                        echo '<p>'.$product['units'].' units sold</p>';
                        echo '</div>';
                        echo '<div class="col-xs-4 activity-desc">';
                        echo '<h6>'.$product['sales'].'</h6>';
                        echo '</div>';
                        echo '<div class="clearfix"></div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <!-- Top Categories -->
        <div class="col-md-6 stats-info">
            <div class="panel-heading">
                <h4 class="panel-title">Sales by Category</h4>
            </div>
            <div class="panel-body">
                <ul class="list-unstyled">
                    <li>Rings<div class="text-success pull-right">35%<i class="fa fa-level-up"></i></div></li>
                    <li>Necklaces<div class="text-success pull-right">28%<i class="fa fa-level-up"></i></div></li>
                    <li>Earrings<div class="text-success pull-right">15%<i class="fa fa-level-up"></i></div></li>
                    <li>Bracelets<div class="text-danger pull-right">12%<i class="fa fa-level-down"></i></div></li>
                    <li>Pendants<div class="text-danger pull-right">7%<i class="fa fa-level-down"></i></div></li>
                    <li>Other<div class="text-success pull-right">3%<i class="fa fa-level-up"></i></div></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Additional Chart Script -->
<script type="text/javascript">
    // Sample data for the sales chart
    $(document).ready(function() {
        var salesData = [
            {month: 'Jan', sales: 3200},
            {month: 'Feb', sales: 3800},
            {month: 'Mar', sales: 4200},
            {month: 'Apr', sales: 3900},
            {month: 'May', sales: 4500},
            {month: 'Jun', sales: 4800}
        ];
        
        // Create simple bar chart using the existing Rickshaw library from your template
        var graph = new Rickshaw.Graph({
            element: document.getElementById("sales_chart"),
            renderer: 'bar',
            series: [{
                data: salesData.map(function(d, i) { return {x: i, y: d.sales/1000}}),
                color: '#33b5e5'
            }]
        });
        
        graph.render();
        
        var xAxis = new Rickshaw.Graph.Axis.X({
            graph: graph,
            tickFormat: function(i) {
                return salesData[i] ? salesData[i].month : '';
            }
        });
        
        xAxis.render();
    });
</script>

<?php
include ("footer.php");
?>