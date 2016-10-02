<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/navigation.php'; ?>
<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
//PHP Goes Here!
$pageId = Input::get('id');
$errors = [];
$successes = [];

//Check if selected pages exist
if(!pageIdExists($pageId)){
  Redirect::to("admin_pages.php"); die();
}

$pageDetails = fetchPageDetails($pageId); //Fetch information specific to page


//Forms posted
if(Input::exists()){
	$token = Input::get('csrf');
	if(!Token::check($token)){
		die('Token doesn\'t match!');
	}
	$update = 0;

	if(!empty($_POST['private'])){
		$private = Input::get('private');
	}

	//Toggle private page setting
	if (isset($private) AND $private == 'Yes'){
		if ($pageDetails->private == 0){
			if (updatePrivate($pageId, 1)){
				$successes[] = lang("PAGE_PRIVATE_TOGGLED", array("private"));
			}else{
				$errors[] = lang("SQL_ERROR");
			}
		}
	}elseif ($pageDetails->private == 1){
		if (updatePrivate($pageId, 0)){
			$successes[] = lang("PAGE_PRIVATE_TOGGLED", array("public"));
		}else{
			$errors[] = lang("SQL_ERROR");
		}
	}

	//Remove permission level(s) access to page
	if(!empty($_POST['removePermission'])){
		$remove = $_POST['removePermission'];
		if ($deletion_count = removePage($pageId, $remove)){
			$successes[] = lang("PAGE_ACCESS_REMOVED", array($deletion_count));
		}else{
			$errors[] = lang("SQL_ERROR");
		}
	}

	//Add permission level(s) access to page
	if(!empty($_POST['addPermission'])){
		$add = $_POST['addPermission'];
		$addition_count = 0;
		foreach($add as $perm_id){
			if(addPage($pageId, $perm_id)){
				$addition_count++;
			}
		}
		if ($addition_count > 0 ){
			$successes[] = lang("PAGE_ACCESS_ADDED", array($addition_count));
		}
	}
	$pageDetails = fetchPageDetails($pageId);
}
$pagePermissions = fetchPagePermissions($pageId);
$permissionData = fetchAllPermissions();
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
          <!-- Content Goes Here. Class width can be adjusted -->
		  
			<h2>Page Permissions </h2>
			<?php resultBlock($errors,$successes); ?>

			<form name='adminPage' action='<?=$_SERVER['PHP_SELF'];?>?id=<?=$pageId;?>' method='post'>
				<input type='hidden' name='process' value='1'>
				
			<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Information</strong></div>
					<div class="panel-body">
						<div class="form-group">
						<label>ID:</label>
						<?= $pageDetails->id; ?>
						</div>
						<div class="form-group">
						<label>Name:</label>
						<?= $pageDetails->page; ?>
						</div>
					</div>
				</div><!-- /panel -->
			</div><!-- /.col -->
			
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Public or Private?</strong></div>
					<div class="panel-body">
						<div class="form-group">
						<label>Private:</label>
						<?php
						$checked = ($pageDetails->private == 1)? ' checked' : ''; ?>
						<input type='checkbox' name='private' id='private' value='Yes'<?=$checked;?>>
						</div>
					</div>
				</div><!-- /panel -->
			</div><!-- /.col -->
			
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Remove Access</strong></div>
					<div class="panel-body">
						<div class="form-group">
						<?php
						//Display list of permission levels with access
						$perm_ids = [];
						foreach($pagePermissions as $perm){
							$perm_ids[] = $perm->permission_id;
						}
						foreach ($permissionData as $v1){
							if(in_array($v1->id,$perm_ids)){ ?>
							<input type='checkbox' name='removePermission[]' id='removePermission[]' value='<?=$v1->id;?>'> <?=$v1->name;?><br/>
							<?php }} ?>
						</div>
					</div>
				</div><!-- /panel -->
			</div><!-- /.col -->
			
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Add Access</strong></div>
					<div class="panel-body">
						<div class="form-group">
						<?php
						//Display list of permission levels without access
						foreach ($permissionData as $v1){
						if(!in_array($v1->id,$perm_ids)){ ?>
						<input type='checkbox' name='addPermission[]' id='addPermission[]' value='<?=$v1->id;?>'> <?=$v1->name;?><br/>
						<?php }} ?>
						</div>
					</div>
				</div><!-- /panel -->
			</div><!-- /.col -->			
			</div><!-- /.row -->				

			<input type="hidden" name="csrf" value="<?=Token::generate();?>" >
			<p>
			<a href = 'admin_pages.php' class='btn btn-primary' >Back</a>
			<input class='btn btn-primary' type='submit' value='Update' class='submit' /></p>
			</form>
        </div>
    </div>				
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

