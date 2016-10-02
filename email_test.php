<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/navigation.php'; ?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php if($user->data()->id != 1){
  Redirect::to('account.php');
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
		 <h1>
            Test your email settings.
          </h1><br>
          It's a good idea to test to make sure you can actually receive system emails before forcing your users to verify theirs. <br><br>
          <strong>DEVELOPER NOTE:</strong>
             If you are having difficulty with your email configuration, go to
             helpers/helpers.php (around line 114) and set $mail->SMTPDebug
             to a non-zero value. This is a development-platform-ONLY setting - be
             sure to set it back to zero (or leave it unset) on any live platform -
             otherwise you would open significant security holes.<br><br>
          <?php
                if (!empty($_POST)){
                  $to = $_POST['test_acct'];
                  $subject = 'Testing Your Email Settings!';
                  $body = 'This is the body of your test email';
                  $mail_result=email($to,$subject,$body);

                    if($mail_result){
                        echo '<div class="alert alert-success" role="alert">Mail sent successfully</div><br/>';
                    }else{
                        echo '<div class="alert alert-danger" role="alert">Mail ERROR</div><br/>';
                    }
                }
              ?>

          <form class="" name="test_email" action="email_test.php" method="post">
            <label>Send test to (Ideally different than your from address):
              <input required size='50' class='form-control' type='text' name='test_acct' value='' /></label>

              <label>&nbsp;</label><br />
              <input class='btn btn-primary' type='submit' value='Send A Test Email' class='submit' />
          </form>		
	
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
