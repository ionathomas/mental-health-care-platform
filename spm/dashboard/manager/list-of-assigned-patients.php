<?php

    session_start();
    include "../../db_conn.php";

    if(isset($_SESSION['UserName'])){
        $FullName = $_SESSION['FullName'];
        $UserName = $_SESSION['UserName'];
        $UserCategory = $_SESSION['UserCategory'];

        //CHANGE APPOINTMENT2 TO APPOINTMENT
        $sql = "SELECT * FROM patient WHERE UserName IN (SELECT PatientUserName FROM assignPatient) AND UserName NOT IN (SELECT PatientUserName FROM deletepatient) ORDER BY PatientID;" ;
        $result = mysqli_query($conn, $sql);
        $len = mysqli_num_rows($result);

        $pid = array();
        $name = array();
        $dob = array();
        $score = array();
        $assigned = array();
        $assignedCategory = array();
        // $patientUserName = array();
        // $date = array();
        // $time = array();
        //echo $len;
        if($len > 0){
          $i=0;

          while($row = mysqli_fetch_assoc($result)){

            $un = $row['UserName'];
            $patientUserName[$i] = $un;
            $name[$i] = $row['FullName'];
            $dob[$i] = $row['DOB'];
            $pid[$i] = $row['PatientID'];

            //echo "".$name[$i];

            $sql2 = "SELECT Score FROM assessmentresults WHERE UserName = '$un' ";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $score[$i] = $row2['Score'];

            $sql3 = "SELECT AdminUserName from assignpatient where PatientUserName = '$un' and AdminCategory = 'D' ORDER BY TIMESTAMP DESC LIMIT 1";
            $result3 = mysqli_query($conn, $sql3);
            if(mysqli_num_rows($result3) == 1){
              $row3 = mysqli_fetch_assoc($result3);
              $assigned[$i] = $row3['AdminUserName'];
              $assignedCategory[$i] = 'Doctor';
            }
            else{

              $sql4 = "SELECT AdminUserName from assignpatient where PatientUserName = '$un' and AdminCategory = 'C' ORDER BY TIMESTAMP DESC LIMIT 1";
              $result4 = mysqli_query($conn, $sql4);
              $row4 = mysqli_fetch_assoc($result4);
              $assigned[$i] = $row4['AdminUserName'];
              $assignedCategory[$i] = 'Counselor';

            }
            
            $i++;
          }

          if(isset($_POST['patientUserName'])){
            $patientUn = $_POST['patientUserName'];
            $reason = $_POST['reason'];
            $sql6 = "INSERT INTO deletepatient(patientUserName, mgtUserName, reason) VALUES ('$patientUn','$UserName','$reason')";
            if(mysqli_query($conn,$sql6)){
              echo "<script>alert('Patient Deleted'); window.open('list-of-assigned-patients.php','_self');</script>";
              exit();
            }
            else{
              echo "<script>alert('Error Encountered while deleting Patient. Try again later'); window.open('list-of-assigned-patients.php','_self');</script>";
              exit();
            }
          }
          elseif(isset($_POST['patientUserName'])){
            $patientUn = $_POST['patientUserName'];
            $reason = $_POST['reason'];
            $sql6 = "INSERT INTO deletepatient(patientUserName, mgtUserName, reason) VALUES ('$patientUn','$UserName','$reason')";
            if(mysqli_query($conn,$sql6)){
              echo "<script>alert('Patient Deleted'); window.open('list-of-assigned-patients.php','_self');</script>";
              exit();
            }
            else{
              echo "<script>alert('Error Encountered while deleting Patient. Try again later'); window.open('list-of-assigned-patients.php','_self');</script>";
              exit();
            }
          }
        }
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
  </style>
  <link rel="stylesheet" href="../assets/css/my_style.css">
</head>

<body>
  <!--<script src="assets/js/preloader.js"></script>-->
  <div class="body-wrapper">
    <!-- partial:../../partials/_sidebar.html -->
    <aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
      <div class="mdc-drawer__header">
        <a href="index.html" class="brand-logo">
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
                    <a href="../../logout.php"><div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">Logout</h6>
                    </div></a>
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
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card p-0">
                  <div class="row">
                    <div class="col-md-8 nopadd">
                      <h6 class="card-title card-padding pb-2"
                        style="font-weight: 600; margin-bottom: 20px; font-size: 22px;">Assigned Patients</h6>
                    </div>
                    <div class="col-md-4 nopadd searchinput">
                      <input type="text" id="searchInput"  onkeyup="searchTable()" style="margin-bottom: 20px;" placeholder="Search Patient"
                        title="Type in patient id">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <div class="row" style="display: flex; justify-content: center;">
                      <div class="col-md-12">
                      <h7 id="msg" style="visibility: visible; color: red">No Unassigned Patients...</h7>
                        <table class="table table-bordered table-hover" id="table" style="visibility: hidden">
                          <thead>
                            <tr>
                              <th scope="col" style="width: 7%;">ID</th>
                              <th scope="col" style="width: 16%;">Full Name</th>
                              <th scope="col" style="width: 13%;">Date of Birth</th>
                              <th scope="col" style="width: 16%;">Self Assessment Score</th>
                              <th scope="col" style="width: 16%;">Assigned To</th>
                              <th scope="col" style="width: 16%;">Assigned To Category</th>
                              <th scope="col" style="width: 14%;">Details</th>
                              <!-- <th scope="col">Assign a Counselor</th> -->
                              <!--<th scope="col" style="width: 16%;">History</th> -->
                              <th scope="col" style="width: 6%;">Edit</th>
                              <!-- <th scope="col" style="width: 6%;">Save</th> -->
                              <th scope="col" style="width: 6%;">Delete</th>
                            </tr>
                          </thead>
                          <tbody id="myTable">
                            <!-- <tr>
                              <td scope="row" >1001</td>
                              <td >Karnik Shah</td>
                              <td >12-12-2000</td>
                              <td >10/10</td>
                              <td><a href="specific_patient-for-manager.html">View More</a></td>
                              <td><a href="">Patient History</a></td> -->
                              <!-- <td style="width: 15%;">
                                  <div class="dropdown">
                                    <select id="counsrlor">
                                      <option value="">Select Counselor</option>
                                    </select>
                                  </div>
                                </td> -->
                              <!-- <td> -->
                                <!-- <button type="button" class="btn edit"> -->
                                <!-- <a class="edit" href="edit-profile-specifically.html"><i class="fa fa-edit"></i></a></i> -->
                                <!-- </button> -->

                              <!-- </td> -->
                              <!-- <td style="width: 8%;">10:00AM</td> -->
                              <!-- <td>
                                <button type="button" class="btn save" data-toggle="modal" data-target="#save">
                                  <i class="fa fa-check"></i>
                                </button>
                                <div class="modal fade savecontent" id="save" tabindex="-1" role="dialog"
                                  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header"> -->
                                        <!-- <h5 class="modal-title" id="exampleModalLongTitle">Do you want to Remove the Patient?</h5> -->
                                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="row">
                                          <div class="col-md-12">
                                            <i class="fa fa-exclamation-circle"></i>
                                            <h4>Are you sure?</h4>
                                            <p>Do you want to save the changes for the patient?<br>This process cannot
                                              be undone.</p>
                                          </div>
                                        </div>

                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                          data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-success">Save</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </td> 
                              <td>
                                <button type="button" class="btn delete" data-toggle="modal" data-target="#delete">
                                  <i class="fas fa-trash"></i>
                                </button>
                                <div class="modal fade deletecontent" id="delete" tabindex="-1" role="dialog"
                                  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                         <h5 class="modal-title" id="exampleModalLongTitle">Do you want to Remove the Patient?</h5> -->
                                        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="row">
                                          <div class="col-md-12">
                                            <i class="fa fa-times-circle"></i>
                                            <h4>Are you sure?</h4>
                                            <p>Do you really want to delete the record of the patient?<br>This process
                                              cannot be undone.</p>
                                            <form action="">
                                              <textarea name="whydelete" id="whydelete" cols="30" rows="5"
                                                required></textarea>
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
                            </tr> -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
        <form id="specPatient" method = "post" action = "specific_patient-for-manager.php">
          <input type="hidden" id="Fname" name="Fname" value="">
          <input type="hidden" id="username" name="username" value="">
          <input type="hidden" id="score" name="score" value="">
        </form>
        <form id="deletePatient" method="post" action="list-of-assigned-patients.php">
          <input type="hidden" value="" name="patientUserName" id="patientUserName">
          <input type="hidden" value="" name="reason" id="reason">                           
        </form>
        <form id="editPatient" method="post" action="edit-profile-patient.php">
          <input type="hidden" value="" name="patientUN" id="patientUN">
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

  }

  userSession();  

  FullName = [];
  userName = [];
  score = [];

  function displayList(){

    len = <?php echo $len; ?>;

    if(len > 0){

      document.getElementById("table").style.visibility = "visible";
      document.getElementById("msg").style.visibility = "hidden";

      Pid = <?php echo '["' . implode('", "', $pid) . '"]' ?>;
      FullName=<?php echo '["' . implode('", "', $name) . '"]' ?>;
      dob=<?php echo '["' . implode('", "', $dob) . '"]' ?>;
      score=<?php echo '["' . implode('", "', $score) . '"]' ?>;
      userName=<?php echo '["' . implode('", "', $patientUserName) . '"]' ?>;
      adminName=<?php echo '["' . implode('", "', $assigned) . '"]' ?>;
      adminCategory=<?php echo '["' . implode('", "', $assignedCategory) . '"]' ?>;

      str="";
      for(i=0;i<len;i++){
        str+='<tr><td scope="row_'+i+'" >'+Pid[i]+'</td>'
        str+='<td >'+FullName[i]+'</td>'
        str+='<td >'+dob[i]+'</td>'
        str+='<td >'+score[i]+'</td>'
        str+='<td >'+adminName[i]+'</td>'
        str+='<td >'+adminCategory[i]+'</td>'
        str+='<td><a href="javascript: patient('+i+')" id="view">View More</a></td>'
        //str+='<td><a href="">Patient History</a></td>'
        str+='<td><a class="edit" href="javascript: editProfile('+i+')"><i class="fa fa-edit"></i></a></i>'
        str+='</td><td>'
        str+='<button type="button" class="btn delete" data-toggle="modal" data-target="#delete" onclick="setIdx('+i+')">'
        str+='<i class="fas fa-trash"></i></button>'
        str+='<div class="modal fade deletecontent" id="delete" tabindex="-1" role="dialog"'
        str+='aria-labelledby="exampleModalCenterTitle" aria-hidden="true">'
        str+='<div class="modal-dialog modal-dialog-centered" role="document">'
        str+='<div class="modal-content">'
        str+='<div class="modal-header">'
        str+='<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
        str+='<span aria-hidden="true">&times;</span>'
        str+='</button></div>'
        str+='<div class="modal-body">'
        str+='<div class="row">'
        str+='<div class="col-md-12">'
        str+='<i class="fa fa-times-circle"></i>'
        str+='<h4>Are you sure?</h4>'
        str+='<p>Do you really want to delete the record of the patient?<br>This process'
        str+=' cannot be undone.</p>'
        str+='<form action="">'
        str+='<textarea name="whydelete" id="whydelete" cols="30" rows="5"'
        str+='required></textarea>'
        str+='</form></div></div></div>'
        str+='<div class="modal-footer">'
        str+='<button type="button" class="btn btn-secondary"'
        str+='data-dismiss="modal">Cancel</button>'
        str+='<button type="button" class="btn btn-danger" onclick="deletePatient()">Delete</button>'
        str+='</div></div></div></div></td></tr>'

      }

    document.getElementById("myTable").innerHTML = str;
    } 
  } 

    idx = 0

    function setIdx(i){
      idx = i;
    }

    function deletePatient(){

      document.getElementById("patientUserName").value = userName[idx];
      document.getElementById("reason").value = document.getElementById("whydelete").value;
      document.getElementById("deletePatient").submit();
    }

    displayList();

    function patient(i){

      document.getElementById("Fname").value = FullName[i];
      document.getElementById("username").value = userName[i];
      document.getElementById("score").value = score[i];
      document.getElementById("specPatient").submit();

    }

    function editProfile(i){

      document.getElementById("patientUN").value = userName[i];
      document.getElementById("editPatient").submit();
    }

    function searchTable() {
      var input, filter, table, tr, td, i, j, txtValue;
      input = document.getElementById("searchInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
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