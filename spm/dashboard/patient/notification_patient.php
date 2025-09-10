<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



session_start();
if (isset($_SESSION['UserName'])) {
  $FullName = $_SESSION['FullName'];
  $UserName = $_SESSION['UserName'];
  $UserCategory = $_SESSION['UserCategory'];

  $sql = "SELECT * FROM pending_appointment WHERE PatientUserName = '$UserName' ";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $PatientUserName = $row['PatientUserName'];
    $MgtUserName = $row['MgtUserName'];
    $MgtCategory = $row['MgtCategory'];
    $Date = $row['Date'];
    $Time = $row['Time'];
    $d="";

    if ($MgtCategory == 'D') {
      $sql3 = "SELECT * FROM doctor WHERE UserName = '$MgtUserName'";
      $result2 = mysqli_query($conn, $sql3);
      if (mysqli_num_rows($result2) > 0) {
        $row = mysqli_fetch_assoc($result2);
        $d = "Doctor";
        $CUserName = $row['UserName'];
        $CFullName = $row['FullName'];
        $Address = $row['Address'];

      }

    } elseif ($MgtCategory == 'C') {
      $sql2 = "SELECT * FROM counselor WHERE UserName = '$MgtUserName'";
      $result2 = mysqli_query($conn, $sql2);
      if ($result2) {
        $row = mysqli_fetch_assoc($result2);
        $d = "Counselor";
        $CUserName = $row['UserName'];
        $CFullName = $row['FullName'];
        $Address = $row['Address'];

      }

    }

  }
  //           If patient has appointment
  $sql3 = "SELECT * FROM appointment WHERE PatientUserName = '$UserName' ORDER BY AppointmentID desc";
  $result3 = mysqli_query($conn, $sql3);
  if (mysqli_num_rows($result3) > 0) {
    $row3 = mysqli_fetch_assoc($result3);
    $A_PatientUserName = $row3['PatientUserName'];
    $A_MgtUserName = $row3['MgtUserName'];
    $A_MgtCategory = $row3['MgtCategory'];
    $A_Date = $row3['Date'];
    $A_Time = $row3['Time'];

    if ($A_MgtCategory == 'D') {
      $sql4 = "SELECT * FROM doctor WHERE UserName = '$A_MgtUserName'";
      $result4 = mysqli_query($conn, $sql4);
      if (mysqli_num_rows($result4) > 0) {
        $row4 = mysqli_fetch_assoc($result4);
        $d = "Doctor";
        $A_CUserName = $row4['UserName'];
        $A_CFullName = $row4['FullName'];
        $A_Address = $row4['Address'];

      }

    } elseif ($A_MgtCategory == 'C') {
      $sql4 = "SELECT * FROM counselor WHERE UserName = '$A_MgtUserName'";
      $result4 = mysqli_query($conn, $sql4);
      if (mysqli_num_rows($result4) > 0) {
        $row4 = mysqli_fetch_assoc($result4);
        $d = "Counselor";
        $A_CUserName = $row4['UserName'];
        $A_CFullName = $row4['FullName'];
        $A_Address = $row4['Address'];

      }

    }


  }


} else {
  echo "<script>alert('Error while logging in. Try again later'); window.open('authenticate.php','_self');</script>";
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css" rel="stylesheet">
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

    .mdc-drawer__header .active {
      background-color: white;
    }

    .content-wrapper .row {
      margin-left: 0;
      margin-right: 0;
    }

    .table {
      margin-bottom: 35px;
    }

    .table-responsive {
      padding: 0 14px !important;
      /* min-height: 60vh; */
    }

    .table thead tr th {
      background-color: #398378;
      color: white !important;
      font-weight: 600;
    }

    .table td {
      vertical-align: middle !important;
    }

    .table td button:focus {
      outline: none;
      box-shadow: none;
      border: 1px solid black;
    }

    .table select {
      padding: 5px 7px;
      border: none;
      background: rgba(223, 222, 222, 0.925);
    }

    .table .save {
      background: #039403;
      color: white;
      padding: 2px 7px;
    }

    .table .delete {
      background: #cb0a03;
      color: white;
      padding: 2px 7px;
    }

    .mdc-card {
      background: none !important;
      box-shadow: none !important;
    }
  </style>
  <link rel="stylesheet" href="../assets/css/my_style.css">
</head>

<body>
  <!-- <script src="assets/js/preloader.js"></script> -->
  <div class="body-wrapper">
    <!-- partial:../../partials/_sidebar.html -->
    <aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
      <div class="mdc-drawer__header">
        <a href="../index.html" class="brand-logo">
          <img src="../../images/logo.png" alt="logo">
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
            <span class="mdc-top-app-bar__title" id="greeting_msg"> </span>
          </div>
          <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end mdc-top-app-bar__section-right">
            <div class="menu-button-container menu-profile d-none d-md-block">
              <button class="mdc-button mdc-menu-button">
                <span class="d-flex align-items-center">
                  <span class="figure">
                    <img src="../assets/images/faces/dummy.jpg" alt="user" class="user">
                  </span>
                  <span class="user-name" id="user-full-name"> </span>
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
                      <h6 class="item-subject font-weight-normal">Logout</h6>
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
                      <h6 class="item-subject font-weight-normal">Logout</h6>
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
          <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card p-0">

                  <!-- Notification starts -->
                  <?php
                  if (!empty($row)) {
                    echo '<div class="my-card" >';
                  } else
                    echo '<div class="my-card" style = "display: none">';
                  ?>

                  <div class="row">
                    <div class="col-md-8">
                      <i class="fa fa-bell"></i>
                      <!-- <i class="material-icons mdi mdi-bell"></i> -->
                      <span class="notify">Notification</span>
                    </div>
                  </div>
                  <div class="row main-cont">
                    <div class="col-md-12" style="border-right: 1px solid gray;">
                      <p>Our specialist has decided to consult you after going through your self
                        assessment result. Details of the specialist:</p>
                      <p><b>Name:</b>
                        <?php echo $CFullName ?> (
                        <?php if($MgtCategory=='D')
                    {
                      echo "Doctor ";
                    } 
                    else{
                      echo "Counselor ";
                    } ?>)
                      </p>
                      <p><b>Email Address: </b>
                        <?php echo $MgtUserName ?>
                      </p>
                      <!-- </div>
                        <div class="col-md-4"> -->
                      <div class="scheduled">
                        <p>
                          Time and Date assigned to you for consultation is: <b>
                            <?php echo $Time ?> on
                            <?php echo $Date ?>
                          </b>
                        </p>
                        <p><b>Venue: </b> 1455 Boul. de Maisonneuve O, Montréal, QC H3G 1M8
                          
                        </p>


                        <form action="confirm_appointment.php" method="post">
                          <div class="btns">
                            <p style="font-weight: 700;">Are you accepting the appointment date and time: </p>
                            <button type="submit" class="btn accept">Accept</button>
                        </form>

                        <form action="delete_appointment.php" method="post">
                          <button type="submit" class="btn cancel">Cancel</button>
                        </form>

                      </div>



                      <!-- </p> -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- Notification ends -->


              <!-- If patient already has an appointment -->
              <?php
              if (empty($row) and !empty($row3)) {
                echo '<div class="my-card" >';
              } else
                echo '<div class="my-card" style = "display: none">';
              ?>

              <div class="row">
                <div class="col-md-8">
                  <i class="fa fa-bell"></i>
                  <!-- <i class="material-icons mdi mdi-bell"></i> -->
                  <span class="notify">Appointment</span>
                </div>
                <div class="col-md-4">
                  <div class="time">
                    <!--   <span style="color: #398378;">1st April 2023, 7:30 pm</span> -->
                  </div>
                </div>
              </div>
              <div class="row main-cont">
                <div class="col-md-12" style="border-right: 1px solid gray;">
                  <p>You have an appointment with our specialist. Details of the specialist:</p>
                  <p><b>Name: </b>
                    <?php echo $A_CFullName ?> (
                    <?php if($A_MgtCategory=='D')
                    {
                      echo "Doctor ";
                    } 
                    else{
                      echo "Counselor ";
                    }?>)
                  </p>
                  <p><b>Email Address: </b>
                    <?php echo $A_MgtUserName ?>
                  </p>
                  <!-- </div>
                        <div class="col-md-4"> -->
                  <div class="scheduled">
                    <p>
                      Time and Date for your appointment is: <b>
                        <?php echo $A_Time ?> on
                        <?php echo $A_Date ?>
                      </b>
                    </p>
                    <p><b>Venue: </b> 1455 Boul. de Maisonneuve O, Montréal, QC H3G 1M8
                    <!--  <p><b>Address: </b><?php echo $A_Address ?></p>  -->





                    <!-- </p> -->
                  </div>
                </div>
              </div>
            </div>
            <!-- Notification ends -->
            <!-- <h6 class="card-title card-padding pb-2"
                    style="font-weight: 600; margin-bottom: 20px; font-size: 22px;">Notifications</h6> -->

          </div>
      </div>
    </div>
  </div>
  </main>
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
  <script>
    //info about the user in session
    function userSession() {
      name = "<?php echo $FullName; ?>";
      document.getElementById("name").innerHTML = name;
      document.getElementById("greeting_msg").innerHTML = "Greetings " + name + "!";
      document.getElementById("user-full-name").innerHTML = name;

      email = "<?php echo $UserName; ?>";
      document.getElementById("email").innerHTML = email;

    }

    userSession();

    // get the password and confirm password fields
    var passwordInput = document.getElementById('password');
    var confirmPasswordInput = document.getElementById('confirmpassword');

    // add an event listener to the confirm password field
    confirmPasswordInput.addEventListener('keyup', function () {
      // compare the password and confirm password fields
      if (passwordInput.value !== confirmPasswordInput.value) {
        // if they don't match, display an error message
        confirmPasswordInput.setCustomValidity('Passwords do not match');
      } else {
        // if they match, clear the error message
        confirmPasswordInput.setCustomValidity('');
      }
    });
    function password_show_hide() {
      var x = document.getElementById("password");
      var y = document.getElementById("confirmpassword");
      var show_eye = document.getElementById("show_eye");
      var hide_eye = document.getElementById("hide_eye");
      hide_eye.classList.remove("d-none");
      if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
      } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
      }
    }
    function password_show_hidee() {
      var x = document.getElementById("password");
      var y = document.getElementById("confirmpassword");
      var show_eyee = document.getElementById("show_eyee");
      var hide_eyee = document.getElementById("hide_eyee");
      hide_eyee.classList.remove("d-none");
      if (y.type === "password") {
        y.type = "text";
        show_eyee.style.display = "none";
        hide_eyee.style.display = "block";
      } else {
        y.type = "password";
        show_eyee.style.display = "block";
        hide_eyee.style.display = "none";
      }
    }
  </script>
  <script>
    var timeSelect = document.getElementById("time");
    for (var hour = 0; hour < 24; hour++) {
      for (var minute = 0; minute < 60; minute += 60) {
        var timeString = hour.toString().padStart(2, '0') + ':' + minute.toString().padStart(2, '0');
        var option = document.createElement("option");
        option.text = timeString;
        option.value = timeString;
        timeSelect.add(option);
      }
    }
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
</body>

</html>