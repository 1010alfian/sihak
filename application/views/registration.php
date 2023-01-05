<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>

		<!-- Title -->
		<title><?=$title?></title>

		<!--- Favicon --->
		<link rel="icon" href="<?=base_url();?>assets/img/brand/favicon.png" type="image/x-icon"/>

		<!--- Icons css --->
		<link href="<?=base_url();?>assets/css/icons.css" rel="stylesheet">

		<!--- Right-sidemenu css --->
		<link href="<?=base_url();?>assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!--- Custom Scroll bar --->
		<link href="<?=base_url();?>assets/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>

		<!--- Style css --->
		<link href="<?=base_url();?>assets/rtl-css/style.css" rel="stylesheet">
		<link href="<?=base_url();?>assets/rtl-css/skin-modes.css" rel="stylesheet">

		<!--- Animations css --->
		<link href="<?=base_url();?>assets/css/animate.css" rel="stylesheet">

	</head>
	<body class="main-body bg-light">

		<!-- Loader -->
		<div id="global-loader">
			<img src="<?=base_url();?>assets/img/loaders/loader-4.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- main-signin-wrapper -->
		<div class="my-auto page page-h">
			<div class="main-signin-wrapper">
				<div class="main-card-signin d-md-flex wd-100p">
                <div class="wd-md-50p login d-none d-md-block page-signin-style p-5 text-white" >
					<div class="my-auto authentication-pages">
						<div>
							<img src="<?=base_url();?>assets/img/brand/logo-white.png" class=" m-0 mb-4" alt="logo">
							<h5 class="mb-4">Responsive Modern Dashboard &amp; Admin Template</h5>
						</div>
					</div>
				</div>
				<div class="p-5 wd-md-50p">
					<div class="main-signin-header">
						<h2>Registration</h2>
						<h4>Please sign in to continue</h4>
						<form action="<?=base_url()?>auth/registration" method="post">
                            <div class="form-group">
								<label>Name</label>
                                <input name="name" class="form-control invalid" placeholder="Enter your name" type="text" value="<?=set_value('name')?>">
                                <small class="text-danger"><?= form_error('name'); ?></small>
							</div>
							<div class="form-group">
								<label>Email</label>
                                <input name="email" class="form-control" placeholder="Enter your email" type="text" value="<?=set_value('email')?>">
                                <small class="text-danger"><?= form_error('email'); ?></small>
							</div>
							<div class="form-group">
								<label>Password</label>
                                <input name="password" class="form-control" placeholder="Enter your password" type="password">
                                <small class="text-danger"><?= form_error('password'); ?></small>
							</div>
                            <button class="btn btn-main-primary btn-block">Sign In</button>
						</form>
					</div>
					<div class="main-signin-footer mt-3 mg-t-5">
						<p class="text-center">Already have an account? <a href="<?=base_url()?>auth/signin">Sign In</a></p>
					</div>
				</div>
			</div>
			</div>
		</div>
		<!-- /main-signin-wrapper -->

		<!--- JQuery min js --->
		<script src="<?=base_url();?>assets/plugins/jquery/jquery.min.js"></script>

		<!--- Bootstrap Bundle js --->
		<script src="<?=base_url();?>assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="<?=base_url();?>assets/plugins/bootstrap/js/bootstrap-rtl.js"></script>

		<!--- Ionicons js --->
		<script src="<?=base_url();?>assets/plugins/ionicons/ionicons.js"></script>

		<!--- Moment js --->
		<script src="<?=base_url();?>assets/plugins/moment/moment.js"></script>

		<!--- Eva-icons js --->
		<script src="<?=base_url();?>assets/js/eva-icons.min.js"></script>

		<!--- Rating js --->
		<script src="<?=base_url();?>assets/plugins/rating/jquery.rating-stars.js"></script>
		<script src="<?=base_url();?>assets/plugins/rating/jquery.barrating.js"></script>

		<!--- Index js --->
		<script src="<?=base_url();?>assets/js/script.js"></script>

		<!--- Custom js --->
		<script src="<?=base_url();?>assets/js/custom.js"></script>

	</body>
</html>