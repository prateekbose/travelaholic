<?php
    $flag = 0;
    
    if(isset($_COOKIE["USID"]) && isset($_COOKIE["USLG"])){
        $flag = 1;
        $user = base64_decode($_COOKIE["USFN"]);
        $client_user = $_COOKIE["USID"];
    }


    if(isset($_COOKIE["USLG"]) && $_COOKIE["USLG"] == 0){
        setcookie('USID', '', time()-(8400*10));
        setcookie('USFN', '', time()-(8400*10));
        if(isset($_COOKIE["USID"])){
            header("refresh: 0");
        }
    }

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

    $placesData = array();


    if(isset($user)){
        $placesQuery = "SELECT `Name`,`Place_Tag`,`Country_Tag`,`Index_Tag` FROM `bookmarks` WHERE `Username` = \"$client_user\"";
        $PLACES = $conn->query($placesQuery) or die($conn->error);
        while(($data = $PLACES->fetch_assoc())){
            array_push($placesData,$data);
        }
    } 

    $savedURL = array();

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
        <link rel="stylesheet" href="./assets/css/style.css" type="text/css">
    </head>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <nav>
            <h1><a href="./">travelaholic</a></h1>
            <div class="burger-section">
                <div class="burger">
                <div class="line line1"></div>
                <div class="line line2"></div>
                <div class="line line3"></div>
            </div>
                <div class="popup hide">
                    <a href="./plan">Plan</a>
                    <a href="./explore">Explore</a>
                    <a href="./account">Account</a>
                    <?php if($flag == 1): ?>
                        <a href="#" class="logout">Log out</a>
                    <?php else: ?>
                        <a href="./login">Log in</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav> 
        <h1 class="account-header">Hello,<?php if($flag == 1): ?>
                    <?php echo  $user; ?>
                    <?php else: ?>
                    <?php echo "User" ?>
                <?php endif; ?></h1>
        <h3 class="account-subheader">Account</h3>
        <section class="account-section">
            <h1>Liked Places</h1>
            <div class="liked-places">
                
            <?php if(count($placesData)>0): ?>
                <?php foreach($placesData as $place){
                    $link = "./city?name=".base64_encode($place["Name"])."&p=".base64_encode($place["Place_Tag"])."&c=".base64_encode($place["Country_Tag"])."&i=".$place["Index_Tag"];
                    array_push($savedURL, $link);
                echo "
                    <div class='card' style=\"background-image: url('./images/".$place["Place_Tag"]."/".$place["Country_Tag"]."/".$place["Index_Tag"].".jpg')\">
                        <div class='details'>
                            <h1>".$place["Name"]."</h1>
                        </div>
                    </div>";
            }
            ?> 

            <?php else: ?>
                <h1>Looks like you haven't saved any places</h1>
            <?php endif; ?>               
            </div>

            <?php if($flag == 1): ?>
                <h1>Security</h1>
                <div class="security-section">
                    <a href="./changepass.php"><button>Change Password</button></a>
                    <a href="./delacc.php"><button>Delete Account</button></a>
                </div>
            <?php else: ?>
                <h1>Security</h1>
                <div class="security-section">
                    <a href="./login.php"><button>Log In</button></a>
                </div>
            <?php endif; ?>
        </section>
        <footer class="account-footer">
            <section>
                <h1>travelaholic</h1>
            </section>
            <div class="super-footer">
                <h1>Made with ❤️ by <a href="https://github.com/prateekbose20011">Prateek Bose</a></h1>
                <a>Link to the GitHub Repo for the project would be added soon</a>
            </div>
        </footer>
        <script>
            const namePlace = "Account";
            const savedURL = <?php echo json_encode($savedURL); ?>;

            const savePlaces = document.querySelectorAll(".account-section .liked-places .card");

            savePlaces.forEach((item,index) => {
                item.addEventListener('click', () => {
                    window.location.href = savedURL[index];
                });
            });
        </script>
        <script src="./assets/js/animate.js" async defer></script>
        <?php if($flag == 1): ?>
            <script src="./assets/js/func.js"></script>
        <?php endif; ?>
    </body>
</html>