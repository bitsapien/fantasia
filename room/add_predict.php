<?php

//initializing database
require("chat/db.php");
session_start();
$user_id = $_SESSION['id'];
$a = $_POST['a'];
$b = $_POST['b'];
$mid = $_POST['mid'];
$mt = $_POST['mt'];
if(($user_id!="")&&($a!="")&&($b!="")&&($mid!="")){
	date_default_timezone_set('Asia/Kolkata'); // check if the predictions has been submitted duly in time
	$apudu = new DateTime($mt);
	$apudu->setTimezone(new DateTimeZone('Asia/Kolkata')); 
	$ipudu = new DateTime('now');
	$ipudu->setTimezone(new DateTimeZone('Asia/Kolkata')); 
	$antar = $ipudu->diff($apudu);
	if($antar->format('%R') == "-"){
		echo 0;exit;
	}
	$mysqli = $con;
	$check = $mysqli->prepare('SELECT * FROM predictions WHERE pred_matches_id=? AND pred_mem_id=?');
	$check->bind_param('ss', $mid, $user_id);
	$check->execute();
	$check->store_result();
	$countRows = $check->num_rows;
	if($countRows != 1){
	$predict = $mysqli->prepare('INSERT INTO predictions (pred_matches_id, pred_mem_id, pred_a, pred_b) VALUES(?, ?, ?, ?);') or die($mysqli->error); 		// insert prediction 
	$predict->bind_param('ssss', $mid, $user_id, $a, $b);
	$predict->execute();
	echo 1;
	}
	else
		echo 0;
}
else{
	echo 0;
}
?>
