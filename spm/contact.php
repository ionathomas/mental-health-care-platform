<!-- PHP code to send an patient inquiry as an email -->

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';


$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";

$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
$mail->Host       = "smtp.gmail.com";
$mail->Username   = "info.healthcare2023@gmail.com";
$mail->Password   = "qioozveosslzzhaf";


$success = $error = "";
$name = $email = $phone = $message = "";
$errors = array('name' => '', 'email' => '', 'phone' => '', 'message' => '');

if (isset($_POST["submit"])) {
    if (empty(trim($_POST["name"]))) {
        $errors['name'] = "Your name is required";
    } else {
        $name = $_POST["name"];
        if (!preg_match("/^([a-zA-Z' ]+)$/", $name)) {
            $errors['name'] = "Only Letters And Spaces Are Allowed";
        }
    }

    if (empty(trim($_POST["email"]))) {
        $errors["email"] = "Your email is required";
    } else {
        $email =$_POST["email"];
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email)) {
            $errors["email"] = "Invalid Email";
        }
    }

    if (empty(trim($_POST["phone"]))) {
        $errors["email"] = "Your phone number is required";
    } else {
        $phone = $_POST["phone"];
        if (!preg_match("/^[1-9][0-9]{0,15}$/", $phone)) {
            $errors["phone"] = "Invalid Phone Number";
        }
    }


    if (empty(trim($_POST["message"]))) {
        $errors["message"] = "Please type your message";
    } else {
        $message = $_POST["message"];
        // if (!preg_match("/^[a-zA-Z\d\s]+$/", $message)) {
        //     $errors["message"] = "Only letters, spaces and maybe numbers allowed";
        // }
    }

    if (array_filter($errors)) {
    } else {
        try {
            //Email structure

            $mail->setFrom('healthcare.spm@gmail.com', 'Patient Inquiry From: ' .$name);
            $mail->addAddress('healthcare.spm@gmail.com', $name);
            $mail->Subject = 'New inquiry On The Website';
            $mail->Body =
"Fullname: $name
Email Address: $email
Mobile Number: $phone
Message: $message";

            $mail->send();
            $name = $email = $phone = $message = "";
            $success = "Message sent successfully";
			echo '<script>alert("Thanks for sending message. We will get back to you soon.")</script>';
			// header('Location: index.php?message=Successfull');
        } catch (Exception $e) {
            $error = "Sorry message could not send, try again";
        }
    }
}
// header('Location: http://www.yoursite.com/index.php#myplace') ;

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <title>HealthCare - Helping Patients with Depression</title>
  <meta charset="utf-8">
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
  <script
    nonce="fb130dd1-969a-4222-8959-d5697818fe64">(function (w, d) { !function (bw, bx, by, bz) { bw[by] = bw[by] || {}; bw[by].executed = []; bw.zaraz = { deferred: [], listeners: [] }; bw.zaraz.q = []; bw.zaraz._f = function (bA) { return function () { var bB = Array.prototype.slice.call(arguments); bw.zaraz.q.push({ m: bA, a: bB }) } }; for (const bC of ["track", "set", "debug"]) bw.zaraz[bC] = bw.zaraz._f(bC); bw.zaraz.init = () => { var bD = bx.getElementsByTagName(bz)[0], bE = bx.createElement(bz), bF = bx.getElementsByTagName("title")[0]; bF && (bw[by].t = bx.getElementsByTagName("title")[0].text); bw[by].x = Math.random(); bw[by].w = bw.screen.width; bw[by].h = bw.screen.height; bw[by].j = bw.innerHeight; bw[by].e = bw.innerWidth; bw[by].l = bw.location.href; bw[by].r = bx.referrer; bw[by].k = bw.screen.colorDepth; bw[by].n = bx.characterSet; bw[by].o = (new Date).getTimezoneOffset(); if (bw.dataLayer) for (const bJ of Object.entries(Object.entries(dataLayer).reduce(((bK, bL) => ({ ...bK[1], ...bL[1] }))))) zaraz.set(bJ[0], bJ[1], { scope: "page" }); bw[by].q = []; for (; bw.zaraz.q.length;) { const bM = bw.zaraz.q.shift(); bw[by].q.push(bM) } bE.defer = !0; for (const bN of [localStorage, sessionStorage]) Object.keys(bN || {}).filter((bP => bP.startsWith("_zaraz_"))).forEach((bO => { try { bw[by]["z_" + bO.slice(7)] = JSON.parse(bN.getItem(bO)) } catch { bw[by]["z_" + bO.slice(7)] = bN.getItem(bO) } })); bE.referrerPolicy = "origin"; bE.src = "../../cdn-cgi/zaraz/sd0d9.js?z=" + btoa(encodeURIComponent(JSON.stringify(bw[by]))); bD.parentNode.insertBefore(bE, bD) };["complete", "interactive"].includes(bx.readyState) ? zaraz.init() : bw.addEventListener("DOMContentLoaded", zaraz.init) }(w, d, "zarazData", "script"); })(window, document);</script>
