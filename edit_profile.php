<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/navigation.php'; ?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
//PHP Goes Here!
$validation = new Validate();
$userID = $user->data()->id;
$grav = get_gravatar(strtolower(trim($user->data()->email)));
$profileQ = $db->query("SELECT * FROM profiles WHERE user_id = ?",array($userID));
$thisProfile = $profileQ->first();
//Uncomment out the 2 lines below to see what's available to you.
// dump($user);
// dump($thisProfile);

//Forms posted
if(!empty($_POST)) {
    $token = $_POST['csrf'];
    if(!Token::check($token)){
      die('Token doesn\'t match!');
    }else {
      if ($thisProfile->bio != $_POST['bio']){
        $newBio = $_POST['bio'];
        $fields=array('bio'=>$newBio);
        $validation->check($_POST,array(
          'bio' => array(
            'display' => 'Bio',
            'required' => true
          )
        ));
      if($validation->passed()){
        $db->update('profiles',$userID,$fields);
        Redirect::to('profile.php?id='.$userID);
      }
    }
  }
}
?>

	
<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
<script>
tinymce.init({
  selector: '#mytextarea'
});
</script>

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
		<div class="well">
					<div class="row">
						<div class="col-xs-12 col-md-2">
							<p><img src="<?=$grav; ?>" alt=""class="left-block img-thumbnail" alt="Generic placeholder thumbnail"></p>
						</div>
						<div class="col-xs-12 col-md-10">
						<h1><?=ucfirst($user->data()->username)?>'s Profile</h1>

        <h2>Bio</h2>
          <form name="update_bio" action="edit_profile.php" method="post">
    <div align="center"><textarea rows="20" cols="80"  id="mytextarea" name="bio" ><?=$thisProfile->bio;?></textarea></div>
          <input type="hidden" name="csrf" value="<?=Token::generate();?>" >
		</p>
		  <p>
			<button type="submit" class="btn btn-primary" name="update_bio">Update Bio</button>
			<a class="btn btn-info" href="profile.php?id=<?php echo $userID;?>">Cancel</a>

</p>

			 </form>

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
