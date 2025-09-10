<?php

    session_start();
    include "../../db_conn.php";
    if(isset($_SESSION['UserName'])){
        $FullName = $_SESSION['FullName'];
        $UserName = $_SESSION['UserName'];
        $UserCategory = $_SESSION['UserCategory'];

        $sql="SELECT * FROM patient WHERE Assigned=0 AND UserName IN (SELECT UserName FROM assessmentresults) AND UserName NOT IN (SELECT PatientUserName FROM deletepatient);";
        $result1=mysqli_query($conn, $sql);
        $new_patients_len=mysqli_num_rows($result1);

        $sql2="SELECT * FROM patient WHERE UserName IN (SELECT PatientUserName FROM assignPatient) AND UserName NOT IN (SELECT PatientUserName FROM deletepatient);";
        $result2=mysqli_query($conn, $sql2);
        $assigned_patients_len=mysqli_num_rows($result2);

        $sql3 = "SELECT * FROM counselor ORDER BY FullName";
        $result3=mysqli_query($conn, $sql3);
        $counselor_len=mysqli_num_rows($result3);

        $sql7 = "SELECT * FROM Doctor ORDER BY FullName";
        $result7=mysqli_query($conn, $sql7);
        $doctor_len=mysqli_num_rows($result7);

        $sql4 = "SELECT * FROM appointment WHERE patientUsername NOT IN (SELECT patientUsername FROM deletepatient) AND Date = CURRENT_DATE AND Time >= CURRENT_TIME UNION SELECT * FROM appointment WHERE patientUsername NOT IN (SELECT patientUsername FROM deletepatient) AND Date > CURRENT_DATE ORDER BY Date, Time LIMIT 5;";
        $result4=mysqli_query($conn, $sql4);
        $len=mysqli_num_rows($result4);

        $name = array();
        $score = array();
        $patientUserName = array();
        $date = array();
        $time = array();
        $pid = array();
        $mgtUN = array();
        $mgtCat = array();
        $dob = array();
        $mgtName = array();
        
        if($len > 0){
          $i=0;

          while($row = mysqli_fetch_assoc($result4)){

            $un = $row['PatientUserName'];
            $patientUserName[$i] = $un;
            $date[$i] = $row['Date'];
            $time[$i] = $row['Time'];
            $mgtUN[$i] = $row['MgtUserName'];
            $mgtCat[$i] = $row['MgtCategory'];

            if(strcmp("C",$mgtCat[$i])==0){
              $tableName="counselor";
            }
            else{
              $tableName="doctor";
            }

            $sql2 = "SELECT FullName, PatientID, DOB FROM Patient WHERE UserName = '$un' ";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $name[$i] = $row2['FullName'];
            $pid[$i] = $row2['PatientID'];
            $dob[$i] = $row2['DOB'];

            $sql3 = "SELECT Score FROM assessmentresults WHERE UserName = '$un' ";
            $result3 = mysqli_query($conn,$sql3);
            $row3 = mysqli_fetch_assoc($result3);
            $score[$i] = $row3['Score'];

            $sql5 = "SELECT FullName from $tableName where UserName = '$mgtUN[$i]'";
            $result5 = mysqli_query($conn, $sql5);
            $row5 = mysqli_fetch_assoc($result5);
            $mgtName[$i] = $row5['FullName'];

            $i++;
          }
        }        
    }
    else{
        echo "<script>alert('Error while logging in. Try again later'); window.open('authenticate.php','_self');</script>";
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
  integrity="sha512-jc7KzIDg0obaVhchti0nOkurGpdaJ+aK69Paa7DnHJLYftV7+RYsdQbMq3O89DdPr0VCfw5R5+5a5m40mOtiLw=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>HealthCare - Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="../assets/vendors/jvectormap/jquery-jvectormap.css">
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
    /* .content-wrapper{
      min-height: calc(100vh - 64px - 69px) !important;
    } */
    .mdc-card{
      padding: 0;
    }
  </style>
  <link rel="stylesheet" href="../assets/css/my_style.css">
</head>

<body>
  <!-- <script src="../assets/js/preloader.js"></script> -->
  <div class="body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
      <div class="mdc-drawer__header">
        <a href="../../index.php" class="brand-logo">
          <img src="../assets/images/logo.png" alt="logo">
        </a>
      </div>
      <div class="mdc-drawer__content">
        <div class="user-info">
          <p class="name" id="name">Manager (M)</p>
          <p class="email" id="email">manager@gmail.com</p>
        </div>
        <div class="mdc-list-group">
          <nav class="mdc-list mdc-drawer-menu">
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="index.php">
                <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">home</i>
                Dashboard
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="list-of-patients.php">
                <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">pages</i>
                List of New Patients
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="list-of-assigned-patients.php">
                <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                  aria-hidden="true">description</i>
                Assigned Patients
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="list-of-counselors.php">
                <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                  aria-hidden="true">dashboard</i>
                List of Counselors
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="list-of-doctors.php">
                <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                  aria-hidden="true">track_changes</i>
                List of Doctors
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link bell" href="report2.php">
                <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                  aria-hidden="true">description</i>
                Report
              </a>
            </div>
            <!-- <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link bell" href="#">
                <i class="material-icons mdi mdi-bell"></i>
                Notifications
              </a>
            </div> -->
            <!-- <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="edit-profile.html" >
                <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                  aria-hidden="true">description</i>
                Edit Profile
              </a>
            </div> -->
          </nav>
        </div>
        <div class="profile-actions">
          <a href="../../logout.php"><i class="mdi mdi-logout-variant"></i> Logout</a>
        </div>
      </div>
    </aside>
    <!-- partial -->
    <div class="main-wrapper mdc-drawer-app-content">
      <!-- partial:partials/_navbar.html -->
      <header class="mdc-top-app-bar">
        <div class="mdc-top-app-bar__row">
          <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button
              class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button sidebar-toggler">menu</button>
            <span class="mdc-top-app-bar__title" id="greeting_msg">Greetings Manager!</span>
          </div>
          <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end mdc-top-app-bar__section-right">
            <div class="menu-button-container menu-profile d-none d-md-block">
              <button class="mdc-button mdc-menu-button">
                <span class="d-flex align-items-center">
                  <span class="figure">
                    <img src="../assets/images/faces/dummy.jpg" alt="user" class="user">
                  </span>
                  <span class="user-name" id="user-full-name">Manager</span>
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
                    <a href="../../logout.php"><div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">Logout</h6>
                    </div></a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="divider d-none d-md-block"></div>
            <!-- <div class="menu-button-container">
              <button class="mdc-button mdc-menu-button">
                <i class="mdi mdi-bell"></i>
              </button>
              <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                <h6 class="title"> <i class="mdi mdi-bell-outline mr-2 tx-16"></i> Notifications</h6>
                <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon">
                      <i class="mdi mdi-email-outline"></i>
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">You received a new message</h6>
                      <small class="text-muted"> 6 min ago </small>
                    </div>
                  </li>
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon">
                      <i class="mdi mdi-account-outline"></i>
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">New user registered</h6>
                      <small class="text-muted"> 15 min ago </small>
                    </div>
                  </li>
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon">
                      <i class="mdi mdi-alert-circle-outline"></i>
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">System Alert</h6>
                      <small class="text-muted"> 2 days ago </small>
                    </div>
                  </li>
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon">
                      <i class="mdi mdi-update"></i>
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">You have a new update</h6>
                      <small class="text-muted"> 3 days ago </small>
                    </div>
                  </li>
                </ul>
              </div>
            </div> -->
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
                    <a href="../../logout.php"><div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">Logout</h6>
                    </div></a>
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
              <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card info-card info-card--success">
                  <div class="card-inner">
                    <h5 class="card-title">New Patients</h5>
                    <h5 class="font-weight-light pb-2 mb-1 border-bottom hsize" id="new_patients">2</h5>
                    <a href="list-of-patients.php">
                      <p class="tx-12 text-muted">View </p>
                      <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <div class="card-icon-wrapper">
                      <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card info-card info-card--danger">
                  <div class="card-inner">
                    <h5 class="card-title">Assigned Patients</h5>
                    <h5 class="font-weight-light pb-2 mb-1 border-bottom hsize" id="assigned_patients">2</h5>
                    <a href="list-of-assigned-patients.php">
                      <p class="tx-12 text-muted">View </p>
                      <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <div class="card-icon-wrapper">
                      <i class="fa fa-medkit" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card info-card info-card--primary">
                  <div class="card-inner">
                    <h5 class="card-title">Total Counselors</h5>
                    <h5 class="font-weight-light pb-2 mb-1 border-bottom hsize" id="counselor">2</h5>
                    <a href="list-of-counselors.php">
                      <p class="tx-12 text-muted">View </p>
                      <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <div class="card-icon-wrapper">
                      <i class="fa fa-handshake-o" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card info-card info-card--info">
                  <div class="card-inner">
                    <h5 class="card-title">Total Doctors</h5>
                    <h5 class="font-weight-light pb-2 mb-1 border-bottom hsize" id="doctor">2</h5>
                    <a href="list-of-doctors.php">
                      <p class="tx-12 text-muted">View </p>
                      <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <div class="card-icon-wrapper">
                      <i class="fa fa-user-md"></i>
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                  <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-0">Revenue by location</h4>
                    <div>
                      <i class="material-icons refresh-icon">refresh</i>
                      <i class="material-icons options-icon ml-2">more_vert</i>
                    </div>
                  </div>
                  <div class="d-block d-sm-flex justify-content-between align-items-center">
                    <h5 class="card-sub-title mb-2 mb-sm-0">Sales performance revenue based by country</h5>
                    <div class="menu-button-container">
                      <button
                        class="mdc-button mdc-menu-button mdc-button--raised button-box-shadow tx-12 text-dark bg-white font-weight-light">
                        Last 7 days
                        <i class="material-icons">arrow_drop_down</i>
                      </button>
                      <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                        <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                          <li class="mdc-list-item" role="menuitem">
                            <h6 class="item-subject font-weight-normal">Back</h6>
                          </li>
                          <li class="mdc-list-item" role="menuitem">
                            <h6 class="item-subject font-weight-normal">Forward</h6>
                          </li>
                          <li class="mdc-list-item" role="menuitem">
                            <h6 class="item-subject font-weight-normal">Reload</h6>
                          </li>
                          <li class="mdc-list-divider"></li>
                          <li class="mdc-list-item" role="menuitem">
                            <h6 class="item-subject font-weight-normal">Save As..</h6>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="mdc-layout-grid__inner mt-2">
                    <div
                      class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6 mdc-layout-grid__cell--span-8-tablet">
                      <div class="table-responsive">
                        <table class="table dashboard-table">
                          <tbody>
                            <tr>
                              <td>
                                <span class="flag-icon-container"><i
                                    class="flag-icon flag-icon-us mr-2"></i></span>United States
                              </td>
                              <td>$1,671.10</td>
                              <td class=" font-weight-medium"> 39% </td>
                            </tr>
                            <tr>
                              <td> <span class="flag-icon-container"><i
                                    class="flag-icon flag-icon-ph mr-2"></i></span>Philippines </td>
                              <td>$1,064.75</td>
                              <td class=" font-weight-medium"> 30% </td>
                            </tr>
                            <tr>
                              <td> <span class="flag-icon-container"><i
                                    class="flag-icon flag-icon-gb mr-2"></i></span>United Kingdom</td>
                              <td>$1,055.98</td>
                              <td class=" font-weight-medium"> 45% </td>
                            </tr>
                            <tr>
                              <td> <span class="flag-icon-container"><i
                                    class="flag-icon flag-icon-ca mr-2"></i></span>Canada</td>
                              <td>$1,045.49</td>
                              <td class=" font-weight-medium"> 80% </td>
                            </tr>
                            <tr>
                              <td> <span class="flag-icon-container"><i
                                    class="flag-icon flag-icon-fr mr-2"></i></span>France</td>
                              <td>$2,050.93</td>
                              <td class=" font-weight-medium"> 10% </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div
                      class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6 mdc-layout-grid__cell--span-8-tablet">
                      <div id="revenue-map" class="revenue-world-map"></div>
                    </div>
                  </div>
                </div>
              </div> -->
              <!-- <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card bg-success text-white">
                  <div class="d-flex justify-content-between">
                    <h3 class="font-weight-normal">Impressions</h3>
                    <i class="material-icons options-icon text-white">more_vert</i>
                  </div>
                  <div class="mdc-layout-grid__inner align-items-center">
                    <div
                      class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-3-tablet mdc-layout-grid__cell--span-2-phone">
                      <div>
                        <h5 class="font-weight-normal mt-2">Customers 58.39k</h5>
                        <h2 class="font-weight-normal mt-3 mb-0">636,757K</h2>
                      </div>
                    </div>
                    <div
                      class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop mdc-layout-grid__cell--span-5-tablet mdc-layout-grid__cell--span-2-phone">
                      <canvas id="impressions-chart" height="80"></canvas>
                    </div>
                  </div>
                </div>
              </div> -->
              <!-- <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop mdc-layout-grid__cell--span-4-tablet">
                <div class="mdc-card bg-info text-white">
                  <div class="d-flex justify-content-between">
                    <h3 class="font-weight-normal">Traffic</h3>
                    <i class="material-icons options-icon text-white">more_vert</i>
                  </div>
                  <div class="mdc-layout-grid__inner align-items-center">
                    <div
                      class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-3-tablet mdc-layout-grid__cell--span-2-phone">
                      <div>
                        <h5 class="font-weight-normal mt-2">Customers 58.39k</h5>
                        <h2 class="font-weight-normal mt-3 mb-0">636,757K</h2>
                      </div>
                    </div>
                    <div
                      class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop mdc-layout-grid__cell--span-5-tablet mdc-layout-grid__cell--span-2-phone">
                      <canvas id="traffic-chart" height="80"></canvas>
                    </div>
                  </div>
                </div>
              </div> -->
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                  <div class="row">
                    <div class="col-md-8 nopadd">
                      <h6 class="card-title card-padding pb-2"
                        style="font-weight: 600; margin-bottom: 20px; font-size: 22px;">Upcoming Appointments</h6>
                    </div>
                    <div class="col-md-4 nopadd searchinput">
                      <input type="text" id="searchingInput"  onkeyup="searchingTable()" style="margin-bottom: 20px;" placeholder="Search Patient"
                        title="Type in patient id">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <div class="row" style="display: flex; justify-content: center;">
                      <div class="col-md-12">
                      <!-- <h7 id="msg" style="visibility: visible; color: red">No Upcoming Appointments...</h7>
                        <table class="table table-bordered table-hover"  id="table" style="visibility: hidden"> -->
                        <h7 id="msg" style="visibility: visible; color: red">No Upcoming Appointments...</h7>
                        <table class="table table-bordered table-hover" id="table" style="visibility: hidden">
                          <thead>
                            <tr>
                              <th scope="col" style="width: 12%;">Patient ID</th>
                              <th scope="col" style="width: 25%;">Patient Name</th>
                              <th scope="col" style="width: 16%;">Self Assessment Score</th>
                              <th scope="col" style="width: 22%;">Date and Time</th>
                              <th scope="col" style="width: 25%;">Assigned To</th>
                            </tr>
                          </thead>
                          <tbody id="table-body">
                            <!--<tr>
                              <td scope="row" ><span class="fwbold">1001</span></td>
                              <td ><span class="fwbold">Karnik Shah</span> (12-12-2000)<br><span class="tgray">karnik@gmail.com</span></td>
                              <td ><span class="fwbold">10/10</span><br><a href="specific_patient-for-manager.php">View More</a></td>
                              <td><span class="fwbold">5th April 2023</span><br><span class="tgray">10:00AM</span></td>
                              <td ><span class="fwbold">Karnik Shah</span><br><span class="tgray">karnik@gmail.com</span></td>
                            </tr>-->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="chart-container mt-4">
                    <canvas id="revenue-chart" height="260"></canvas>
                  </div> -->
                </div>
              </div>
              <!-- <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-8-tablet">
                <div class="mdc-card">
                  <div class="d-flex d-lg-block d-xl-flex justify-content-between">
                    <div>
                      <h4 class="card-title">Order Statistics</h4>
                      <h6 class="card-sub-title">Customers 58.39k</h6>
                    </div>
                    <div id="sales-legend" class="d-flex flex-wrap"></div>
                  </div>
                  <div class="chart-container mt-4">
                    <canvas id="chart-sales" height="260"></canvas>
                  </div>
                </div>
              </div> -->
            </div>
          </div>
        </main>
        <form id="specPatient" method = "post" action = "specific_patient-for-manager.php">
          <input type="hidden" id="Fname" name="Fname" value="">
          <input type="hidden" id="username" name="username" value="">
          <input type="hidden" id="score" name="score" value="">
        </form>
        <!-- partial:partials/_footer.html -->
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
  <script src="https://momentjs.com/downloads/moment.min.js"></script>
  <script>
  function userSession(){
    name = "<?php echo $FullName; ?>";
    document.getElementById("name").innerHTML = name;
    document.getElementById("greeting_msg").innerHTML = "Greetings "+name+"!";
    document.getElementById("user-full-name").innerHTML = name;

    email = "<?php echo $UserName; ?>";
    document.getElementById("email").innerHTML = email;

    len = "<?php echo $new_patients_len; ?>";
    document.getElementById("new_patients").innerHTML = len;
    len = "<?php echo $assigned_patients_len; ?>";
    document.getElementById("assigned_patients").innerHTML = len;
    len = "<?php echo $counselor_len; ?>";
    document.getElementById("counselor").innerHTML = len;
    len = "<?php echo $doctor_len; ?>";
    document.getElementById("doctor").innerHTML = len;
    }

    userSession();

    function displayAppointments(){

      len2 = <?php echo $len; ?>;

      if(len2 > 0){

        document.getElementById("table").style.visibility = "visible";
        document.getElementById("msg").style.visibility = "hidden";

        FullName=<?php echo '["' . implode('", "', $name) . '"]' ?>;
        dob=<?php echo '["' . implode('", "', $dob) . '"]' ?>;
        score=<?php echo '["' . implode('", "', $score) . '"]' ?>;
        userName=<?php echo '["' . implode('", "', $patientUserName) . '"]' ?>;
        setDate=<?php echo '["' . implode('", "', $date) . '"]' ?>;
        setTime=<?php echo '["' . implode('", "', $time) . '"]' ?>;
        pid=<?php echo '["' . implode('", "', $pid) . '"]' ?>;
        mgtUn=<?php echo '["' . implode('", "', $mgtUN) . '"]' ?>;
        mgtCat=<?php echo '["' . implode('", "', $mgtCat) . '"]' ?>;
        mgtName=<?php echo '["' . implode('", "', $mgtName) . '"]' ?>;

        str="";
        for(i = 0;i<len2; i++){

          if(mgtCat[i] == "C")
            mgt="Counselor";
          else
            mgt="Doctor";

          formatDate = moment(setDate[i]).format('MMMM Do YYYY');
          formatTime = setTime[i];
          formatDob = moment(dob[i]).format('DD MMMM YYYY');

          str+='<tr>';
          str+='<td scope="row" ><span class="fwbold">'+pid[i]+'</span></td>';
          str+='<td ><span class="fwbold">'+FullName[i]+'</span> ('+formatDob+')<br><span class="tgray">'+userName[i]+'</span></td>';
          str+='<td ><span class="fwbold">'+score[i]+'</span><br><a href="javascript: patient('+i+')">View More</a></td>';
          str+='<td><span class="fwbold">'+formatDate+'</span><br><span class="tgray">'+formatTime+'</span></td>';
          str+='<td ><span class="fwbold">'+mgtName[i]+' ('+mgt+')</span><br><span class="tgray">'+mgtUn[i]+'</span></td>';
          str+='</tr>';


        }

        document.getElementById("table-body").innerHTML = str;
      }

    }
    
    displayAppointments();

    function patient(i){

      document.getElementById("Fname").value = FullName[i];
      document.getElementById("username").value = userName[i];
      document.getElementById("score").value = score[i];
      document.getElementById("specPatient").submit();

    }

    function searchingTable() {
      var input, filter, table, tr, td, i, j, txtValue;
      input = document.getElementById("searchingInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("mineTable");
      tr = table.getElementsByTagName("tr");

      // Loop through all table rows
      for (i = 0; i < tr.length; i++) {
        // Loop through all table cells in current row
        for (j = 0; j < tr[i].cells.length; j++) {
          td = tr[i].cells[j];
          if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
              break;
            } else {
              tr[i].style.display = "none";
            }
          }
        }
      }
    }
  </script>
  <!-- plugins:js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="../assets/vendors/chartjs/Chart.min.js"></script>
  <script src="../assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
  <script src="../assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../assets/js/material.js"></script>
  <script src="../assets/js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../assets/js/spm/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>