</head>

<body>
<nav class="navbar py-3 navbar-expand-lg ftco_navbar navbar-light bg-light flex-row">
    <div class="container">
      <div class="row no-gutters d-flex align-items-start align-items-center px-3 px-md-0">
        <div class="col-lg-2 pr-4 align-items-center">
          <a class="navbar-brand" href="index.php"><img src="images/logo.png" style="width: 85%;" alt=""></a>
        </div>
        <div class="col-lg-10 d-none d-md-block">
          <div class="row d-flex">
            <div class="col-md-4 pr-4 d-flex topper align-items-center">
              <div class="icon bg-white circle_border mr-2 d-flex justify-content-center align-items-center"><span
                  class="icon-map"></span></div>
              <span class="text">Address: 1455 Boul. de Maisonneuve O, Montréal, QC H3G 1M8</span>
            </div>
            <div class="col-md pr-4 d-flex topper align-items-center">
              <div class="icon bg-white circle_border mr-2 d-flex justify-content-center align-items-center"><span
                  class="icon-paper-plane"></span></div>
              <span class="text">Email: <a href="healthcare.spm@gmail.com" class="__cf_email__"
                  data-cfemail="">healthcare.spm@gmail.com</a></span>
            </div>
            <div class="col-md pr-4 d-flex topper align-items-center">
              <div class="icon bg-white circle_border mr-2 d-flex justify-content-center align-items-center"><span
                  class="icon-phone2"></span></div>
              <span class="text">Phone: +1 234 567 8901</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
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
          <li class="nav-item active"><a href="contact.php" class="nav-link">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg.jpeg');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center">
          <h1 class="mb-2 bread">Contact Us</h1>
          <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i
                  class="ion-ios-arrow-forward"></i></a></span> <span>Contact <i
                class="ion-ios-arrow-forward"></i></span></p>
        </div>
      </div>
    </div>
  </section>
  <section class="ftco-section mt-5ftco-no-pt ftco-no-pb contact-section">
    <div class="container">
      <div class="row d-flex align-items-stretch no-gutters">
        <div class="col-md-6 p-4 p-md-5 order-md-last" style="padding-top: 2rem !important;">
          <form action="contact.php" method="post" >
          <div class="form-group">
                <!-- <input type="text" class="form-control" placeholder="Your Name*" required> -->
				<input type="text" class="form-control" name="name" id="name" placeholder="Your Name" value="<?php echo htmlspecialchars($name) ?>" required>
              </div>
              <div class="form-group">
                <!-- <input type="email" class="form-control" placeholder="Your Email*" required> -->
				<input type="email" class="form-control" name="email" id="email" placeholder="Your Email" value="<?php echo htmlspecialchars($email) ?>"required>
              </div>
              <div class="form-group">
                <!-- <input type="text" class="form-control" placeholder="Your Mobile Number*" required> -->
				<input type="number" class="form-control" name="phone" id="phone" placeholder="Your Mobile Number" value="<?php echo htmlspecialchars($phone) ?>"required>
              </div>
              <div class="form-group">
			  <!-- <textarea name="" id="" cols="30" rows="4" class="form-control" placeholder="Message*" required></textarea> -->
                <textarea name="message" id="" cols="30" rows="6" class="form-control" placeholder="Message" required><?php echo htmlspecialchars($message) ?></textarea>
              </div>
            <div class="form-group">
              <input type="submit" value="Send Message" name="submit" id="submit" class="btn btn-primary py-3 px-5">
            </div>
          </form>
        </div>
        <div class="col-md-6 d-flex">
          <div id="">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2796.6442297680214!2d-73.58092258459249!3d45.497108579101386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cc91a6a633b679b%3A0xe8bab992db81a44c!2s1455%20Boul.%20de%20Maisonneuve%20Ouest%2C%20Montr%C3%A9al%2C%20QC%20H3G%201M8!5e0!3m2!1sen!2sca!4v1677703729285!5m2!1sen!2sca" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="ftco-section contact-section" style="padding: 3em 0;">
    <div class="container">
      <div class="row d-flex mb-5 contact-info">
        <div class="col-md-12 mb-4">
          <h2 class="h4" style="font-weight: 700; text-decoration: underline; font-size: 26px;">Contact Information:</h2>
        </div>
        <div class="w-100"></div>
        <div class="col-md-4 d-flex">
          <div class="bg-green d-flex align-self-stretch box p-4">
            <p><span>Address:</span> 1455 Boul. de Maisonneuve O, Montréal, QC H3G 1M8</p>
          </div>
        </div>
        <div class="col-md-4 d-flex">
          <div class="bg-green d-flex align-self-stretch box p-4">
            <p><span>Phone:</span> <a href="tel://12345678901">+1 234 567 8901</a></p>
          </div>
        </div>
        <div class="col-md-4 d-flex">
          <div class="bg-green d-flex align-self-stretch box p-4">
            <p><span>Email:</span> <a
                href="mailto:healthcare.spm@gmail.com"><span
                  class="__cf_email__"
                  data-cfemail=""></span>healthcare.spm@gmail.com</a></p>
          </div>
        </div>
        </div>
      </div>
    </div>
  </section>
  <footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
      <div class="row mb-5">
        <div class="col-md">
          <div class="ftco-footer-widget mb-5">
            <div class="mb-3 align-items-center">
              <a class="navbar-brand" href="index.php"><img src="images/logo.png" style="width: 65%;" alt=""></a>
            </div>
            <p>Making Professional Therapy Accessible, Affordable, and Convenient. We attempt to heal the patient by
              setting up an appointment with the finest therapist or physician after analysing their mental state.</p>
          </div>
          <!-- <div class="ftco-footer-widget mb-5">
            <h2 class="ftco-heading-2">Have a Questions?</h2>
            <div class="block-23 mb-3">
              <ul>
                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San
                    Francisco, California, USA</span></li>
                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                <li><a href="#"><span class="icon icon-envelope"></span><span class="text"><span class="__cf_email__"
                        data-cfemail="442d2a222b043d2b3136202b29252d2a6a272b29">[email&#160;protected]</span></span></a>
                </li>
              </ul>
            </div>
            <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-3">
              <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
            </ul>
          </div> -->
        </div>
        <div class="col-md">
          <div class="ftco-footer-widget mb-5 ml-md-4">
            <h2 class="ftco-heading-2">Links</h2>
            <ul class="list-unstyled">
              <li><a href="index.php"><span class="ion-ios-arrow-round-forward mr-2"></span>Home</a></li>
              <li><a href="about.html"><span class="ion-ios-arrow-round-forward mr-2"></span>About Us</a></li>
              <li><a href="counselor.html"><span class="ion-ios-arrow-round-forward mr-2"></span>Counselors</a></li>
              <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Dotors</a></li>
              <li><a href="contact.php"><span class="ion-ios-arrow-round-forward mr-2"></span>Contact Us</a></li>
            </ul>
          </div>
          <!-- <div class="ftco-footer-widget mb-5 ml-md-4">
            <h2 class="ftco-heading-2">Services</h2>
            <ul class="list-unstyled">
              <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Neurolgy</a></li>
              <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Dentist</a></li>
              <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Ophthalmology</a></li>
              <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Cardiology</a></li>
              <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>Surgery</a></li>
            </ul>
          </div> -->
        </div>
        <div class="col-md">
          <!-- <div class="ftco-footer-widget mb-5">
            <h2 class="ftco-heading-2">Recent Blog</h2>
            <div class="block-21 mb-4 d-flex">
              <a class="blog-img mr-4" style="background-image: url(images/image_1.jpg);"></a>
              <div class="text">
                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                <div class="meta">
                  <div><a href="#"><span class="icon-calendar"></span> Dec 25, 2018</a></div>
                  <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                  <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                </div>
              </div>
            </div>
            <div class="block-21 mb-5 d-flex">
              <a class="blog-img mr-4" style="background-image: url(images/image_2.jpg);"></a>
              <div class="text">
                <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                <div class="meta">
                  <div><a href="#"><span class="icon-calendar"></span> Dec 25, 2018</a></div>
                  <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                  <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                </div>
              </div>
            </div>
          </div> -->
          <div class="ftco-footer-widget mb-5">
            <h2 class="ftco-heading-2">Have Questions?</h2>
            <div class="block-23 mb-1">
              <ul>
                <li><span class="icon icon-map-marker"></span><span class="text" style="color: white;">1455 Boul. de
                    Maisonneuve O, Montréal, QC, H3G 1M8</span></li>
                <li><a href="+12345678901"><span class="icon icon-phone"></span><span class="text">+1 234 567
                      8901</span></a></li>
                <li><a href="mailto:healthcare.spm@gmail.com"><span class="icon icon-envelope"></span><span
                      class="text"><span class="__cf_email__" data-cfemail="">healthcare.spm@gmail.com</span></span></a>
                </li>
              </ul>
            </div>
            <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-1">
              <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
              <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md">
          <!-- <div class="ftco-footer-widget mb-5">
            <h2 class="ftco-heading-2">Opening Hours</h2>
            <h3 class="open-hours pl-4"><span class="ion-ios-time mr-3"></span>We are open 24/7</h3>
          </div> -->
          <div class="ftco-footer-widget mb-5">
            <h2 class="ftco-heading-2">Subscribe Us!</h2>
            <form action="#" class="subscribe-form">
              <div class="form-group">
                <input type="email" class="form-control mb-2 text-center" placeholder="Enter email address">
                <input type="submit" value="Subscribe" class="form-control submit px-3">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="container" style="max-width: 100%; margin: auto 0; ">
      <div class="row">
        <div class="text-center" style="width: 100%;">
          <p
            style="margin: 0px auto !important; padding-top: 7px; padding-bottom: 7px; background: #398378; color: white;">
            Copyright &copy;
            <script data-cfasync="false"
              src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
            <script>document.write(new Date().getFullYear());</script> All rights reserved | This Website is made with
            <i class="icon-heart" aria-hidden="true"></i> by Team 5
          </p>
        </div>
      </div>
    </div>
  </footer>

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
  <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vaafb692b2aea4879b33c060e79fe94621666317369993"
    integrity="sha512-0ahDYl866UMhKuYcW078ScMalXqtFJggm7TmlUtp0UlD4eQk0Ixfnm5ykXKvGJNFjLMoortdseTfsRT8oCfgGA=="
    data-cf-beacon='{"rayId":"79e5c0415cd98cab","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2023.2.0","si":100}'
    crossorigin="anonymous"></script>
</body>

</html>