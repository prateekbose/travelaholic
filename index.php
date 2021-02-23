<?php
    $flag = 0; // this flag depicts if the user is logged in or not
    
    if(isset($_COOKIE["USID"]) && isset($_COOKIE["USLG"])){ // this checks if the user is logged in or not
        $flag = 1; // this sets the flag 1 if the user is logged in 
        $user = base64_decode($_COOKIE["USFN"]); // this fetches the user's first name is logged in
        $client_user = $_COOKIE["USID"]; // this fetches the username (still base64 encoded) if logged in
    }


    if(isset($_COOKIE["USLG"]) && $_COOKIE["USLG"] == 0){ // this is used to remove the cookies if the user logs out
        setcookie('USID', '', time()-(8400*10)); // expires the cookie
        setcookie('USFN', '', time()-(8400*10)); // expires the cookie
        if(isset($_COOKIE["USID"])){
            header("refresh: 0"); //refreshes the page to make the change to DOM elements
        }
    }

    // connection details for the MySQL databse
    $servername = "SERVER_NAME_HERE";
    $username = "USER_NAME_HERE";
    $password = "PASSWORD_HERE";
    $dbname = "DATABASE_NAME_HERE";
    
    // create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $placesData = array(); // array which stores the bookmarked places of the user if logged in

    if(isset($user)){ // checks if user is logged in or not
        $placesQuery = "SELECT `Name`,`Place_Tag`,`Country_Tag`,`Index_Tag` FROM `bookmarks` WHERE `Username` = \"$client_user\""; // query to fetch bookmarked places
        $PLACES = $conn->query($placesQuery) or die($conn->error); // running query to fetch bookmarked places
        while(($data = $PLACES->fetch_assoc())){
            array_push($placesData,$data); // pushing the fetched row to the array to display later on
        }
    } 

    $savedURL = array(); // holds URLS of the bookmarked places

?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>

        <!-- meta tags and link for
            1. Google Fonts used
            2. Font-Awesome for icons used
            3. Our custom CSS stylesheet
            4. Favicon used
            and also the title of the page
        -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel='shortcut icon' type='image/x-icon' href='./favicon.ico' />
        <title>Home | travelaholic</title>
        <meta name="description" content="Start exploring places to travel to">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="./assets/css/style.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- preloader -->
        <div id="loader">
            <div class="loader"></div>
        </div>

        <!-- navbar section which
            1. Displays name if logged in
            2. Displays the option to Logout only is logged in, otherwise shows Login
        -->
        <nav>
            <h1><a href="./">travelaholic</a><span><?php if($flag == 1): ?>
                    <?php echo "/ ". $user; ?></span>  <!-- displays the first name if user is logged in -->
                <?php endif; ?>
            </h1>
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
                        <a href="#" class="logout">Log out</a> <!-- display option to Log Out if logged in, otherwise shows option t o Log in -->
                    <?php else: ?>
                        <a href="./login">Log in</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <!-- hero section which houses the Call-To-Action section -->
        <section class="hero-section">
            <div class="hero-header">
                <h1>"We wander for distraction,<br> but we travel for fulfilment"</h1>
                <h3>Start exploring places to travel to</h3>
                <div>
                    <a href="./explore"><button>Explore</button></a>
                    <a href="./plan"><button>Plan</button></a>
                </div>
            </div>
        </section>

        <!-- section where the cards for different categories are display -->
        <section class="category-card-section card-section">
            <div class="card" style="background-image: url('./images/SPIRITUAL/MALDIVES/1.jpg">
                <div class="details">
                    <h1>Connect to the spiritual you</h1>
                </div>
            </div>
            <div class="card" style="background-image: url('./images/MOUNTAIN/BRAZIL/3.jpg">
                <div class="details">
                    <h1>Discover breathtaking views</h1>
                </div>
            </div>
            <div class="card" style="background-image: url('./images/FLIGHTS.jpg">
                <div class="details">
                    <h1>See Flight prices</h1>
                </div>
            </div>
        </section>                
            <?php if(count($placesData)>0): ?>
                
        <!-- section where your Bookmarked Places will be displayed if the user is logged in -->
        <section class="account-section home-liked">
            <h1>Your Liked Places</h1>
            <div class="liked-places">
                <?php foreach($placesData as $place){
                    // the link to be pushed is created by adding the correct GET Parameters with the original link
                    $link = "./city?name=".base64_encode($place["Name"])."&p=".base64_encode($place["Place_Tag"])."&c=".base64_encode($place["Country_Tag"])."&i=".$place["Index_Tag"];
                    array_push($savedURL, $link); // pushes URL of each bookmarked places to the URL array for redirecting to the City page
                echo "
                    <div class='card' style=\"background-image: url('./images/".strtoupper($place["Place_Tag"])."/".$place["Country_Tag"]."/".$place["Index_Tag"].".jpg')\">
                        <div class='details'>
                            <h1>".$place["Name"]."</h1>
                        </div>
                    </div>";
                // the above line fetches the image of the bookmarked place from the directory and displays a card with the required details
            }
            ?>
            </section>
            <?php endif; ?>

        <!-- footer section with navigations links for different places -->
        <footer>
            <section>
                <h1>travelaholic</h1>
            </section>
            <section class="links">
                <h1>Links</h1>
                <a href="./plan">Plan your next adventure</a>
                <a href="./plan">Explore spiritual places</a>
                <a href="./account">Manage your account</a>
            </section>
            <div class="super-footer">
                <h1>Made with ❤️ by <a href="https://github.com/prateekbose20011">Prateek Bose</a></h1>
                <a>Link to the GitHub Repo for the project would be added soon</a>
            </div>
        </footer>
        <script>
            const namePlace = "Home"; // used to pass the name of the page, used for defining which animations and functions to be ran for the page
            const savedURL = <?php echo json_encode($savedURL); ?>; // passes the URL array to JavaScript for redirecting


            // the function below is for the preloading animation
            // waits for the DOM to be completely rendered before displaying the page
            document.onreadystatechange = function() { 
                if (document.readyState !== "complete") { 
                    document.querySelector("body").style.visibility = "hidden"
                    document.querySelector("#loader").style.visibility = "visible" 
                } else { 
                    document.querySelector("#loader").style.display = "none"
                    document.querySelector("body").style.visibility = "visible"
                } 
            }; 

            // selects all of the Category Cards
            const categoryCards = document.querySelectorAll(".category-card-section .card");

            // IDs for the categories to be redirected to if the user were to click on a category card
            const pageID = ["#spiritual","#mountain","#flight"]

            // redirects to the Explore page and scrolls to the particular section of the page
            categoryCards.forEach((item,index) => {
                item.addEventListener('click', () => {
                    window.location.href = `./explore${pageID[index]}`;
                });
            });

            // selects all of the Bookmarked Places Cards
            const savePlaces = document.querySelectorAll(".home-liked .liked-places .card");

            // redirects to the City Page with required GET Parameters to get the details for the required city
            savePlaces.forEach((item,index) => {
                item.addEventListener('click', () => {
                    window.location.href = savedURL[index];
                });
            });

        </script>
        <script src="./assets/js/animate.js"></script> <!-- script for animations -->
        <?php if($flag == 1): ?>  <!-- checks if the user is logged in or not -->
            <script src="./assets/js/func.js"></script>  <!-- loads the script to handle login only if user is logged in  -->
        <?php endif; ?>
    </body>
</html>