<?php
    include "db_conn.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';

    if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"])){
        $key = $_GET["key"];
        $email = $_GET["email"];
        $curDate = date("Y-m-d H:i:s");
        $query = mysqli_query($conn, "SELECT * FROM password_reset_temp WHERE key='$key' and email='$email';");
        if (!$query){
            //echo "<script>alert('Invalid Link! The link is invalid/expired. Either you did not copy the correct link from the email, or you have already used the key in which case it is deactivated.'); window.open('index.php','_self');</script>";
        }else{
            $row = mysqli_fetch_assoc($query);
            $expDate = $row['expDate'];
            if ($expDate < $curDate){
                //echo "<script>alert('Link Expired! The link is expired. You are trying to use the expired link which as valid only 24 hours (1 days after request).'); window.open('index.php','_self');</script>";
            }	
        }		
    } // isset email key validate end


    if(isset($_POST["pass1"])){
        $error="";
        $email = $_POST["email"];
        $pass1 = mysqli_real_escape_string($conn,$_POST["pass1"]);
        $pass1 = str_rot13($pass1);
        $sql = "UPDATE user SET Password='$pass1' WHERE UserName='$email'; ";
        $sql2 = "DELETE FROM password_reset_temp WHERE email='$email';";
        $result = mysqli_query($conn, $sql);
        $result2 = mysqli_query($conn, $sql2);
        if($result && $result2)
            echo "<script>alert('Your password has been updated successfully'); window.open('authenticate.php','_self');</script>";	
        else
            echo "<script>alert('Error encountered".mysqli_error($conn)."'); window.open('index.php','_self');</script>";
    }



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>HealthCare - Helping Patients with Depression</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <script src="js/resetpassword.js" defer></script>
    
    <style>
        .contact-section .row{
            justify-content: center;
            display: flex;
            margin-top: 3em;
            padding-bottom: 5em;
        }
        .panel{
            padding: 20px;
            border: 1px solid #398378;
        }
        .panel h2{
            font-weight: 500;
            line-height: 1;
            font-size: 24px;
        }
        .panel h3{
            font-weight: 500;
            line-height: 1;
        }
    </style>
    <script
        nonce="fb130dd1-969a-4222-8959-d5697818fe64">(function (w, d) { !function (bw, bx, by, bz) { bw[by] = bw[by] || {}; bw[by].executed = []; bw.zaraz = { deferred: [], listeners: [] }; bw.zaraz.q = []; bw.zaraz._f = function (bA) { return function () { var bB = Array.prototype.slice.call(arguments); bw.zaraz.q.push({ m: bA, a: bB }) } }; for (const bC of ["track", "set", "debug"]) bw.zaraz[bC] = bw.zaraz._f(bC); bw.zaraz.init = () => { var bD = bx.getElementsByTagName(bz)[0], bE = bx.createElement(bz), bF = bx.getElementsByTagName("title")[0]; bF && (bw[by].t = bx.getElementsByTagName("title")[0].text); bw[by].x = Math.random(); bw[by].w = bw.screen.width; bw[by].h = bw.screen.height; bw[by].j = bw.innerHeight; bw[by].e = bw.innerWidth; bw[by].l = bw.location.href; bw[by].r = bx.referrer; bw[by].k = bw.screen.colorDepth; bw[by].n = bx.characterSet; bw[by].o = (new Date).getTimezoneOffset(); if (bw.dataLayer) for (const bJ of Object.entries(Object.entries(dataLayer).reduce(((bK, bL) => ({ ...bK[1], ...bL[1] }))))) zaraz.set(bJ[0], bJ[1], { scope: "page" }); bw[by].q = []; for (; bw.zaraz.q.length;) { const bM = bw.zaraz.q.shift(); bw[by].q.push(bM) } bE.defer = !0; for (const bN of [localStorage, sessionStorage]) Object.keys(bN || {}).filter((bP => bP.startsWith("_zaraz_"))).forEach((bO => { try { bw[by]["z_" + bO.slice(7)] = JSON.parse(bN.getItem(bO)) } catch { bw[by]["z_" + bO.slice(7)] = bN.getItem(bO) } })); bE.referrerPolicy = "origin"; bE.src = "../../cdn-cgi/zaraz/sd0d9.js?z=" + btoa(encodeURIComponent(JSON.stringify(bw[by]))); bD.parentNode.insertBefore(bE, bD) };["complete", "interactive"].includes(bx.readyState) ? zaraz.init() : bw.addEventListener("DOMContentLoaded", zaraz.init) }(w, d, "zarazData", "script"); })(window, document);
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light sticky-top" id="ftco-navbar">
        <div class="container d-flex align-items-center">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
            aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
          </button>
          <p class="button-custom hover order-lg-last mb-0"><a href="authenticate.php" target="_blank"
              class="btn btn-secondary py-2 px-3">Log-In / Sign-Up</a></p>
          <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item "><a href="index.php" class="nav-link">Home</a></li>
              <li class="nav-item "><a href="about.html" class="nav-link">About Us</a></li>
              <li class="nav-item"><a href="counselor.html" class="nav-link">Counselors</a></li>
              <li class="nav-item"><a href="#" class="nav-link">Doctors</a></li>
              <li class="nav-item"><a href="contact.php" class="nav-link">Contact Us</a></li>
            </ul>
          </div>
        </div>
      </nav>
    <section class="ftco-section mt-5ftco-no-pt ftco-no-pb contact-section" style="background-color: #fafafab0; height: 90vh;">
        <div class="container">
            <!-- <div class="row d-flex align-items-stretch no-gutters">
                <div class="col-md-6 p-4 p-md-5 order-md-last" style="padding-top: 2rem !important;">
                    <form action="#">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Name*" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Your Email*" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Mobile Number*" required>
                        </div>
                        <div class="form-group">
                            <textarea name="" id="" cols="30" rows="6" class="form-control"
                                placeholder="Message"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>
                </div>
                <div class="col-md-6 d-flex">
                    <div id="">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2796.6442297680214!2d-73.58092258459249!3d45.497108579101386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cc91a6a633b679b%3A0xe8bab992db81a44c!2s1455%20Boul.%20de%20Maisonneuve%20Ouest%2C%20Montr%C3%A9al%2C%20QC%20H3G%201M8!5e0!3m2!1sen!2sca!4v1677703729285!5m2!1sen!2sca"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div> -->

            <div class="row">
                <div class="col-md-5 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-center">
                                <h3><i class="fa fa-lock fa-x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">
                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post" action="" name="update">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="dflex">
                                                    <input type="password" name="pass1" id="register-password" placeholder="Password" autocomplete="new-password" minlength="8" required>
                                                    <button type="button" id="register-see-password"><i class="fa fa-eye fa-x"></i></button>
                                                </div>
                                                <p class="pchar">8-character minimum; case sensitive</p>
                                                <!-- <input type="password" name="password" id="register-password" placeholder="Password" autocomplete="new-password" minlength="8" required> -->
                                                <!-- </label> -->
                                                <!-- <label for="register-confirm-password">
                                                Confirm Password -->
                                                <div class="dflex">
                                                    <input type="password" id="register-confirm-password" placeholder="Confirm Password" autocomplete="new-password" required>
                                                    <button type="button" id="register-see-confirm-password"><i class="fa fa-eye fa-x"></i></button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="email" value="<?php echo $email?>">
                                        </div>
                                        <div class="form-group" style="padding-top: 10px;">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block"
                                                value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
                stroke="#F96D00" />
        </svg></div>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/jquery.timepicker.min.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&amp;sensor=false"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
    </script>
    <script defer
        src="https://static.cloudflareinsights.com/beacon.min.js/vaafb692b2aea4879b33c060e79fe94621666317369993"
        integrity="sha512-0ahDYl866UMhKuYcW078ScMalXqtFJggm7TmlUtp0UlD4eQk0Ixfnm5ykXKvGJNFjLMoortdseTfsRT8oCfgGA=="
        data-cf-beacon='{"rayId":"79e5c0415cd98cab","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2023.2.0","si":100}'
        crossorigin="anonymous"></script>
</body>

</html>