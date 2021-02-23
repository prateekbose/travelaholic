<?php

    require_once 'vendor/autoload.php';
    
    $flag = 0;
    
    if(isset($_COOKIE["USID"]) && isset($_COOKIE["USLG"])){
        $flag = 1;
        $user = base64_decode($_COOKIE["USFN"]);
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

    $beachData = array();

    $beachQuery = "SELECT `Name`,`Country`,`Tag` FROM `beaches`";
    $BEACH = $conn->query($beachQuery);
    while($row = $BEACH->fetch_assoc()) {
        if(key_exists($row["Tag"],$beachData)){
            array_push($beachData[$row["Tag"]], array($row["Name"],$row["Country"]));
        } else {
            $beachData[$row["Tag"]] = array();
            array_push($beachData[$row["Tag"]], array($row["Name"],$row["Country"]));
        }
      }

    $mountainData = array();

    $mountainQuery = "SELECT `Name`,`Country`,`Tag` FROM `mountain`";
    $MOUNTAIN = $conn->query($mountainQuery);
    while($row = $MOUNTAIN->fetch_assoc()) {
        if(key_exists($row["Tag"],$mountainData)){
            array_push($mountainData[$row["Tag"]], array($row["Name"],$row["Country"]));
        } else {
            $mountainData[$row["Tag"]] = array();
            array_push($mountainData[$row["Tag"]], array($row["Name"],$row["Country"]));
        }
      }

    $urbanData = array();

    $urbanQuery = "SELECT `Name`,`Country`,`Tag` FROM `urban`";
    $URBAN = $conn->query($urbanQuery);
    while($row = $URBAN->fetch_assoc()) {
        if(key_exists($row["Tag"],$urbanData)){
            array_push($urbanData[$row["Tag"]], array($row["Name"],$row["Country"]));
        } else {
            $urbanData[$row["Tag"]] = array();
            array_push($urbanData[$row["Tag"]], array($row["Name"],$row["Country"]));
        }
      }

      $spiritualData = array();

      $spiritualQuery = "SELECT `Name`,`Country`,`Tag` FROM `spiritual`";
      $SPIRITUAL = $conn->query($spiritualQuery);
      while($row = $SPIRITUAL->fetch_assoc()) {
          if(key_exists($row["Tag"],$spiritualData)){
              array_push($spiritualData[$row["Tag"]], array($row["Name"],$row["Country"]));
          } else {
              $spiritualData[$row["Tag"]] = array();
              array_push($spiritualData[$row["Tag"]], array($row["Name"],$row["Country"]));
          }
        }

?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Explore | travelaholic</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="./assets/css/style.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div id="loader">
            <div class="loader">
                <img src="" alt="">
            </div>
        </div>
        <div class="preload">
            <img src="./images/BEACHES/ITALY/3.jpg" alt="">
            <img src="./images/MOUNTAIN/MALDIVES/2.jpg" alt="">
            <img src="./images/SPIRITUAL/MALDIVES/1.jpg" alt="">
            <img src="./images/URBAN/AUSTRALIA/3.jpg" alt="">
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
                        <a class="logout">Log out</a>
                    <?php else: ?>
                        <a href="./login">Log in</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>       
        <section class="hero-section explore-hero explore-italy">
            <div class="hero-header">
                <h1>01</h1>
                <h4><?php echo $beachData["ITALY"][2][1] ?></h4>
                <h3><?php echo $beachData["ITALY"][2][0] ?></h3>
                <button>Explore</button>
            </div>
            <div class="button-section">
                <button><i class="fas fa-angle-left"></i></button>
                <button><i class="fas fa-angle-right"></i></button>
            </div>
        </section>
        <section class="popular-section explore-popular" id="mountain">            
            <div class="explore-header-section">
                <div>
                <h1>Call of the Mountains</h1>
                <p>Witness breathtaking views and experiences</p>
                </div>
                <div class="button-section">
                    <button><i class="fas fa-angle-left"></i></button>
                    <button><i class="fas fa-angle-right"></i></button>
                </div>
            </div>
            <div class="category-card-section card-section">
                <div class="card" style="background-image: url('./images/MOUNTAIN/BRAZIL/3.jpg')">
                    <div class="details">
                        <h1><?php echo $mountainData["BRAZIL"][2][0] ?></h1>
                        <p><?php echo $mountainData["BRAZIL"][2][1] ?></p>
                    </div>
                </div>  
                <div class="card" style="background-image: url('./images/MOUNTAIN/MALDIVES/2.jpg')">
                    <div class="details">
                        <h1><?php echo $mountainData["MALDIVES"][1][0] ?></h1>
                        <p><?php echo $mountainData["MALDIVES"][1][1] ?></p>
                    </div>
                </div>      
                <div class="card" style="background-image: url('./images/MOUNTAIN/AUSTRALIA/3.jpg')">
                    <div class="details">
                        <h1><?php echo $mountainData["AUSTRALIA"][2][0] ?></h1>
                        <p><?php echo $mountainData["AUSTRALIA"][2][1] ?></p>
                    </div>
                </div>      
                <div class="card" style="background-image: url('./images/MOUNTAIN/ITALY/1.jpg')">
                    <div class="details">
                        <h1><?php echo $mountainData["ITALY"][0][0] ?></h1>
                        <p><?php echo $mountainData["ITALY"][0][1] ?></p>
                    </div>
                </div>      
                <div class="card" style="background-image: url('./images/MOUNTAIN/ITALY/3.jpg')">
                    <div class="details">
                        <h1><?php echo $mountainData["ITALY"][2][0] ?></h1>
                        <p><?php echo $mountainData["ITALY"][2][1] ?></p>
                    </div>
                </div>      
                <div class="card" style="background-image: url('./images/MOUNTAIN/ITALY/4.jpg')">
                    <div class="details">
                        <h1><?php echo $mountainData["ITALY"][3][0] ?></h1>
                        <p><?php echo $mountainData["ITALY"][3][1] ?></p>
                    </div>
                </div>      
            </div>
        </section>
        <section class="popular-section explore-popular" id="spiritual">            
            <div class="explore-header-section">
                <div>
                <h1>Between truth and reconciliation</h1>
                <p>Explore places that brings you closer you to the spiritual you</p>
                </div>
                <div class="button-section">
                    <button><i class="fas fa-angle-left"></i></button>
                    <button><i class="fas fa-angle-right"></i></button>
                </div>
            </div>
            <div class="category-card-section card-section">
                <div class="card" style="background-image: url('./images/SPIRITUAL/BRAZIL/3.jpg')">
                    <div class="details">
                        <h1><?php echo $spiritualData["BRAZIL"][2][0] ?></h1>
                        <p><?php echo $spiritualData["BRAZIL"][2][1] ?></p>
                    </div>
                </div>      
                <div class="card" style="background-image: url('./images/SPIRITUAL/MALDIVES/2.jpg')">
                    <div class="details">
                        <h1><?php echo $spiritualData["MALDIVES"][1][0] ?></h1>
                        <p><?php echo $spiritualData["MALDIVES"][1][1] ?></p>
                    </div>
                </div>      
                <div class="card" style="background-image: url('./images/SPIRITUAL/AUSTRALIA/3.jpg')">
                    <div class="details">
                        <h1><?php echo $spiritualData["AUSTRALIA"][2][0] ?></h1>
                        <p><?php echo $spiritualData["AUSTRALIA"][2][1] ?></p>
                    </div>
                </div>      
                <div class="card" style="background-image: url('./images/SPIRITUAL/ITALY/1.jpg')">
                    <div class="details">
                        <h1><?php echo $spiritualData["ITALY"][0][0] ?></h1>
                        <p><?php echo $spiritualData["ITALY"][0][1] ?></p>
                    </div>
                </div>      
                <div class="card" style="background-image: url('./images/SPIRITUAL/ITALY/3.jpg')">
                    <div class="details">
                        <h1><?php echo $spiritualData["ITALY"][2][0] ?></h1>
                        <p><?php echo $spiritualData["ITALY"][2][1] ?></p>
                    </div>
                </div>      
                <div class="card" style="background-image: url('./images/SPIRITUAL/ITALY/4.jpg')">
                    <div class="details">
                        <h1><?php echo $spiritualData["ITALY"][3][0] ?></h1>
                        <p><?php echo $spiritualData["ITALY"][3][1] ?></p>
                    </div>
                </div>      
            </div>
        </section>
        <section class="explore-country" id="flight">
            <h1>Countries</h1>
            <div class="small-card-section">
               <?php
                    $i = 0;
                    $j = 0;
                    $URL;
                    $ID = ["JP", "NO", "US", "CA", "VN", "KR", "IT", "FR", "CH", "PE"];
                    $country = ["Japan", "Norway", "USA", "Canada", "Vietnam", "South Korea", "Italy", "France", "Switzerland", "Peru"];
                    $ImageURL = ["./images/MOUNTAIN/MALDIVES/2.jpg","./images/MOUNTAIN/ITALY/1.jpg","./images/URBAN/BRAZIL/1.jpg","./images/URBAN/BRAZIL/2.jpg","./images/BEACHES/MALDIVES/3.jpg","./images/URBAN/MALDIVES/3.jpg","./images/MOUNTAIN/ITALY/4.jpg","./images/SPIRITUAL/ITALY/2.jpg","./images/MOUNTAIN/ITALY/2.jpg","./images/SPIRITUAL/BRAZIL/3.jpg"];
                    while($i!=8){
                        Unirest\Request::verifyPeer(false);
                        $response = Unirest\Request::get("https://skyscanner-skyscanner-flight-search-v1.p.rapidapi.com/apiservices/browsequotes/v1.0/IN/INR/en-US/". $ID[$j]. "-sky/IN-sky/anytime?inboundpartialdate=anytime",
                            array(
                                "X-RapidAPI-Host" => "RAPID API HOST URL HERE",
                                "X-RapidAPI-Key" => "YOUR RAPID API KEY HERE"
                            )
                        );
                        $j++;
                        $flightPrice;
                        if(count($response->body->Quotes) > 0){
                            $flightPrice = $response->body->Quotes[0]->MinPrice;
                            $URL = "https://www.skyscanner.co.in/transport/flights/in/".strtolower($ID[$j]);
                            echo '<a href = "'.$URL.'" target = "_blank">
                            <div class="small-card">
                                        <div class="card-image" style="background-image: url('.$ImageURL[$j].');"></div>
                                        <div class="details">
                                            <h1>'.$country[$j].'</h1>
                                            <h3>&#8377; '.$flightPrice.'</h3>
                                        </div>
                                    </div></a>';
                            $i++;
                        }
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
        <script src="./assets/js/explore.js"></script>
        <script>
            const placeURL = [  "./city?name=<?php echo base64_encode($mountainData["BRAZIL"][2][0]) ?>&p=<?php echo base64_encode("MOUNTAIN") ?>&c=<?php echo base64_encode("BRAZIL") ?>&i=3",
                                "./city?name=<?php echo base64_encode($mountainData["MALDIVES"][1][0]) ?>&p=<?php echo base64_encode("MOUNTAIN") ?>&c=<?php echo base64_encode("MALDIVES") ?>&i=2",
                                "./city?name=<?php echo base64_encode($mountainData["AUSTRALIA"][2][0]) ?>&p=<?php echo base64_encode("MOUNTAIN") ?>&c=<?php echo base64_encode("AUSTRALIA") ?>&i=3",
                                "./city?name=<?php echo base64_encode($mountainData["ITALY"][0][0]) ?>&p=<?php echo base64_encode("MOUNTAIN") ?>&c=<?php echo base64_encode("ITALY") ?>&i=1",
                                "./city?name=<?php echo base64_encode($mountainData["ITALY"][2][0]) ?>&p=<?php echo base64_encode("MOUNTAIN") ?>&c=<?php echo base64_encode("ITALY") ?>&i=3",
                                "./city?name=<?php echo base64_encode($mountainData["ITALY"][3][0]) ?>&p=<?php echo base64_encode("MOUNTAIN") ?>&c=<?php echo base64_encode("ITALY") ?>&i=4",
                                "./city?name=<?php echo base64_encode($spiritualData["BRAZIL"][2][0]) ?>&p=<?php echo base64_encode("SPIRITUAL") ?>&c=<?php echo base64_encode("BRAZIL") ?>&i=3",
                                "./city?name=<?php echo base64_encode($spiritualData["MALDIVES"][1][0]) ?>&p=<?php echo base64_encode("SPIRITUAL") ?>&c=<?php echo base64_encode("MALDIVES") ?>&i=2",
                                "./city?name=<?php echo base64_encode($spiritualData["AUSTRALIA"][2][0]) ?>&p=<?php echo base64_encode("SPIRITUAL") ?>&c=<?php echo base64_encode("AUSTRALIA") ?>&i=3",
                                "./city?name=<?php echo base64_encode($spiritualData["ITALY"][0][0]) ?>&p=<?php echo base64_encode("SPIRITUAL") ?>&c=<?php echo base64_encode("ITALY") ?>&i=1",
                                "./city?name=<?php echo base64_encode($spiritualData["ITALY"][2][0]) ?>&p=<?php echo base64_encode("SPIRITUAL") ?>&c=<?php echo base64_encode("ITALY") ?>&i=3",
                                "./city?name=<?php echo base64_encode($spiritualData["ITALY"][3][0]) ?>&p=<?php echo base64_encode("SPIRITUAL") ?>&c=<?php echo base64_encode("ITALY") ?>&i=4"];
            const namePlace = "Explore"; 
            const H1 = ["01", "02", "03", "04"];
            const H3 = ["<?php echo $beachData["ITALY"][2][0] ?>","<?php echo $mountainData["MALDIVES"][1][0] ?>","<?php echo $spiritualData["MALDIVES"][0][0] ?>","<?php echo $urbanData["AUSTRALIA"][2][0] ?>"];
            const H4 = ["<?php echo $beachData["ITALY"][2][1] ?>","<?php echo $mountainData["MALDIVES"][1][1] ?>","<?php echo $spiritualData["MALDIVES"][0][1] ?>","<?php echo $urbanData["AUSTRALIA"][2][1] ?>"];
            const back = ['./images/BEACHES/ITALY/3.jpg','./images/MOUNTAIN/MALDIVES/2.jpg','./images/SPIRITUAL/MALDIVES/1.jpg','./images/URBAN/AUSTRALIA/3.jpg'];
            const href = ["./city?name=SWJpemE=&p=QkVBQ0hFUw==&c=SVRBTFk=&i=3", "./city?name=TW91bnQgRnVqaQ==&p=TU9VTlRBSU4=&c=TUFMRElWRVM=&i=2", "./city?name=UGFybyBUYWt0c2FuZw==&p=U1BJUklUVUFM&c=TUFMRElWRVM=&i=1", "./city?name=V2VsbGluZ3Rvbg==&p=VVJCQU4=&c=QVVTVFJBTElB&i=3"];
        </script>
        <script src="assets\js\animate.js"></script>
        <script src="assets\js\func.js"></script>
    </body>
</html>