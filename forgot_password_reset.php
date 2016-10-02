<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/navigation.php'; ?>
<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
$error_message = null;
$errors = array();
$reset_password_success=FALSE;
$password_change_form=FALSE;


$token = Input::get('csrf');
if(Input::exists()){
	if(!Token::check($token)){
		die('Token doesn\'t match!');
	}
}

if(Input::get('reset') == 1){ //$_GET['reset'] is set when clicking the link in the password reset email.

	//display the reset form.
	$email = Input::get('email');
	$vericode = Input::get('vericode');
	$ruser = new User($email);
	if (Input::get('resetPassword')) {

		$validate = new Validate();
		$validation = $validate->check($_POST,array(
		'password' => array(
		  'display' => 'New Password',
		  'required' => true,
		  'min' => 6,
		),
		'confirm' => array(
		  'display' => 'Confirm Password',
		  'required' => true,
		  'matches' => 'password',
		),
		));
		if($validation->passed()){
			//update password
			$ruser->update(array(
			  'password' => password_hash(Input::get('password'), PASSWORD_BCRYPT, array('cost' => 12)),
			  'vericode' => rand(100000,999999),
				'email_verified' => true,
			),$ruser->data()->id);
			$reset_password_success=TRUE;
		}else{
			$reset_password_success=FALSE;
			$errors = $validation->errors();
		}
	}
	if ($ruser->exists() && $ruser->data()->vericode == $vericode) {
		//if the user email is in DB and verification code is correct, show the form
		$password_change_form=TRUE;
	}
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
<?php
if ((Input::get('reset') == 1)){
	if($reset_password_success){
		require 'views/_forgot_password_reset_success.php';
	}elseif((!Input::get('resetPassword') || !$reset_password_success) && $password_change_form){
		require 'views/_forgot_password_reset.php';
	}else{
		require 'views/_forgot_password_reset_error.php';
	}
}else{
	require 'views/_forgot_password_reset_error.php';
}
?>				

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

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <script src="js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>

  <script src="js/custom.js"></script>

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>
