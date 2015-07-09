<?php
/* Stores user credentials in the database */
//start session
session_start();

//initializing database
require("db.php");


	$id = $_POST['id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$team = $_POST['team'];
	$pic = $_POST['pic'];
	$pass = $_POST['pass'];

	$mysqli = $con; 		// check if already present
	$getEmail = $mysqli->prepare('SELECT mem_id, mem_name, mem_team, mem_email, mem_pass, mem_pic, mem_ts FROM members WHERE mem_email=?') or die('Couldn\'t check the email');
	$getEmail->bind_param('s', $email);
	$getEmail->execute();
	$getEmail->store_result();
	$countRows = $getEmail->num_rows;

	if(!$countRows){
	 $insert_row = $mysqli->query('INSERT INTO members (mem_id, mem_name, mem_email, mem_team, mem_pic, mem_pass) VALUES("'.$id.'","'.$name.'","'.$email.'","'.$team.'","'.$pic.'","'.sha1($pass).'");');	
	
	 $_SESSION['id'] = $id;		// build cookie
	 $_SESSION['name'] = $name;
	 $_SESSION['team'] = $team;
	 $_SESSION['pic'] = $pic;
	 $_SESSION['timezone'] = $tz;
	}
	else {
	 $getEmail->bind_result($id, $name, $team, $email, $pass, $pic, $ts); // build cookie
	 while($getEmail->fetch()) {
	  if(!is_int($id)){
		header('Location:index.php?email='.$email);exit;}
	  else{
	  $_SESSION['id'] = $id;
	  $_SESSION['name'] = $name;
	  $_SESSION['team'] = $team;
	  $_SESSION['pic'] = $pic;
	  $_SESSION['timezone'] = $tz;}
	 }

	}


mysqli_close($con);
header("Location:room/index.php");	// log member in 
?>
