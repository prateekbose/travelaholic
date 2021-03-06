<?php 
    $servername = "SERVER_NAME_HERE";
    $username = "USER_NAME_HERE";
    $password = "PASSWORD_HERE";
    $dbname = "DATABASE_NAME_HERE";
    $flag = 0;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_POST["submit"])){
        $user = $_COOKIE["USID"];
        $pass = hash("sha256",$_POST["pass"]);
        $newpass = hash("sha256",$_POST["new_pass"]);
    
        
        $data = $conn->query("SELECT pass FROM users WHERE user=\"".$user."\"");
        $row = mysqli_fetch_array($data);      
        if($row["pass"] == $pass){
            $flag = 1;
            $conn->query("UPDATE users
                        SET pass=\"".$newpass."\"
                        WHERE user=\"".$user."\""); 
            header("refresh: 5;url=index.php");
        }

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
        <title>Account | travelaholic</title>
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
                <h1>Change Password</h1>
                <?php if(empty($_POST)): ?>
                    <form action="" method="post">
                        <input type="password" placeholder="Old Password" name="pass">
                        <input type="password" placeholder="New Password" name="new_pass">
                        <input type="submit" value="Change" name="submit">
                    </form>
                <?php elseif($flag == 1): ?>
                    <h1>Password Changed</h1>
                    <h1>Redirecting to the Site</h1>
                <?php else: ?>
                    <p style="text-align: center;">Incorrect password</p>
                    <form action="" method="post">
                        <input type="password" placeholder="Old Password" name="pass">
                        <input type="password" placeholder="New Password" name="new_pass">
                        <input type="submit" value="Change" name="submit">
                    </form>
                <?php endif; ?>
            </div>
        </section>
        <script src="" async defer></script>
    </body>
</html>


