<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/navigation.php'; ?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
$validation = new Validate();
//PHP Goes Here!

$errors = [];
$successes = [];

//Forms posted
if(!empty($_POST))
{
  $token = $_POST['csrf'];
  if(!Token::check($token)){
    die('Token doesn\'t match!');
  }

  //Delete permission levels
  if(!empty($_POST['delete'])){
    $deletions = $_POST['delete'];
    if ($deletion_count = deletePermission($deletions)){
      $successes[] = lang("PERMISSION_DELETIONS_SUCCESSFUL", array($deletion_count));
    }
  }

  //Create new permission level
  if(!empty($_POST['name'])) {
    $permission = Input::get('name');
    $fields=array('name'=>$permission);
    //NEW Validations
        $validation->check($_POST,array(
          'name' => array(
            'display' => 'Permission Name',
            'required' => true,
            'unique' => 'permissions',
            'min' => 1,
            'max' => 25
          )
        ));
        if($validation->passed()){
          $db->insert('permissions',$fields);
          echo "Permission Updated";

  }else{

    }
  }
}


$permissionData = fetchAllPermissions(); //Retrieve list of all permission levels
$count = 0;
// dump($permissionData);
// echo $permissionData[0]->name;
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
<div class="col-sm-12">
        <div id="form-errors">
            <?=$validation->display_errors();?></div>
        <!-- Left Column -->
        <div class="class col-sm-3"></div>

        <!-- Main Center Column -->
        <div class="class col-sm-6">
          <!-- Content Goes Here. Class width can be adjusted -->


			<?php
			$errors = [];
			$successes = [];
			echo resultBlock($errors,$successes);
			?>
			<form name='adminPermissions' action='<?=$_SERVER['PHP_SELF']?>' method='post'>
			  <h2>Create a new permission group</h2>
			  <p>
				<label>Permission Name:</label>
				<input type='text' name='name' />
			  </p>

			  <br>
			  <table class='table table-hover table-list-search'>
				<tr>
				  <th>Delete</th><th>Permission Name</th>
				</tr>

				<?php
				//List each permission level
				foreach ($permissionData as $v1) {
				  ?>
				  <tr>
					<td><input type='checkbox' name='delete[<?=$permissionData[$count]->id?>]' id='delete[<?=$permissionData[$count]->id?>]' value='<?=$permissionData[$count]->id?>'></td>
					<td><a href='admin_permission.php?id=<?=$permissionData[$count]->id?>'><?=$permissionData[$count]->name?></a></td>
				  </tr>
				  <?php
				  $count++;
				}
				?>

			  </table>


			  <input type="hidden" name="csrf" value="<?=Token::generate();?>" >

			  <input class='btn btn-primary' type='submit' name='Submit' value='Add/Update/Delete' /><br><br>

			</form>

          <!-- End of main content section -->
        </div>

        <!-- Right Column -->
        <div class="class col-sm-1"></div>
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
