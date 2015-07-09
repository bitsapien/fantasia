<?php
/*	Login Verification
*	by C Rahul,
*	website: http://crahul.eu.cr
*	email:   c.rahulx@gmail.com
*	twitter: CRahul92
*	facebook: http://www.facebook.com/rahul.wozniak
*
*	note : If you need a site built ,you can contact me ,or if 
*	you are a developer and you want to suggest changes ,feel 
*	free to contact me. :)
*/
ob_start();
require("db.php");
header('WWW-Authenticate: Basic realm="Restricted Site Access"');
header('HTTP/1.0 401 Unauthorized');

// Define $myusername and $mypassword
$email = $_POST['email'];
$pass = sha1($_POST['pass']);


$mysqli = $con;
$getEmail = $mysqli->prepare('SELECT mem_id, mem_name, mem_team, mem_email, mem_pass, mem_pic, mem_ts FROM members WHERE mem_email=? AND mem_pass=?') or die('Couldn\'t check the email');
$getEmail->bind_param('ss', $email, $pass);
$getEmail->execute();
$getEmail->store_result();
$countRows = $getEmail->num_rows;

if($countRows == 1){
	session_start();
	$getEmail->bind_result($id, $name, $team, $email, $pass, $pic, $ts); // build cookie
	 while($getEmail->fetch()) {
	  $_SESSION['id'] = $id;
	  $_SESSION['name'] = $name;
	  $_SESSION['team'] = $team;
	  $_SESSION['pic'] = $pic;
	  $_SESSION['timezone'] = $tz;
	  header("location:room/index.php");exit;
	 }
}
else {
	session_start();
	session_destroy();
	header("location:index.php?message=1&email=".$email);exit;


}

ob_end_flush();
?>
