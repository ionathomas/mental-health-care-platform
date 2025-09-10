<?php

    session_start();
    include "../../db_conn.php";

    if(isset($_SESSION['UserName'])){
        $FullName = $_SESSION['FullName'];
        $UserName = $_SESSION['UserName'];
        $UserCategory = $_SESSION['UserCategory'];

        $flag=0;
        $sql="SELECT * FROM assessmentresults WHERE UserName = '$UserName'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0)
          $flag=1;
        else{
          if(isset($_POST['question-1'])){
            $score=0;
            $qs="";
            for($i=0;$i<9;$i++){
              $score += $_POST['question-'.$i];
              $qs.=$_POST['question-'.$i];
            }
            $sql2="INSERT INTO assessmentresults(UserName, Result, Score) VALUES ('$UserName','$qs',$score)";
            if(mysqli_query($conn,$sql2))
              $flag=2;
            else
              echo "<script>alert('Error submitting the test. Try again later'); window.open('index.php','_self');</script>";
          }
        }
        

    }
    else{
        echo "<script>alert('Error opening the page. Try again later'); window.open('index.php','_self');</script>";
        exit();
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>HealthCare - Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="../assets/css/demo/style.css">

  <!-- End layout styles -->
  <link rel="shortcut icon" href="../assets/images/favicon.ico" />
  <link rel="stylesheet" href="../assets/css/my_style.css">
  <style>
    .mdc-drawer__header a {
      display: flex !important;
      justify-content: center;
      background-color: white;
    }

    .mdc-drawer__header img {
      width: 55%;
    }

    .bell i.mdi-bell {
      font-size: 1.25rem !important;
      margin-right: 0.562rem !important;
    }
  </style>
  <link href="https://fonts.googleapis.com/css?family=Lato:400,500,700%7CMontserrat:400,700" rel="stylesheet"
    type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/css/assessment.css">
  <style>
    #start-button.btn,
    form .btn {
      border-radius: 5px;
      margin: 0;
      margin-top: 20px;
      margin-bottom: 10px;
      border: 1px solid #398378;
      background-color: #398378;
      color: #FFFFFF;
      font-size: 13px;
      font-weight: bold;
      padding: 12px 35px;
      letter-spacing: 1px;
      text-transform: uppercase;
      cursor: pointer;
    }

    form .btn {
      margin-bottom: 0;
    }

    #start-button.btn:hover,
    form .btn:hover {
      border: 1px solid #398378;
      background-color: #fff;
      color: #398378;
    }
  </style>
</head>

<body>
  <div class="body-wrapper">
    <!-- partial:../../partials/_sidebar.html -->
    <aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
      <div class="mdc-drawer__header">
        <a href="../../../index.php" class="brand-logo">
          <img src="../assets/images/logo.png" alt="logo">
        </a>
      </div>
      <div class="mdc-drawer__content">
        <div class="user-info">
          <p class="name" id="name"></p>
          <p class="email" id="email"></p>
        </div>
        <div class="mdc-list-group">
          <nav class="mdc-list mdc-drawer-menu">
            <!-- <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="../index.html">
                <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">home</i>
                Dashboard
              </a>
            </div> -->
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="self-assessment-test.php">
                <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                  aria-hidden="true">track_changes</i>
                Self Assessment Test
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link bell" href="notification_patient.php">
                <i class="material-icons mdi mdi-bell"></i>
                Notifications
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="edit-profile.php">
                <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                  aria-hidden="true">description</i>
                Edit Profile
              </a>
            </div>
          </nav>
        </div>
        <div class="profile-actions">
          <a href="../../logout.php"><i class="mdi mdi-logout-variant"></i> Logout</a>
        </div>
      </div>
    </aside>
    <!-- partial -->
    <div class="main-wrapper mdc-drawer-app-content">
      <!-- partial:../../partials/_navbar.html -->
      <header class="mdc-top-app-bar">
        <div class="mdc-top-app-bar__row">
          <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button
              class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button sidebar-toggler">menu</button>
            <span class="mdc-top-app-bar__title" id="greeting_msg"></span>
          </div>
          <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end mdc-top-app-bar__section-right">
            <div class="menu-button-container menu-profile d-none d-md-block">
              <button class="mdc-button mdc-menu-button">
                <span class="d-flex align-items-center">
                  <span class="figure">
                    <img src="../assets/images/faces/dummy.jpg" alt="user" class="user">
                  </span>
                  <span class="user-name" id="user-full-name"></span>
                </span>
              </button>
              <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon-only">
                      <i class="mdi mdi-account-edit-outline text-primary"></i>
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">Edit profile</h6>
                    </div>
                  </li>
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon-only">
                      <i class="mdi mdi-settings-outline text-primary"></i>
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal"><a href="../../logout.php">Logout</a></h6>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="divider d-none d-md-block"></div>
            <div class="menu-button-container d-none d-md-block">
              <button class="mdc-button mdc-menu-button">
                <i class="mdi mdi-arrow-down-bold-box"></i>
              </button>
              <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon-only">
                      <i class="mdi mdi-logout-variant text-primary"></i>
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal"><a href="../../logout.php">Logout</a></h6>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </header>
      <!-- partial -->
      <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">


          <!-- <section class="component component--quiz normal"> -->
          <!-- <div class="progress"><div class="progress--bar"></div></div>
            <div class="container">
                <form method="post" onsubmit="return returnScore()"> -->

          <div class="mdc-layout-grid" id="startpage" style="visibility: visible">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                  <div class="row">
                    <div class="col-md-12">
                      <h6 class="card-title" style="font-weight: 600; margin-bottom: 30px; font-size: 22px;" id="TestHeading">Test
                        Instructions:-</h6>
                      <ol class="olli" id="ol">
                        <li>
                          <b>1. The Self Assessment Test aims to understand your mental health. The test is having 9
                            questions.</b>

                        </li>
                        <li>
                          2. You will need 5-10 to complete this section.
                        </li>
                        <li>
                          3. Kindly respond to each statement by choosing one of the options from the four possible
                          response options provided.
                        </li>
                        <li>
                          4. Carefully read the statements and give the first response thought which comes to your mind.
                          DO
                          NOT spend lot of time on one statement.
                        </li>
                        <li>
                          <b>5. Respond to all statements.</b>
                        </li>
                        <li>
                          <b>6. Your response will be kept confidential.</b>

                        </li>
                        <li>
                          7. Test once given will be locked for the user.
                        </li>
                      </ol>
                      <button id="start-button" class="btn">Start Test</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="mdc-layout-grid" id="responsePage" hidden>
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                  <div class="row">
                    <div class="col-md-12">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
  
          <!-- <div id="startpage">
            <h4 class="startContent">Kindly complete the self-assessment test </p>
              <button id="start-button">Start</button>
          </div> -->
          <div class="mdc-layout-grid" id="questions-container" hidden>
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                  <div class="row">
                    <div class="col-md-12">
                      <div id="result" class="quiz-body">
                        <form name="quizForm" onSubmit="">
                          <fieldset class="form-group">
                            <h4><span id="qid">1.</span> <span id="question"></span></h4>    
                            <div class="option-block-container" id="question-options">    
                            </div> <!-- End of option block -->
                          </fieldset>
                          <button name="previous" id="previous" class="btn btn-success">Previous</button>
                          &nbsp;
                          <button name="next" id="next" class="btn btn-success">Next</button>
                          <button type="submit" id="submit" form="questions" class="btn btn-success" hidden>Submit</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <!-- <div id="questions-container" class="content" hidden>
            <div class="container-fluid">

              <div class="row">
                <div class="col-sm-12">
                  <div id="result" class="quiz-body">
                    <form name="quizForm" onSubmit="">
                      <fieldset class="form-group">
                        <h4><span id="qid">1.</span> <span id="question"></span></h4>

                        <div class="option-block-container" id="question-options">

                        </div> 
                      </fieldset>
                      <button name="previous" id="previous" class="btn btn-success">Previous</button>
                      &nbsp;
                      <button name="next" id="next" class="btn btn-success">Next</button>
                      <button id="submit" form="questions" class="btn btn-success" hidden>Submit</button>
                    </form>
                  </div>
                </div> 

              </div> 
              </div> 
          </div> -->
          



        </main>
      </div>
      <!-- partial:../../partials/_footer.html -->
      <footer>
        <div class="mdc-layout-grid">
          <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
              <span class="text-center text-sm-left d-block d-sm-inline-block tx-14">Copyright © 2023 All Rights
                Reserved</span>
            </div>
            <div
              class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex justify-content-end">
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center tx-14">This Website is made by
                Team 5 </span>
            </div>
          </div>
        </div>
      </footer>
      <!-- partial -->
    </div>
  </div>
  </div>



  <!-- plugins:js -->
  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../assets/js/material.js"></script>
  <script src="../assets/js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->

  <script>

    //info about the user in session
    function userSession(){
      name = "<?php echo $FullName; ?>";
      document.getElementById("name").innerHTML = name;
      document.getElementById("greeting_msg").innerHTML = "Greetings "+name+"!";
      document.getElementById("user-full-name").innerHTML = name;

      email = "<?php echo $UserName; ?>";
      document.getElementById("email").innerHTML = email;

    }

    userSession();
    flag = "<?php echo $flag; ?>";

    function checkSelf(){

      if(flag==1){
        document.getElementById("ol").style.visibility = "hidden";
        document.getElementById("start-button").style.visibility = "hidden";
        document.getElementById("TestHeading").innerHTML = "Test Submitted Already. Please Wait for Further Notifications...";
      }
      else if(flag==2){
        document.getElementById("ol").style.visibility = "hidden";
        document.getElementById("start-button").style.visibility = "hidden";
        document.getElementById("TestHeading").innerHTML = "Test has been submitted. Please Wait for Further Notifications...";
      }

    }
    
    checkSelf();

  </script>

  <script type="text/javascript">

    function jumpScroll() {
      window.scrollTo(0, document.body.scrollHeight); // horizontal and vertical scroll targets
      location.hash = "bottomofpage";
    }
    function ScrollToElement() {
      if ((obj = document.getElementById("bottomofpage")) && obj != null) {
        window.scrollTo(0, obj.offsetTop);
        //EPPZScrollTo.scrollVerticalToElementById('bottomofpage', 20);
      }
    }

  </script>

  <script src="../assets/js/script.js"></script>
  
</body>

</html>