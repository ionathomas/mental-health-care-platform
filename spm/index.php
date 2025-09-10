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
Email: $email
Phone Number: $phone
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
<!-- git add .
git commit -m "test"
git push -u origin main -->

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
  <script nonce="dc1d99de-fc6c-4768-8c18-a9384351bf71">
    (function (w, d) { !function (bw, bx, by, bz) { bw[by] = bw[by] || {}; bw[by].executed = []; bw.zaraz = { deferred: [], listeners: [] }; bw.zaraz.q = []; bw.zaraz._f = function (bA) { return function () { var bB = Array.prototype.slice.call(arguments); bw.zaraz.q.push({ m: bA, a: bB }) } }; for (const bC of ["track", "set", "debug"]) bw.zaraz[bC] = bw.zaraz._f(bC); bw.zaraz.init = () => { var bD = bx.getElementsByTagName(bz)[0], bE = bx.createElement(bz), bF = bx.getElementsByTagName("title")[0]; bF && (bw[by].t = bx.getElementsByTagName("title")[0].text); bw[by].x = Math.random(); bw[by].w = bw.screen.width; bw[by].h = bw.screen.height; bw[by].j = bw.innerHeight; bw[by].e = bw.innerWidth; bw[by].l = bw.location.href; bw[by].r = bx.referrer; bw[by].k = bw.screen.colorDepth; bw[by].n = bx.characterSet; bw[by].o = (new Date).getTimezoneOffset(); if (bw.dataLayer) for (const bJ of Object.entries(Object.entries(dataLayer).reduce(((bK, bL) => ({ ...bK[1], ...bL[1] }))))) zaraz.set(bJ[0], bJ[1], { scope: "page" }); bw[by].q = []; for (; bw.zaraz.q.length;) { const bM = bw.zaraz.q.shift(); bw[by].q.push(bM) } bE.defer = !0; for (const bN of [localStorage, sessionStorage]) Object.keys(bN || {}).filter((bP => bP.startsWith("_zaraz_"))).forEach((bO => { try { bw[by]["z_" + bO.slice(7)] = JSON.parse(bN.getItem(bO)) } catch { bw[by]["z_" + bO.slice(7)] = bN.getItem(bO) } })); bE.referrerPolicy = "origin"; bE.src = "../../cdn-cgi/zaraz/sd0d9.js?z=" + btoa(encodeURIComponent(JSON.stringify(bw[by]))); bD.parentNode.insertBefore(bE, bD) };["complete", "interactive"].includes(bx.readyState) ? zaraz.init() : bw.addEventListener("DOMContentLoaded", zaraz.init) }(w, d, "zarazData", "script"); })(window, document);</script>
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
          <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
          <li class="nav-item "><a href="about.html" class="nav-link">About Us</a></li>
          <li class="nav-item"><a href="counselor.html" class="nav-link">Counselors</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Doctors</a></li>
          <li class="nav-item"><a href="contact.php" class="nav-link">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image:url(images/bg.jpeg);" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-12 text ftco-animate">
            <h1 class="mb-4">Healing Minds <span>Transforming Lives</span></h1>
            <h3 class="subheading">Help you finding hope and healing through mental wellness.</h3>
            <!-- <p><a href="#" class="btn btn-secondary px-4 py-3 mt-3">View our works</a></p> -->
          </div>
        </div>
      </div>
    </div>
    <div class="slider-item" style="background-image:url(images/bg1.jpeg);">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-12 text ftco-animate">
            <h1 class="mb-4">We Care <span>About Your Health</span></h1>
            <h3 class="subheading">Your Health is Our Top Priority with Comprehensive and Affordable medical.</h3>
            <!-- <p><a href="#" class="btn btn-secondary px-4 py-3 mt-3">View our works</a></p> -->
          </div>
        </div>
      </div>
    </div>
    <div class="slider-item" style="background-image:url(images/bg2.webp);">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-12 text ftco-animate">
            <h1 class="mb-4">Helping You <span>Stay Happy One</span></h1>
            <h3 class="subheading">Everyday We Bring Hope and Smile to the Patient We Serve.</h3>
            
            <!-- <p><a href="#" class="btn btn-secondary px-4 py-3 mt-3">View our works</a></p> -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="ftco-services ftco-no-pb">
    <div class="container">
      <div class="row no-gutters">
        <div class="col-md-3 d-flex services align-self-stretch p-4 ftco-animate">
          <div class="media block-6 d-block text-center">
            <div class="icon d-flex justify-content-center align-items-center">
              <span class="flaticon-doctor"></span>
            </div>
            <div class="media-body p-2 mt-3">
              <h3 class="heading">Qualified Providers</h3>
              <p>Our network of providers offers a range of expertise to meet your particular needs.</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 d-flex services align-self-stretch p-4 ftco-animate">
          <div class="media block-6 d-block text-center">
            <div class="icon d-flex justify-content-center align-items-center">
              <span class="flaticon-ambulance"></span>
            </div>
            <div class="media-body p-2 mt-3">
              <h3 class="heading">Emergency Care</h3>
              <p>Providing patients with compassionate and expertise urgent care.</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 d-flex services align-self-stretch p-4 ftco-animate">
          <div class="media block-6 d-block text-center">
            <div class="icon d-flex justify-content-center align-items-center">
              <span class="flaticon-stethoscope"></span>
            </div>
            <div class="media-body p-2 mt-3">
              <h3 class="heading">Mental Health Tips</h3>
              <p>For a happier existence, look after your intellect by getting healthy tips.</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 d-flex services align-self-stretch p-4 ftco-animate">
          <div class="media block-6 d-block text-center">
            <div class="icon d-flex justify-content-center align-items-center">
              <span class="flaticon-24-hours"></span>
            </div>
            <div class="media-body p-2 mt-3">
              <h3 class="heading">24 Hours Service</h3>
              <p>Day or night, get professional treatment when you need it from HealthCare.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="ftco-section ftco-no-pt ftc-no-pb">
    <div class="container">
      <div class="row no-gutters">
        <div class="col-md-7 wrap-about py-4 py-md-5 ftco-animate">
          <div class="heading-section mb-4">
            <div class="pr-md-5 mr-md-5">
              <span class="subheading">About HEALTHCARE</span>
              <h2 class="mb-4" style="font-size: 28px;">Making Professional Therapy Accessible, Affordable, and
                Convenient</h2>
            </div>
          </div>
          <div class="pr-md-5 mr-md-5 mb-3">
            <p>With a web-based platform called HealthCare, individuals may make connections with qualified counsellors
              and medical professionals. We attempt to heal the patient by setting up an appointment with the finest
              therapist or physician after analysing their mental state.</p>
            <div class="row mt-4 pt-2">
              <div class="col-lg-6">
                <div class="services-2 d-flex">
                  <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                      class="flaticon-first-aid-kit"></span></div>
                  <div class="text">
                    <h3>Register Yourself</h3>
                    <p>You should sign up for getting help from licensed & professional providers</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="services-2 d-flex">
                  <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                      class="flaticon-experiment-results"></span></div>
                  <div class="text">
                    <h3>Self Assessment Test</h3>
                    <p>Answer a few questions about your preferences.</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="services-2 d-flex">
                  <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                      class="flaticon-doctor"></span></div>
                  <div class="text">
                    <h3>Match with Counselor or Doctor</h3>
                    <p>Your test results will be consider for understanding your mental state</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="services-2 d-flex">
                  <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                      class="flaticon-stethoscope"></span></div>
                  <div class="text">
                    <h3>Start Therapy</h3>
                    <p>Start the path to a happy version of yourself.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5 p-md-5 img img-2 mt-5 mt-md-0" style="background-image: url(images/about1.jpg);">
        </div>
      </div>
    </div>
  </section>
  <section class="ftco-intro" style="background-image: url(images/bg_3.jpg);" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-md-9">
          <h2>We Provide Best Mental Health Consultation</h2>
          <p class="mb-0">Your Health is Our Top Priority with Comprehensive, Affordable medical.</p>
          <p></p>
        </div>
        <div class="col-md-3 d-flex align-items-center">
          <p class="mb-0"><a href="authenticate.php" target="_blank" class="btn btn-secondary px-4 py-3">Register Here</a></p>
        </div>
      </div>
    </div>
  </section>
  <section class="ftco-section" style="background-color: #fafafa;">
    <div class="container">
      <div class="row no-gutters">
        <div class="col-md-5 p-md-5 img img-2 mt-5 mt-md-0" style="padding-right: 0 !important;">
          <div id="slideshow">
            <div class="slide-wrapper">
              <div class="slide">
                <img src="images/img2.png" alt="">
              </div>
              <div class="slide">
                <img src="images/img1.png" alt="">
              </div>
              <div class="slide">
                <img src="images/img3.png" alt="">
              </div>
              <div class="slide">
                <img src="images/img4.png" alt="">
              </div>
              <div class="slide">
                <img src="images/img2.png" alt="">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-7 wrap-about py-4 py-md-5 mt-3 ftco-animate">
          <div class="heading-section mb-4">
            <div class="pl-md-5 ml-md-5">
              <span class="subheading">Meet licensed providers</span>
              <h2 class="mb-4" style="font-size: 28px; text-transform: capitalize;">Trustworthy Therapists Who Are Skilled, Licensed, And Vetted</h2>
            </div>
          </div>
          <div class="pl-md-5 ml-md-5 mb-3">
            <p style="margin-bottom: 0;">Register for a meeting with qualified, certified, and experienced therapists who can assist you with a variety of problems. To address your unique needs, our network of providers offers a variety of specialties. Get paired right now!</p>
            <div class="row mt-2 pt-2">
              <div class="">
                <div class="services-2 d-flex">
                  <ul role="list" class="c-providers__list w-list-unstyled">
                    <li class="c-providers__list-item">
                      <div>Depression</div>
                    </li>
                    <li class="c-providers__list-item">
                      <div>Relationships</div>
                    </li>
                    <li class="c-providers__list-item">
                      <div>Anxiety &amp; Stress</div>
                    </li>
                    <li class="c-providers__list-item">
                      <div>Parenting</div>
                    </li>
                    <li class="c-providers__list-item">
                      <div>LGBTQIA+</div>
                    </li>
                    <li class="c-providers__list-item">
                      <div>Chronic illness</div>
                    </li>
                    <li class="c-providers__list-item">
                      <div>Eating disorders</div>
                    </li>
                    <li class="c-providers__list-item">
                      <div>Anger management</div>
                    </li>
                    <li class="c-providers__list-item">
                      <div>Childhood abuse</div>
                    </li>
                    <li class="c-providers__list-item">
                      <div>Mood disorders</div>
                    </li>
                    <li class="c-providers__list-item">
                      <div>OCD</div>
                    </li>
                    <li class="c-providers__list-item">
                      <div>Trauma &amp; grief</div>
                    </li>
                    <li class="c-providers__list-item">
                      <div>Substance abuse</div>
                    </li>
                    <li class="c-providers__list-item">
                      <div>Family conflict</div>
                    </li>
                      <!-- <li class="c-providers__list-item mobile">
                        <div>Bipolar disorder</div>
                      </li> -->
                    <li class="c-providers__list-item no-checkmark">
                      <div>and more...</div>
                    </li>
                  </ul>
                </div>
              </div>  
            </div>
            <p style="font-weight: 500; font-size: 17px; margin-bottom: 0;" class="pa">Are you a Therapist?&nbsp;<a href="joinourorganisation.html" rel="noopener noreferrer" style="font-weight: 700; color: #398378;">Join our organization</a></p>
          </div>
        </div>

      </div>
    </div>
  </section>
  <section class="ftco-section">
    <div class="container">
      <div class="row justify-content-center mb-4 pb-2">
        <div class="col-md-8 text-center heading-section ftco-animate">
          <span class="subheading">Therapies</span>
          <h2 class="mb-4">Major Psychotherapies</h2>
          <p>Therapy is a depression treatment. Therapists use a range of therapeutic techniques to help their patients
            overcome depression. </p>
        </div>
      </div>
      <div class="ftco-departments">
        <div class="row">
          <div class="col-md-12 nav-link-wrap">
            <div class="nav nav-pills d-flex text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link ftco-animate active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab"
                aria-controls="v-pills-1" aria-selected="true">Cognitive-Behavioral Therapy</a>
              <a class="nav-link ftco-animate" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab"
                aria-controls="v-pills-2" aria-selected="false">Dialectical Behavior Therapy</a>
              <a class="nav-link ftco-animate" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab"
                aria-controls="v-pills-3" aria-selected="false">&nbsp;&nbsp;Trauma - Based Therapy&nbsp;</a>
              <a class="nav-link ftco-animate" id="v-pills-4-tab" data-toggle="pill" href="#v-pills-4" role="tab"
                aria-controls="v-pills-4" aria-selected="false">Acceptance and Commitment Therapy</a>
            </div>
          </div>
          <div class="col-md-12 tab-wrap">
            <div class="tab-content bg-light p-4 p-md-5 ftco-animate" id="v-pills-tabContent">
              <div class="tab-pane py-2 fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="day-1-tab">
                <div class="row departments">
                  <div class="col-lg-6 order-lg-last d-flex align-items-stretch">
                    <div class="img d-flex align-self-stretch" style="background-image: url(images/therapy1.png);">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <h2>Cognitive-Behavioral Therapy (CBT)</h2>
                    <p>Cognitive-Behavioral Therapy (CBT) is a form of psychotherapy that tries to assist people in
                      identifying and changing negative thinking patterns and behaviours that lead to depression.</p>
                    <p>It is a systematic, brief treatment based on the premise that how we think about circumstances
                      and events influences our emotions and behaviour. Different methods used by CBT are:
                    </p>
                    <ul>
                      <li>
                        Cognitive restructuring
                      </li>
                      <li>
                        Behavioral activation
                      </li>
                      <li>
                        Exposure therapy
                      </li>
                    </ul>
                    <!-- <div class="row mt-5 pt-2">
                      <div class="col-lg-6">
                        <div class="services-2 d-flex">
                          <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                              class="flaticon-first-aid-kit"></span></div>
                          <div class="text">
                            <h3>Primary Care</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia.</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="services-2 d-flex">
                          <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                              class="flaticon-dropper"></span></div>
                          <div class="text">
                            <h3>Lab Test</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia.</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="services-2 d-flex">
                          <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                              class="flaticon-experiment-results"></span></div>
                          <div class="text">
                            <h3>Symptom Check</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia.</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="services-2 d-flex">
                          <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                              class="flaticon-heart-rate"></span></div>
                          <div class="text">
                            <h3>Heart Rate</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia.</p>
                          </div>
                        </div>
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-day-2-tab">
                <div class="row departments">
                  <div class="col-lg-6 order-lg-last d-flex align-items-stretch">
                    <div class="img img2 d-flex align-self-stretch" style="background-image: url(images/therapy2.png);">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h2>Dialectical Behavior Therapy (DBT)</h2>
                    <p>Dialectical Behavior Therapy (DBT) is a cognitive-behavioral treatment that was created to treat
                      borderline personality disorder.</p>
                    <p>DBT incorporates components of mindfulness and acceptance-based treatments into classic
                      cognitive-behavioral approaches. The treatment focuses on teaching people how to control their
                      emotions, enhance their relationships, and increase their ability to bear discomfort. Different
                      methods used by DBT are:</p>
                    <ul>
                      <li>Mindfulness</li>
                      <li>Emotion regulation</li>
                      <li>Distress tolerance</li>
                      <li>Interpersonal effectiveness
                      </li>
                    </ul>
                    <!-- <div class="row mt-5 pt-2">
                      <div class="col-lg-6">
                        <div class="services-2 d-flex">
                          <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                              class="flaticon-first-aid-kit"></span></div>
                          <div class="text">
                            <h3>Primary Care</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia.</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="services-2 d-flex">
                          <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                              class="flaticon-dropper"></span></div>
                          <div class="text">
                            <h3>Lab Test</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia.</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="services-2 d-flex">
                          <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                              class="flaticon-experiment-results"></span></div>
                          <div class="text">
                            <h3>Symptom Check</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia.</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="services-2 d-flex">
                          <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                              class="flaticon-heart-rate"></span></div>
                          <div class="text">
                            <h3>Heart Rate</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia.</p>
                          </div>
                        </div>
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-day-3-tab">
                <div class="row departments">
                  <div class="col-lg-6 order-lg-last d-flex align-items-stretch">
                    <div class="img img1 d-flex align-self-stretch" style="background-image: url(images/therapy3.png);">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h2>Trauma-Based Therapy</h2>
                    <p>One type of treatment that might assist you in coping with the emotional reaction brought on by a
                      traumatic incident is trauma therapy.
                    </p>
                    <p>You may benefit from this type of treatment if you are struggling to deal with your trauma or if
                      it is interfering with your ability to carry out daily tasks.
                      Different methods used by TBT are:</p>
                    <ul>
                      <li>Imaginal exposure</li>
                      <li>In vivo exposure</li>
                      <li>Written account</li>
                      <li>Impact statement</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-day-4-tab">
                <div class="row departments">
                  <div class="col-lg-6 order-lg-last d-flex align-items-stretch">
                    <div class="img img1 d-flex align-self-stretch" style="background-image: url(images/therapy.png);">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h2>Acceptance and Commitment Therapy (ACT)</h2>
                    <p>To assist people in accepting their existing reality, attending to their own beliefs, and acting
                      to make significant changes that improve their physical and mental well-being and build meaningful
                      lives, ACT was evolved from classic cognitive-based techniques.</p>
                    <p>ACT is a shorter-term therapy that has been proven effective now in treating a variety of mental
                      health challenges, including depression, anxiety and chronic pain.</p>
                  </div>
                </div>
              </div>
              <!-- <div class="tab-pane fade" id="v-pills-5" role="tabpanel" aria-labelledby="v-pills-day-5-tab">
                <div class="row departments">
                  <div class="col-lg-4 order-lg-last d-flex align-items-stretch">
                    <div class="img d-flex align-self-stretch" style="background-image: url(images/dept-5.jpg);"></div>
                  </div>
                  <div class="col-md-8">
                    <h2>Cardiology Deparments</h2>
                    <p>On her way she met a copy. The copy warned the Little Blind Text, that where it came from it
                      would have been rewritten a thousand times and everything that was left from its origin would be
                      the word.</p>
                    <div class="row mt-5 pt-2">
                      <div class="col-md-6">
                        <div class="services-2 d-flex">
                          <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                              class="flaticon-idea"></span></div>
                          <div class="text">
                            <h3>Primary Care</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia.</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="services-2 d-flex">
                          <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                              class="flaticon-idea"></span></div>
                          <div class="text">
                            <h3>Lab Test</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia.</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="services-2 d-flex">
                          <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                              class="flaticon-idea"></span></div>
                          <div class="text">
                            <h3>Symptom Check</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia.</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="services-2 d-flex">
                          <div class="icon mt-2 mr-3 d-flex justify-content-center align-items-center"><span
                              class="flaticon-idea"></span></div>
                          <div class="text">
                            <h3>Heart Rate</h3>
                            <p>Far far away, behind the word mountains, far from the countries Vokalia.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- <section class="ftco-section ftco-no-pt">
    <div class="container">
      <div class="row justify-content-center mb-5 pb-2">
        <div class="col-md-8 text-center heading-section ftco-animate">
          <span class="subheading">Doctors</span>
          <h2 class="mb-4">Our Qualified Doctors</h2>
          <p>Separated they live in. A small river named Duden flows by their place and supplies it with the necessary
            regelialia. It is a paradisematic country</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3 ftco-animate">
          <div class="staff">
            <div class="img-wrap d-flex align-items-stretch">
              <div class="img align-self-stretch" style="background-image: url(images/doc-1.jpg);"></div>
            </div>
            <div class="text pt-3 text-center">
              <h3>Dr. Lloyd Wilson</h3>
              <span class="position mb-2">Neurologist</span>
              <div class="faded">
                <p>I am an ambitious workaholic, but apart from that, pretty simple person.</p>
                <ul class="ftco-social text-center">
                  <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 ftco-animate">
          <div class="staff">
            <div class="img-wrap d-flex align-items-stretch">
              <div class="img align-self-stretch" style="background-image: url(images/doc-2.jpg);"></div>
            </div>
            <div class="text pt-3 text-center">
              <h3>Dr. Rachel Parker</h3>
              <span class="position mb-2">Ophthalmologist</span>
              <div class="faded">
                <p>I am an ambitious workaholic, but apart from that, pretty simple person.</p>
                <ul class="ftco-social text-center">
                  <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 ftco-animate">
          <div class="staff">
            <div class="img-wrap d-flex align-items-stretch">
              <div class="img align-self-stretch" style="background-image: url(images/doc-3.jpg);"></div>
            </div>
            <div class="text pt-3 text-center">
              <h3>Dr. Ian Smith</h3>
              <span class="position mb-2">Dentist</span>
              <div class="faded">
                <p>I am an ambitious workaholic, but apart from that, pretty simple person.</p>
                <ul class="ftco-social text-center">
                  <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 ftco-animate">
          <div class="staff">
            <div class="img-wrap d-flex align-items-stretch">
              <div class="img align-self-stretch" style="background-image: url(images/doc-4.jpg);"></div>
            </div>
            <div class="text pt-3 text-center">
              <h3>Dr. Alicia Henderson</h3>
              <span class="position mb-2">Pediatrician</span>
              <div class="faded">
                <p>I am an ambitious workaholic, but apart from that, pretty simple person.</p>
                <ul class="ftco-social text-center">
                  <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
                  <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <!-- <section class="ftco-section testimony-section bg-light">
    <div class="container">
      <div class="row justify-content-center mb-5 pb-2">
        <div class="col-md-8 text-center heading-section ftco-animate">
          <span class="subheading">Testimonials</span>
          <h2 class="mb-4">Our Patients Says About Us</h2>
          <p>Separated they live in. A small river named Duden flows by their place and supplies it with the necessary
            regelialia. It is a paradisematic country</p>
        </div>
      </div>
      <div class="row ftco-animate justify-content-center">
        <div class="col-md-8">
          <div class="carousel-testimony owl-carousel">
            <div class="item">
              <div class="testimony-wrap d-flex">
                <div class="user-img mr-4" style="background-image: url(images/person_1.jpg)">
                </div>
                <div class="text ml-2 bg-light">
                  <span class="quote d-flex align-items-center justify-content-center">
                    <i class="icon-quote-left"></i>
                  </span>
                  <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live
                    the blind texts.</p>
                  <p class="name">Racky Henderson</p>
                  <span class="position">Farmer</span>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="testimony-wrap d-flex">
                <div class="user-img mr-4" style="background-image: url(images/person_2.jpg)">
                </div>
                <div class="text ml-2 bg-light">
                  <span class="quote d-flex align-items-center justify-content-center">
                    <i class="icon-quote-left"></i>
                  </span>
                  <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live
                    the blind texts.</p>
                  <p class="name">Henry Dee</p>
                  <span class="position">Businessman</span>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="testimony-wrap d-flex">
                <div class="user-img mr-4" style="background-image: url(images/person_3.jpg)">
                </div>
                <div class="text ml-2 bg-light">
                  <span class="quote d-flex align-items-center justify-content-center">
                    <i class="icon-quote-left"></i>
                  </span>
                  <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live
                    the blind texts.</p>
                  <p class="name">Mark Huff</p>
                  <span class="position">Students</span>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="testimony-wrap d-flex">
                <div class="user-img mr-4" style="background-image: url(images/person_4.jpg)">
                </div>
                <div class="text ml-2 bg-light">
                  <span class="quote d-flex align-items-center justify-content-center">
                    <i class="icon-quote-left"></i>
                  </span>
                  <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live
                    the blind texts.</p>
                  <p class="name">Rodel Golez</p>
                  <span class="position">Striper</span>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="testimony-wrap d-flex">
                <div class="user-img mr-4" style="background-image: url(images/person_1.jpg)">
                </div>
                <div class="text ml-2 bg-light">
                  <span class="quote d-flex align-items-center justify-content-center">
                    <i class="icon-quote-left"></i>
                  </span>
                  <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live
                    the blind texts.</p>
                  <p class="name">Ken Bosh</p>
                  <span class="position">Manager</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <section class="ftco-section ftco-no-pt ftco-no-pb ftco-counter img" id="section-counter"
    style="background-image: url(images/bg_3.jpg);" data-stellar-background-ratio="0.5">
    <div class="container">
      <div class="row">
        <div class="col-md-6 py-5 pr-md-5 mtmb">

		<!-- Inquiry Form -->
          <div class="heading-section heading-section-white ftco-animate mb-5">
            <span class="subheading">Consultation</span>
            <h2 class="mb-4">Inquiry for Consultation</h2>
            <p>Please use this form to inquire about us or contact us and we will get back to you as soon as possible!
            </p>
          </div>
          <form action="index.php" method="post" class="appointment-form ftco-animate">
            <div class="d-md-flex">
              <div class="form-group">
                <!-- <input type="text" class="form-control" placeholder="Your Name*" required> -->
				<input type="text" class="form-control" name="name" id="name" placeholder="Your Name" value="<?php echo htmlspecialchars($name) ?>" required>
              </div>
            </div>
            <div class="d-md-flex">
              <div class="form-group">
                <!-- <input type="email" class="form-control" placeholder="Your Email*" required> -->
				<input type="email" class="form-control" name="email" id="email" placeholder="Your Email" value="<?php echo htmlspecialchars($email) ?>"required>
              </div>
            </div>
            <div class="d-md-flex">
              <div class="form-group">
                <!-- <input type="text" class="form-control" placeholder="Your Mobile Number*" required> -->
				<input type="number" class="form-control" name="phone" id="phone" placeholder="Your Mobile Number" value="<?php echo htmlspecialchars($phone) ?>"required>
              </div>
            </div>
            <div class="d-md-flex">
              <div class="form-group">
			  <!-- <textarea name="" id="" cols="30" rows="4" class="form-control" placeholder="Message*" required></textarea> -->
                <textarea name="message" id="" cols="30" rows="4" class="form-control" placeholder="Message" required><?php echo htmlspecialchars($message) ?></textarea>
              </div>
            </div>
            <div class="d-md-flex">
              <div class="form-group">
                <input type="submit" value="Send" name="submit" id="submit" class="btn btn-secondary1 py-3 px-3">
              </div>
            </div>
          </form>
        </div>




        <div class="col-lg-6 p-5 bg-counter aside-stretch">
          <h3 class="vr">About HealthCare Facts</h3>
          <div class="row pt-4 mt-1">
            <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
              <div class="block-18 p-5 bg-light">
                <div class="text">
                  <strong class="number" data-number="2">0</strong>
                  <span>Years of Experience</span>
                </div>
              </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
              <div class="block-18 p-5 bg-light">
                <div class="text">
                  <strong class="number" data-number="45">0</strong>
                  <span>Number of Happy Patients</span>
                </div>
              </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
              <div class="block-18 p-5 bg-light">
                <div class="text">
                  <strong class="number" data-number="8">0</strong>
                  <span>Number of Counselors</span>
                </div>
              </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
              <div class="block-18 p-5 bg-light">
                <div class="text">
                  <strong class="number" data-number="7">0</strong>
                  <span>Number of Doctors</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- <section class="ftco-section bg-light">
    <div class="container">
      <div class="row justify-content-center mb-5 pb-2">
        <div class="col-md-8 text-center heading-section ftco-animate">
          <span class="subheading">Pricing</span>
          <h2 class="mb-4">Our Pricing</h2>
          <p>Separated they live in. A small river named Duden flows by their place and supplies it with the necessary
            regelialia. It is a paradisematic country</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 ftco-animate">
          <div class="pricing-entry pb-5 text-center">
            <div>
              <h3 class="mb-4">Basic</h3>
              <p><span class="price">$24.50</span> <span class="per">/ session</span></p>
            </div>
            <ul>
              <li>Diagnostic Services</li>
              <li>Professional Consultation</li>
              <li>Tooth Implants</li>
              <li>Surgical Extractions</li>
              <li>Teeth Whitening</li>
            </ul>
            <p class="button text-center"><a href="#" class="btn btn-primary px-4 py-3">Get Offer</a></p>
          </div>
        </div>
        <div class="col-md-3 ftco-animate">
          <div class="pricing-entry pb-5 text-center">
            <div>
              <h3 class="mb-4">Standard</h3>
              <p><span class="price">$34.50</span> <span class="per">/ session</span></p>
            </div>
            <ul>
              <li>Diagnostic Services</li>
              <li>Professional Consultation</li>
              <li>Tooth Implants</li>
              <li>Surgical Extractions</li>
              <li>Teeth Whitening</li>
            </ul>
            <p class="button text-center"><a href="#" class="btn btn-primary px-4 py-3">Get Offer</a></p>
          </div>
        </div>
        <div class="col-md-3 ftco-animate">
          <div class="pricing-entry active pb-5 text-center">
            <div>
              <h3 class="mb-4">Premium</h3>
              <p><span class="price">$54.50</span> <span class="per">/ session</span></p>
            </div>
            <ul>
              <li>Diagnostic Services</li>
              <li>Professional Consultation</li>
              <li>Tooth Implants</li>
              <li>Surgical Extractions</li>
              <li>Teeth Whitening</li>
            </ul>
            <p class="button text-center"><a href="#" class="btn btn-primary px-4 py-3">Get Offer</a></p>
          </div>
        </div>
        <div class="col-md-3 ftco-animate">
          <div class="pricing-entry pb-5 text-center">
            <div>
              <h3 class="mb-4">Platinum</h3>
              <p><span class="price">$89.50</span> <span class="per">/ session</span></p>
            </div>
            <ul>
              <li>Diagnostic Services</li>
              <li>Professional Consultation</li>
              <li>Tooth Implants</li>
              <li>Surgical Extractions</li>
              <li>Teeth Whitening</li>
            </ul>
            <p class="button text-center"><a href="#" class="btn btn-primary px-4 py-3">Get Offer</a></p>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <!-- <section class="ftco-section bg-light">
    <div class="container">
      <div class="row justify-content-center mb-5 pb-2">
        <div class="col-md-8 text-center heading-section ftco-animate">
          <span class="subheading">Blog</span>
          <h2 class="mb-4">Recent Blog</h2>
          <p>Separated they live in. A small river named Duden flows by their place and supplies it with the necessary
            regelialia. It is a paradisematic country</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 ftco-animate">
          <div class="blog-entry">
            <a href="blog-single.html" class="block-20" style="background-image: url('images/image_1.jpg');">
              <div class="meta-date text-center p-2">
                <span class="day">23</span>
                <span class="mos">January</span>
                <span class="yr">2019</span>
              </div>
            </a>
            <div class="text bg-white p-4">
              <h3 class="heading"><a href="#">Scary Thing That You Don’t Get Enough Sleep</a></h3>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the
                blind texts.</p>
              <div class="d-flex align-items-center mt-4">
                <p class="mb-0"><a href="#" class="btn btn-primary">Read More <span
                      class="ion-ios-arrow-round-forward"></span></a></p>
                <p class="ml-auto mb-0">
                  <a href="#" class="mr-2">Admin</a>
                  <a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 ftco-animate">
          <div class="blog-entry">
            <a href="blog-single.html" class="block-20" style="background-image: url('images/image_2.jpg');">
              <div class="meta-date text-center p-2">
                <span class="day">23</span>
                <span class="mos">January</span>
                <span class="yr">2019</span>
              </div>
            </a>
            <div class="text bg-white p-4">
              <h3 class="heading"><a href="#">Scary Thing That You Don’t Get Enough Sleep</a></h3>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the
                blind texts.</p>
              <div class="d-flex align-items-center mt-4">
                <p class="mb-0"><a href="#" class="btn btn-primary">Read More <span
                      class="ion-ios-arrow-round-forward"></span></a></p>
                <p class="ml-auto mb-0">
                  <a href="#" class="mr-2">Admin</a>
                  <a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 ftco-animate">
          <div class="blog-entry">
            <a href="blog-single.html" class="block-20" style="background-image: url('images/image_3.jpg');">
              <div class="meta-date text-center p-2">
                <span class="day">23</span>
                <span class="mos">January</span>
                <span class="yr">2019</span>
              </div>
            </a>
            <div class="text bg-white p-4">
              <h3 class="heading"><a href="#">Scary Thing That You Don’t Get Enough Sleep</a></h3>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the
                blind texts.</p>
              <div class="d-flex align-items-center mt-4">
                <p class="mb-0"><a href="#" class="btn btn-primary">Read More <span
                      class="ion-ios-arrow-round-forward"></span></a></p>
                <p class="ml-auto mb-0">
                  <a href="#" class="mr-2">Admin</a>
                  <a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
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
    data-cf-beacon='{"rayId":"79e5c037dab0c42a","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2023.2.0","si":100}'
    crossorigin="anonymous"></script>
</body>

</html>