
<?php

    session_start();
    include "../../db_conn.php";

    if(isset($_SESSION['UserName'])){
        $FullName = $_SESSION['FullName'];
        $UserName = $_SESSION['UserName'];
        $UserCategory = $_SESSION['UserCategory'];

        //CHANGE APPOINTMENT2 TO APPOINTMENT
        $sql = "SELECT * FROM appointment WHERE MgtUserName = '$UserName' AND patientUserName NOT IN (SELECT patientUsername FROM deletepatient) AND Date > CURRENT_DATE UNION SELECT * FROM appointment WHERE MgtUserName = '$UserName' AND patientUserName NOT IN (SELECT patientUsername FROM deletepatient) AND Date = CURRENT_DATE AND Time >= CURRENT_TIME ORDER BY Date, Time;" ;
        $result = mysqli_query($conn, $sql);
        $len = mysqli_num_rows($result);

        $name = array();
        $dob = array();
        $score = array();
        $patientUserName = array();
        $date = array();
        $time = array();
        $i=0;
        
        if($len > 0){

          while($row = mysqli_fetch_assoc($result)){

            $un = $row['PatientUserName'];
            $patientUserName[$i] = $un;
            $date[$i] = $row['Date'];
            $time[$i] = $row['Time'];

            $sql2 = "SELECT FullName, DOB FROM Patient WHERE UserName = '$un' ";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $name[$i] = $row2['FullName'];
            $dob[$i] = $row2['DOB'];

            $sql3 = "SELECT Score FROM assessmentresults WHERE UserName = '$un' ";
            $result3 = mysqli_query($conn,$sql3);
            $row3 = mysqli_fetch_assoc($result3);
            $score[$i++] = $row3['Score'];
          }

          if(isset($_POST['patientUserName'])){
            $patientUn = $_POST['patientUserName'];
            $reason = $_POST['reason'];
            $sql6 = "INSERT INTO deletepatient(patientUserName, mgtUserName, reason) VALUES ('$patientUn','$UserName','$reason')";
            if(mysqli_query($conn,$sql6)){
              echo "<script>alert('Patient Deleted'); window.open('list-of-patients-assigned-to-counselor-itself.php','_self');</script>";
              exit();
            }
            else{
              echo "<script>alert('Error Encountered while deleting Patient. Try again later'); window.open('list-of-patients-assigned-to-counselor-itself.php','_self');</script>";
              exit();
            }
          }
        }

        $flag = 0;
        $sql4 = "SELECT * FROM appointment WHERE MgtUserName = '$UserName' AND PatientUserName NOT IN (SELECT patientUsername FROM deletepatient UNION SELECT PatientUserName FROM appointment WHERE MgtUserName = '$UserName' AND PatientUserName NOT IN (SELECT patientUsername FROM deletepatient) AND Date > CURRENT_DATE UNION SELECT PatientUserName FROM appointment WHERE MgtUserName = '$UserName' AND PatientUserName NOT IN (SELECT patientUsername FROM deletepatient ) AND Date = CURRENT_DATE AND Time >= CURRENT_TIME UNION SELECT PatientUserName FROM assignpatient WHERE AdminCategory = 'D' UNION SELECT PatientUserName from pending_appointment) ORDER BY Date, Time;";
        $result4 = mysqli_query($conn, $sql4);
        $idx = 0;
        $idxLen = 0;
        if(mysqli_num_rows($result4)>0){
          $flag =1;
          $idx = $i;

          while($row = mysqli_fetch_assoc($result4)){

            $un = $row['PatientUserName'];
            $patientUserName[$i] = $un;
            $date[$i] = $row['Date'];
            $time[$i] = $row['Time'];

            $sql2 = "SELECT FullName, DOB FROM Patient WHERE UserName = '$un' ";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $name[$i] = $row2['FullName'];
            $dob[$i] = $row2['DOB'];

            $sql3 = "SELECT Score FROM assessmentresults WHERE UserName = '$un' ";
            $result3 = mysqli_query($conn,$sql3);
            $row3 = mysqli_fetch_assoc($result3);
            $score[$i++] = $row3['Score'];
          }

          $idxLen = $i;
        }
    }
    else{
        echo "<script>alert('Error encountered. Try again later'); window.open('authenticate.php','_self');</script>";
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
              <a class="mdc-drawer-link active" href="list-of-patients-assigned-to-counselor-itself.php">
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
              <a class="mdc-drawer-link" href="edit-profile-for-counselors.php" >
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
          <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card p-0">
                  <h6 class="card-title card-padding pb-2"
                    style="font-weight: 600; margin-bottom: 20px; font-size: 22px;">Upcoming Consultations</h6>
                  <div class="table-responsive">
                    <div class="row" style="display: flex; justify-content: center;">
                      <div class="col-md-12">
                      <h7 id="msg" style="visibility: visible; color: red">No Upcoming Appointments...</h7>
                        <table class="table table-bordered table-hover"  id="table" style="visibility: hidden">
                          <thead>
                            <tr>
                              <!-- <th scope="col">No.</th> -->
                              <th scope="col">Full Name</th>
                              <th scope="col">Date of Birth</th>
                              <th scope="col">Self Assessment Score</th>
                              <th scope="col">Date</th>
                              <th scope="col">Time Assigned</th>
                              <!-- <th scope="col">Doctor Assigned</th> -->
                              <th scope="col">Details/Decision</th>
                            </tr>
                          </thead>
                          <tbody id="table-body">
                            <!--<tr>
                              <!-- <td scope="row" style="width: 5%;">1</td> -->
                              <!--<td style="width: 15%;">Karnik Shah</td>
                              <td style="width: 16%;">12-12-2000</td>
                              <td style="width: 16%;">10/10</td>
                              <td style="width: 12%;">23-10-2023</td>
                              <td style="width: 12%;">10:00AM</td>
                              <!-- <td style="width: 14%;">
                                <div class="dropdown">
                                  <select id="doctor">
                                    <option value="">Select Doctor</option>
                                  </select>
                                </div>
                              </td> -->
                              <!--<td style="width: 13%;">
                                <a href="specific_patient.php">View More</a>
                              </td>
                              <td style="width: 6%;">
                                <button type="button" class="btn delete" data-toggle="modal" data-target="#delete">
                                  <i class="fas fa-trash"></i>
                                </button>
                                <div class="modal fade deletecontent" id="delete" tabindex="-1" role="dialog"
                                  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <!-- <h5 class="modal-title" id="exampleModalLongTitle">Do you want to Remove the Patient?</h5> -->
                                        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="row">
                                          <div class="col-md-12">
                                            <i class="fa fa-times-circle"></i>
                                            <h4>Are you sure?</h4>
                                            <p>Do you really want to delete the record of the patient?<br>This process cannot be undone.</p>
                                            <form action="">
                                              <textarea name="whydelete" id="whydelete" cols="30" rows="5" required></textarea>
                                            </form>
                                          </div>
                                        </div>
                                        
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                          data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger">Delete</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </td>
                              <!-- <td style="width: 20%;">
                                <div class="dropdown">
                                  <select id="time">
                                    <option value="">Select Time</option>
                                  </select>
                                  </div>
                                </div>
                              </td> -->
                            <!--</tr>-->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div id="followUp" style="visibility: hidden">
                  <h6 class="card-title card-padding pb-2"
                    style="font-weight: 600; margin-bottom: 20px; font-size: 22px;" id="follow">Follow-up Consultations</h6>
                  <div class="table-responsive">
                    <div class="row" style="display: flex; justify-content: center;">
                      <div class="col-md-12">
                        <table class="table table-bordered table-hover"  id="table">
                          <thead>
                            <tr>
                              <!-- <th scope="col">No.</th> -->
                              <th scope="col">Full Name</th>
                              <th scope="col">Date of Birth</th>
                              <th scope="col">Self Assessment Score</th>
                              <th scope="col">Date</th>
                              <th scope="col">Time Assigned</th>
                              <!-- <th scope="col">Doctor Assigned</th> -->
                              <th scope="col">Details/Decision</th>
                              <th scope="col">Delete</th>
                            </tr>
                          </thead>
                          <tbody id="table-body2">
                            <!--<tr>
                              <!-- <td scope="row" style="width: 5%;">1</td> -->
                              <!--<td style="width: 15%;">Karnik Shah</td>
                              <td style="width: 16%;">12-12-2000</td>
                              <td style="width: 16%;">10/10</td>
                              <td style="width: 12%;">23-10-2023</td>
                              <td style="width: 12%;">10:00AM</td>
                              <!-- <td style="width: 14%;">
                                <div class="dropdown">
                                  <select id="doctor">
                                    <option value="">Select Doctor</option>
                                  </select>
                                </div>
                              </td> -->
                              <!--<td style="width: 13%;">
                                <a href="specific_patient.php">View More</a>
                              </td>
                              <td style="width: 6%;">
                                <button type="button" class="btn delete" data-toggle="modal" data-target="#delete">
                                  <i class="fas fa-trash"></i>
                                </button>
                                <div class="modal fade deletecontent" id="delete" tabindex="-1" role="dialog"
                                  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <!-- <h5 class="modal-title" id="exampleModalLongTitle">Do you want to Remove the Patient?</h5> -->
                                        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="row">
                                          <div class="col-md-12">
                                            <i class="fa fa-times-circle"></i>
                                            <h4>Are you sure?</h4>
                                            <p>Do you really want to delete the record of the patient?<br>This process cannot be undone.</p>
                                            <form action="">
                                              <textarea name="whydelete" id="whydelete" cols="30" rows="5" required></textarea>
                                            </form>
                                          </div>
                                        </div>
                                        
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                          data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger">Delete</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </td>
                              <!-- <td style="width: 20%;">
                                <div class="dropdown">
                                  <select id="time">
                                    <option value="">Select Time</option>
                                  </select>
                                  </div>
                                </div>
                              </td> -->
                            <!--</tr>-->
                          </tbody>
                        </table>
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

    FullName=<?php echo '["' . implode('", "', $name) . '"]' ?>;
    dob=<?php echo '["' . implode('", "', $dob) . '"]' ?>;
    score=<?php echo '["' . implode('", "', $score) . '"]' ?>;
    userName=<?php echo '["' . implode('", "', $patientUserName) . '"]' ?>;
    setDate=<?php echo '["' . implode('", "', $date) . '"]' ?>;
    setTime=<?php echo '["' . implode('", "', $time) . '"]' ?>;

    function displayList(){

      len = <?php echo $len; ?>;

      if(len > 0){

        document.getElementById("table").style.visibility = "visible";
        document.getElementById("msg").style.visibility = "hidden";

        str="";

        for(i=0;i<len;i++){

          str+='<tr>'
          str+='<td style="width: 15%;">'+FullName[i]+'</td>'
          str+='<td style="width: 16%;">'+dob[i]+'</td>'
          str+='<td style="width: 16%;">'+score[i]+'</td>'
          str+='<td style="width: 12%;">'+setDate[i]+'</td>'
          str+='<td style="width: 12%;">'+setTime[i]+'</td>'
          str+='<td style="width: 10%;"><a href="javascript: patient('+i+')" id="view">View More</a>'
          str+='<form id="'+i+'" method="POST" action="specific_patient.php">'
          str+='<input type="hidden" id="name" name="name" value="'+FullName[i]+'">'
          str+='<input type="hidden" id="username" name="username" value="'+userName[i]+'">'
          str+='<input type="hidden" id="score" name="score" value="'+score[i]+'"></form>'
          str+='</td>'
        }

        document.getElementById("table-body").innerHTML = str;
      }

      flag = <?php echo $flag; ?>;
      if(flag == 1){
        document.getElementById("followUp").style.visibility = "visible";
        displayPast();
      }
    }

    displayList();

    function displayPast(){

        idx2 = <?php echo $idx ?>; 
        idxLen = <?php echo $idxLen ?>;

        str="";

        for(i=idx2;i<idxLen;i++){

          str+='<tr>'
          str+='<td style="width: 15%;">'+FullName[i]+'</td>'
          str+='<td style="width: 16%;">'+dob[i]+'</td>'
          str+='<td style="width: 16%;">'+score[i]+'</td>'
          str+='<td style="width: 12%;">'+setDate[i]+'</td>'
          str+='<td style="width: 12%;">'+setTime[i]+'</td>'
          str+='<td style="width: 10%;"><a href="javascript: patient('+i+')" id="view">View More</a>'
          str+='<form id="'+i+'" method="POST" action="specific_patient-for-counselors.php">'
          str+='<input type="hidden" id="name" name="name" value="'+FullName[i]+'">'
          str+='<input type="hidden" id="username" name="username" value="'+userName[i]+'">'
          str+='<input type="hidden" id="score" name="score" value="'+score[i]+'"></form>'
          str+='</td>'
          str+='<td style="width: 10%;">'
          str+='<button type="button" class="btn delete" data-toggle="modal" data-target="#delete" onclick="setIdx('+i+')">'
          str+='<i class="fas fa-trash"></i></button>'
          str+='<div class="modal fade deletecontent" id="delete" tabindex="-1" role="dialog"'
          str+='aria-labelledby="exampleModalCenterTitle" aria-hidden="true">'
          str+='<div class="modal-dialog modal-dialog-centered" role="document">'
          str+='<div class="modal-content">'
          str+='<div class="modal-header">'
          str+='<!-- <h5 class="modal-title" id="exampleModalLongTitle">Do you want to Remove the Patient?</h5> -->'
          str+='<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
          str+='<span aria-hidden="true">&times;</span>'
          str+='</button></div>'
          str+='<div class="modal-body">'
          str+='<div class="row">'
          str+='<div class="col-md-12">'
          str+='<i class="fa fa-times-circle"></i>'
          str+='<h4>Are you sure?</h4>'
          str+='<p>Do you really want to delete the record of the patient?<br>This process cannot be undone.</p>'
          str+='<textarea name="whydelete" id="whydelete'+i+'" cols="30" rows="5" required></textarea>'
          str+='</div></div></div>'
          str+='<div class="modal-footer">'
          str+='<button type="button" class="btn btn-secondary"'
          str+='data-dismiss="modal">Cancel</button>'
          str+='<form id="deletePatient'+i+'" method="post" action="list-of-patients-assigned-to-counselor-itself.php">'
          str+='<input type="hidden" value="" name="patientUserName" id="patientUserName">'
          str+='<input type="hidden" value="" name="reason" id="reason'+i+'">'                            
          str+='<input type="submit" class="btn btn-danger" onclick="deletePatient('+i+')" value="Delete">'
          str+='</form>'
        }

        document.getElementById("table-body2").innerHTML = str;

    }

    idx=0;

    function setIdx(i){
      idx = i;
    }

    function deletePatient(i){

      document.getElementById("patientUserName").value = userName[idx];
      document.getElementById("reason"+i).value = document.getElementById("whydelete"+i).value;
    }

    function patient(i){

      document.getElementById(i).submit();

    }

    /*var timeSelect = document.getElementById("time");
    for (var hour = 0; hour < 24; hour++) {
      for (var minute = 0; minute < 60; minute += 60) {
        var timeString = hour.toString().padStart(2, '0') + ':' + minute.toString().padStart(2, '0');
        var option = document.createElement("option");
        option.text = timeString;
        option.value = timeString;
        timeSelect.add(option);
      }
    }*/
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