<?php

    session_start();
    if(isset($_SESSION['UserName'])){
        $FullName = $_SESSION['FullName'];
        $UserName = $_SESSION['UserName'];
        $UserCategory = $_SESSION['UserCategory'];
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

    form label {
      font-weight: 500;
    }

    form input {
      background-color: #eee !important;
      border-radius: 0 !important;
    }

    form input:focus {
      outline: none !important;
      box-shadow: none !important;
      border: 1px solid black !important;
      background-color: transparent;
    }

    form .btn {
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

    form .btn:hover {
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
  <!-- <script src="assets/js/preloader.js"></script> -->
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
              <a class="mdc-drawer-link" href="list-of-patients-assigned-to-counselor-main.php">
                <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">pages</i>
                Patients Assigned
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="list-of-patients-assigned-to-counselor-itself.php">
                <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">dashboard</i>
                Patients to Consult
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="list-of-doctors.php">
                <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                  aria-hidden="true">track_changes</i>
                List of Doctors
              </a>
            </div>
            <!-- <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link bell" href="#">
                <i class="material-icons mdi mdi-bell"></i>
                Notifications
              </a>
            </div> -->
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="edit-profile.php" >
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
                    <a href="../../logout.php"><h6 class="item-subject font-weight-normal">Logout</h6></a>
                    </div>
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
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                    <a href="../../logout.php"><h6 class="item-subject font-weight-normal">Logout</h6></a>
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
                  <h6 class="card-title" style="font-weight: 600; margin-bottom: 20px; font-size: 22px;">Edit Your
                    Profile</h6>
                  <form action="../../update-profile.php" method="post"> 
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="full_name">Full Name</label>
                          <input type="text" name = "name" class="form-control" id="full_name" value='<?php echo $_SESSION['FullName'] ?>' required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="dob">Date Of Birth</label>
                          <input type="text" name = "date-of-birth" onfocus="(this.type='date')" class="form-control" id="dob"
                            value='<?php echo $_SESSION['DOB'] ?>' required>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                              <label for="address">Address</label>
                              <input type="text" name = "address" class="form-control" id="address"
                                value='<?php echo $_SESSION['Address'] ?>' required>
                        </div>
                      </div>
                      <!-- <div class="col-md-6">
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" id="email" value="karnik@gmail.com" required>
                        </div>
                      </div> -->

                      <!-- if user is patient it should be displayed -->
                      <!-- <div class="col-md-12 dispat">
                        <div class="form-group">
                          <label for="address">Address</label>
                          <input type="text" class="form-control" id="address"
                            value="1455 Boul. de Maisonneuve O, Montréal, QC H3G 1M8" required>
                        </div>
                      </div> -->

                      <!-- if user is counselor or doctor it should be displayed -->
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="number">Phone Number</label>
                              <input type="text" name = "phone" onfocus="(this.type='number')" class="form-control" id="number" pattern="(\+\d{1,2}[-\s.]?)?([(]\d{3}[)]|\d{3})[-\s.]?\d{3}[-\s.]?\d{4}?"
                                value='<?php echo $_SESSION['PhoneNumber'] ?>' required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="full_name">Quebec Registered Number</label>
                              <input type="text" name = "QNR" class="form-control" id="full_name" value='<?php echo $_SESSION['QNR'] ?>'
                                minlength="14" maxlength="14" pattern="[A-Z]{4}-\d{4}-\d{4}" required>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="password">Password</label>
                          <div class="input-group-append">
                            <input type="password" name = "password" class="form-control" id="password" minlength="8" value=<?php echo str_rot13($_SESSION['Password']) ?>
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
                              value=<?php echo str_rot13($_SESSION['Password']) ?> required>
                            <span class="input-group-text" onclick="password_show_hidee();">
                              <i class="fas fa-eye" id="show_eyee"></i>
                              <i class="fas fa-eye-slash d-none" id="hide_eyee"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <button type="submit" class="btn">Save New Details</button>
                      </div>
                    </div>
                  </form>
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
    function userSession(){
    name = "<?php echo $FullName; ?>";
    document.getElementById("name").innerHTML = name;
    document.getElementById("greeting_msg").innerHTML = "Greetings "+name+"!";
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