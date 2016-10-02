
<!DOCTYPE html>
<html>
    <head>
        <title>Pretty Charts with jQuery and AJAX | Tutorialzine Demo</title>
		<link href="assets/css/xcharts.min.css" rel="stylesheet">
		<link href="assets/css/style.css" rel="stylesheet">

    </head>
    <body>
		<div id="content">
			
			<form class="form-horizontal">
			  <fieldset>
		        <div class="input-prepend">
		          <span class="add-on"><i class="icon-calendar"></i></span><input type="text" name="range" id="range" />
		        </div>
			  </fieldset>
			</form>
			
			<div id="placeholder">
				<figure id="chart"></figure>
			</div>

		</div>

		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

		<!-- xcharts includes -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/d3/2.10.0/d3.v2.js"></script>
		<script src="assets/js/xcharts.min.js"></script>

		<!-- The daterange picker bootstrap plugin -->
		<script src="assets/js/sugar.min.js"></script>
		<script src="assets/js/daterangepicker.js"></script>

		<!-- Our main script file -->
		<script src="assets/js/script.js"></script>

		
    </body>
</html><?php

// Set up the ORM library
require_once('setup.php');

try{
	// Insert records for the last 30 days for demo purposes.
	// Delete this block if you want to disable this functionality.
	
	for($i = 0; $i < 30; $i++){
		$sales = ORM::for_table('chart_sales')->create();
		$sales->date = date('Y-m-d', time() - $i*24*60*60);
		$sales->sales_order = rand(0, 100);
		$sales->save();
	}

}
catch(PDOException $e){}

?>