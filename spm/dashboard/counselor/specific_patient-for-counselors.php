<?php

    session_start();
    include "../../db_conn.php";

    if(isset($_SESSION['UserName'])){
      $FullName = $_SESSION['FullName'];
      $UserName = $_SESSION['UserName'];
      $UserCategory = $_SESSION['UserCategory'];
      
      if(isset($_POST['name'])){
        $patientName = $_POST['name'];
        $score = $_POST['score'];
        $un = $_POST['username'];

        $sql = "SELECT * FROM patient WHERE UserName = '$un'";
        $result = mysqli_query($conn, $sql);
        if($result){
          $row = mysqli_fetch_assoc($result);
          $address = $row['Address'];
          $phone = $row['PhoneNumber'];
          $dob = $row['DOB'];

          $sql2 = "SELECT * FROM assessmentresults WHERE UserName = '$un'";
          $result2 = mysqli_query($conn, $sql2);
          $row2 = mysqli_fetch_assoc($result2);
          $assessmentResult = $row2['Result'];

          $sql3 = "SELECT FullName, UserName FROM doctor ORDER BY FullName";
          $result3 = mysqli_query($conn, $sql3);
          $len = mysqli_num_rows($result3);
          $options = array();
          $email = array();
          $i=0;
          while($row3 = mysqli_fetch_assoc($result3)){
            $options[$i++] = $row3['FullName'];
            $email[$i++] = $row3['UserName'];
          }
        }
      }
      elseif(isset($_POST['doctorUn'])){
          $docUn=$_POST['doctorUn'];
          $patientUn=$_POST['patientUn'];
          $patientDob=$_POST['patientDob'];
          $setDate = $_POST['setDate'];
          $setTime = $_POST['setTime'];

          if($docUn != ""){
            //CHANGE ASSIGNPATIENT2 TO ASSIGNPATIENT
            $sql4 = "INSERT INTO assignpatient(PatientUserName, PatientDOB, AdminUserName, AdminCategory, AssignedBy, AssignerCategory) VALUES ('$patientUn','$patientDob','$docUn','D','$UserName','$UserCategory')";
            if(mysqli_query($conn, $sql4)){
              echo "<script>alert('Patient Assigned to Doctor'); window.open('list-of-patients-assigned-to-counselor-main.php','_self');</script>";
              exit();
            }
            else{
              echo "<script>alert('Error during Doctor Assignment. Try again later'); window.open('list-of-patients-assigned-to-counselor-main.php','_self');</script>";
              exit(); 
            }
          }
          else{
            //CHANGE APPOINTMENT2 TO APPOINTMENT
            $sql5 = "INSERT INTO pending_appointment(PatientUserName, MgtUserName, MgtCategory, Date, Time) VALUES ('$patientUn','$UserName','$UserCategory','$setDate','$setTime')";
            if(mysqli_query($conn, $sql5)){
              echo "<script>alert('Appointment Set'); window.open('list-of-patients-assigned-to-counselor-main.php','_self');</script>";
              exit();
            }
            else{
              echo "<script>alert('Error during Appointment Set up". mysqli_error($conn)." Try again later'); window.open('list-of-patients-assigned-to-counselor-main.php','_self');</script>";
              exit(); 
            }
          }         
      }
      elseif(isset($_POST['patientUserName'])){
        $patientUn = $_POST['patientUserName'];
        $reason = $_POST['reason'];
        $sql6 = "INSERT INTO deletepatient(patientUserName, mgtUserName, reason) VALUES ('$patientUn','$UserName','$reason')";
        if(mysqli_query($conn,$sql6)){
          echo "<script>alert('Patient Deleted'); window.open('list-of-patients-assigned-to-counselor-main.php','_self');</script>";
          exit();
        }
      }
      else{
        echo "<script>alert('Error Encountered. Try again later'); window.open('index.php','_self');</script>";
        exit();
      }
    }
    else{
        echo "<script>alert('Error while logging in. Try again later'); window.open('../../../authenticate.php','_self');</script>";
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
  </style>
  <link rel="stylesheet" href="../assets/css/my_style.css">
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
      <div class="page-wrapper mdc-toolbar-fixed-adjust specificpatient">
        <main class="content-wrapper">
          <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card p-0">
                  <div class="spdetails">
                    <div class="row">
                      <div class="col-md-7">
                        <h6 id="patientName"></h6>
                        <p id="address"><b>Patient's Address: </b></p>
                      </div>
                      <div class="col-md-5 text-right">
                        <p id="patient-email"><b>Email Address: </b></p>
                        <p id="patient-phone"><b>Phone Number: </b></p>
                        <p id="patient-dob"><b>Date of Birth: </b></p>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <div class="row" style="display: flex; justify-content: center;">
                      <div class="col-md-12">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th scope="col" style="font-size: 16px; font-weight: 600; padding: 10px 0;" colspan="3">
                                Self Assessment Test Result</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope="col">Sr. No.</th>
                              <th scope="col">Questions</th>
                              <th scope="col">Answers</th>
                            </tr>
                            <tr>
                              <td style="width: 10%;">1.</td>
                              <td style="width: 60%; text-align: left">Over the past 2 weeks, how often have you been bothered by any of the following problems: <br><strong>Little interest or pleasure in doing things</strong>?</td>
                              <td style="width: 30%;" id="row1"></td>
                              </tr>
                            <tr>
                              <td style="width: 10%;">2.</td>
                              <td style="width: 60%; text-align: left">Over the past 2 weeks, how often have you been bothered by any of the following problems: <br><strong>Feeling down, depressed or hopless?</strong></td>
                              <td style="width: 30%;" id="row2"></td>
                            </tr>
                            <tr>
                              <td style="width: 10%;">3.</td>
                              <td style="width: 60%; text-align: left">Over the past 2 weeks, how often have you been bothered by any of the following problems: <br><strong>Trouble falling asleep, staying asleep, or sleeping too much?</strong></td>
                              <td style="width: 30%;" id="row3"></td>
                            </tr>
                            <tr>
                              <td style="width: 10%;">4.</td>
                              <td style="width: 60%; text-align: left">Over the past 2 weeks, how often have you been bothered by any of the following problems: <br><strong>Feeling tired or having little energy?</strong></td>
                              <td style="width: 30%;" id="row4"></td>
                            </tr>
                            <tr>
                              <td style="width: 10%;">5.</td>
                              <td style="width: 60%; text-align: left">Over the past 2 weeks, how often have you been bothered by any of the following problems: <br><strong>Poor appetite or overeating?</strong></td>
                              <td style="width: 30%;" id="row5"></td>
                            </tr>
                            <tr>
                              <td style="width: 10%;">6.</td>
                              <td style="width: 60%; text-align: left">Over the past 2 weeks, how often have you been bothered by any of the following problems: <br><strong>Feeling bad about yourself - or that you're a failure or have let yourself or your family down</strong>?</td>
                              <td style="width: 30%;" id="row6"></td>
                            </tr>
                            <tr>
                              <td style="width: 10%;">7.</td>
                              <td style="width: 60%; text-align: left">Over the past 2 weeks, how often have you been bothered by any of the following problems: <br><strong>Trouble concentrating on things, such as reading the newspaper or watching television</strong>?</td>
                              <td style="width: 30%;" id="row7"></td>
                            </tr>
                            <tr>
                              <td style="width: 10%;">8.</td>
                              <td style="width: 60%; text-align: left">Over the past 2 weeks, how often have you been bothered by any of the following problems: <br><strong>Moving or speaking so slowly that other people could have noticed. <br>Or, the opposite - being so fidgety or restless that you have been moving around a lot <br>more than usual?</strong></td>
                              <td style="width: 30%;" id="row8"></td>
                            </tr>
                            <tr>
                              <td style="width: 10%;">9.</td>
                              <td style="width: 60%; text-align: left">Over the past 2 weeks, how often have you been bothered by any of the following problems: <br><strong>Thoughts that you would be better off dead or of hurting yourself in some way?</strong></td>
                              <td style="width: 30%;" id="row9"></td>
                            </tr>
                            <tr>
                              <td scope="col" style="font-size: 16px; font-weight: 600; padding: 10px 0; background-color: #398378; color: white;" colspan="2">
                                Total Score
                              </td>
                              <td id="totalScore" style="background-color: #398378; color: white;"></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="twoque">
                      <div class="row">
                        <div class="col-md-12">
                          <h6 style="text-decoration: underline; text-transform: capitalize;">
                            Based on the results
                          </h6>
                        </div>
                        <div class="col-md-6" style="border-right: 3px solid #eee;">
                          <h5>When do you want to Consult
                            the Patient?</h5>
                          <div class="row datetime">
                            <div class="col-md-6 dflex">
                              <p>Date:</p>
                              <input type="date" name="date" id="date">
                            </div>
                            <div class="col-md-6 dflex">
                              <p>Time:</p>
                              <select id="time">
                                <option value="">Select Time</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <h5>Which Doctor you want to Assign the Patient?</h5>
                          <div class="row datetime">
                            <div class="col-md-12 dflex">
                              <p style="width: 30%;">Select a Doctor:</p>
                              <select id="doctor">
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12 btns">
                          <a href="list-of-patients-assigned-to-counselor-main.php">Back</a>
                          <button type="button" class="btn save" data-toggle="modal" data-target="#save" onclick="checkFilled()">
                            Save the Changes
                          </button>
                          <div class="modal fade savecontent" id="save" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <!-- <h5 class="modal-title" id="exampleModalLongTitle">Do you want to Remove the Patient?</h5> -->
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <i class="fa fa-exclamation-circle"></i>
                                      <h4 id="change_msg">Are you sure?</h4>
                                      <p id="hide_msg">Do you want to save the changes for the patient?<br>This process cannot be undone.</p>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal" id="cancelSave">Cancel</button>
                                  <form id="form" method="post" action="specific_patient.php">
                                    <input type="hidden" value="" name="patientUn" id="patientUn">
                                    <input type="hidden" value="" name="patientDob" id="patientDob">
                                    <input type="hidden" value="" name="doctorUn" id="doctorUn">
                                    <input type="hidden" value="" name="setDate" id="setDate">
                                    <input type="hidden" value="" name="setTime" id="setTime">
                                    <input type="submit" class="btn btn-success" id="saveContent" onclick="setActivity()" value="Save">
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                            <button class="btn delete" data-toggle="modal" data-target="#delete">Delete the Patient
                            </button>
                          <div class="modal fade deletecontent" id="delete" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <!-- <h5 class="modal-title" id="exampleModalLongTitle">Do you want to Remove the Patient?</h5> -->
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <i class="fa fa-times-circle"></i>
                                      <h4>Are you sure?</h4>
                                      <p>Do you really want to delete the record of the patient?<br>This process cannot be undone.</p>
                                      <textarea name="whydelete" id="whydelete" cols="30" rows="5" required></textarea>
                                    </div>
                                  </div>
                                  
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Cancel</button>
                                    <form id="deletePatient" method="post" action="specific_patient.php">
                                      <input type="hidden" value="" name="patientUserName" id="patientUserName">
                                      <input type="hidden" value="" name="reason" id="reason">
                                      <input type="submit" class="btn btn-danger" onclick="deletePatient()" value="Delete">
                                    </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
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
                <span class="text-center text-sm-left d-block d-sm-inline-block tx-14">Copyright © 2023 All Rights Reserved</span>
              </div>
              <div
                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex justify-content-end">
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center tx-14">This Website is made by Team 5 </span>
              </div>
            </div>
          </div>
        </footer>
        <!-- partial -->
      </div>
    </div>
  </div>
  </body>
  <!-- plugins:js -->
  <script>

    patientName="";
    patientEmail="";
    patientDob="";
    email="";

    //info about the user in session
    function userSession(){
      name = "<?php echo $FullName; ?>";

      document.getElementById("name").innerHTML = name;
      document.getElementById("greeting_msg").innerHTML = "Greetings "+name+"!";
      document.getElementById("user-full-name").innerHTML = name;

      email = "<?php echo $UserName; ?>";
      document.getElementById("email").innerHTML = email;

      patientName = "<?php echo $patientName; ?>";
      document.getElementById("patientName").innerHTML = "Patient Name: <i>"+patientName+"</i> ";

      address = "<?php echo $address; ?>";
      document.getElementById("address").innerHTML += address;

      patientEmail = "<?php echo $un; ?>";
      document.getElementById("patient-email").innerHTML += patientEmail;

      patientDob = "<?php echo $dob; ?>";
      document.getElementById("patient-dob").innerHTML += patientDob;

      patientPhone = "<?php echo $phone; ?>";
      document.getElementById("patient-phone").innerHTML += patientPhone;    

    }

    userSession();

    function displayAssessment(){

      answers = ["<strong>Not At all </strong><br> Score: 0", "<strong>Several Days </strong><br> Score: 1", "<strong>More Than Half the Days </strong><br> Score: 2", "<strong>Nearly Every Day </strong><br> Score: 3"];
      result = "<?php echo $assessmentResult; ?>";
      for(let i=0;i<9;i++){
        rowId="row"+(i+1);
        idx=result[i];
        document.getElementById(rowId).innerHTML = answers[parseInt(idx)];
      }

      score = '<?php echo $score; ?>';
      document.getElementById('totalScore').innerHTML = score;

    }

    displayAssessment();

    function setDropDown(){

      options = <?php echo '["' . implode('", "', $options) . '"]' ?>;
      email = <?php echo '["' . implode('", "', $email) . '"]' ?>;
      str = '<option value="">Select Doctor</option>';
      
      for(i = 0;i<options.length;i++){
        str+='<option value="'+email[i]+'">'+options[i]+'</option>';
      }

      document.getElementById("doctor").innerHTML = str;

    }

    setDropDown();

    function checkFilled(){
      doctor = document.getElementById("doctor").value;
      date = document.getElementById("date").value;
      time = document.getElementById("time").value;

      if(doctor !=""){
        document.getElementById("change_msg").innerHTML = "Are you sure?";
        document.getElementById("change_msg").style.color = "black";
        document.getElementById("hide_msg").style.visibility = "visible";
        document.getElementById("saveContent").style.visibility = "visible";
        document.getElementById("cancelSave").style.visibility = "visible";
      }

      else if(date !="" && time !=""){
        document.getElementById("change_msg").innerHTML = "Are you sure?";
        document.getElementById("change_msg").style.color = "black";
        document.getElementById("hide_msg").style.visibility = "visible";
        document.getElementById("saveContent").style.visibility = "visible";
        document.getElementById("cancelSave").style.visibility = "visible";
      }

      else{
        document.getElementById("change_msg").innerHTML = "<br>Set appointment date or Assign a doctor";
        document.getElementById("change_msg").style.textAlign = "center";
        document.getElementById("change_msg").style.color = "red";
        document.getElementById("hide_msg").style.visibility = "hidden";
        document.getElementById("saveContent").style.visibility = "hidden";
        document.getElementById("cancelSave").style.visibility = "hidden";

      }
      
    }

    function setActivity(){
      document.getElementById("patientUn").value = patientEmail;
      document.getElementById("patientDob").value = patientDob;
      document.getElementById("doctorUn").value = document.getElementById("doctor").value;
      document.getElementById("setDate").value = document.getElementById("date").value;
      document.getElementById("setTime").value = document.getElementById("time").value;
    }

    function deletePatient(){
      document.getElementById("patientUserName").value = patientEmail;
      document.getElementById("reason").value = document.getElementById("whydelete").value;
    }

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
  //<script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../assets/js/material.js"></script>
  <script src="../assets/js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->

</html>