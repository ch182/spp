<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.tanggal.php";
?>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>:: SMK Nusa Putra - Sistem SPP Online ::</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <link href="assets/css/animate.min.css" rel="stylesheet" />
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
	

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="blue" data-image="assets/img/sidebar-4.jpg">

    <!--
        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag
    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="#"  class="sidebar-header">
                    <img src="images/header.png"></img>
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                        <?php include "menu.php"; ?>
                </li>

            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-center navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <img src="assets/img/logo2.png"/>
                </div>
                
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
					<?php include "open_file.php";?>
                </div>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>

                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="#">Nur Sahidin</a>, made with love for a better web
                </p>
            </div>
        </footer>

    </div>
</div>

</body>
<div class="modal fade bs-modal-sm log-sign" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        
      <div class="modal-body">
        <div id="myTabContent" class="tab-content">
       
        <div class="tab-pane fade active in" id="signin">
            <form class="form-horizontal" name="logForm" method="post" action="?open=Login-Validasi">
            <fieldset>
            <!-- Sign In Form -->
            <!-- Text input-->
              
        <div class="group">
			<input required="" class="input" type="name" name="txtUser"><span class="highlight"></span><span class="bar"></span>
				<label class="label" for="name">User ID</label></div>
              
            <!-- Password input-->
        <div class="group">
			<input required="" class="input" type="password" name="txtPassword"><span class="highlight"></span><span class="bar"></span>
				<label class="label" for="name">Password</label>
		</div>
		
		<div class="form-group">
				<select class="form-control" id="cmbLevel" name="cmbLevel">
					<option value="Kosong">....</option>
					<?php
						$pilihan	= array("Pengajaran", "Kasir", "Admin");
						foreach ($pilihan as $nilai) {
						if ($dataLevel==$nilai) {
						$cek=" selected";
						} else { $cek = ""; }
						echo "<option value='$nilai' $cek>$nilai</option>";} 
					?>
				</select>
		</div>

            <!-- Button -->
            <div class="control-group">
              <label class="control-label" for="signin"></label>
              <div class="controls">
                <button id="signin" name="btnLogin" class="btn btn-primary btn-block" value="Login">Log In</button>
              </div>
            </div>
            </fieldset>
            </form>
        </div>
                  
    </div>
      </div>
    </div>
  </div>
</div>


    <!--   Core JS Files   -->
    <script src="assets/js/jquery.3.2.1.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>


</html>
