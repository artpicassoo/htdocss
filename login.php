<?php
/*
UserSpice 4
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
ini_set("allow_url_fopen", 1);
?>




<?php require_once 'init.php'; ?>
<?php
//check for a custom page
$currentPage = currentPage();
if(file_exists($abs_us_root.$us_url_root.'usersc/'.$currentPage)){
	if(currentFolder()!= 'usersc'){
		Redirect::to($us_url_root.'usersc/'.$currentPage);
	}
}

$db = DB::getInstance();
$settingsQ = $db->query("Select * FROM settings");
$settings = $settingsQ->first();
if ($settings->site_offline==1){
	die("The site is currently offline.");
}

if ($settings->force_ssl==1){
	if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) {
		// if request is not secure, redirect to secure url
		$url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		Redirect::to($url);
		exit;
	}
}

//if track_guest enabled AND there is a user logged in
if($settings->track_guest == 1 && $user->isLoggedIn()){
	if ($user->isLoggedIn()){
		$user_id=$user->data()->id;
	}else{
		$user_id=0;
	}
	new_user_online($user_id);
	
}
?>
<?php

// Signup
$lang = array_merge($lang,array(
	"SIGNUP_TEXT"			=> "Register",
	"SIGNUP_BUTTONTEXT"		=> "Register Me",
	"SIGNUP_AUDITTEXT"		=> "Registered",
	));

// Signin
$lang = array_merge($lang,array(
	"SIGNIN_FAIL"			=> "** FAILED LOGIN **",
	"SIGNIN_TITLE"			=> "Please Log In",
	"SIGNIN_TEXT"			=> "Log In",
	"SIGNOUT_TEXT"			=> "Log Out",
	"SIGNIN_BUTTONTEXT"		=> "Login",
	"SIGNIN_AUDITTEXT"		=> "Logged In",
	"SIGNOUT_AUDITTEXT"		=> "Logged Out",
	));

//Navigation
$lang = array_merge($lang,array(
	"NAVTOP_HELPTEXT"		=> "Help",
	));

$query = $db->query("SELECT * FROM email");
$results = $query->first();

//Value of email_act used to determine whether to display the Resend Verification link
$email_act=$results->email_act;

?>
<?php
$settingsQ = $db->query("SELECT * FROM settings");
$settings = $settingsQ->first();
$error_message = '';
$reCaptchaValid=FALSE;

if (Input::exists()) {
	$token = Input::get('csrf');
	if(!Token::check($token)){
		die('Token doesn\'t match!');
	}

	//Check to see if recaptcha is enabled
	if($settings->recaptcha == 1){
		require_once 'includes/recaptcha.config.php';

		//reCAPTCHA 2.0 check
		$response = null;

		// check secret key
		$reCaptcha = new ReCaptcha($privatekey);

		// if submitted check response
		if ($_POST["g-recaptcha-response"]) {
			$response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$_POST["g-recaptcha-response"]);
		}
		if ($response != null && $response->success) {
			$reCaptchaValid=TRUE;

		}else{
			$reCaptchaValid=FALSE;
			$error_message .= 'Please check the reCaptcha.';
		}
	}else{
		$reCaptchaValid=TRUE;
	}

	if($reCaptchaValid || $settings->recaptcha == 0){ //if recaptcha valid or recaptcha disabled

		$validate = new Validate();
		$validation = $validate->check($_POST, array('username' => array('display' => 'Username','required' => true),'password' => array('display' => 'Password', 'required' => true)));

		if ($validation->passed()) {
			//Log user in

			$remember = (Input::get('remember') === 'on') ? true : false;
			$user = new User();
			$login = $user->loginEmail(Input::get('username'), trim(Input::get('password')), $remember);
			if ($login) {
				if(file_exists($abs_us_root.$us_url_root.'usersc/scripts/custom_login_script.php')){
					require_once $abs_us_root.$us_url_root.'usersc/scripts/custom_login_script.php';
				}else{
					//Feel free to change where the user goes after login!
					Redirect::to('account.php');
				}
			} else {
				$error_message .= 'Log in failed. Please check your username and password and try again.';
			}
		} else{
			$error_message .= '<ul>';
			foreach ($validation->errors() as $error) {
				$error_message .= '<li>' . $error . '</li>';
			}
			$error_message .= '</ul>';
		}
	}
}

?>


<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Manager </title>
  <!-- Bootstrap core CSS -->

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/maps/jquery-jvectormap-2.0.3.css" />
  <link href="css/icheck/flat/green.css" rel="stylesheet" />
  <link href="css/floatexamples.css" rel="stylesheet" type="text/css" />

  <script src="js/jquery.min.js"></script>
  <script src="js/nprogress.js"></script>



<body style="background:#F7F7F7;">

 
    <a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>

    <div id="wrapper">
      <div id="login" class="animate form">
        <section class="login_content">
          <div class="bg-danger"><?=$error_message;?></div>
	<form name="login" class="form-signin" action="login.php" method="post">
	<h1 class="form-signin-heading"> <?=lang("SIGNIN_TITLE","");?></h1>

	<div class="form-group">
		<label for="username" >Username OR Email</label>
		<input  class="form-control" type="text" name="username" id="username" placeholder="Username/Email" required autofocus>
	</div>

	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" class="form-control"  name="password" id="password"  placeholder="Password" required autocomplete="off">
	</div>

	<?php
	if($settings->recaptcha == 1){
	?>
	<div class="form-group">
	<label>Please check the box below to continue</label>
	<div class="g-recaptcha" data-sitekey="<?=$publickey; ?>"></div>
	</div>
	<?php } ?>
	
    <div class="form-group">
	<input type="hidden" name="csrf" value="<?=Token::generate(); ?>">
	<button class="btn btn-default submit" type="submit"><i class="fa fa-sign-in"></i> Log in </button>
	<label for="remember">
	<input type="checkbox" name="remember" id="remember" > Remember Me</label>
	</div>
	     
	</form>
	
             
			 <?php require_once $abs_us_root.$us_url_root.'includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>
			 <?php 	if($settings->recaptcha == 1){ ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php } ?>
<?php require_once $abs_us_root.$us_url_root.'includes/html_footer.php'; // currently just the closing /body and /html ?>
			 
          
         
          <!-- form -->
        </section>
		  </div>
        <!-- content -->
      </div>







    <!-- footers -->


    <!-- Place any per-page javascript here -->


