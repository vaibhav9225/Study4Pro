<?php require_once '../includes/initialise.php'; ?>
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
	<link rel="shortcut icon" href="../img/favicon.ico">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/font-awesome.css">
	<link rel="stylesheet" href="../css/layout.css">
</head>
<body>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="brand" href="home.php"><i class="icon-book"></i> Study4Pro </a>
			<ul class="nav" id="nav-pull-down">
				<li><a href="home.php">Home</a></li>
				<li class="dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Courses <i class="icon-caret-down"></i></a>
					<ul class="dropdown-menu">
						<?php
						$courseNames = $courses->getNames();
						$courseIds = $courses->getIds();
						for($i=0; $i<count($courseNames); $i++){
							echo "<li><a href='courses.php?courseId=$courseIds[$i]'><i class='icon-book'></i> $courseNames[$i]</a></li>";
						}
						?>
					</ul>
				</li>
				<li><a href="contact.php">Contact Us</a></li>
				<li><a href="about.php">About Us</a></li>
			</ul>
			<ul class="nav pull-right" id="nav-pull-down">
				<li class="dropdown">
					<?php
					$languageNames = $languages->getNames();
					$languageIds = $languages->getIds();
					$session->checkValue('languageId') ? $languageId = $session->getValue('languageId') : $languageId = 1;
					?>
					<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
						Language: <?php echo $database->otherValue('languages','id',$languageId,'language') ?> <i class="icon-caret-down"></i>
					</a>
					<ul class="dropdown-menu">
						<?php
						for($i=0; $i<count($languageNames); $i++){
							if($languageIds[$i] == $languageId){
								echo "<li><a href='Javascript:void(0);'><i class='icon-check'></i> $languageNames[$i]</a></li>";
							}
							else{
								echo "<li><a href='languages.php?languageId=$languageIds[$i]'><i class='icon-check-empty'></i> $languageNames[$i]</a></li>";
							}
						}
						?>
					</ul>
				</li>
				<?php
				if($session->checkValue('loginId') or $cookie->checkValue('loginId')){
					echo '<li><a href="logout.php"><i class="icon-user"></i> Logout</a></li>';
				}
				else{
					echo '<li><a href="user.php"><i class="icon-user"></i> Login</a></li>';
				}
				?>
			</ul>
		</div>
	</div>
</div>
<div id="wrapper">
<div class="cap"></div>