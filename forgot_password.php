<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/navigation.php'; ?>
<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
$error_message = null;
$errors = array();
$email_sent=FALSE;

$token = Input::get('csrf');
if(Input::exists()){
	if(!Token::check($token)){
		die('Token doesn\'t match!');
	}
}

if (Input::get('forgotten_password')) {
	$email = Input::get('email');
	$fuser = new User($email);
	//validate the form
	$validate = new Validate();
	$validation = $validate->check($_POST,array('email' => array('display' => 'Email','valid_email' => true,'required' => true,),));

	if($validation->passed()){
		if($fuser->exists()){
			//send the email
			$options = array(
			  'fname' => $fuser->data()->fname,
			  'email' => $email,
			  'vericode' => $fuser->data()->vericode,
			);
			$subject = 'Password Reset';
			$encoded_email=rawurlencode($email);
			$body =  email_body('_email_template_forgot_password.php',$options);
			$email_sent=email($encoded_email,$subject,$body);
			if(!$email_sent){
				$errors[] = 'Email NOT sent due to error. Please contact site administrator.';
			}
		}else{
			$errors[] = 'That email does not exist in our database';
		}
	}else{
		//display the errors
		$errors = $validation->errors();
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

if($email_sent){
	require 'views/_forgot_password_sent.php';
}else{
	require 'views/_forgot_password.php';
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

  <script src="js/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
  <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- icheck -->
  <script src="js/icheck/icheck.min.js"></script>

  <script src="js/custom.js"></script>

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
