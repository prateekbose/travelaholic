<?php 
    $servername = "SERVER_NAME_HERE";
    $username = "USER_NAME_HERE";
    $password = "PASSWORD_HERE";
    $dbname = "DATABASE_NAME_HERE";
    
  // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_POST["submit"])){        
        if($_POST["pass"] == $_POST["con_pass"]){
            $user = base64_encode($_POST["user"]);
            $pass = hash("sha256",$_POST["pass"]);
            $firstName = $_POST["firstName"];
            
            $sql = "INSERT INTO `users` (`user`, `pass`, `firstName`) VALUES ('$user', '$pass', '$firstName');";
    
            if ($conn->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    
        }else {
            $noMatch = 1;
            header("Refresh:5; url=signup.php");
        }

    }
    
    
    
    $conn->close();  
    if(isset($_POST["submit"])){
        header("refresh: 5;");
    }

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Signup | travelaholic</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="./assets/css/login.css" type="text/css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <nav>
            <h1><a href="./">travelaholic</a></h1>
        </nav>
        <section class="login-form">
            <div class="form-section">
                <h1>Signup</h1>
                <?php if(isset($noMatch)): ?>
                    <p style="color:red;text-align:center">Passwords don't match try again</p>
                <?php endif; ?>
                <?php if(empty($_POST)): ?>
                    <form action="" method="post">
                        <input type="text" placeholder="First Name" name="firstName">
                        <input type="text" placeholder="Last Name" name="lastName">
                        <input type="text" placeholder="Username" name="user">
                        <input type="password" placeholder="Password" name="pass">
                        <input type="password" placeholder="Confirm Password" name="con_pass">
                        <input type="submit" value="Log In" name="submit">
                    </form>
                <?php elseif (!isset($noMatch)): ?>
                        <h1>Redirecting to Login Page</h1>
                <?php endif; ?>
            </div>
        </section>
        <script src="" async defer></script>
    </body>
</html>


