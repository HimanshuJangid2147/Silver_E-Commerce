<?php
include("header.php");
?>
        <div id="page-wrapper">
        <div class="graphs">
	    <div class="graph_box">
			<div class="col-md-4 grid_2"><div class="grid_1">
				<h3>Circular</h3>
				<canvas id="doughnut" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
			</div></div>
			<div class="col-md-4 grid_2"><div class="grid_1">
				<h3>Line</h3>
				<canvas id="line" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
			</div></div>
			<div class="col-md-4 grid_2"><div class="grid_1">
				<h3>PolarArea</h3>
				<canvas id="polarArea" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
			</div></div>
			<div class="clearfix"> </div>
	    </div>
	    <div class="graph_box1">
			<div class="col-md-4 grid_2"><div class="grid_1">
				<h3>Bar</h3>
				<canvas id="bar" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
			</div></div>
			<div class="col-md-4 grid_2"><div class="grid_1">
				<h3>Pie</h3>
				<canvas id="pie" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
			</div></div>
			<div class="col-md-4 grid_2"><div class="grid_1">
				<h3>Radar</h3><canvas id="radar" height="300" width="400" style="width: 400px; height: 300px;"></canvas>
			</div></div>
			<div class="clearfix"> </div>
		</div>
    <script>

		var doughnutData = [
				{
					value: 30,
					color:"#ef553a"
				},
				{
					value : 50,
					color : "#9358ac"
				},
				{
					value : 100,
					color : "#3b5998"
				},
				{
					value : 40,
					color : "#00aced"
				},
				{
					value : 120,
					color : "#4D5360"
				}
			
			];
		var lineChartData = {
			labels : ["","","","","","",""],
			datasets : [
				{
					fillColor : "#00aced",
					strokeColor : "#00aced",
					pointColor : "#00aced",
					pointStrokeColor : "#fff",
					data : [65,59,90,81,56,55,40]
				},
				{
					fillColor : "#3b5998",
					strokeColor : "#3b5998",
					pointColor : "#3b5998",
					pointStrokeColor : "#fff",
					data : [28,48,40,19,96,27,100]
				}
			]
			
		};
		var pieData = [
				{
					value: 30,
					color:"#ef553a"
				},
				{
					value : 50,
					color : "#00aced"
				},
				{
					value : 100,
					color : "#69D2E7"
				}
			
			];
		var barChartData = {
			labels : ["January","February","March","April","May","June","July"],
			datasets : [
				{
					fillColor : "#ef553a",
					strokeColor : "#ef553a",
					data : [65,59,90,81,56,55,40]
				},
				{
					fillColor : "#00aced",
					strokeColor : "#00aced",
					data : [28,48,40,19,96,27,100]
				}
			]
			
		};
	var chartData = [
			{
				value : Math.random(),
				color: "#D97041"
			},
			{
				value : Math.random(),
				color: "#C7604C"
			},
			{
				value : Math.random(),
				color: "#21323D"
			},
			{
				value : Math.random(),
				color: "#9D9B7F"
			},
			{
				value : Math.random(),
				color: "#7D4F6D"
			},
			{
				value : Math.random(),
				color: "#9358ac"
			}
		];
		var radarChartData = {
			labels : ["","","","","","",""],
			datasets : [
				{
					fillColor : "#3b5998",
					strokeColor : "#3b5998",
					pointColor : "#3b5998",
					pointStrokeColor : "#fff",
					data : [65,59,90,81,56,55,40]
				},
				{
					fillColor : "#ef553a",
					strokeColor : "#ef553a",
					pointColor : "#ef553a",
					pointStrokeColor : "#fff",
					data : [28,48,40,19,96,27,100]
				}
			]
			
		};
	new Chart(document.getElementById("doughnut").getContext("2d")).Doughnut(doughnutData);
	new Chart(document.getElementById("line").getContext("2d")).Line(lineChartData);
	new Chart(document.getElementById("radar").getContext("2d")).Radar(radarChartData);
	new Chart(document.getElementById("polarArea").getContext("2d")).PolarArea(chartData);
	new Chart(document.getElementById("bar").getContext("2d")).Bar(barChartData);
	new Chart(document.getElementById("pie").getContext("2d")).Pie(pieData);
	
	</script>
<?php
include("footer.php");
?>
