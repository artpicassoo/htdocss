<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/navigation.php'; ?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
//PHP Goes Here!
$errors = $successes = [];
$form_valid=TRUE;
$permOpsQ = $db->query("SELECT * FROM permissions");
$permOps = $permOpsQ->results();
// dnd($permOps);

//Forms posted
if (!empty($_POST)) {
  //Delete User Checkboxes
  if (!empty($_POST['delete'])){
    $deletions = $_POST['delete'];
    if ($deletion_count = deleteUsers($deletions)){
      $successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
    }
    else {
      $errors[] = lang("SQL_ERROR");
    }
  }
  //Manually Add User
  if(!empty($_POST['addUser'])) {
    $join_date = date("Y-m-d H:i:s");
    $username = Input::get('username');
  	$fname = Input::get('fname');
  	$lname = Input::get('lname');
  	$email = Input::get('email');
    $perm = Input::get('perm');
    $token = $_POST['csrf'];

    if(!Token::check($token)){
      die('Token doesn\'t match!');
    }

    $form_valid=FALSE; // assume the worst
    $validation = new Validate();
    $validation->check($_POST,array(
      'username' => array(
      'display' => 'Username',
      'required' => true,
      'min' => 5,
      'max' => 35,
      'unique' => 'users',
      ),
      'fname' => array(
      'display' => 'First Name',
      'required' => true,
      'min' => 2,
      'max' => 35,
      ),
      'lname' => array(
      'display' => 'Last Name',
      'required' => true,
      'min' => 2,
      'max' => 35,
      ),
      'email' => array(
      'display' => 'Email',
      'required' => true,
      'valid_email' => true,
      'unique' => 'users',
      ),
      'password' => array(
      'display' => 'Password',
      'required' => true,
      'min' => 6,
      'max' => 25,
      ),
      'confirm' => array(
      'display' => 'Confirm Password',
      'required' => true,
      'matches' => 'password',
      ),
    ));
  	if($validation->passed()) {
		$form_valid=TRUE;
      try {
        // echo "Trying to create user";
        $fields=array(
          'username' => Input::get('username'),
          'fname' => Input::get('fname'),
          'lname' => Input::get('lname'),
          'email' => Input::get('email'),
          'password' =>
          password_hash(Input::get('password'), PASSWORD_BCRYPT, array('cost' => 12)),
          'permissions' => 1,
          'account_owner' => 1,
          'stripe_cust_id' => '',
          'join_date' => $join_date,
          'company' => Input::get('company'),
          'email_verified' => 1,
          'active' => 1,
          'vericode' => 111111,
        );
        $db->insert('users',$fields);
        $theNewId=$db->lastId();
        // bold($theNewId);
        $addNewPermission = array('user_id' => $theNewId, 'permission_id' => $perm);
        $db->insert('user_permission_matches',$addNewPermission);

        $successes[] = lang("ACCOUNT_USER_ADDED");

      } catch (Exception $e) {
        die($e->getMessage());
      }

    }
  }
}

$userData = fetchAllUsers(); //Fetch information for all users


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
				
	    <div class="col-xs-12 col-md-6">
		<h1>Manage Users</h1>
	  </div>

	  <div class="col-xs-12 col-md-6">
			<form class="">
				<label for="system-search">Search:</label>
				<div class="input-group">
                    <input class="form-control" id="system-search" name="q" placeholder="Search Users..." type="text">
                    <span class="input-group-btn">
						<button type="submit" class="btn btn-default"><i class="fa fa-times"></i></button>
                    </span>
                </div>
			</form>
		  </div>

				 <div class="row">
		     <div class="col-md-12">
          <?php echo resultBlock($errors,$successes);
				?>

							 <hr />
               <div class="row">
               <div class="col-xs-12">
               <?php
               if (!$form_valid && Input::exists()){
               	echo display_errors($validation->errors());
               }
               ?>

               <form class="form-signup" action="admin_users.php" method="POST" id="payment-form">

                <div class="well well-sm">
               	<h3 class="form-signin-heading"> Manually Add a New
                <select name="perm">
                  <?php

                  foreach ($permOps as $permOp){
                    echo "<option value='$permOp->id'>$permOp->name</option>";
                  }
                  ?>
                  </select>
                  </h3>

               	<div class="form-group">
                  <div class="col-xs-2">
               		<input  class="form-control" type="text" name="username" id="username" placeholder="Username" value="<?php if (!$form_valid && !empty($_POST)){ echo $username;} ?>" required autofocus>
</div>
                  <div class="col-xs-2">
               		<input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="<?php if (!$form_valid && !empty($_POST)){ echo $fname;} ?>" required>
</div>
                  <div class="col-xs-2">
               		<input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="<?php if (!$form_valid && !empty($_POST)){ echo $lname;} ?>" required>
</div>
                  <div class="col-xs-2">
               		<input  class="form-control" type="text" name="email" id="email" placeholder="Email Address" value="<?php if (!$form_valid && !empty($_POST)){ echo $email;} ?>" required >
</div>
                  <div class="col-xs-2">
               		<input  class="form-control" type="password" name="password" id="password" placeholder="Password" required aria-describedby="passwordhelp">
</div>
                  <div class="col-xs-2">
               		<input  type="password" id="confirm" name="confirm" class="form-control" placeholder="Confirm Password" required >
</div>
               	</div>

                <br /><br />
               	<input type="hidden" value="<?=Token::generate();?>" name="csrf">
	            <input class='btn btn-primary' type='submit' name='addUser' value='Manually Add User' />
              </div>
               </form>
               </div>
               </div>
        <div class="row">
        <div class="col-xs-12">
				 <div class="alluinfo">&nbsp;</div>
				<form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
				 <div class="allutable table-responsive">
					<table class='table table-hover table-list-search'>
					<thead>
					<tr>
						<th>Delete</th><th>Username</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Join Date</th><th>Last Sign In</th><th>Logins</th>
					 </tr>
					</thead>
				 <tbody>
					<?php
					//Cycle through users
					foreach ($userData as $v1) {
							?>
					<tr>
					<td><div class="form-group"><input type="checkbox" name="delete[<?=$v1->id?>]" value="<?=$v1->id?>" /></div></td>
					<td><a href='admin_user.php?id=<?=$v1->id?>'><?=$v1->username?></a></td>
					<td><?=$v1->email?></td>
					<td><?=$v1->fname?></td>
					<td><?=$v1->lname?></td>
					<td><?=$v1->join_date?></td>
					<td><?=$v1->last_login?></td>
					<td><?=$v1->logins?></td>
					</tr>
							<?php } ?>

				  </tbody>
				</table>
				</div>


				<input class='btn btn-danger' type='submit' name='Submit' value='Delete' /><br><br>
				</form>

		  </div>
		</div>


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
