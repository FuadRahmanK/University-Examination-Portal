<?php 
session_start();
require "connection.php";
$errors = array();

if (!isset($_SESSION['email'])) {
    header('Location: index.html');
    exit();
}

if (isset($_POST['change-password'])) {
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    if ($password !== $cpassword) {
        $errors['password'] = "Passwords do not match!";
    } else {
       
        $email = $_SESSION['email'];
        
        $update_pass = "UPDATE credentials SET password = '$password', code = NULL WHERE email = '$email'";
        $run_query = mysqli_query($con, $update_pass);

        if ($run_query) {
            $_SESSION['info'] = "Your password has been changed successfully!";
            header('location: index.html');
            exit();
        } else {
            $errors['db-error'] = "Failed to change your password!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: url('index_bg.jpg') no-repeat center center/cover;
            position: relative;
        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }
        .main-content {
            display: flex;
            flex: 1;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 3.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 80%;
            max-width: 400px;
            min-height: 400px;
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-container h2 {
            margin-bottom: 2rem;
            font-size: 2rem;
            color: #fff;
        }
        .login-container p {
            color: #fff;
            margin-bottom: 2rem;
        }
        .login-container input {
            width: calc(100% - 2rem);
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }
        .login-container .button {
            display: inline-block;
            background-color: #2e8b57;
            color: #fff;
            padding: 1rem 1.5rem;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2rem;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        .alert {
            color: #ff4444;
            margin-bottom: 1rem;
            background: rgba(255, 68, 68, 0.1);
            padding: 1rem;
            border-radius: 5px;
        }
        .success-message {
            color: #fff;
            margin-bottom: 1rem;
            background: rgba(0, 0, 0, 0.3);
            padding: 1rem;
            border-radius: 5px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="login-container">
            <h2>Create New Password</h2>
            <?php if(isset($_SESSION['info'])){ ?>
                <div class="success-message"><?php echo $_SESSION['info']; ?></div>
            <?php } ?>
            <?php if(count($errors) > 0){ ?>
                <div class="alert">
                    <?php foreach($errors as $showerror){ echo $showerror; } ?>
                </div>
            <?php } ?>
            <form action="new-password.php" method="POST" autocomplete="off">
                <input type="password" name="password" placeholder="Create new password" required>
                <input type="password" name="cpassword" placeholder="Confirm your password" required>
                <input type="submit" name="change-password" value="Change Password" class="button">
            </form>
        </div>
    </div>
</body>
</html>
