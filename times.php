<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/navigation.php'; ?>
<?php if (!securePage($_SERVER['PHP_SELF'])){die();}
 if ($settings->site_offline==1){die("The site is currently offline.");}?>
<?php
//PHP Goes Here!

if($user->isLoggedIn()) { $thisUserID = $user->data()->id;} else { $thisUserID = 0; }

if(isset($_GET['id']))
	{
	$userID = Input::get('id');
	
	$userQ = $db->query("SELECT * FROM profiles LEFT JOIN users ON user_id = users.id WHERE user_id = ?",array($userID));
	$thatUser = $userQ->first();

	if($thisUserID == $userID)
		{
		$editbio = ' <small><a href="edit_profile.php">Edit Bio</a></small>';
		}
	else
		{
		$editbio = '';
		}
	
	$ususername = ucfirst($thatUser->username)."'s Profile";
	$grav = get_gravatar(strtolower(trim($thatUser->email)));
	$useravatar = '<img src="'.$grav.'" class="img-thumbnail" alt="'.$ususername.'">';
	$usbio = html_entity_decode($thatUser->bio);
	//Uncomment out the line below to see what's available to you.
	//dump($thisUser);
	}
else
	{
	$ususername = '404';
	$usbio = 'User not found';
	$useravatar = '';
	$editbio = ' <small><a href="/">Go to the homepage</a></small>';
	}
?>
<?php
//if (!securePage($_SERVER['PHP_SELF'])){die();}

	$london_tz    = new DateTimeZone("Europe/London");
    $alaska_tz = new DateTimeZone("America/Anchorage");
    $an_tz     = new DateTimeZone("America/Toronto");
    $ro_bu     = new DateTimeZone("Europe/Bucharest");

    $london_time    = new DateTime("now", $london_tz);
    $alaska_time = new DateTime("now", $alaska_tz);
    $an_time     = new DateTime("now", $an_tz);
    $Romania_time     = new DateTime("now", $ro_bu);
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
<div class="col-xs-4">
			<div class="col-xs-4">
			<div><p>Anchorage</p><strong class="text-success"><?php echo $alaska_time->format("H:i");	?></strong></div>
		</div>		

		<div class="col-xs-4">
			<div><p>Ottawa</p> <strong class="text-success"><?php	 echo $an_time->format("H:i");	?></strong></div>
		</div>	

		<div class="col-xs-4">
			<div><p>London</p> <strong class="text-success"><?php	  echo $london_time->format("H:i");	?></strong></div>
		</div>
		<div class="col-xs-4">
			<div><p>Romania</p> <strong class="text-success"><?php	  echo $Romania_time->format("H:i"); ?></strong></div>
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