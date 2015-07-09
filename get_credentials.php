<?php

if(isset($_GET['id']))
$user = "fb";
else
$user = "";
//initializing database
require("db.php");
?>

<!DOCTYPE html>
<html lang="en"><head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Fantasia – The Fantasy 2014 FIFA World Cup Game</title>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   
        
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootply.css" type="text/css" rel="stylesheet">



        <!-- CSS code from Bootply.com editor -->
        
        <style type="text/css">
            @import url('http://fonts.googleapis.com/css?family=Open+Sans:200,300');

body {
	background: url('img/bg-main.jpg') no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	color:#fff;
  	background-color:#333;
  	font-family: 'Open Sans',Arial,Helvetica,Sans-Serif;
}

a:link, a:visited {
	color:#eee;
}

.block {
	background-color:rgba(0,0,0,0.2);
	border-radius:4px;
    	height:370px;
	  padding: 12px;
}

.block-sm {
    height:180px;
}

.btn-flat {
  	font-family: 'Open Sans',Arial,Helvetica,Sans-Serif;
	border-radius:0px;
  	border-width:0;
  	background-image:none;
  	padding:10px;
  	margin:0 auto;
  	margin-top:15px;
  	width:auto;
    font-size:10pt;
}

        </style>

    </head>
    
    <!-- HTML code from Bootply.com editor -->
    
    <body>
        
        <div class="container">
  </div>
   <br><br><br>
	<div class="row-fluid">
      		<img src="img/logo-invert.png" class="img-responsive offsetHalf" alt="Responsive image">

	</div>	
  <br><br><br><br>
  <div class="row-fluid">
    
      	<div class="span5 block">
          <div class="pull-center">
	<?php if($user != "fb") { ?>
      	 	<h2>Tell us about yourself, so we know you better.</h2><br><br>
		<form action="store_credentials.php" method="POST" role="form" class="form-horizontal">
			<div class="form-group">
    				<label class="col-sm-2 control-label" for="exampleInputEmail2" >Your Name</label>
    				<div class="col-sm-10"><input type="text" class="form-control" placeholder="Your Name" name="name" ></div>

  			</div>
			<div class="form-group">
    				<label class="col-sm-2 control-label" for="exampleInputEmail2">Email address</label>
    				<div class="col-sm-10"><input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email" name="email"></div>
				<input type="hidden" name="id" value="<?php echo uniqid(); ?>">
				<input type="hidden" name="pic" value="<?php echo 'img/r'.rand(1,2).'.jpg'; ?>">
  			</div>
			<div class="form-group">
    				<label class="col-sm-2 control-label" for="exampleInputEmail2" >Favorite Team !</label>
    				<div class="col-sm-10"><select name="team" class="form-control" placeholder="Favorite Team" name="team">
				  <?php
						$mysqli = $con; 		// extract teams
						$getTeams = $mysqli->prepare('SELECT * FROM teams') or die('Couldn\'t connect to teams');
						$getTeams->execute();
						$getTeams->store_result();
						$getTeams->bind_result($id, $name, $group, $ts); // build cookie
						while($getTeams->fetch()) {
						  echo '<option>'.$name.'</option>';
						}
				  ?>
				</select></div>

  			</div>
			
			<div class="form-group">
			    	<label class="col-sm-2 control-label" for="exampleInputEmail2">Password </label>
			      	<div class="col-sm-10"><input type="password" class="form-control" id="exampleInputEmail2" placeholder="Enter Password" name="pass"></div>
			    </div>
			</div>


			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-default">Jump in</button>
			</div>
			</div>
          	 </form>
		<?php } else { ?>
      	 	<h2>Choose your favorite team</h2><br><br>
		<form action="store_credentials.php" method="POST" role="form" class="form-inline">
			<div class="form-group">
    				<label class="sr-only" for="exampleInputEmail2" >Favorite Team !</label>
    				<select name="team" class="form-control" placeholder="Favorite Team" name="team">
				  <?php
						$mysqli = $con; 		// extract teams
						$getTeams = $mysqli->prepare('SELECT team_id,team_name FROM teams') or die('Couldn\'t connect to teams');
						$getTeams->bind_param('s', $email);
						$getTeams->execute();
						$getTeams->store_result();
						$getTeams->bind_result($id, $name); // build cookie
						while($getTeams->fetch()) {
						  echo '<option>'.$name.'</option>';
						}
						$data = explode('|',$_GET['id']); // extract data
						$id = $data[0];
						$name = $data[1];
						$email = $data[2];

				  ?>
				</select>
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<input type="hidden" name="name" value="<?php echo $name; ?>">
			<input type="hidden" name="email" value="<?php echo $email; ?>">
			<input type="hidden" name="pic" value="<?php echo 'http://graph.facebook.com/'.$id.'/picture'; ?>">
  			</div>
			
			<div class="form-group">
			    	<div class="col-sm-offset-2 col-sm-10">
			      	<button type="submit" class="btn btn-default">Jump in</button>
			    	</div>
			</div>
          	 </form>
		<?php } ?>
          	<h1><i class="icon-fire icon-4x"></i></h1>
		
          	
          </div>
      	</div>
      
  </div>  
 	<br><br><br>
	
</div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://code.jquery.com/jquery.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jstz-1.0.4.min.js"></script>
        <script>
		var tz = jstz.determine(); // Determines the time zone of the browser client
		$(".form-horizontal").append('<input type="hidden" name="timezone" value="'+tz.name()+'" >');
		$(".form-inline").append('<input type="hidden" name="timezone" value="'+tz.name()+'" >');
	</script>
</body></html>
