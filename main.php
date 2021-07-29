<?php

	session_start();

	if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== false) {
		header('location: login.php');
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome</title>
	<link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/cosmo/bootstrap.min.css" rel="stylesheet" integrity="sha384-qdQEsAI45WFCO5QwXBelBe1rR9Nwiss4rGEqiszC+9olH1ScrLrMQr1KmDR964uZ" crossorigin="anonymous">
	<style>
				body {background-image: url('https://is-a-good.dev/content/dont-delete.jpg'); background-repeat:no-repeat; background-attachment:fixed; background-position: center; background-size:cover; overflow:hidden;}
        .wrapper{ 
        	width: 500px; 
        	padding: 20px; 
        }
		.rounded{border-radius:4px;}
        .wrapper h2 {text-align: center}
        .wrapper form .form-group span {color: red;}
	</style>


</head>
<body>
	<main>
		<section class="container wrapper">
			<div class="page-header">
			</div>

			<a href="password_reset.php" class="btn btn-block btn-outline-warning rounded">Reset Password</a>
			<a href="logout.php" class="btn btn-block btn-outline-danger rounded">Sign Out</a>
		</section>
	</main>
</body>
</html>