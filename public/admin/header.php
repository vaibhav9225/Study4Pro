<?php require_once '../../includes/adminInitialise.php'; ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en" xmlns="http://www.w3.org/1999/html"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Study4Pro</title>
	<meta name="insurance" content="">
	<meta name="Study4Pro" content="">
	<!--<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1">-->
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<!--[if IE 7]><link rel="stylesheet" href="css/font-awesome-ie7.min.css"><![endif]-->
	<link rel="shortcut icon" href="../../img/favicon.ico">
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/font-awesome.css">
	<link rel="stylesheet" href="../../css/layout.css">
</head>
<body>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="dashboard.php"><i class="icon-book"></i> Study4Pro <small>Admin</small></a>
			<ul class="nav" id="nav-pull-down">
				<li><a href="dashboard.php">Dashboard</a></li>
				<li class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Courses <i class="icon-caret-down"></i></a>
					<ul class="dropdown-menu">
						<li><a href="courses.php">Add Courses</a></li>
						<li><a href="syllabus.php">Add Syllabus</a></li>
						<li><a href="notes.php">Add Notes</a></li>
						<li><a href="questions.php">Add Questions</a></li>
						<li><a href="languages.php">Add Languages</a></li>
						<li><a href="showcase.php">Add Updates</a></li>
						<li><a href="toppers.php">Add Toppers</a></li>
						<li><a href="uploads.php">Uploaded Files</a></li>
					</ul>
				</li>
				<li><a href="admin.php">Admin</a></li>
			</ul>
			<ul class="nav pull-right" id="nav-pull-down">
				<?php
				if($session->checkValue('adminId') or $cookie->checkValue('adminId')){
					echo '<li><a href="logout.php"><i class="icon-user"></i> Logout</a></li>';
				}
				else{
					echo '<li><a href="login.php"><i class="icon-user"></i> Login</a></li>';
				}
				?>
			</ul>
		</div>
	</div>
</div>
<div id="wrapper">
<div class="cap"></div>