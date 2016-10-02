<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/navigation.php'; ?>
<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php

$errors = [];
$successes = [];

//Get line from z_us_root.php that starts with $path
$file = fopen($abs_us_root.$us_url_root."z_us_root.php","r");
while(!feof($file)){
	$currentLine=fgets($file);
	if (substr($currentLine,0,5)=='$path'){
		//echo $currentLine;
		//if here, then it found the line starting with $path so break to preserve $currentLine value
		break;
	}
}
fclose($file);

//sample text: $path=('/','/','/usersc/');
//Get array of paths, with quotes removed
$lineLength=strlen($currentLine);
$pathString=str_replace("'","",substr($currentLine,7,$lineLength-11));
$paths=explode(',',$pathString);

$pages=[];

//Get list of php files for each $path
foreach ($paths as $path){
	$rows=getPathPhpFiles($abs_us_root,$us_url_root,$path);
 	foreach ($rows as $row){
		$pages[]=$row;
	} 
}

$dbpages = fetchAllPages(); //Retrieve list of pages in pages table

$count = 0;
$dbcount = count($dbpages);
$creations = array();
$deletions = array();

foreach ($pages as $page) {
    $page_exists = false;
    foreach ($dbpages as $k => $dbpage) {
        if ($dbpage->page === $page) {
            unset($dbpages[$k]);
            $page_exists = true;
            break;
        }
    }
    if (!$page_exists) {
        $creations[] = $page;
    }
}

// /*
//  * Remaining DB pages (not found) are to be deleted.
//  * This function turns the remaining objects in the $dbpages
//  * array into the $deletions array using the 'id' key.
//  */
$deletions = array_column(array_map(function ($o) {return (array)$o;}, $dbpages), 'id');

$deletes = '';
for($i = 0; $i < count($deletions);$i++) {
	$deletes .= $deletions[$i] . ',';
}
$deletes = rtrim($deletes,',');
//Enter new pages in DB if found
if (count($creations) > 0) {
    createPages($creations);
}
// //Delete pages from DB if not found
if (count($deletions) > 0) {
    deletePages($deletes);
}

//Update $dbpages
$dbpages = fetchAllPages();

?>


<div class="main_container">

     
      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Plain Page</h3>
            </div>

            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
               
              </div>
            </div>
          </div>
          

          <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel" style="height:100%;">
 <!-- CONTINUT PAGINA -->               
				
  <div class="col-xs-12">

          <h1>Manage Page Access</h1>

          <!-- Content goes here -->

		  
		  
		
<br>
<table class='table table-hover table-list-search'>
    <th>Id</th><th>Page</th><th>Access</th><th>Status</th>

    <?php
    //Display list of pages
	$count=0;
    foreach ($dbpages as $page){
		?>
		<tr><td><?=$dbpages[$count]->id?></td>
		<td><?=$dbpages[$count]->page?></td>
		<td>
		<?php
		//Show public/private setting of page
		if($dbpages[$count]->private == 0){
			echo "<span class='btn btn-success btn-xs status'>Public";
		}else {
			echo "<span class='btn btn-danger btn-xs status'>Private";
		}
		?>
		</td>
		<td>
		<a href ='admin_page.php?id=<?=$dbpages[$count]->id?>' class="btn btn-info btn-xs" ><i class='fa fa-info-circle'></i> Edit</a>
		</td>
		
		</tr>
		<?php
		$count++;
    }?>
</table>

        

    </div>
    <!-- /.row -->				
<!-- CONTINUT PAGINA --> 				
              </div>.
            </div>
          </div>
        </div>

        <!-- footer content -->
        <footer>
          <div class="copyright-info">
            <p class="pull-right"><?php require_once $abs_us_root.$us_url_root.'includes/page_footer.php'; // the final html footer copyright row + the external js calls ?></a>
            </p>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->

      </div>
      <!-- /page content -->
    </div>

	
	
	<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>

  <script src="js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>

  <script src="js/custom.js"></script>

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
