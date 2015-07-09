<?php

//initializing database
require("chat/db.php");
session_start();
$user_id = $_SESSION['id'];
$old = sha1($_POST['old_pass']);
$new = sha1($_POST['new_pass']);
$cnf = sha1($_POST['cnf_pass']);
	$mysqli = $con; 		// check if change password request is from a new user 
	$getMem = $mysqli->prepare('SELECT mem_pass FROM members WHERE mem_id=?') or die('Couldn\'t check the email');
	$getMem->bind_param('s', $user_id);
	$getMem->execute();
	$getMem->store_result();
	$getMem->bind_result($old_pass); // build cookie
	while($getMem->fetch()) {
		if($old == $old_pass){
			if($new == $cnf){
			$insert_row = $mysqli->query('UPDATE members SET mem_pass="'.$new.'" WHERE mem_id="'.$user_id.'";');
			echo 1;
			}
			else
			echo 0;

		}
		else{
			echo 0;
		}

	}

?>
