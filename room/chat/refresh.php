<?php
session_start();
require('db.php');
$mysqli = $con;
$getChat = $mysqli->prepare('SELECT * FROM chat WHERE chat_id >= ( (SELECT MAX( chat_id ) FROM chat ) -60) ORDER BY chat_id ASC ') or die('Chat got screwed. We\'re sorry.'); //querying for chat messages
$getChat->execute();
$getChat->store_result();


$getChat->bind_result($id, $msg, $sender, $time);

$direction[0] = "left"; // for setting the chats left/right alternatively
$direction[1] = "right";
$i = 0;
while($getChat->fetch())
  {
	$getMember = $mysqli->prepare('SELECT mem_name, mem_team, mem_email, mem_pic FROM members WHERE mem_id=?') or die('Couldn\'t find the member'); // querying member details
	$getMember->bind_param('s', $sender);
	$getMember->execute();
	$getMember->store_result();
	$getMember->bind_result($mem_name, $mem_team, $mem_email, $mem_pic); 
	while($getMember->fetch()) {
		$name = $mem_name;
		$pic = $mem_pic;
	}
	date_default_timezone_set('Asia/Kolkata');
	$then = new DateTime($time); // calculating how long ago the message was posted.
	$now = new DateTime("now");
	$duration = $then ->diff($now);
	$days = $duration->format('%d');
	$hours = $duration->format('%h');
	$mins = $duration->format('%i');
	$seconds = $duration->format('%s');
	if( $days > 0 ){
		if($days == 1)
		$dur = $days." day ago";
		else
		$dur = $days." days ago";}
	else if( $hours > 0 ){
		if($hours == 1)
		$dur = $hours." hour ago";
		else
		$dur = $hours." hours ago";}
	else if( $mins > 0 ){
		if($mins == 1)
		$dur = $mins." minute ago";
		else
		$dur = $mins." minutes ago";}
	else
		$dur = "few seconds ago";


	$j = $i%2;
	$chat = '		                <li class="'.$direction[$j].' clearfix"><span class="chat-img pull-'.$direction[$j].'">
		                    <img src="'.$pic.'" alt="" class="img-circle">
		                </span>
		                    <div class="chat-body clearfix">
		                        <div class="header">
		                            <strong class="primary-font">'.$name.'</strong> <small class="pull-right text-muted">
		                                <span class="glyphicon glyphicon-time"></span>'.$dur.'</small>
		                        </div>
		                        <p>
		                            '.$msg.'
		                        </p>
		                    </div>
		                </li>';
	echo $chat;
	$i++;
  }

mysqli_close($con);
?>
