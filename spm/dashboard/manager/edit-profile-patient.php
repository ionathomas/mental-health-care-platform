<?php

    session_start();
    include "../../db_conn.php";

    if(isset($_SESSION['UserName'])){
      $FullName = $_SESSION['FullName'];
      $UserName = $_SESSION['UserName'];
      $UserCategory = $_SESSION['UserCategory'];

      if(isset($_POST['patientUN'])){
        $un = $_POST['patientUN'];
        $sql="SELECT * FROM patient WHERE UserName = '$un'";
        $result=mysqli_query($conn,$sql);

        if($row = mysqli_fetch_assoc($result)){
          $profileName = $row['FullName'];
          $profileUn = $row['UserName'];
          $profileAddr = $row['Address'];
          $profileDob = $row['DOB'];
          $profileNo = $row['PhoneNumber'];
        }
        else{
            echo "<script>alert('Error encountered. Try again later'); window.open('index.php','_self');</script>";
            exit();
        }
      }
      elseif(isset($_POST['profileName'])){
        $name = $_POST['profileName'];
        $mail = $_POST['profileMail'];
        $addr = $_POST['profileAddr'];
        $dob = $_POST['profileDob'];
        $no = $_POST['profileNo'];
        $unO = $_POST['un'];

        $sql3 = "UPDATE patient SET UserName='$mail',FullName='$name',Address='$addr',DOB='$dob',PhoneNumber='$no' WHERE UserName = '$unO'";
        $result3 = mysqli_query($conn,$sql3);

        $sql4 = "UPDATE user SET UserName='$mail' WHERE UserName = '$unO'";
        $result4 = mysqli_query($conn, $sql4);

        $sql5 = "UPDATE appointment SET PatientUserName='$mail' WHERE PatientUserName = '$unO'";
        $result5 = mysqli_query($conn, $sql5);

        $sql6 = "UPDATE assessmentresults SET UserName='$mail' WHERE UserName = '$unO'";
        $result6 = mysqli_query($conn, $sql6);

        $sql7 = "UPDATE assignpatient SET PatientUserName='$mail' WHERE PatientUserName = '$unO'";
        $result7 = mysqli_query($conn, $sql7);

        $sql8 = "UPDATE deletepatient SET patientUsername='$mail' WHERE PatientUserName = '$unO'";
        $result8 = mysqli_query($conn, $sql8);

        if($result3 && $result4 && $result5 && $result6 && $result7 && $result8){
            echo "<script>alert('Details Updated'); window.open('index.php','_self');</script>";
            exit();
        }
        else{
            echo "<script>alert('Error encountered. Try again later'); window.open('index.php','_self');</script>";
            exit();
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

    label {
      font-weight: 500;
    }

    input {
      background-color: #eee !important;
      border-radius: 0 !important;
    }

    input:focus {
      outline: none !important;
      box-shadow: none !important;
      border: 1px solid black !important;
      background-color: transparent;
    }

    .btn {
      border-radius: 5px;
      margin-top: 5px;
      border: 1px solid #398378;
      background-color: #398378;
      color: #FFFFFF;
      font-size: 12px;
      font-weight: bold;
      padding: 12px 35px;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .btn:hover {
      border: 1px solid #398378;
      background-color: #fff;
      color: #398378;
    }

    .condoc {
      display: none;
    }

    .dispat {
      display: initial;
    }

    .input-group-text {
      padding: 5px 10px;
      font-size: 12px !important;
      background-color: #eee;
      border-radius: 0%;
      border-left: none;
    }
  </style>
</head>

<body>
  <!--<script src="assets/js/preloader.js"></script>-->
  <div class="body-wrapper">
    <!-- partial:../../partials/_sidebar.html -->
    <aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
      <div class="mdc-drawer__header">
        <a href="../../index.php" class="brand-logo">
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
                  <li class="mdc-list-item" role="menuitem" onclick="window.open('../../logout.php','_self')">
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
          <!-- <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-6-desktop stretch-card">
                <div class="mdc-card">
                  <h6 class="card-title">Switch</h6>
                  <div class="template-demo">
                    <div class="mdc-switch" data-mdc-auto-init="MDCSwitch">
                      <div class="mdc-switch__track"></div>
                      <div class="mdc-switch__thumb-underlay">
                        <div class="mdc-switch__thumb">
                          <input type="checkbox" id="basic-switch" class="mdc-switch__native-control" role="switch">
                        </div>
                      </div>
                    </div>
                    <div class="mdc-switch mdc-switch--checked" data-mdc-auto-init="MDCSwitch">
                      <div class="mdc-switch__track"></div>
                      <div class="mdc-switch__thumb-underlay">
                        <div class="mdc-switch__thumb">
                          <input type="checkbox" id="basic-switch" class="mdc-switch__native-control" role="switch"
                            checked>
                        </div>
                      </div>
                    </div>
                    <div class="mdc-switch mdc-switch--disabled" data-mdc-auto-init="MDCSwitch">
                      <div class="mdc-switch__track"></div>
                      <div class="mdc-switch__thumb-underlay">
                        <div class="mdc-switch__thumb">
                          <input type="checkbox" id="basic-switch" class="mdc-switch__native-control" role="switch">
                        </div>
                      </div>
                    </div>
                    <div class="mdc-switch mdc-switch--secondary" data-mdc-auto-init="MDCSwitch">
                      <div class="mdc-switch__track"></div>
                      <div class="mdc-switch__thumb-underlay">
                        <div class="mdc-switch__thumb">
                          <input type="checkbox" id="basic-switch" class="mdc-switch__native-control" role="switch"
                            checked>
                        </div>
                      </div>
                    </div>
                    <div class="mdc-switch mdc-switch--success" data-mdc-auto-init="MDCSwitch">
                      <div class="mdc-switch__track"></div>
                      <div class="mdc-switch__thumb-underlay">
                        <div class="mdc-switch__thumb">
                          <input type="checkbox" id="basic-switch" class="mdc-switch__native-control" role="switch"
                            checked>
                        </div>
                      </div>
                    </div>
                    <div class="mdc-switch mdc-switch--info" data-mdc-auto-init="MDCSwitch">
                      <div class="mdc-switch__track"></div>
                      <div class="mdc-switch__thumb-underlay">
                        <div class="mdc-switch__thumb">
                          <input type="checkbox" id="basic-switch" class="mdc-switch__native-control" role="switch"
                            checked>
                        </div>
                      </div>
                    </div>
                    <div class="mdc-switch mdc-switch--warning" data-mdc-auto-init="MDCSwitch">
                      <div class="mdc-switch__track"></div>
                      <div class="mdc-switch__thumb-underlay">
                        <div class="mdc-switch__thumb">
                          <input type="checkbox" id="basic-switch" class="mdc-switch__native-control" role="switch"
                            checked>
                        </div>
                      </div>
                    </div>
                    <div class="mdc-switch mdc-switch--light" data-mdc-auto-init="MDCSwitch">
                      <div class="mdc-switch__track"></div>
                      <div class="mdc-switch__thumb-underlay">
                        <div class="mdc-switch__thumb">
                          <input type="checkbox" id="basic-switch" class="mdc-switch__native-control" role="switch"
                            checked>
                        </div>
                      </div>
                    </div>
                    <div class="mdc-switch mdc-switch--dark" data-mdc-auto-init="MDCSwitch">
                      <div class="mdc-switch__track"></div>
                      <div class="mdc-switch__thumb-underlay">
                        <div class="mdc-switch__thumb">
                          <input type="checkbox" id="basic-switch" class="mdc-switch__native-control" role="switch"
                            checked>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-6-desktop stretch-card">
                <div class="mdc-card">
                  <h6 class="card-title">Select Menu</h6>
                  <div class="template-demo">
                    <div class="mdc-select demo-width-class" data-mdc-auto-init="MDCSelect">
                      <input type="hidden" name="enhanced-select">
                      <i class="mdc-select__dropdown-icon"></i>
                      <div class="mdc-select__selected-text"></div>
                      <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                        <ul class="mdc-list">
                          <li class="mdc-list-item mdc-list-item--selected" data-value="" aria-selected="true">
                          </li>
                          <li class="mdc-list-item" data-value="grains">
                            Bread, Cereal, Rice, and Pasta
                          </li>
                          <li class="mdc-list-item" data-value="vegetables">
                            Vegetables
                          </li>
                          <li class="mdc-list-item" data-value="fruit">
                            Fruit
                          </li>
                        </ul>
                      </div>
                      <span class="mdc-floating-label">Pick a Food Group</span>
                      <div class="mdc-line-ripple"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
          <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                  <h6 class="card-title" style="font-weight: 600; margin-bottom: 20px; font-size: 22px;" id="profileNameHeading">Edit Profile: </h6>  
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="full_name">Full Name</label>
                          <input type="text" class="form-control" id="full_name" value="" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="dob">Date Of Birth</label>
                          <input type="text" onfocus="(this.type='date')" class="form-control" id="dob"
                            value="" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="number">Phone Number</label>
                          <input type="text" onfocus="(this.type='number')" class="form-control" id="number"
                            value="" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" id="profileEmail" value="" required>
                        </div>
                      </div>
                      <!-- if user is counselor or doctor it should be displayed -->
                      <div class="col-md-12 ">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="address">Address</label>
                              <input type="text" class="form-control" id="address"
                                value="">
                            </div>
                          </div>
                        </div>
                      </div>

                      <!--<div class="col-md-6">
                        <div class="form-group">
                          <label for="password">Password</label>
                          <div class="input-group-append">
                            <input type="password" class="form-control" id="password" minlength="8" value=""
                              required>
                            <span class="input-group-text" onclick="password_show_hide();">
                              <i class="fas fa-eye" id="show_eye"></i>
                              <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                            </span>
                          </div>
                          <small id="password" class="form-text text-muted">8-character minimum; case sensitive </small>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="confirmpassword">Confirm Password</label>
                          <div class="input-group-append">
                            <input type="password" class="form-control" id="confirmpassword" minlength="8"
                              value="" required>
                            <span class="input-group-text" onclick="password_show_hidee();">
                              <i class="fas fa-eye" id="show_eyee"></i>
                              <i class="fas fa-eye-slash d-none" id="hide_eyee"></i>
                            </span>
                          </div>
                        </div>
                      </div>-->
                      <div class="col-md-3">
                        <button class="btn" onclick="submitProfile()">Save New Details</button>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                  <h6 class="card-title">Checkbox</h6>
                  <div class="template-demo">
                    <div class="mdc-form-field">
                      <div class="mdc-checkbox">
                        <input type="checkbox" class="mdc-checkbox__native-control" id="checkbox-1" />
                        <div class="mdc-checkbox__background">
                          <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                            <path class="mdc-checkbox__checkmark-path" fill="none"
                              d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                          </svg>
                          <div class="mdc-checkbox__mixedmark"></div>
                        </div>
                      </div>
                      <label for="checkbox-1">Default</label>
                    </div>
                    <div class="mdc-form-field">
                      <div class="mdc-checkbox mdc-checkbox--disabled">
                        <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control"
                          disabled />
                        <div class="mdc-checkbox__background">
                          <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                            <path class="mdc-checkbox__checkmark-path" fill="none"
                              d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                          </svg>
                          <div class="mdc-checkbox__mixedmark"></div>
                        </div>
                      </div>
                      <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Disabled</label>
                    </div>
                    <div class="mdc-form-field">
                      <div class="mdc-checkbox">
                        <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control"
                          checked />
                        <div class="mdc-checkbox__background">
                          <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                            <path class="mdc-checkbox__checkmark-path" fill="none"
                              d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                          </svg>
                          <div class="mdc-checkbox__mixedmark"></div>
                        </div>
                      </div>
                      <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Primary Checked</label>
                    </div>
                    <div class="mdc-form-field">
                      <div class="mdc-checkbox mdc-checkbox--secondary">
                        <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control"
                          checked />
                        <div class="mdc-checkbox__background">
                          <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                            <path class="mdc-checkbox__checkmark-path" fill="none"
                              d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                          </svg>
                          <div class="mdc-checkbox__mixedmark"></div>
                        </div>
                      </div>
                      <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Secondary</label>
                    </div>
                    <div class="mdc-form-field">
                      <div class="mdc-checkbox mdc-checkbox--success">
                        <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control"
                          checked />
                        <div class="mdc-checkbox__background">
                          <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                            <path class="mdc-checkbox__checkmark-path" fill="none"
                              d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                          </svg>
                          <div class="mdc-checkbox__mixedmark"></div>
                        </div>
                      </div>
                      <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Success</label>
                    </div>
                    <div class="mdc-form-field">
                      <div class="mdc-checkbox mdc-checkbox--info">
                        <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control"
                          checked />
                        <div class="mdc-checkbox__background">
                          <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                            <path class="mdc-checkbox__checkmark-path" fill="none"
                              d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                          </svg>
                          <div class="mdc-checkbox__mixedmark"></div>
                        </div>
                      </div>
                      <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Info</label>
                    </div>
                    <div class="mdc-form-field">
                      <div class="mdc-checkbox mdc-checkbox--warning">
                        <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control"
                          checked />
                        <div class="mdc-checkbox__background">
                          <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                            <path class="mdc-checkbox__checkmark-path" fill="none"
                              d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                          </svg>
                          <div class="mdc-checkbox__mixedmark"></div>
                        </div>
                      </div>
                      <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Warning</label>
                    </div>
                    <div class="mdc-form-field">
                      <div class="mdc-checkbox mdc-checkbox--light">
                        <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control"
                          checked />
                        <div class="mdc-checkbox__background">
                          <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                            <path class="mdc-checkbox__checkmark-path" fill="none"
                              d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                          </svg>
                          <div class="mdc-checkbox__mixedmark"></div>
                        </div>
                      </div>
                      <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Light</label>
                    </div>
                    <div class="mdc-form-field">
                      <div class="mdc-checkbox mdc-checkbox--dark">
                        <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control"
                          checked />
                        <div class="mdc-checkbox__background">
                          <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                            <path class="mdc-checkbox__checkmark-path" fill="none"
                              d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                          </svg>
                          <div class="mdc-checkbox__mixedmark"></div>
                        </div>
                      </div>
                      <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Dark</label>
                    </div>
                    <div class="mdc-form-field">
                      <div class="mdc-checkbox mdc-checkbox--custom">
                        <input type="checkbox" id="basic-custom-checkbox" class="mdc-checkbox__native-control" />
                        <div class="mdc-checkbox__background">
                          <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                            <path class="mdc-checkbox__checkmark__path" dropzone="" fill="none" stroke="white"
                              d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                          </svg>
                          <div class="mdc-checkbox__mixedmark"></div>
                        </div>
                      </div>
                      <label for="basic-custom-checkbox">Custom colored</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
        </main>
        <form id="editProfile" method="post" action="edit-profile-patient.php">
            <input type="hidden" name="profileName" id="profileName">
            <input type="hidden" name="profileMail" id="profileMail">
            <input type="hidden" name="profileAddr" id="profileAddr">
            <input type="hidden" name="profileDob" id="profileDob">
            <input type="hidden" name="profileNo" id="profileNo">
            <input type="hidden" name="un" id="un">
        </form>
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

  function userSession(){
    name = "<?php echo $FullName; ?>";
    document.getElementById("name").innerHTML = name;
    document.getElementById("greeting_msg").innerHTML = "Greetings "+name+"!";
    document.getElementById("user-full-name").innerHTML = name;

    email = "<?php echo $UserName; ?>";
    document.getElementById("email").innerHTML = email;

    document.getElementById("un").value = "<?php echo $profileUn;?>";

  }

  userSession();

  profileUn="";

  function  displayProfile(){

    profileName = "<?php echo $profileName;?>";
    document.getElementById("profileNameHeading").innerHTML += profileName;
    document.getElementById("full_name").value = profileName;
    
    profileUn = "<?php echo $profileUn;?>";
    document.getElementById("profileEmail").value = profileUn;
    
    profileAddr = "<?php echo $profileAddr;?>";
    document.getElementById("address").value = profileAddr;

    profileDob = "<?php echo $profileDob;?>";
    document.getElementById("dob").value = profileDob;

    profileNo = "<?php echo $profileNo;?>";
    document.getElementById("number").value = profileNo;

  }

  displayProfile();

  function submitProfile(){

    document.getElementById("profileName").value = document.getElementById("full_name").value;
    document.getElementById("profileMail").value = document.getElementById("profileEmail").value;
    document.getElementById("profileAddr").value = document.getElementById("address").value;
    document.getElementById("profileDob").value = document.getElementById("dob").value;
    document.getElementById("profileNo").value = document.getElementById("number").value;
    document.getElementById("editProfile").submit();
  }

  /*// get the password and confirm password fields
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
    }*/
  </script>
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