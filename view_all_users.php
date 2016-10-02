<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/navigation.php'; ?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
//PHP Goes Here!

if($user->isLoggedIn()) { $thisUserID = $user->data()->id;} else { $thisUserID = 0; }

$userQ = $db->query("SELECT * FROM users LEFT JOIN profiles ON users.id = user_id ");
// group active, inactive, on naughty step
$users = $userQ->results();
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
				
<div class="allutable table-responsive">
<table class='table table-hover table-list-search'>
<thead>
<tr>
  <th><div class="alluinfo">&nbsp;</div></th>
  <th>Username</th>
 </tr>
</thead>
 <tbody>
<?php
//Cycle through users
foreach ($users as $v1) {

	$ususername = ucfirst($v1->username);
	$ususerbio = ucfirst($v1->bio);
	$grav = get_gravatar(strtolower(trim($v1->email)));
	$useravatar = '<img src="'.$grav.'" class="img-responsive img-thumbnail" alt="'.$ususername.'" style="width:50px;height:50px;">';

?>

	<tr>
		<td>
			<a href="profile.php?id=<?=$v1->id?>"><?php echo $useravatar;?></a>
		</td>
  
		  <td>
			<h4><a href="profile.php?id=<?=$v1->id?>"><?=$ususername?>  </a></h4>
			<p ><?=$ususerbio?></p>
		</td>

	</tr>
<?php } ?>
  </tbody>
</table> 
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


