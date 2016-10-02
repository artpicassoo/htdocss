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
*/ ?>
<?php require_once 'init.php'; ?>

<?php
if($user->isLoggedIn()){
	$user->logout();
	Redirect::to('verify_resend.php');
}

$token = Input::get('csrf');
if(Input::exists()){
	if(!Token::check($token)){
		die('Token doesn\'t match!');
	}
}

$email_sent=FALSE;

$errors = array();
if(Input::exists('post')){
	$email = Input::get('email');
	$fuser = new User($email);

	$validate = new Validate();
	$validation = $validate->check($_POST,array(
	'email' => array(
	  'display' => 'Email',
	  'valid_email' => true,
	  'required' => true,
	),
	));
	if($validation->passed()){ //if email is valid, do this

		if($fuser->exists()){
			//send the email
			$options = array(
			  'fname' => $fuser->data()->fname,
			  'email' => $email,
			  'vericode' => $fuser->data()->vericode,
			);
			$encoded_email=rawurlencode($email);
			$subject = 'Verify Your Email';
			$body =  email_body('_email_template_verify.php',$options);
			$email_sent=email($encoded_email,$subject,$body);
			if(!$email_sent){
				$errors[] = 'Email NOT sent due to error. Please contact site administrator.';
			}
		}else{
			$errors[] = 'That email does not exist in our database';
		}
	}else{
		$errors = $validation->errors();
	}
}

?>


  
  
  
  
  
  
  
  
  
  
  <!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Gentallela Alela! | </title>

  <!-- Bootstrap core CSS -->

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="css/custom.css" rel="stylesheet">
  <link href="css/icheck/flat/green.css" rel="stylesheet">


  <script src="js/jquery.min.js"></script>

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

  <div class="container body">

    <div class="main_container">

      <!-- page content -->
      <div class="col-md-12">
        <div class="col-middle">
          <div class="text-center">
            <h1 class="error-number">500</h1>
            <h2>Internal Server Error</h2>
            <p>We track these errors automatically, but if the problem persists feel free to contact us. In the meantime, try refreshing. <a href="#">Report this?</a>
            </p>
        <?php

if ($email_sent){
	require 'views/_verify_resend_success.php';
}else{
	require 'views/_verify_resend.php';
}

?>	
          </div>
        </div>
      </div>
      <!-- /page content -->

    </div>
    <!-- footer content -->
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

  <!-- /footer content -->
</body>

</html>
