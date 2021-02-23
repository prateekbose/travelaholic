<?php

    require_once 'vendor/autoload.php';
    
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $flag = 0;
    
    if(isset($_COOKIE["USID"]) && isset($_COOKIE["USLG"])){
        $flag = 1;
        $user = base64_decode($_COOKIE["USFN"]);
        $client_username = $_COOKIE["USID"];
    }


    if(isset($_COOKIE["USLG"]) && $_COOKIE["USLG"] == 0){
        setcookie('USID', '', time()-(8400*10));
        setcookie('USFN', '', time()-(8400*10));
        if(isset($_COOKIE["USID"])){
            header("refresh: 0");
        }
    }

    $name = base64_decode($_GET["name"]);
    $place = strtolower(base64_decode($_GET["p"]));
    $country = base64_decode($_GET["c"]);
    $index = $_GET["i"];
    $bookmark;
    
    if(isset($_GET["bookmark"])){
        $bookmark = $_GET["bookmark"];
    } else {
        $bookmark = 0;
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

    function random_strings($length_of_string) {
        return substr(md5(time()), 0, $length_of_string); 
    }

    $beachQuery = "SELECT `Name`,`Country`,`ID`,`Country Code` FROM `cities` WHERE `Name`=\"$name\"";
    $BEACH = $conn->query($beachQuery);
    $row = $BEACH->fetch_assoc();
    $search = join("%20",explode(" ",$row["Name"]));
    $flightsearch = strtolower($row["Country Code"]);
    Unirest\Request::verifyPeer(false);
    $response = Unirest\Request::get("https://skyscanner-skyscanner-flight-search-v1.p.rapidapi.com/apiservices/browsequotes/v1.0/IN/INR/en-US/". $row["ID"]. "/IN-sky/anytime?inboundpartialdate=anytime",
        array(
            "X-RapidAPI-Host" => "RAPID API URL HERE",
            "X-RapidAPI-Key" => "RAPID API KEY HERE"
        )
    );
    $flightPrice;
    $flightFlag = 0;
    if(count($response->body->Quotes) > 0){
        $flightPrice = $response->body->Quotes[0]->MinPrice;
        $flightFlag = 1;
    }

    if(isset($_COOKIE["USID"])){
        $bookQuery = "SELECT COUNT(*) count FROM `bookmarks` WHERE `Name`=\"$name\" AND `Username`=\"$client_username\"";
        $BOOK = $conn->query($bookQuery);
        $bookData = $BOOK->fetch_assoc();

        if($bookData["count"] == 0){
            $bookmarked = 0;
        } else {
            $bookmarked = 1;
        }

    }
    
    if($bookmark == 1 && isset($user)){
        if($bookmarked == 0){
            $bookQuery = "INSERT INTO `bookmarks` (`ID`, `Username`, `Name`, `Place_Tag`, `Country_Tag`, `Index_Tag`) VALUES (\"".random_strings(10)."\", \"$client_username\", \"$name\", \"$place\", \"$country\", $index)";
            if ($conn->query($bookQuery) === TRUE) { 
                $link = parse_url($actual_link);
                parse_str($link["query"],$link_parameters);
                unset($link_parameters["bookmark"]);
                $new_param = http_build_query($link_parameters);
                
                $new_link = $link["scheme"]."://".$link["host"].$link["path"]."?".$new_param;
                
                header('Location: '.$new_link);
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            } else {
                $bookQuery = "DELETE FROM `bookmarks` WHERE `Name` = \"$name\"";            
                if ($conn->query($bookQuery) === TRUE) {
                    $link = parse_url($actual_link);
                    parse_str($link["query"],$link_parameters);
                    unset($link_parameters["bookmark"]);
                    $new_param = http_build_query($link_parameters);
                    $new_link = $link["scheme"]."://".$link["host"].$link["path"]."?".$new_param;
                    
                    header('Location: '.$new_link);
            } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
    }


    $place_data = Unirest\Request::get("https://api.opentripmap.com/0.1/en/places/geoname?name=\"".$row['Name']."\"&country=".$row['Country Code']."&OPEN TRIP MAP API KEY HERE");
    $lon = $place_data->body->lon;
    $lat = $place_data->body->lat;
    
    $places = Unirest\Request::get("https://api.opentripmap.com/0.1/en/places/radius?radius=70000&lon=".$lon."&lat=".$lat."&OPEN TRIP MAP API KEY HERE");
    $place_info = $places->body->features;
    $i=0;
    $j=0;
    $place_data = array();
    $aData = $places->body->features;
    $abc = array();
    

    foreach($aData as $plac){
       array_push($abc, $plac->properties);
    }
    
    usort($abc, function($a, $b) {
        return $b->rate <=> $a->rate;
    });

    while($i<8){
        if(!empty($abc[$j]->name)){
            $temp = array();
            $types = ucwords(strtolower(explode(",",$abc[$j]->kinds)[0]));
            $types = explode("_",$types);
            $types = ucwords(join(" ",$types));
            $dist = $abc[$j]->dist/1000;
            $dist = round($dist,2);
            array_push($temp, $abc[$j]->name,$types,$dist);
            array_push($place_data,$temp);
            $i++;
        }
        $j++;
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
        <title>City | travelaholic</title>
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
        <div class="preload">
            <img src="./images/<?php echo strtoupper($place) ?>/<?php echo "$country" ?>/<?php echo $index ?>.jpg" alt="">
        </div>
        <nav>
            <h1><a href="./">travelaholic</a><span><?php if($flag == 1): ?>
                    <?php echo "/ ". $user; ?></span>
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
                        <a href="#" class="logout">Log out</a>
                    <?php else: ?>
                        <a href="./login">Log in</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>     
        <section class="city-hero-section">
            <div class="details">
                <h3>Description</h3>
                <h1>Name Of The Place</h1>
                <h3><?php echo $lat ?>, <?php echo $lon ?></h3>
                <?php if($flightFlag == 1): ?>
                    <h3><?php echo "Flights to ".$row["Country"]." from <br><span>&#8377; " . $flightPrice ?></span> </h3>
                <?php else: ?>
                    <h3>No flight currently</h3>
                <?php endif; ?>
                <?php if(isset($_COOKIE["USID"]) && $bookmarked == 1): ?>
                    <a href="<?php echo $actual_link."&bookmark=1" ?>"><button class="bookmarked"><i class="fas fa-heart"></i> Saved</button></a>
                <?php elseif(isset($bookmarked) && $bookmarked == 0): ?>
                    <a href="<?php echo $actual_link."&bookmark=1" ?>"><button><i class="fas fa-heart"></i></button></a>
                <?php else: ?>
                    <a href="./login"><button><i class="fas fa-heart"></i></button></a>
                <?php endif; ?>
            </div>
            <div class="city-card-section">
                <div class="button-section">
                    <button><i class="fas fa-angle-left"></i></button>
                    <button><i class="fas fa-angle-right"></i></button>
                </div>
                <div class="card-section">
                    <div class="city-card" style="background-image: url('./images/EXPERIENCES.jpg');">
                        <h1>Experiences</h1>
                        <a href="https://www.tripadvisor.in/Search?q=<?php echo $search ?>" target="_blank"><button><i class="fas fa-share-square"></i></button></a>
                    </div>
                    <div class="city-card" style="background-image: url('./images/FLIGHTS.jpg')">
                        <h1>Flights</h1>
                        <a href="https://www.skyscanner.co.in/transport/flights/in/<?php echo $flightsearch ?>" target="_blank"><button><i class="fas fa-share-square"></i></button></a>
                    </div>
                    <div class="city-card" style="background-image: url('./images/HOTELS.jpg')">
                        <h1>Hotels</h1>
                        <a href="https://www.google.com/search?q=<?php echo $search ?>%20hotels" target="_blank"><button><i class="fas fa-share-square"></i></button></a>
                    </div>
                    <div class="city-card" style="background-image: url('./images/MORE_INFO.jpg')">
                        <h1>More Info</h1>
                        <a href="https://www.google.com/search?q=<?php echo $search ?>%3Alonelyplanet.com" target="_blank"><button><i class="fas fa-share-square"></i></button></a>
                    </div>
                </div>
            </div>
        </section>
        <div class="category-card-section card-section mobile-explore">
                <div class="card" style="background-image: url('./images/EXPERIENCES.jpg');">
                    <div class="details">
                        <h1>Experiences</h1>
                    </div>
                </div>
                <div class="card" style="background-image: url('./images/FLIGHTS.jpg');">
                    <div class="details">
                        <h1>Flights</h1>
                    </div>
                </div>  
                <div class="card" style="background-image: url('./images/HOTELS.jpg');">
                    <div class="details">
                        <h1>Hotels</h1>
                    </div>
                </div>  
                <div class="card" style="background-image: url('./images/MORE_INFO.jpg');">
                    <div class="details">
                        <h1>More Info</h1>
                    </div>
                </div>  
            </div>
        </section>
        <section class="explore-country explore-city">
            <h1>Places Nearby</h1>
            <div class="small-card-section">
               <?php 
                                    
                    foreach($place_data as $d){
                        echo '<div class="small-card">
                        <div class="card-image"></div>
                        <div class="details">
                            <h1>'.$d[0].'</h1>
                            <h3>'.$d[1].'</h3>
                            <h3>'.$d[2].' km</h3>
                        </div>
                       </div>';
                    } 
                ?>
            </div>
        </section>
        <footer>
            <section>
                <h1>travelaholic</h1>
            </section>
            <section class="links">
                <h1>Links</h1>
                <a href="./plan">Plan your next aadventure</a>
                <a href="./plan">Explore spiritual places</a>
                <a href="./account">Manage your account</a>
                <a href="./contact">Send us a message</a>
            </section>
            <div class="super-footer">
                <h1>Made with ❤️ by <a href="https://github.com/prateekbose20011">Prateek Bose</a></h1>
                <a>Link to the GitHub Repo for the project would be added soon</a>
            </div>
        </footer>
        <script src="./assets/js/func.js"></script>
        <script>
            const DATA = <?php echo json_encode($row) ?>;
            const place = "<?php echo $place ?>".toUpperCase();
            const country = "<?php echo "$country" ?>";
            const index = <?php echo $index ?>;
            const cityTitle = document.querySelector('.city-hero-section .details h1');
            const countryTitle = document.querySelector('.city-hero-section .details h3');
            const heroBackgroundImage = document.querySelector('.city-hero-section');
            const smallCardImage = document.querySelectorAll('.small-card .card-image');

            const namePlace = "City";

            const mobileCards = document.querySelectorAll('.mobile-explore .card');
            const infoURL = ["https://www.tripadvisor.in/Search?q=<?php echo $search ?>","https://www.skyscanner.co.in/transport/flights/in/<?php echo $flightsearch ?>", "https://www.google.com/search?q=<?php echo $search ?>%20hotels", "https://www.google.com/search?q=<?php echo $search ?>%3Alonelyplanet.com"];

            mobileCards.forEach((item, index) => {
                item.addEventListener('click', () => {
                    window.open(infoURL[index], '_blank');
                });
            });


            cityTitle.innerHTML = DATA["Name"];
            countryTitle.innerHTML = DATA["Country"];
            heroBackgroundImage.style.backgroundImage = `url('./images/${place}/${country}/${index}.jpg')`;
            smallCardImage.forEach(item => {
                item.style.backgroundImage = `url('./images/${place}/${country}/${index}.jpg')`;
            });
        </script>
        <script src="./assets/js/animate.js"></script>
    </body>
</html>