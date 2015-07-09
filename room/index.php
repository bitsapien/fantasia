<?php
require('header.php');
$groups = array("A","B","C","D","E","F","G","H");
// for matches($content) and polls($polls) and slide($slide)
					$polls= "";$slide = "";
					$mysqli = $con; 		// extract days
					$getDate = $mysqli->prepare("SELECT matches_datetime FROM matches") or die('Couldn\'t connect to matches');
					$getDate->execute();
					$getDate->store_result();
					$num_of_days = 0;
					$getDate->bind_result($datetime); 
					$date[0] = "";$content[0] = "";
					while($getDate->fetch()) {
						$date_tmp = get_time_ist($datetime, 'Y-m-d');	// converting time-zone
						if(!array_search($date_tmp,$date)){
							$date[$num_of_days] = $date_tmp;			// counting dates of league
							$num_of_days++;
						}
					}
					sort($date);
					$j = 0;
					$pos = array_search(get_time_ist("now", 'Y-m-d'), $date);
					while($j < $num_of_days){
						if($j == $pos){
							$slide .= '<li data-target="#carousel-example-generic" data-slide-to="'.$j.'" class="active"></li>';
							$content[$j] = '<div class="item active">';
						}
						else{
							$slide .= '<li data-target="#carousel-example-generic" data-slide-to="'.$j.'"></li>';
							$content[$j] = '<div class="item">';
						}
						$j++;
					}
					for($m = 0;$m < $num_of_days;$m++)
						$content[$m] .= '<div class="panel-heading gameHeading"><h3>'.'Day '.($m + 1)."</h3></div>";
					
					$mysqli = $con; 		// extract days
					$getSchedule = $mysqli->prepare("SELECT ta.team_name, tb.team_name, m.matches_score_a, 										m.matches_score_b, m.matches_datetime, r.round_name,m.matches_id
									FROM matches m
									INNER JOIN teams ta ON m.matches_team_a = ta.team_id
									INNER JOIN teams tb ON m.matches_team_b = tb.team_id
									INNER JOIN round r ON m.matches_round_id = r.round_id") or die('Couldn\'t connect to matches');
					$getSchedule->execute();
					$getSchedule->store_result();
					$getSchedule->bind_result($ta, $tb, $sa, $sb, $mdt, $round,$id); 
					while($getSchedule->fetch()) {
						$date_tmp = get_time_ist($mdt, 'Y-m-d');	// converting time-zone
						for($k = 0;$k < $num_of_days;$k++){
/* prediction script */
							if($date_tmp == $date[$k]){
								$time = get_time_ist($mdt,'M j G:i T ');
								date_default_timezone_set('Asia/Kolkata');
								$time1 = new DateTime($mdt);
								$time1->setTimezone(new DateTimeZone('Asia/Kolkata')); 
								$time2 = new DateTime('now');
								$time2->setTimezone(new DateTimeZone('Asia/Kolkata')); 

								$interval = $time2->diff($time1);
								$hours = $interval->format('%R%h');
								$days = $interval->format('%d');
								if(($hours>=0)&&($hours<=24)&&($days == 0)){

/* checking for predictions made before */
	$cd = get_time_ist($mdt,'Y/m/d h:i:s');
	$check = $mysqli->prepare('SELECT pred_a, pred_b FROM predictions WHERE pred_matches_id=? AND pred_mem_id=?');
	$check->bind_param('ss', $id, $_SESSION['id']);
	$check->execute();
	$check->store_result();
	$countRows = $check->num_rows;
	$check->bind_result($a, $b);
	if($countRows == 1){
		
		while($check->fetch()) {
			$polls .= '<div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <div class="panel-heading">'.$ta.' vs '.$tb.'</div>
                            <div class="caption"><p><div data-countdown="'.$cd.'" class="well"></div></p>
                                <form class="form-inline poll" role="form" id="poll">'.$time.'<p>
				  <div class="form-group ">
				    <label class="sr-only">'.$ta.'</label>
				    <input type="text"  class="form-control" id="teama" autocomplete="off" placeholder="goals" size="1" name="a" value ="'.$a.'" disabled>
				  </div> - 
				  <div class="form-group">
				    <label class="sr-only">'.$tb.'</label>
				    <input type="text" class="form-control" id="teamb" autocomplete="off" placeholder="goals" size="1" name="b" value ="'.$a.'" disabled>
				    <input type="hidden" class="form-control" id="" placeholder="goals" size="1" name="mid" value="'.$id.'">
				    <input type="hidden" class="form-control" id="" placeholder="goals" size="1" name="mt" value="'.$mdt.'">
				  </div>
				  <br>
				</form>

                            </div>
                            
                        </div>
                    </div>';
		}


	}


		else{	
			$polls .= '<div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <div class="panel-heading">'.$ta.' vs '.$tb.'</div>
                            <div class="caption"><p><div data-countdown="'.$cd.'" class="well">
                                        </div></p>
                                <form class="form-inline poll" role="form" id="poll" data-toggle="validator">'.$time.'<p>
				  <div class="form-group ">
				    <label class="sr-only">'.$ta.'</label>
				    <input type="text" pattern="^\d$" class="form-control ta" id="teama" autocomplete="off" placeholder="goals" size="1" name="a">
				  </div> - 
				  <div class="form-group">
				    <label class="sr-only">'.$tb.'</label>
				    <input type="text" pattern="^\d$" class="form-control tb" id="teamb" autocomplete="off" placeholder="goals" size="1" name="b">
				    <input type="hidden" class="form-control" id="teamb" placeholder="goals" size="1" name="mid" value="'.$id.'">
				    <input type="hidden" class="form-control" id="" placeholder="goals" size="1" name="mt" value="'.$mdt.'">
				  </div>
				  <br><input type="submit" class="btn btn-default pull-right" id="btn" value="Predict">
				</form>

                            </div>
                            
                        </div>
                    </div>';
		}
}




								$content[$k] .= '<section class="Game">
                                        						<p class="gameTime">'.$time.'</p>
                                        						<h4><span class="team team-'.strtolower (substr($ta,0,3)).'">'.$ta.'</span> <em>vs</em> <span class="team team-'.strtolower (substr($tb,0,3)).'">'.$tb.'</span></h4>';
								if($sa != "")
                                        			$content[$k] .= '<h5>'.$sa.' : '.$sb.'</h5>';
								else
								$content[$k] .= '<h5>- : -</h5>';
								if($round === "Group Rounds"){
								$getGroup = $mysqli->query('SELECT  teams.team_group_id FROM teams WHERE team_name ="'.$ta.'";'); // only for group games
								while($row = $getGroup->fetch_object())
								$content[$k] .= '<p>Group '.$groups[$row->team_group_id-1].' Match</p>
                                   							 </section>'; // preparing schedule
								}
								else{
									$content[$k] .= '<p>'.$rounds.'</p>
                                   							 </section>';
								}
							}
						}
					} 
?>

    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <p class="lead"><h1 style="font-family:'Robofan Free';font-weight:normal;font-size:42px">Fantasia</h1></p>
                <div class="list-group">
                    <a href="#" class="list-group-item">Poll</a>
                    <a href="#" class="list-group-item">News Stream</a>
                </div>
		<!-- chat -->
		    <div class="panel panel-primary">
		        <div class="panel-heading">
		            <span class="glyphicon glyphicon-comment"></span> Chat
		        </div>
		        <div class="panel-body">
				<!-- chat-messages -->
		            <ul class="chat">
		                <div class="refresh"></div>
		            </ul>
		        </div>
		        <div class="panel-footer">
		            <div class="input-group">
		                <input id="btn-input" class="form-control input-sm" placeholder="Type your message here..." type="text">
		                <span class="input-group-btn">
		                    <button class="btn btn-warning btn-sm" id="btn-chat">
		                        Send</button>
		                </span>
		            </div>
		        </div>
		    </div>
		<!-- chat close -->		
            </div>
	<!-- page-content -->
            <div class="col-md-9"> 

                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <div class="panel-heading gameHeading"><h4>Rankings</h4></div>
				
                            <div class="ratings">
                                
                            </div>
                        </div>
                    </div>
<!-- poll consoles -->
<?php
// check for next matches in 24 hours 

echo $polls;
 
?>
                    
		<div class="col-md-12">
<div class="row carousel-holder">

                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
				<?php
					echo $slide;
				?>

                            </ol>
                            <div class="carousel-inner">
				<?php
					for($k = 0;$k < $num_of_days;$k++)
						echo $content[$k].'</div>';
					
				?>
                                
                              
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>
		</div>
                </div>



            </div>

        </div>

    </div>
    <!-- /.container -->

<?php require('footer.php'); ?>
