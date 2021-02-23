<?php
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
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Plan | travelaholic</title>
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
        <div id="loader">
            <div class="loader"></div>
        </div>
        <div class="preload">
            <img src="./images/PLAN/paris.jpg" alt="">
            <img src="./images/PLAN/maldives.jpg" alt="">
            <img src="./images/PLAN/kilimanjaro.jpg" alt="">
            <img src="./images/PLAN/monastry.jpg" alt="">
            <img src="./images/PLAN/italy.jpg" alt="">
            <img src="./images/PLAN/brazil.jpg" alt="">
            <img src="./images/PLAN/maldives_1.jpg" alt="">
            <img src="./images/PLAN/australia.jpg" alt="">
            <img src="./images/BEACHES/AUSTRALIA/1.jpg" alt="">
            <img src="./images/BEACHES/AUSTRALIA/2.jpg" alt="">
            <img src="./images/BEACHES/AUSTRALIA/3.jpg" alt="">
            <img src="./images/BEACHES/AUSTRALIA/4.jpg" alt="">
            <img src="./images/BEACHES/BRAZIL/1.jpg" alt="">
            <img src="./images/BEACHES/BRAZIL/2.jpg" alt="">
            <img src="./images/BEACHES/BRAZIL/3.jpg" alt="">
            <img src="./images/BEACHES/BRAZIL/4.jpg" alt="">
            <img src="./images/BEACHES/ITALY/1.jpg" alt="">
            <img src="./images/BEACHES/ITALY/2.jpg" alt="">
            <img src="./images/BEACHES/ITALY/3.jpg" alt="">
            <img src="./images/BEACHES/ITALY/4.jpg" alt="">
            <img src="./images/BEACHES/MALDIVES/1.jpg" alt="">
            <img src="./images/BEACHES/MALDIVES/2.jpg" alt="">
            <img src="./images/BEACHES/MALDIVES/3.jpg" alt="">
            <img src="./images/BEACHES/MALDIVES/4.jpg" alt="">
            <img src="./images/MOUNTAIN/AUSTRALIA/1.jpg" alt="">
            <img src="./images/MOUNTAIN/AUSTRALIA/2.jpg" alt="">
            <img src="./images/MOUNTAIN/AUSTRALIA/3.jpg" alt="">
            <img src="./images/MOUNTAIN/AUSTRALIA/4.jpg" alt="">
            <img src="./images/MOUNTAIN/BRAZIL/1.jpg" alt="">
            <img src="./images/MOUNTAIN/BRAZIL/2.jpg" alt="">
            <img src="./images/MOUNTAIN/BRAZIL/3.jpg" alt="">
            <img src="./images/MOUNTAIN/BRAZIL/4.jpg" alt="">
            <img src="./images/MOUNTAIN/ITALY/1.jpg" alt="">
            <img src="./images/MOUNTAIN/ITALY/2.jpg" alt="">
            <img src="./images/MOUNTAIN/ITALY/3.jpg" alt="">
            <img src="./images/MOUNTAIN/ITALY/4.jpg" alt="">
            <img src="./images/MOUNTAIN/MALDIVES/1.jpg" alt="">
            <img src="./images/MOUNTAIN/MALDIVES/2.jpg" alt="">
            <img src="./images/MOUNTAIN/MALDIVES/3.jpg" alt="">
            <img src="./images/MOUNTAIN/MALDIVES/4.jpg" alt="">
            <img src="./images/URBAN/AUSTRALIA/1.jpg" alt="">
            <img src="./images/URBAN/AUSTRALIA/2.jpg" alt="">
            <img src="./images/URBAN/AUSTRALIA/3.jpg" alt="">
            <img src="./images/URBAN/AUSTRALIA/4.jpg" alt="">
            <img src="./images/URBAN/BRAZIL/1.jpg" alt="">
            <img src="./images/URBAN/BRAZIL/2.jpg" alt="">
            <img src="./images/URBAN/BRAZIL/3.jpg" alt="">
            <img src="./images/URBAN/BRAZIL/4.jpg" alt="">
            <img src="./images/URBAN/ITALY/1.jpg" alt="">
            <img src="./images/URBAN/ITALY/2.jpg" alt="">
            <img src="./images/URBAN/ITALY/3.jpg" alt="">
            <img src="./images/URBAN/ITALY/4.jpg" alt="">
            <img src="./images/URBAN/MALDIVES/1.jpg" alt="">
            <img src="./images/URBAN/MALDIVES/2.jpg" alt="">
            <img src="./images/URBAN/MALDIVES/3.jpg" alt="">
            <img src="./images/URBAN/MALDIVES/4.jpg" alt="">
            <img src="./images/SPIRITUAL/AUSTRALIA/1.jpg" alt="">
            <img src="./images/SPIRITUAL/AUSTRALIA/2.jpg" alt="">
            <img src="./images/SPIRITUAL/AUSTRALIA/3.jpg" alt="">
            <img src="./images/SPIRITUAL/AUSTRALIA/4.jpg" alt="">
            <img src="./images/SPIRITUAL/BRAZIL/1.jpg" alt="">
            <img src="./images/SPIRITUAL/BRAZIL/2.jpg" alt="">
            <img src="./images/SPIRITUAL/BRAZIL/3.jpg" alt="">
            <img src="./images/SPIRITUAL/BRAZIL/4.jpg" alt="">
            <img src="./images/SPIRITUAL/ITALY/1.jpg" alt="">
            <img src="./images/SPIRITUAL/ITALY/2.jpg" alt="">
            <img src="./images/SPIRITUAL/ITALY/3.jpg" alt="">
            <img src="./images/SPIRITUAL/ITALY/4.jpg" alt="">
            <img src="./images/SPIRITUAL/MALDIVES/1.jpg" alt="">
            <img src="./images/SPIRITUAL/MALDIVES/2.jpg" alt="">
            <img src="./images/SPIRITUAL/MALDIVES/3.jpg" alt="">
            <img src="./images/SPIRITUAL/MALDIVES/4.jpg" alt="">
        </div>
        <nav>
            <h1><a href="./">travelaholic</a></h1>
            <div class="burger-section">
                <div class="burger">
                <div class="line line1"></div>
                <div class="line line2"></div>
                <div class="line line3"></div>
            </div>
                <div class="popup hide">
                    <a href="#">Plan</a>
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
        <h1 class="account-header plan-header">Plan</h1>
        <h3 class="account-subheader">What would you prefer to do?</h3>
        <section class="account-section">
            <div class="choose-place">
                <div class="card" data-value="URBAN" style="background-image: url('./images/PLAN/paris.jpg');">
                    <div class="details">
                        <h1>Shopping in Paris</h1>
                    </div>
                </div>
                <div class="card" data-value="BEACHES" style="background-image: url('./images/PLAN/maldives.jpg');">
                    <div class="details">
                        <h1>Diving in Maldives</h1>
                    </div>
                </div>
                <div class="card" data-value="MOUNTAIN" style="background-image: url('./images/PLAN/kilimanjaro.jpg');">
                    <div class="details">
                        <h1>Hiking Mount Kilimanjaro</h1>
                    </div>
                </div>
                <div class="card" data-value="SPIRITUAL" style="background-image: url('./images/PLAN/monastry.jpg');">
                    <div class="details">
                        <h1>Visit Monasteries in the Himalayas</h1>
                    </div>
                </div>
            </div>
        </section>
        <h3 class="account-subheader">Where would you prefer visiting?</h3>
        <section class="account-section">
            <div class="choose-country">
                <div class="card" data-value="ITALY" style="background-image: url('./images/PLAN/italy.jpg');">
                    <div class="details">
                        <h1>Italy</h1>
                    </div>
                </div>
                <div class="card" data-value="BRAZIL" style="background-image: url('./images/PLAN/brazil.jpg');">
                    <div class="details">
                        <h1>Brazil</h1>
                    </div>
                </div>
                <div class="card" data-value="MALDIVES" style="background-image: url('./images/PLAN/maldives_1.jpg');">
                    <div class="details">
                        <h1>Maldives</h1>
                    </div>
                </div>
                <div class="card" data-value="AUSTRALIA" style="background-image: url('./images/PLAN/australia.jpg');">
                    <div class="details">
                        <h1>Australia</h1>
                    </div>
                </div>
            </div>
        </section>
        <h3 class="account-subheader">Choose a city</h3>
        <section class="account-section" style="margin-bottom: 5em;">
            <div class="choose-city">
                <div class="card" data-value="0">
                    <div class="details">
                        <h1>City 1</h1>
                        <h2>Country</h1>
                    </div>
                </div>
                <div class="card" data-value="1">
                    <div class="details">
                        <h1>City 2</h1>
                        <h2>Country</h1>
                    </div>
                </div>
                <div class="card" data-value="2">
                    <div class="details">
                        <h1>City 3</h1>
                        <h2>Country</h1>
                    </div>
                </div>
                <div class="card" data-value="3">
                    <div class="details">
                        <h1>City 4</h1>
                        <h2>Country</h1>
                    </div>
                </div>
            </div>
            <div class="security-section accept-section">
                <a><button>Confirm</button></a>
            </div>
        </section>
        <script src="./assets/js/animate.js" async defer></script>
        <script>
            const namePlace = "Plan";
            const BEACHES = <?php echo json_encode($beachData); ?>;
            const URBAN = <?php echo json_encode($urbanData); ?>;
            const MOUNTAIN = <?php echo json_encode($mountainData); ?>;
            const SPIRITUAL = <?php echo json_encode($spiritualData); ?>;
        </script>
        <script src="./assets/js/plan.js" async defer></script>
    </body>
</html>