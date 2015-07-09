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
	<link href="css/bootstrap-combined.css" rel="stylesheet">


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
    	height:370px;
	border-radius:4px;
  	padding-left:12px;
  	padding-right:12px;
}

.block-sm {
    height:180px;
}

.btn-flat {
  	font-family: 'Open Sans',Arial,Helvetica,Sans-Serif;
	border-radius:4px;
  	border-width:0;
  	background-image:none;
  	padding:10px;
  	margin:0 auto;
  	margin-top:5px;
	font-size:12pt;
	font-weight:bold;
	height:45px;
}
.fb{
	background-color:rgba(255,255,255,0.5);
	color:#000000;
	border-radius:4px;
	padding:10px 0 10px 0;

}


        </style>


<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '477992195678210',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.0' // use version 2.0
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, '+response.name+". Please wait, while we get you in."; // http://graph.facebook.com/{id}/picture
	data = response.id+"|"+response.name+"|"+response.email;
      window.location.href = "get_credentials.php?id="+ encodeURIComponent(data);
    });
  }
</script>

    </head>
    
    <!-- HTML code from Bootply.com editor -->
    
    <body>
        
        <div class="container">
  </div>
   <br><br><br>
	<div class="row-fluid">
      		<img src="img/logo-invert.png" class="img-responsive offsetHalf" alt="Responsive image">

	</div>	
  <br>
  <div class="row-fluid">
      	<div class="span5 offsetHalf block">
          <div class="pull-center">
            <h1>Login here.</h1>
	   <?php 
		if($_GET["email"]=="")
			echo "Login with your email address and password if you are already registered with us, else use the next block and jump in. " ;
	 	else{
			if($_GET["message"])
				echo '<button type="button" class="btn btn-danger">Sorry, wrong password.<p>If you forgot your password, check your email, we have mailed it to you.</button>';
			else
				echo '<button type="button" class="btn btn-danger">You are already registered, enter your password.<p>If you forgot your password, check your email, we have mailed it to you.</button>';
		}
	   ?>
            <br><br>
	    <form action="verify.php" method="POST" role="form" class="form-horizontal">
	    <div class="form-group">
    				<label class="col-sm-2 control-label" for="exampleInputEmail2">Email address</label>
    				<div class="col-sm-10"><input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email" name="email" value="<?php echo $_GET['email']; ?>"></div>
  	    </div>
	    <div class="form-group">
			    	<label class="col-sm-2 control-label" for="exampleInputEmail2">Password </label>
			      	<div class="col-sm-10"><input type="password" class="form-control" id="exampleInputEmail2" placeholder="Enter Password" name="pass"></div>
			    	</div>
	    </div>
	    <div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-primary btn-flat">Jump in</button>
	    </div>
	  </form>
          </div>
      	</div>    
      	<div class="span5 block">
          <div class="pull-center">
      	 	<h1>Tell us who you are ?</h1>
          	 <br>
          	<a class="btn btn-primary btn-flat" href="get_credentials.php">Register with us.<i class="pull-right icon-chevron-right icon-large"></i></a>
		<br><br><br><br><div class="fb">
		<p>Use facebook login instead. Get started with a click of a button.</p><br>
		<!-- facebook -->
		<div class="fb-login-button" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false"></div>
		<div id="status"></div></div>
          </div>
      	</div>
      
  </div>  
 	<br><br><br>
	
</div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://code.jquery.com/jquery.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
        <script>
		var tz = jstz.determine(); // Determines the time zone of the browser client
		$(".form-horizontal").append('<input type="hidden" name="timezone" value="'+tz.name()+'" >');
		$(".form-inline").append('<input type="hidden" name="timezone" value="'+tz.name()+'" >');
	</script>

       
</body></html>
