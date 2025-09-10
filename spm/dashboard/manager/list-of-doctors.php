<?php

    session_start();
    include "../../db_conn.php";

    if(isset($_SESSION['UserName'])){
        $FullName = $_SESSION['FullName'];
        $UserName = $_SESSION['UserName'];
        $UserCategory = $_SESSION['UserCategory'];

        $sql = "SELECT * FROM doctor ORDER BY FullName";
        $result = mysqli_query($conn, $sql);
        $len = mysqli_num_rows($result);

        if($len <= 0){
          echo "<script>alert('Doctor list missing. Try again later'); window.open('../../../index.php','_self');</script>";
        }
        else{
          $name = array();
          $email = array();
          $dob = array();
          $phone = array();
          for($i = 0; $i < $len; $i++){
              $row = mysqli_fetch_assoc($result);
              
              $name[$i]=$row['FullName'];
              $dob[$i]=$row['DOB'];
              $qnr[$i]=$row['QNR'];
              $email[$i]=$row['UserName'];

          }
        }

        if(isset($_POST['UserName'])){
          $doctorUn = $_POST['UserName'];
          $sql6 = "DELETE FROM doctor WHERE UserName = '$doctorUn'";
          $sql7 = "UPDATE patient SET Assigned=0 WHERE UserName IN (SELECT PatientUserName from assignpatient WHERE AdminUserName = '$doctorUn') OR UserName IN (SELECT PatientUserName from appointment WHERE MgtUserName = '$doctorUn')";
          if(mysqli_query($conn,$sql6) && mysqli_query($conn, $sql7)){
            echo "<script>alert('Doctor Deleted'); window.open('list-of-doctors.php','_self');</script>";
            exit();
          }
          else{
            echo "<script>alert('Error Encountered while deleting Doctor. Try again later'); window.open('list-of-doctors.php','_self');</script>";
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

    .mdc-drawer__header .active {
      background-color: white;
    }

    .content-wrapper .row{
      margin-left: 0;
      margin-right: 0;
    }

    .table{
      margin-bottom: 35px;
    }

    .table thead tr th{
      background-color: #398378;
      color: white !important;
      font-weight: 600;
    }

    .table td{
      vertical-align: middle !important;
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
      <!-- partial:../../partials/_navbar.html -->
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
                  <h6 class="card-title card-padding pb-2" style="font-weight: 600; margin-bottom: 20px; font-size: 22px;">List of Doctors</h6>
                  <div class="table-responsive">
                      <div class="row" style="display: flex; justify-content: center;">
                      <div class="col-md-12">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th scope="col">Sr. No.</th>
                              <th scope="col">Full Name</th>
                              <th scope="col">Date of Birth</th>
                              <th scope="col">Quebec Registered Number</th>
                              <th scope="col">Edit</th>
                              <th scope="col">Delete</th>
                            </tr>
                          </thead>
                          <tbody id="table-body">
                            <!--<tr>
                              <td style="width: 10%;">1.</td>
                              <td scope="row" style="width: 25%;">Karnik Shah</td>
                              <td style="width: 20%;">12-12-2000</td>
                              <td style="width: 25%;">ABCD-1234-5678</td>
                              <td style="width: 10%;">
                                <!-- <button type="button" class="btn "> -->
                                  <!--<a class="edit" href="edit-profile-specifically.html"><i class="fa fa-edit"></i></a></i>
                                <!-- </button> -->
                              <!--</td>
                              <td style="width: 10%;">
                                <button type="button" class="btn delete" data-toggle="modal" data-target="#ddel">
                                  <i class="fas fa-trash"></i>
                                </button>
                                <div class="modal fade deletecontent" id="ddel" tabindex="-1" role="dialog"
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
                            </tr>-->
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
        <form id="deletePatient" method="post" action="list-of-doctors.php">
          <input type="hidden" value="" name="UserName" id="UserName">                          
        </form> 
        <form id="editPatient" method="post" action="edit-profile-specifically.php">
          <input type="hidden" value="" name="UN" id="UN">
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

    userName = [];

    function displayList(){
      len = <?php echo $len; ?>;
      FullName=<?php echo '["' . implode('", "', $name) . '"]' ?>;
      dob=<?php echo '["' . implode('", "', $dob) . '"]' ?>;
      qnr=<?php echo '["' . implode('", "', $qnr) . '"]' ?>;
      userName=<?php echo '["' . implode('", "', $email) . '"]' ?>;

      str="";
      for(i=0;i<len;i++){
        str+="<tr>";
        str+='<td scope="row" style="width: 10%;">'+(i+1)+'</td>';
        str+='<td style="width: 25%;">'+FullName[i]+'</td>';
        str+='<td>'+dob[i]+'</td>';
        str+='<td style="width: 25%;">'+qnr[i]+'</td>';
        str+='<td style="width: 10%;">'
        str+='                  <!-- <button type="button" class="btn "> -->'
        str+='                    <a class="edit" href="javascript: editProfile('+i+')"><i class="fa fa-edit"></i></a></i>'
        str+='                  <!-- </button> -->'
        str+='                </td>'
        str+='                <td style="width: 10%;">'
        str+='                  <button type="button" class="btn delete" data-toggle="modal" data-target="#ddel" onclick="setIdx('+i+')">'
        str+='                    <i class="fas fa-trash"></i>'
        str+='                  </button>'
        str+='                  <div class="modal fade deletecontent" id="ddel" tabindex="-1" role="dialog"'
        str+='                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">'
        str+='                    <div class="modal-dialog modal-dialog-centered" role="document">'
        str+='                      <div class="modal-content">'
        str+='                        <div class="modal-header">'
        str+='                          <!-- <h5 class="modal-title" id="exampleModalLongTitle">Do you want to Remove the Patient?</h5> -->'
        str+='                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">'
        str+='                            <span aria-hidden="true">&times;</span>'
        str+='                          </button>'
        str+='                        </div>'
        str+='                        <div class="modal-body">'
        str+='                          <div class="row">'
        str+='                            <div class="col-md-12">'
        str+='                              <i class="fa fa-times-circle"></i>'
        str+='                              <h4>Are you sure?</h4>'
        str+='                              <p>Do you really want to delete the record of the patient?<br>This process cannot be undone.</p>'
        str+='                            </div>'
        str+='                          </div>'
                                        
        str+='                        </div>'
        str+='                        <div class="modal-footer">'
        str+='                          <button type="button" class="btn btn-secondary"'
        str+='                            data-dismiss="modal">Cancel</button>'
        str+='                          <button type="button" class="btn btn-danger" onclick="deletePatient()">Delete</button>'
        str+='                        </div>'
        str+='                      </div>'
        str+='                    </div>'
        str+='                  </div>'
        str+='                </td>'
        str+="</tr>";
      }
      document.getElementById('table-body').innerHTML = str;
    }
    
    displayList();  

    idx=0;

    function setIdx(i){
      idx = i;
    }

    function deletePatient(){

      document.getElementById("UserName").value = userName[idx];
      document.getElementById("deletePatient").submit();
    }

    function editProfile(i){

      document.getElementById("UN").value = userName[i];
      document.getElementById("editPatient").submit();
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