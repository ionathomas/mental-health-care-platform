<?php

    session_start();
    include "../../db_conn.php";

    $flag=0;
    $len = 0;
    $name = array();
    $score = array();
    $patientUserName = array();
    $dob = array();
    $pid = array();

    if(isset($_SESSION['UserName'])){
        $FullName = $_SESSION['FullName'];
        $UserName = $_SESSION['UserName'];
        $UserCategory = $_SESSION['UserCategory'];

        // $sql1="SELECT * FROM patient WHERE Assigned = '0'";
        // $sql2="SELECT distinct PatientUserName FROM assignpatient";
        // $result1=mysqli_query($conn, $sql1);
        // $unassignedpatientlen=mysqli_num_rows($result1);
        // $result2=mysqli_query($conn, $sql2);
        // $assignedpatientlen=mysqli_num_rows($result2);
        //echo $unassignedpatientlen;
        //echo $assignedpatientlen;
      
        if(isset($_POST['startDate']))
        {
          $startdate = $_POST['startDate'];
          $enddate = $_POST['endDate'];
          if(strcmp($startdate,"")!=0 && strcmp($enddate,"")!=0){
            $flag=1;

            $sql1="SELECT * FROM patient WHERE Assigned = '0' AND Date(Timestamp) >= '$startdate' AND Date(Timestamp) <= '$enddate'";
            $result1=mysqli_query($conn, $sql1);
            $unassignedpatientlen=mysqli_num_rows($result1);

            $sql2="SELECT distinct PatientUserName FROM assignpatient WHERE (Date(Timestamp) >= '$startdate' AND Date(Timestamp) <= '$enddate' AND AssignerCategory = 'M')";
            $result2=mysqli_query($conn, $sql2);
            $assignedpatientlen=mysqli_num_rows($result2);

            $sql5="SELECT distinct PatientUserName FROM appointment WHERE Date >= '$startdate' AND Date <= '$enddate'";
            $result5=mysqli_query($conn, $sql5);
            $appointmentlen=mysqli_num_rows($result5);
            //echo $appointmentlen;

            $sql3="SELECT * FROM patient WHERE Date(Timestamp) >= '$startdate' AND Date(Timestamp) <= '$enddate'";
            $result3=mysqli_query($conn, $sql3);
            if(mysqli_num_rows($result3)>0)
            {
              $len=mysqli_num_rows($result3);

              $i=0;
           //echo $len;

              while($row = mysqli_fetch_assoc($result3)){

                $name[$i]=$row['FullName'];
                $dob[$i] = $row['DOB'];
                $id[$i] = $row['PatientID'];
                $patientUserName[$i] = $row['UserName'];
                $un=$patientUserName[$i];

                $sql4 = "SELECT Score FROM assessmentresults WHERE UserName = '$un' ";
                    $result4 = mysqli_query($conn,$sql4);
                    $row4 = mysqli_fetch_assoc($result4);
                    $score[$i]=0;
                    if(isset($row4['Score']))
                        $score[$i] = $row4['Score'];
                        if($score[$i]===0)
                        {
                          $score[$i]="Test Not Taken";
                        }
                    // echo $name[$i];
                    // echo $dob[$i];
                    // echo $id[$i];
                    // echo $score[$i];
                    $i++;
              }
            }        
            
            }
          }
          

        
        //  $sql4 = "SELECT * FROM patient";
        //  $result4=mysqli_query($conn, $sql4);
        //  $len=mysqli_num_rows($result4);

        //  $name = array();
        //  $score = array();
        //  $patientUserName = array();
        //  $date = array();
        //  $pid = array();
 
        //  if($len > 0){
        //    $i=0;
        //    //echo $len;

        //    while($row = mysqli_fetch_assoc($result4)){

        //     $name[$i]=$row['FullName'];
        //     $dob[$i] = $row['DOB'];
        //     $id[$i] = $row['PatientID'];
        //     $patientUserName[$i] = $row['UserName'];
        //     $un=$patientUserName[$i];

        //     $sql3 = "SELECT Score FROM assessmentresults WHERE UserName = '$un' ";
        //         $result3 = mysqli_query($conn,$sql3);
        //         $row3 = mysqli_fetch_assoc($result3);
        //         $score[$i]=0;
        //         if(isset($row3['Score']))
        //             $score[$i] = $row3['Score'];
        //             if($score[$i]===0)
        //             {
        //               $score[$i]="Test Not Taken";
        //             }
        //         // echo $name[$i];
        //         // echo $dob[$i];
        //         // echo $id[$i];
        //         // echo $score[$i];
        //         $i++;
        //    }
        //  }        
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
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
    .mdc-card {
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
        <a href="index.php" class="brand-logo">
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
          <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card nopadd">
                  <div class="row">
                    <div class="col-md-12 nopadd">
                      <h6 class="card-title card-padding pb-2"
                        style="font-weight: 600; margin-bottom: 20px; font-size: 22px; text-align: center; padding-top: 25px;">
                        Generate the
                        Report</h6>
                    </div>
                    <!-- <div class="col-md-4 nopadd searchinput">
                      <input type="text" id="searchingInput"  onkeyup="searchingTable()" style="margin-bottom: 20px;" placeholder="Search Patient"
                        title="Type in patient id">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </div> -->
                  </div>
                    <div class="row makereport" style="justify-content: center;">
                      <div class="col-md-3 dflex">
                        <input type="date" id="startdate" name="startdate" placeholder="Start Date" required>
                        <!-- <p><b>Start Date: </b></p>
                      <input type="date" id="" name=""> -->
                      </div>
                      <div class="col-md-1 dflex">
                        <p><b>to</b></p>
                      </div>
                      <div class="col-md-3 dflex">
                        <!-- <p><b>End Date: </b></p> -->
                        <input type="date" id="enddate" name="enddate" placeholder="End Date" required>
                      </div>
                    </div>
                    <!-- </form> -->
                    <div class="row makereport" style="justify-content:center;">
                      <div class="col-md-3 dflex">
                        <input type="button" value="Generate Report" class="btn" id="btnSub" name="btnSub" onclick="any()">
                      </div>
                    </div>
                  <form action="report-IRT-IRT.php" method="post" id="formDate">
                    <input type="hidden" id="startDate" name="startDate" value="">
                    <input type="hidden" id="endDate" name="endDate" value="">
                  </form>
                  
                </div>
              </div>
              <!-- <div> -->
              <div
                class="mdc-layout-grid__cell showing stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-4-tablet pat"
                id="block1" >
                <div class="mdc-card info-card info-card--success">
                  <div class="card-inner">
                    <h5 class="card-title" >Unassigned Patients</h5>
                    <h5 class="font-weight-light hsize" id="unassignedpatient">0</h5>
                    <!-- <a href="list-of-patients.html">
                      <p class="tx-12 text-muted">View </p>
                      <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a> -->
                    <div class="card-icon-wrapper">
                      <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="mdc-layout-grid__cell showing stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-4-tablet pat" id="block2" >
                <div class="mdc-card info-card info-card--success">
                  <div class="card-inner">
                    <h5 class="card-title" >Assigned Patients</h5>
                    <h5 class="font-weight-light hsize" id="assignedpatient">0</h5>
                    <!-- <a href="list-of-patients.html">
                      <p class="tx-12 text-muted">View </p>
                      <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a> -->
                    <div class="card-icon-wrapper">
                      <i class="fa fa-handshake-o" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="mdc-layout-grid__cell showing stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-4-tablet pat">
                <div class="mdc-card info-card info-card--success">
                  <div class="card-inner">
                    <h5 class="card-title">Patient Consultations</h5>
                    <h5 class="font-weight-light hsize" id="appointmentlen">0</h5>
                    <!-- <a href="list-of-patients.html">
                      <p class="tx-12 text-muted">View </p>
                      <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a> -->
                    <div class="card-icon-wrapper">
                      <i class="fa fa-user-md"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12 pat" id="block3" style="visibility: hidden;">
                <div class="mdc-card">
                  <div class="row">
                    <div class="col-md-8 nopadd">
                      <h6 class="card-title card-padding pb-2"
                        style="font-weight: 600; margin-bottom: 20px; font-size: 22px;">List of Patients who
                        Registered With Us</h6>
                    </div>
                    <div class="col-md-4 nopadd searchinput">
                      <input type="text" id="searchingInput" onkeyup="searchingTable()" style="margin-bottom: 20px;"
                        placeholder="Search Patient" title="Type in patient id">
                      <i class="fa fa-search" aria-hidden="true"></i>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <div class="row" style="display: flex; justify-content: center;">
                      <div class="col-md-12">
                        <h3 id="msg" style="color:red">No Records Found...</h3>
                        <table class="table table-bordered table-hover" id="table" style="visibility:hidden">
                          <thead>
                            <tr>
                              <th scope="col" style="width: 12%;">Patient ID</th>
                              <th scope="col" style="width: 25%;">Full Name</th>
                              <th scope="col" style="width: 16%;">Date of Birth</th>
                              <th scope="col" style="width: 22%;">Self Assessment Score</th>
                              <!-- <th scope="col" style="width: 25%;">Details/Decision</th> -->
                            </tr>
                          </thead>
                          <tbody id="table-body">
                            <!-- <tr>
                              <td scope="row">1001</td>
                              <td>Karnik Shah</td>
                              <td>12-12-2000</td>
                              <td>10/10</td>
                              <td><a href="specific_patient-for-manager.html">View
                                  More</a></td>
                            </tr> -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- </div> -->
              </div>
            </div>
          </div>
        </main>
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
  <script>
    function userSession(){
    name = "<?php echo $FullName; ?>";
    document.getElementById("name").innerHTML = name;
    document.getElementById("greeting_msg").innerHTML = "Greetings "+name+"!";
    document.getElementById("user-full-name").innerHTML = name;

    email = "<?php echo $UserName; ?>";
    document.getElementById("email").innerHTML = email;

    len = "<?php echo $unassignedpatientlen; ?>";
    document.getElementById("unassignedpatient").innerHTML = len;
    len = "<?php echo $assignedpatientlen; ?>";
    document.getElementById("assignedpatient").innerHTML = len;
    len = "<?php echo $appointmentlen; ?>";
     document.getElementById("appointmentlen").innerHTML = len;

    flag=<?php echo $flag ?>;
    if(flag==1)
      displayList();

    }

    function any()
    {
      document.getElementById("startDate").value = document.getElementById("startdate").value;
      document.getElementById("endDate").value = document.getElementById("enddate").value;
      document.getElementById("formDate").submit();
    }

    userSession();
    FullName = [];
    dob = [];
    score = [];
    patientId = [];

    function displayList(){

      len = <?php echo $len?>;

      if(len>0){

        document.getElementById("block3").style.visibility = "visible";
        document.getElementById("table").style.visibility = "visible";
        document.getElementById("msg").style.visibility = "hidden";

        str="";

        FullName=<?php echo '["' . implode('", "', $name) . '"]' ?>;
        dob=<?php echo '["' . implode('", "', $dob) . '"]' ?>;
        score=<?php echo '["' . implode('", "', $score) . '"]' ?>;
        patientId=<?php echo '["' . implode('", "', $id) . '"]' ?>;

        for(i=0;i<len;i++){
          str+='<tr id = "'+i+'">';
          str+='<td scope="row" style="width: 7%;">'+patientId[i]+'</td>';
          str+='<td style="width: 16%;">'+FullName[i]+'</td>';
          str+='<td style="width: 13%;">'+dob[i]+'</td>';
          str+='<td style="width: 16%;">'+score[i]+'</td>';
          str+='</tr>';
        }

        document.getElementById("table-body").innerHTML = str;
      }
      else{
        document.getElementById("block3").style.visibility = "visible";
        document.getElementById("table").style.visibility = "hidden";
        document.getElementById("msg").style.visibility = "visible"

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
  <!-- End custom js for this page -->
</body>

</html>