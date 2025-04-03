<?php
include 'class.php';
?>
<?php
if(!empty($_SESSION['adminlogin']))
{

}
else
{
	header("Location: login.php");
	exit();
}
?>

<?php
if(isset($_GET['logout']) && $_GET['logout'] == 1) {
    $logout = new Logout();
    $logout->logout();
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Modern an Admin Panel Category Flat Bootstarp Resposive Website Template | Home :: w3layouts</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Modern Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
	<script
		type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<link href="css/ckstyles.css" rel='stylesheet' type='text/css' />
	<!-- Graph CSS -->
	<link href="css/lines.css" rel='stylesheet' type='text/css' />
	<link href="css/font-awesome.css" rel="stylesheet">
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!----webfonts--->
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
	<!---//webfonts--->
	<!-- Nav CSS -->
	<link href="css/custom.css" rel="stylesheet">
	<!-- Metis Menu Plugin JavaScript -->
	<script src="js/metisMenu.min.js"></script>
	<script src="js/custom.js"></script>
	<!-- Graph JavaScript -->
	<script src="js/d3.v3.js"></script>
	<script src="js/rickshaw.js"></script>
	<!-- chart -->
	<script src="js/Chart.js"></script>
	<!-- //chart -->

	<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

</head>

<body>
	<div id="wrapper">
		<!-- Navigation -->
		<nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">Modern</a>
			</div>
			<!-- /.navbar-header -->
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
							class="fa fa-comments-o"></i><span class="badge">4</span></a>
					<ul class="dropdown-menu">
						<li class="dropdown-menu-header">
							<strong>Messages</strong>
							<div class="progress thin">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
									aria-valuemin="0" aria-valuemax="100" style="width: 40%">
									<span class="sr-only">40% Complete (success)</span>
								</div>
							</div>
						</li>
						<li class="avatar">
							<a href="#">
								<img src="images/1.png" alt="" />
								<div>New message</div>
								<small>1 minute ago</small>
								<span class="label label-info">NEW</span>
							</a>
						</li>
						<li class="avatar">
							<a href="#">
								<img src="images/2.png" alt="" />
								<div>New message</div>
								<small>1 minute ago</small>
								<span class="label label-info">NEW</span>
							</a>
						</li>
						<li class="avatar">
							<a href="#">
								<img src="images/3.png" alt="" />
								<div>New message</div>
								<small>1 minute ago</small>
							</a>
						</li>
						<li class="avatar">
							<a href="#">
								<img src="images/4.png" alt="" />
								<div>New message</div>
								<small>1 minute ago</small>
							</a>
						</li>
						<li class="avatar">
							<a href="#">
								<img src="images/5.png" alt="" />
								<div>New message</div>
								<small>1 minute ago</small>
							</a>
						</li>
						<li class="avatar">
							<a href="#">
								<img src="images/pic1.png" alt="" />
								<div>New message</div>
								<small>1 minute ago</small>
							</a>
						</li>
						<li class="dropdown-menu-footer text-center">
							<a href="#">View all messages</a>
						</li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle avatar" data-toggle="dropdown"><img src="images/1.png"><span
							class="badge">9</span></a>
					<ul class="dropdown-menu">
						<li class="dropdown-menu-header text-center">
							<strong>Account</strong>
						</li>
						<li class="m_2"><a href="addEditProduct.php"><i class="fa fa-bell-o"></i> Product Updates <span
									class="label label-info">42</span></a></li>
						<li class="m_2"><a href="CouponsManagement.php"><i class="fa fa-envelope-o"></i> Coupons Management <span
									class="label label-success">42</span></a></li>
						<li class="m_2"><a href="CustomerManagement.php"><i class="fa fa-tasks"></i> Customer Management <span
									class="label label-danger">42</span></a></li>
						<li class="dropdown-menu-header text-center">
							<strong>Jewllery</strong>
						</li>
						<li><a href="CategoryManagement.php"><i class="fa fa-comments"></i> Category Management <span
									class="label label-warning">42</span></a></li>
						<li><a href="productmanagement.php"><i class="fa fa-comments"></i> Product Management <span
									class="label label-warning">42</span></a></li>
						<li class="dropdown-menu-header text-center">
							<strong>Settings</strong>
						</li>
						<li class="m_2"><a href="#"><i class="fa fa-user"></i> Profile</a></li>
						<li class="m_2"><a href="SettingsPage.php"><i class="fa fa-wrench"></i> Settings</a></li>
						<li class="m_2"><a href="#"><i class="fa fa-usd"></i> Payments <span
									class="label label-default">42</span></a></li>
						<li class="m_2"><a href="ReportAndAnalysis.php"><i class="fa fa-file"></i> Report and Analytics <span
									class="label label-primary">42</span></a></li>
						<li class="divider"></li>
						<li class="m_2"><a href="#"><i class="fa fa-shield"></i> Lock Profile</a></li>
						<li class="m_2"><a href="?logout=1"><i class="fa fa-lock"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
			<form class="navbar-form navbar-right">
				<input type="text" class="form-control" value="Search..." onfocus="this.value = '';"
					onblur="if (this.value == '') {this.value = 'Search...';}">
			</form>
			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
						<li>
							<a href="index.php"><i class="fa fa-dashboard fa-fw nav_icon"></i>Dashboard</a>
						</li>
						<li>
							<a href="CouponsManagement.php"><i class="fa fa-ticket nav_icon"></i>Coupons Management</a>
						</li>
						<li>
							<a href="AboutUsManagement.php"><i class="fa fa-info-circle nav_icon"></i>About Us Management</a>
						</li>
						<li>
							<a href="CustomerManagement.php"><i class="fa fa-user nav_icon"></i>Customer Management</a>
                        </li>
						<li>
							<a href="CategoryManagement.php"><i class="fa fa-bars nav_icon"></i>Category Management</a>
						</li>
						<li>
							<a href="productmanagement.php"><i class="fa fa-dot-circle-o  nav_icon"></i>Product Management</a>
						</li>
						<li>
							<a href="SliderManagement.php"><i class="fa fa-ellipsis-h nav_icon"></i>Slider Management</a>
                        </li>
						<li>
							<a href="EnquiryManagement.php"><i class="fa fa-cogs nav_icon"></i>Enquires</a>
						</li>
						<li>
							<a href="customerreviews.php"><i class="fa fa-cogs nav_icon"></i>Reviews</a>
						</li>
						<li>
							<a href="orderManagement.php"><i class="fa fa-cogs nav_icon"></i>Orders</a>
						</li>
						<li>
							<a href="policies.php"><i class="fa fa-cogs nav_icon"></i>Policies</a>
						</li>
						<li>
							<a href="#"><i class="fa fa-laptop nav_icon"></i>Layouts<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="grids.php">Grid System</a>
								</li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-indent nav_icon"></i>Menu Levels<span
									class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="graphs.php">Graphs</a>
								</li>
								<li>
									<a href="typography.php">Typography</a>
								</li>
							</ul>
							<!-- /.nav-second-level -->
						</li>
						<li>
							<a href="#"><i class="fa fa-envelope nav_icon"></i>Mailbox<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="inbox.php">Inbox</a>
								</li>
								<li>
									<a href="compose.php">Compose email</a>
								</li>
							</ul>
							<!-- /.nav-second-level -->
						</li>
						<li>
							<a href="widgets.php"><i class="fa fa-flask nav_icon"></i>Widgets</a>
						</li>
						<li>
							<a href="#"><i class="fa fa-check-square-o nav_icon"></i>Forms<span
									class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="forms.php">Basic Forms</a>
								</li>
								<li>
									<a href="validation.php">Validation</a>
								</li>
							</ul>
							<!-- /.nav-second-level -->
						</li>
						<li>
							<a href="#"><i class="fa fa-table nav_icon"></i>Tables<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="basic_tables.php">Basic Tables</a>
								</li>
							</ul>
							<!-- /.nav-second-level -->
						</li>
						<li>
							<a href="#"><i class="fa fa-sitemap fa-fw nav_icon"></i>Css<span
									class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li>
									<a href="media.php">Media</a>
								</li>
								<li>
									<a href="login.php">Login</a>
								</li>
							</ul>
							<!-- /.nav-second-level -->
						</li>
					</ul>
				</div>
				<!-- /.sidebar-collapse -->
			</div>
			<!-- /.navbar-static-side -->
		</nav>
