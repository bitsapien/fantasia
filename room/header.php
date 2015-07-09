<?php
session_start();
if($_SESSION['id']=='')
header("Location:../index.php");

//initializing database
require("chat/db.php");

function get_time_ist($datetime, $format) {
date_default_timezone_set('UTC');
$ist = new DateTime($datetime);
$ist->setTimezone(new DateTimeZone('Asia/Kolkata')); // converting time-zone
$date_tmp = $ist->format($format);
return $date_tmp;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fantasia - FIFA 2014</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/fantasia.css" rel="stylesheet">

</head>

<body>
<!-- Password Modal -->
<div class="modal fade" id="passModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-toggle="validator">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Change Password</h4>
      </div>
      <div class="modal-body">
	    <form role="form" class="form-horizontal" id="pass_form" data-toggle="validator">
	    <div class="form-group">
		<label class="col-sm-2 control-label" for="exampleInputEmail2">Old Password </label>
		<div class="col-sm-10"><input type="password" class="form-control" id="exampleInputEmail2" placeholder="Enter Password" name="old_pass"></div>

	    </div>
	    <div class="form-group">
		<label class="col-sm-2 control-label" for="exampleInputEmail2">New Password </label>
		<div class="col-sm-10"><input type="password" name="new_pass" data-toggle="validator" data-minlength="6" class="form-control" id="inputPassword" placeholder="Password" required></div>
		<span class="help-block" style="margin-left:20px;">Minimum of 6 characters</span>

	    </div>
	    <div class="form-group">
		<label class="col-sm-2 control-label" for="exampleInputEmail2">Confirm new Password </label>
		<div class="col-sm-10"><input type="password" class="form-control" id="inputPasswordConfirm" data-match="#inputPassword" data-match-error="Whoops, these don't match" placeholder="Confirm" required name="cnf_pass"><div class="help-block with-errors"></div></div>
	    </div>

	  </form>
         
      </div>
      <div class="modal-footer">
	<button type="submit" class="btn btn-primary" id = "submitPass">Save changes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- SUCCESS Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Successful!</h4>
      </div>
      <div class="modal-body">
	The changes you made were successfully updated.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- FAIL Modal -->
<div class="modal fade" id="failModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Failed :( </h4>
      </div>
      <div class="modal-body">
	The changes you tried to make returned an error. Try again !
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Picture Modal -->
<div class="modal fade" id="picModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Change Picture</h4>
      </div>
      <div class="modal-body">
	    <form id="imageform" method="post" enctype="multipart/form-data" action="upload.php">
    <div id="uploadBox" class="well" onClick="var j = jQuery.noConflict();j('#photoimg').click();">
                    <H2>Click to Upload</H2>
    </div>
    <input type="file" class="hide" name="photoimg" id="photoimg" onchange="var j = jQuery.noConflict();j(this.form).submit();"/>
</form>
         
      </div>
      <div class="modal-footer">
	<button type="submit" class="btn btn-primary" id = "submitPic">Save changes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
        <!-- Begin Navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="../img/logo-pic.png" class="img-rounded" alt="fantasia" style="height:35px;margin-top:-11px;"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="navbar-collapse  collapse pull-right">
	    <div class="btn-group pull-right" style="margin-top:15px;z-index:99999999999999;">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </button>
                        <ul class="dropdown-menu slidedown">
                            <!--<li><a href="#foo" data-toggle="modal" data-target="#picModal"><span class="glyphicon glyphicon-user">
                            </span> Change Picture</a></li>-->
                            <li><a href="#foo" data-toggle="modal" data-target="#passModal"><span class="glyphicon glyphicon-refresh">
                            </span> Change Password</a></li>
                            
                            <li class="divider"></li>
                            <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span>
                                Leave</a></li>
                        </ul>
                    </div>
                <ul class="nav navbar-nav">
                    <li><a><?php echo $_SESSION['name']; ?></a>
                    </li>
                    <li><img src="<?php echo $_SESSION['pic']; ?>" class="img-circle" alt="" style="height:45px;">
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
