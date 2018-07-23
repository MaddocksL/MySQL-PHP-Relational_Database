<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="includes/style.css">
</head>
<body>
	<header>
		<nav>
			<div class="main-wrapper">
				<div class="home">
					<a href="index.php"><img src="includes/home.png" alt="Home" height="50" width="50"/></a>
				</div>
				<div class="navbar">
					<form action="edit.php" method="POST">
						<input type="submit" name="action" value="Publisher">
						<input type="submit" name="action" value="Game">
						<input type="submit" name="action" value="Reviewer">
						<input type="submit" name="action" value="System">
						<input type="submit" name="action" value="Review">
						<input type="submit" name="action" value="Comment">
					</form>
				</div>
				</div>
			</div>
		</nav>
	</header>
	<div class="wrapper">
