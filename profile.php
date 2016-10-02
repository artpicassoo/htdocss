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
		$editbio = ' <small><a class="btn btn-success" href="edit_profile.php"><i class="fa fa-edit m-right-xs"></i> Edit profile</a></small>';
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

 
 
 <div class="main_container">

  <div class="right_col" role="main">

        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3><?php echo $ususername;?></h3>
            </div>

            <div class="title_right">
              
            </div>
          </div>
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                
                <div class="x_content">

                  <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                    <div class="profile_img">

                      <!-- end of image cropping -->
                      <div id="crop-avatar">
                        <!-- Current avatar -->
                        <div class="avatar-view" title="Change the avatar">
						  <?php echo $useravatar;?>
                        </div>

                        <!-- Cropping modal -->
                        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <form class="avatar-form" action="crop.php" enctype="multipart/form-data" method="post">
                                <div class="modal-header">
                                  <button class="close" data-dismiss="modal" type="button">&times;</button>
                                  <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="avatar-body">

                                    <!-- Upload image and data -->
                                    <div class="avatar-upload">
                                      <input class="avatar-src" name="avatar_src" type="hidden">
                                      <input class="avatar-data" name="avatar_data" type="hidden">
                                      <label for="avatarInput">Local upload</label>
                                      <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                                    </div>

                                    <!-- Crop and preview -->
                                    <div class="row">
                                      <div class="col-md-9">
                                        <div class="avatar-wrapper"></div>
                                      </div>
                                      <div class="col-md-3">
                                        <div class="avatar-preview preview-lg"></div>
                                        <div class="avatar-preview preview-md"></div>
                                        <div class="avatar-preview preview-sm"></div>
                                      </div>
                                    </div>

                                    <div class="row avatar-btns">
                                      <div class="col-md-9">
                                        <div class="btn-group">
                                          <button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">Rotate Left</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-15" type="button">-15deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-30" type="button">-30deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="-45" type="button">-45deg</button>
                                        </div>
                                        <div class="btn-group">
                                          <button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">Rotate Right</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="15" type="button">15deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="30" type="button">30deg</button>
                                          <button class="btn btn-primary" data-method="rotate" data-option="45" type="button">45deg</button>
                                        </div>
                                      </div>
                                      <div class="col-md-3">
                                        <button class="btn btn-primary btn-block avatar-save" type="submit">Done</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- <div class="modal-footer">
                                                  <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                                                </div> -->
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- /.modal -->

                        <!-- Loading state -->
                        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                      </div>
                      <!-- end of image cropping -->

                    </div>
                    <h3><?=$userdetails->fname?> <?=$userdetails->lname?></h3>

                    <ul class="list-unstyled user_data">
                      <li><i class="fa fa-smile-o user-profile-icon"></i> Member Since:<?=$userdetails->join_date?></li> 
					  <li><i class="fa fa-meh-o user-profile-icon"></i> Last seen: <?=$userdetails->last_login?></li> 
                      <li><i class="fa fa-wrench user-profile-icon"></i> User ID: <?=$userdetails->id?></li> 
                      <li><i class="fa fa-envelope-square user-profile-icon"></i> Email: <?=$userdetails->email?></li> 
                      <li><i class="fa fa-phone-square user-profile-icon"></i> Telephone: <?=$userdetails->billing_phone?></li> 
                      <li><i class="fa fa-university user-profile-icon"></i> Company: <?=$userdetails->company?></li> 
                      <li><i class="fa fa-star user-profile-icon"></i> Group: Null</li> 
					  <li><i class="fa fa-map-marker user-profile-icon"></i> <?=$userdetails->stripe_cust_id?>, <?=$userdetails->billing_state?>, <?=$userdetails->billing_city?>, <?=$userdetails->billing_srt1?>, <?=$userdetails->billing_srt2?>
                      </li>

                      <li>
                        <i class="fa fa-envelope-square user-profile-icon"></i> <?=$userdetails->billing_zip_code?>
                      </li>
                    </ul>

                    <?php echo $editbio;?>
                    <br />

                    <!-- start skills -->
                    <h4>Skills</h4>
                    <ul class="list-unstyled user_data">
                      <li>
                        <p>Number of Logins <?=$user->data()->logins?></p>
                        <div class="progress progress_sm">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?=$user->data()->logins?>"></div>
                        </div>
                      </li>
                    </ul>
                    <!-- end of skills -->

                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">

                   
                    

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Mesaje</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Projects Worked on</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Other</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                          <!-- start recent activity -->
                          <ul class="messages">
                            <li>
                              <img src="images/img.jpg" class="avatar" alt="Avatar">
                              <div class="message_date">
                                <h3 class="date text-info">24</h3>
                                <p class="month">May</p>
                              </div>
                              <div class="message_wrapper">
                                <h4 class="heading">Desmond Davison</h4>
                                <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                <br />
                                <p class="url">
                                  <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                  <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                </p>
                              </div>
                            </li>
                            <li>
                              <img src="images/img.jpg" class="avatar" alt="Avatar">
                              <div class="message_date">
                                <h3 class="date text-error">21</h3>
                                <p class="month">May</p>
                              </div>
                              <div class="message_wrapper">
                                <h4 class="heading">Brian Michaels</h4>
                                <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                <br />
                                <p class="url">
                                  <span class="fs1" aria-hidden="true" data-icon=""></span>
                                  <a href="#" data-original-title="">Download</a>
                                </p>
                              </div>
                            </li>
                            <li>
                              <img src="images/img.jpg" class="avatar" alt="Avatar">
                              <div class="message_date">
                                <h3 class="date text-info">24</h3>
                                <p class="month">May</p>
                              </div>
                              <div class="message_wrapper">
                                <h4 class="heading">Desmond Davison</h4>
                                <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                <br />
                                <p class="url">
                                  <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                  <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                </p>
                              </div>
                            </li>
                            <li>
                              <img src="images/img.jpg" class="avatar" alt="Avatar">
                              <div class="message_date">
                                <h3 class="date text-error">21</h3>
                                <p class="month">May</p>
                              </div>
                              <div class="message_wrapper">
                                <h4 class="heading">Brian Michaels</h4>
                                <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                <br />
                                <p class="url">
                                  <span class="fs1" aria-hidden="true" data-icon=""></span>
                                  <a href="#" data-original-title="">Download</a>
                                </p>
                              </div>
                            </li>

                          </ul>
                          <!-- end recent activity -->

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                          <!-- start user projects -->
                          <table class="data table table-striped no-margin">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Project Name</th>
                                <th>Client Company</th>
                                <th class="hidden-phone">Hours Spent</th>
                                <th>Contribution</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>New Company Takeover Review</td>
                                <td>Deveint Inc</td>
                                <td class="hidden-phone">18</td>
                                <td class="vertical-align-mid">
                                  <div class="progress">
                                    <div class="progress-bar progress-bar-success" data-transitiongoal="35"></div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>New Partner Contracts Consultanci</td>
                                <td>Deveint Inc</td>
                                <td class="hidden-phone">13</td>
                                <td class="vertical-align-mid">
                                  <div class="progress">
                                    <div class="progress-bar progress-bar-danger" data-transitiongoal="15"></div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>Partners and Inverstors report</td>
                                <td>Deveint Inc</td>
                                <td class="hidden-phone">30</td>
                                <td class="vertical-align-mid">
                                  <div class="progress">
                                    <div class="progress-bar progress-bar-success" data-transitiongoal="45"></div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>4</td>
                                <td>New Company Takeover Review</td>
                                <td>Deveint Inc</td>
                                <td class="hidden-phone">28</td>
                                <td class="vertical-align-mid">
                                  <div class="progress">
                                    <div class="progress-bar progress-bar-success" data-transitiongoal="75"></div>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <!-- end user projects -->

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                          <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui
                            photo booth letterpress, commodo enim craft beer mlkshk </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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

  <!-- image cropping -->
  <script src="js/cropping/cropper.min.js"></script>
  <script src="js/cropping/main.js"></script>

  <!-- daterangepicker -->
  <script type="text/javascript" src="js/moment/moment.min.js"></script>
  <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>

  <!-- chart js -->
  <script src="js/chartjs/chart.min.js"></script>

  <!-- moris js -->
  <script src="js/moris/raphael-min.js"></script>
  <script src="js/moris/morris.min.js"></script>

  <!-- pace -->
  <script src="js/pace/pace.min.js"></script>

  <script>
    $(function() {
      var day_data = [{
        "period": "Jan",
        "Hours worked": 80
      }, {
        "period": "Feb",
        "Hours worked": 125
      }, {
        "period": "Mar",
        "Hours worked": 176
      }, {
        "period": "Apr",
        "Hours worked": 224
      }, {
        "period": "May",
        "Hours worked": 265
      }, {
        "period": "Jun",
        "Hours worked": 314
      }, {
        "period": "Jul",
        "Hours worked": 347
      }, {
        "period": "Aug",
        "Hours worked": 287
      }, {
        "period": "Sep",
        "Hours worked": 240
      }, {
        "period": "Oct",
        "Hours worked": 211
      }];
      Morris.Bar({
        element: 'graph_bar',
        data: day_data,
        xkey: 'period',
        hideHover: 'auto',
        barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
        ykeys: ['Hours worked', 'sorned'],
        labels: ['Hours worked', 'SORN'],
        xLabelAngle: 60
      });
    });
  </script>
  <!-- datepicker -->
  <script type="text/javascript">
    $(document).ready(function() {

      var cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
      }

      var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: {
          days: 60
        },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
          applyLabel: 'Submit',
          cancelLabel: 'Clear',
          fromLabel: 'From',
          toLabel: 'To',
          customRangeLabel: 'Custom',
          daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
          monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          firstDay: 1
        }
      };
      $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
      $('#reportrange').daterangepicker(optionSet1, cb);
      $('#reportrange').on('show.daterangepicker', function() {
        console.log("show event fired");
      });
      $('#reportrange').on('hide.daterangepicker', function() {
        console.log("hide event fired");
      });
      $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
      });
      $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        console.log("cancel event fired");
      });
      $('#options1').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
      });
      $('#options2').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
      });
      $('#destroy').click(function() {
        $('#reportrange').data('daterangepicker').remove();
      });
    });
  </script>