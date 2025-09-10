<?php
    include "db_conn.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';

    if(isset($_POST["email"]) && (!empty($_POST["email"]))){
        $error=0;
        $email = $_POST["email"];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($email) {
            $sel_query = "SELECT * FROM user WHERE UserName='$email';";
            $results = mysqli_query($conn,$sel_query);
            if($results)
                $row = mysqli_num_rows($results);
            else{
                echo "<script>alert('No user is registered with this email address!'); window.open('index.php','_self');</script>";
            }
        }
        if($error==0){
            
            $expFormat = mktime(
            date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
            );
            $expDate = date("Y-m-d H:i:s",$expFormat);
            $key = md5($email);
            $addKey = substr(md5(uniqid(rand(),1)),3,10);
            $key.=$addKey;
            $sql = "INSERT INTO password_reset_temp (email, passKey, expDate) VALUES ('$email', '$key', '$expDate');";
            $result = mysqli_query($conn, $sql);
            if($result){
                $output='Dear user,
Please click on the following link to reset your password.
-------------------------------------------------------------
spm/resetpassword.php?key='.$key.'&email='.$email.'&action=reset
-------------------------------------------------------------
Please be sure to copy the entire link into your browser.
The link will expire after 1 day for security reasons.
If you did not request this forgot password email, no action is needed, your password will not be reset. However, you may want to log into 
your account and change your security password

Thanks,
Healthcare Team';

            $body = $output; 
            $subject = "Healthcare Reset Password";

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Mailer = "smtp";

            $mail->SMTPAuth   = TRUE;
            $mail->SMTPSecure = "tls";
            $mail->Port       = ; //INSERT PORT
            $mail->Host       = ""; //INSERT HOST
            $mail->Username   = ""; //INSERT USERNAME
            $mail->Password   = ""; //INSERT PASSWORD

            $mail->setFrom($email, 'HealthCare');
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->Body = $body;

            if($mail->Send())
                echo "<script>alert('An email has been sent to you with instructions on how to reset your password.'); window.open('index.php','_self');</script>";
            }
        else{
            echo "<script>alert('Error encountered".mysqli_error($conn)."'); window.open('index.php','_self');</script>";
        }
        }

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
          <p class="button-custom hover order-lg-last mb-0"><a href="authenticate.php" target="_self"
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
                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post" action="forgotpassword.php">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i
                                                        class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="Your Email Address"
                                                    class="form-control" type="email" required>
                                            </div>
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
