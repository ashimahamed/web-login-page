<?php

	require_once 'configs/config.php';


	$username = $password = $confirm_password = "";

	$username_err = $password_err = $confirm_password_err = "";

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (empty(trim($_POST['username']))) {
			$username_err = "Please enter a username.";

		} else {

			$sql = 'SELECT id FROM users WHERE username = ?';

			if ($stmt = $mysql_db->prepare($sql)) {

				
				$param_username = trim($_POST['username']);

				$stmt->bind_param('s', $param_username);


				if ($stmt->execute()) {

					
					$stmt->store_result();

					if ($stmt->num_rows == 1) {
						$username_err = 'This username is already taken.';
					} else {
						$username = trim($_POST['username']);
					}
				} else {
					echo "Oops! ${$username}, something went wrong. Please try again later.";
				}

				
				$stmt->close();
			} else {

				
				$mysql_db->close(); // Close statement
			}
		}

		
	    if(empty(trim($_POST["password"]))){
	        $password_err = "Please enter a password.";     
	    } elseif(strlen(trim($_POST["password"])) < 6){
	        $password_err = "Password must have atleast 6 characters.";
	    } else{
	        $password = trim($_POST["password"]);
	    }
    
	    
	    if(empty(trim($_POST["confirm_password"]))){
	        $confirm_password_err = "Please confirm password.";     
	    } else{
	        $confirm_password = trim($_POST["confirm_password"]);
	        if(empty($password_err) && ($password != $confirm_password)){
	            $confirm_password_err = "Password did not match.";
	        }
	    }

	    

	    if (empty($username_err) && empty($password_err) && empty($confirm_err)) {

	    	// Prepare insert statement
			$sql = 'INSERT INTO users (username, password) VALUES (?,?)';

			if ($stmt = $mysql_db->prepare($sql)) {

			
				$param_username = $username;
				$param_password = password_hash($password, PASSWORD_DEFAULT); 

				
				$stmt->bind_param('ss', $param_username, $param_password);

				
				if ($stmt->execute()) {
					
					header('location: ./login.php');
					
				} else {
					echo "Something went wrong. Try signing in again.";
				}

				$stmt->close();	
			}

			
			$mysql_db->close();
	    }
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sign in</title>
	<link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/cosmo/bootstrap.min.css" rel="stylesheet" integrity="sha384-qdQEsAI45WFCO5QwXBelBe1rR9Nwiss4rGEqiszC+9olH1ScrLrMQr1KmDR964uZ" crossorigin="anonymous">
	<style>
        .wrapper{ 
        	width: 500px; 
        	padding: 20px; 
        }
		body {background-image: url('https://is-a-good.dev/content/dont-delete.jpg'); background-repeat:no-repeat; background-attachment:fixed; background-position: center; background-size:cover; overflow:hidden;}
		.out-blue{border:1px solid #5A91CC !important; color:#5A91CC !important;} .out-blue:hover{background-color:#5A91CC !important; color:#ffffff !important;}
		.out-red{border:1px solid #E64C4C !important; color:#E64C4C !important;} .out-red:hover{background-color:#E64C4C !important; color:#ffffff !important;}
		.rounded{border-radius:4px;}
        .wrapper h2 {text-align: center}
        .wrapper form .form-group span {color: red;}
	</style>
</head>
<body>
	<main>
		<section class="container wrapper">
			<h2 class="display-4 pt-3">Sign Up</h2>
        	<p class="text-center">Please fill in your credentials.</p>
        	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        		<div class="form-group <?php (!empty($username_err))?'has_error':'';?>">
        			<label for="username">Username</label>
        			<input type="text" name="username" id="username" class="form-control" value="<?php echo $username ?>">
        			<span class="help-block"><?php echo $username_err;?></span>
        		</div>

        		<div class="form-group <?php (!empty($password_err))?'has_error':'';?>">
        			<label for="password">Password</label>
        			<input type="password" name="password" id="password" class="form-control" value="<?php echo $password ?>">
        			<span class="help-block"><?php echo $password_err; ?></span>
        		</div>

        		<div class="form-group <?php (!empty($confirm_password_err))?'has_error':'';?>">
        			<label for="confirm_password">Confirm Password</label>
        			<input type="password" name="confirm_password" id="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
        			<span class="help-block"><?php echo $confirm_password_err;?></span>
        		</div>

        		<div class="form-group">
        			<input type="submit" class="btn btn-block btn-outline-success rounded out-blue" value="Submit">
        			<input type="reset" class="btn btn-block btn-outline-primary rounded out-red" value="Reset">
        		</div>
        		<p>If you already have an account? Login <a href="login.php">here</a>.</p>
        	</form>
		</section>
	</main>
</body>
</html>