<?php
ob_start();
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
?>
<?php require_once $abs_us_root.$us_url_root.'helpers/helpers.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'includes/user_spice_ver.php'; ?>
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
$grav = get_gravatar(strtolower(trim($user->data()->email)));
$get_info_id = $user->data()->id;
// $groupname = ucfirst($loggedInUser->title);
$raw = date_parse($user->data()->join_date);
$signupdate = $raw['month']."/".$raw['day']."/".$raw['year'];
$userdetails = fetchUserDetails(NULL, NULL, $get_info_id); //Fetch user details
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
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
	
	
	<?php
	if(file_exists($abs_us_root.$us_url_root.'usersc/includes/head_tags.php')){
		require_once $abs_us_root.$us_url_root.'usersc/includes/head_tags.php';
	}
	?>
	
	<title><?=$settings->site_name;?></title>

	<!-- Bootstrap Core CSS -->
	<!-- AKA Primary CSS -->
	<link href="<?=$us_url_root?><?=str_replace('../','',$settings->us_css1);?>" rel="stylesheet">

	<!-- Template CSS -->
	<!-- AKA Secondary CSS -->
	<link href="<?=$us_url_root?><?=str_replace('../','',$settings->us_css2);?>" rel="stylesheet">

	<!-- Your Custom CSS Goes Here!-->
	<link href="<?=$us_url_root?><?=str_replace('../','',$settings->us_css3);?>" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="<?=$us_url_root?>fonts/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

 
<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          <div class="navbar nav_title" style="border: 0;">
            <a href="index.php" class="site_title">
			<img src="images/logo/Logo_alb.png" alt="Mountain View" style="width:50px;height:50px;">

			<span><?=ucfirst($user->data()->lname)?></span></a>
          </div>
          <div class="clearfix"></div>

          <!-- menu prile quick info -->
          <div class="profile">
            <div class="profile_pic">
              <img src="images/img.jpg" alt="" class="img-circle profile_img">
			  
            </div>
            <div class="profile_info">
              <span>Bun venit</span>
              <h2><?=ucfirst($user->data()->username)?></h2>
              <h2><?=$signupdate?></h2>
            </div>
          </div>
          <!-- /menu prile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              &nbsp;
              <ul class="nav side-menu">
                <li><a><i class="fa fa-home"></i> Admin <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="admin_pages.php">Lista pagini</a>
                    </li>
                    <li><a href="admin_permissions.php">Lista grupuri</a>
                    </li>
                    <li><a href="admin_users.php">Lista utilizatori</a>
                    </li>
					 <li><a href="email_settings.php">Emeil server</a>
                    </li>
					 <li><a href="admin.php">Setari pagina</a>
                    </li>
					
                  </ul>
                </li>
               
              </ul>
            </div>
          

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>
