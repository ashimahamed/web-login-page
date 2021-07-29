<?php

session_start();
 
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header('location: login.php');
    exit;
}
 
require_once 'configs/config.php';
 
$new_password = $confirm_password = '';
$new_password_err = $confirm_password_err = '';

 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
 
    if(empty(trim($_POST['new_password']))){
        $new_password_err = 'Please enter the new password.';     
    } elseif(strlen(trim($_POST['new_password'])) < 5){
        $new_password_err = 'Password must have atleast 5 characters.';
    } else{
        $new_password = trim($_POST['new_password']);
    }
    
    if(empty(trim($_POST['confirm_password']))){
        $confirm_password_err = 'Please confirm the password.';
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = 'Password did not match.';
        }
    }
        

    if(empty($new_password_err) && empty($confirm_password_err)){

        $sql = 'UPDATE users SET password = ? WHERE id = ?';
        
        if($stmt = $mysql_db->prepare($sql)){

            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            $stmt->bind_param("si", $param_password, $param_id);
            
            
            if($stmt->execute()){

                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
    <title>Reset Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/cosmo/bootstrap.min.css" rel="stylesheet" integrity="sha384-qdQEsAI45WFCO5QwXBelBe1rR9Nwiss4rGEqiszC+9olH1ScrLrMQr1KmDR964uZ" crossorigin="anonymous">
    <style type="text/css">
        .wrapper{ 
            width: 450px; 
            padding: 20px; 
        }
        body {background-image: url('https://is-a-good.dev/content/dont-delete.jpg'); background-repeat:no-repeat; background-attachment:fixed; background-position: center; background-size:cover; overflow:hidden;}
        .wrapper h2 {text-align: center}
        .wrapper form .form-group span {color: red;}
    </style>
</head>
<body>
    <main class="container wrapper">
        <section>
            <h2>Reset Your Password</h2>
            <p>Please fill out this form to reset your password.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                    <span class="help-block"><?php echo $new_password_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Your Password</label>
                    <input type="password" name="confirm_password" class="form-control">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-block btn-primary" value="Submit">
                    <a class="btn btn-block btn-link bg-light" href="main.php">Cancel</a>
                </div>
            </form>
        </section>
    </main>    
</body>

</html>