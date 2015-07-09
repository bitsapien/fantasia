<?php
session_start();
if(isset($_POST['text']))
{
	require('db.php');
	$mysqli = $con; 	// preparing variables : message and sender_id
	$sender=$_SESSION["id"];
	
	$message=trim(htmlspecialchars ($_POST['text'],ENT_QUOTES));
	if($message!="")
	$insert_row = $mysqli->query('INSERT INTO chat (chat_msg, chat_mem_id) VALUES("'.$message.'","'.$sender.'");');	
}

?>
