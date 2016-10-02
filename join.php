<?php
ini_set("allow_url_fopen", 1);
?>
<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/navigation.php'; ?>
<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
$settingsQ = $db->query("SELECT * FROM settings");
$settings = $settingsQ->first();
if($settings->recaptcha == 1){
	require_once("includes/recaptcha.config.php");
}
//There is a lot of commented out code for a future release of sign ups with payments
$form_method = 'POST';
$form_action = 'join.php';
$vericode = rand(100000,999999);

$form_valid=FALSE;

//Decide whether or not to use email activation
$query = $db->query("SELECT * FROM email");
$results = $query->first();
$act = $results->email_act;

//Opposite Day for Pre-Activation - Basically if you say in email
//settings that you do NOT want email activation, this lists new
//users as active in the database, otherwise they will become
//active after verifying their email.
if($act==1){
	$pre = 0;
} else {
	$pre = 1;
}

$token = Input::get('csrf');
if(Input::exists()){
	if(!Token::check($token)){
		die('Token doesn\'t match!');
	}
}

$reCaptchaValid=FALSE;

if(Input::exists()){

	$username = Input::get('username');
	$fname = Input::get('fname');
	$lname = Input::get('lname');
	$email = Input::get('email');
	$company = Input::get('company');
	$agreement_checkbox = Input::get('agreement_checkbox');

	if ($agreement_checkbox=='on'){
		$agreement_checkbox=TRUE;
	}else{
		$agreement_checkbox=FALSE;
	}

	$db = DB::getInstance();
	$settingsQ = $db->query("SELECT * FROM settings");
	$settings = $settingsQ->first();
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
	  'company' => array(
		'display' => 'Company Name',
		'required' => false,
		'min' => 0,
		'max' => 75,
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

	//if the agreement_checkbox is not checked, add error
	if (!$agreement_checkbox){
		$validation->addError(["Please read and accept terms and conditions"]);
	}

	if($validation->passed() && $agreement_checkbox){
		//Logic if ReCAPTCHA is turned ON
		if($settings->recaptcha == 1){
			require_once("includes/recaptcha.config.php");
			//reCAPTCHA 2.0 check
			$response = null;

			// check secret key
			$reCaptcha = new ReCaptcha($privatekey);

			// if submitted check response
			if ($_POST["g-recaptcha-response"]) {
				$response = $reCaptcha->verifyResponse(
					$_SERVER["REMOTE_ADDR"],
					$_POST["g-recaptcha-response"]);
			}
			if ($response != null && $response->success) {
				// account creation code goes here
				$reCaptchaValid=TRUE;
				$form_valid=TRUE;
			}else{
				$reCaptchaValid=FALSE;
				$form_valid=FALSE;
				$validation->addError(["Please check the reCaptcha box."]);
			}

		} //else for recaptcha

		if($reCaptchaValid || $settings->recaptcha == 0){

			//add user to the database
			$user = new User();
			$join_date = date("Y-m-d H:i:s");
			$params = array(
				'fname' => Input::get('fname'),
				'email' => $email,
				'vericode' => $vericode,
			);

			if($act == 1) {
				//Verify email address settings
				$to = rawurlencode($email);
				$subject = 'Welcome to UserSpice!';
				$body = email_body('_email_template_verify.php',$params);
				email($to,$subject,$body);
			}
			try {
				// echo "Trying to create user";
				$user->create(array(
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
					'email_verified' => $pre,
					'active' => 1,
					'vericode' => $vericode,
				));
			} catch (Exception $e) {
				die($e->getMessage());
			}
			Redirect::to($us_url_root.'joinThankYou.php');
		}

	} //Validation and agreement checbox
} //Input exists

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
require 'views/_join.php';
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

<?php 	if($settings->recaptcha == 1){ ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php } ?>

