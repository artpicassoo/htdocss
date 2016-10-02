<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/navigation.php'; ?>

<?php
if (!securePage($_SERVER['PHP_SELF'])){die();}

if ($settings->site_offline==1){die("The site is currently offline.");}?>

<?php
$emailQ = $db->query("SELECT * FROM email");
$emailR = $emailQ->first();
// dnd($emailR);
// dnd($emailR->email_act);
//PHP Goes Here!
$errors=[];
$successes=[];
$userId = $user->data()->id;
$grav = get_gravatar(strtolower(trim($user->data()->email)));

$validation = new Validate();
$userdetails=$user->data();

//Temporary Success Message
$holdover = Input::get('success');
if($holdover == 'true'){
	bold("Account Updated");
}

//Forms posted
if(!empty($_POST)) {
    $token = $_POST['csrf'];
    if(!Token::check($token)){
      die('Token doesn\'t match!');
    }else {

    //Update display name

    if ($userdetails->username != $_POST['username']){
		$displayname = Input::get("username");

		$fields=array('username'=>$displayname);
		$validation->check($_POST,array(
		'username' => array(
		  'display' => 'Username',
		  'required' => true,
		  'unique_update' => 'users,'.$userId,
		  'min' => 1,
		  'max' => 25
		)
		));
		if($validation->passed()){
			//echo 'Username changes are disabled by commenting out this field and disabling input in the form/view';
			//$db->update('users',$userId,$fields);

			$successes[]="Username updated.";
		}else{
			//validation did not pass
			foreach ($validation->errors() as $error) {
				$errors[] = $error;
			}

		}
    }else{
		$displayname=$userdetails->username;
	}

    //Update first name

    if ($userdetails->fname != $_POST['fname']){
		$fname = Input::get("fname");

		$fields=array('fname'=>$fname);
		$validation->check($_POST,array(
		'fname' => array(
		  'display' => 'First Name',
		  'required' => true,
		  'min' => 1,
		  'max' => 25
		)
		));
		if($validation->passed()){
			$db->update('users',$userId,$fields);

			$successes[]='First name updated.';
		}else{
			//validation did not pass
			foreach ($validation->errors() as $error) {
				$errors[] = $error;
			}

		}
    }else{
		$fname=$userdetails->fname;
	}

    //Update last name

    if ($userdetails->lname != $_POST['lname']){
      $lname = Input::get("lname");

      $fields=array('lname'=>$lname);
      $validation->check($_POST,array(
        'lname' => array(
          'display' => 'Last Name',
          'required' => true,
          'min' => 1,
          'max' => 25
        )
      ));
    if($validation->passed()){
      $db->update('users',$userId,$fields);

	  $successes[]='Last name updated.';
    }else{
			//validation did not pass
			foreach ($validation->errors() as $error) {
				$errors[] = $error;
			}

      }
    }else{
		$lname=$userdetails->lname;
	}

    //Update email
    if ($userdetails->email != $_POST['email']){
      $email = Input::get("email");
      $fields=array('email'=>$email);
      $validation->check($_POST,array(
        'email' => array(
          'display' => 'Email',
          'required' => true,
          'valid_email' => true,
          'unique_update' => 'users,'.$userId,
          'min' => 3,
          'max' => 75
        )
      ));
    if($validation->passed()){
      $db->update('users',$userId,$fields);
			if($emailR->email_act=1){
				$db->update('users',$userId,['email_verified'=>0]);
			}


	  $successes[]='Email updated.';
    }else{
			//validation did not pass
			foreach ($validation->errors() as $error) {
				$errors[] = $error;
			}
      }

    }else{
		$email=$userdetails->email;
	}

    if(!empty($_POST['password'])) {
      $validation->check($_POST,array(
        'old' => array(
          'display' => 'Old Password',
          'required' => true,
        ),
        'password' => array(
          'display' => 'New Password',
          'required' => true,
          'min' => 6,
        ),
        'confirm' => array(
          'display' => 'Confirm New Password',
          'required' => true,
          'matches' => 'password',
        ),
      ));
		foreach ($validation->errors() as $error) {
			$errors[] = $error;
		}

      if (!password_verify(Input::get('old'),$user->data()->password)) {
			foreach ($validation->errors() as $error) {
				$errors[] = $error;
			}
			$errors[]='Your password does not match our records.';
      }
		if (empty($errors)) {
			//process
			$new_password_hash = password_hash(Input::get('password'),PASSWORD_BCRYPT,array('cost' => 12));
			$user->update(array('password' => $new_password_hash,),$user->data()->id);
			$successes[]='Password updated.';
		}
    }
    }
}else{
	$displayname=$userdetails->username;
	$fname=$userdetails->fname;
	$lname=$userdetails->lname;
	$email=$userdetails->email;
}
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
<div class="row">
<div class="col-xs-12 col-md-2">
<p><img src="<?=$grav; ?>" class="img-thumbnail" alt="Generic placeholder thumbnail"></p>
</div>
<div class="col-xs-12 col-md-10">
<h1>Update your user settings</h1>
<strong>Want to change your profile picture? </strong><br> Visit <a href="https://en.gravatar.com/">https://en.gravatar.com/</a> and setup an account with the email address <?=$email?>.  It works across millions of sites. It's fast and easy!<br>
<span class="bg-danger"><?=display_errors($errors);?></span>
<span><?=display_successes($successes);?></span>

<form name='updateAccount' action='user_settings.php' method='post'>

	<div class="form-group">
		<label>Username</label>
		<input  class='form-control' type='text' name='username' value='<?=$displayname?>' readonly/>
	</div>

	<div class="form-group">
		<label>First Name</label>
		<input  class='form-control' type='text' name='fname' value='<?=$fname?>' />
	</div>

	<div class="form-group">
		<label>Last Name</label>
		<input  class='form-control' type='text' name='lname' value='<?=$lname?>' />
	</div>

	<div class="form-group">
		<label>Email</label>
		<input class='form-control' type='text' name='email' value='<?=$email?>' />
	</div>

	<div class="form-group">
		<label>Old Password (required to change password)</label>
		<input class='form-control' type='password' name='old' />
	</div>

	<div class="form-group">
		<label>New Password (8 character minimum)</label>
		<input class='form-control' type='password' name='password' />
	</div>

	<div class="form-group">
		<label>Confirm Password</label>
		<input class='form-control' type='password' name='confirm' />
	</div>

	<input type="hidden" name="csrf" value="<?=Token::generate();?>" />

	<p><input class='btn btn-primary' type='submit' value='Update' class='submit' />
	<a class="btn btn-info" href="account.php">Cancel</a>

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
