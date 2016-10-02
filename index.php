<?php
require_once 'init.php';
if(isset($user) && $user->isLoggedIn()){
  Redirect::to($us_url_root.'account.php');
}else{
  Redirect::to($us_url_root.'login.php');
}
die();
?>
