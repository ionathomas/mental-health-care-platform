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
        if(isset($_SESSION['UserName'])){
            $FullName = $_SESSION['FullName'];
            $UserName = $_SESSION['UserName'];
            $UserCategory = $_SESSION['UserCategory'];

                   $sql = "SELECT * FROM pending_appointment WHERE PatientUserName = '$UserName' ";
                         $result = mysqli_query($conn, $sql);
                         if($result){
                                   $row = mysqli_fetch_assoc($result);
                                   $AppointmentID = $row['AppointmentID'];
                                   $PatientUserName = $row['PatientUserName'];
                                   $MgtUserName = $row['MgtUserName'];
                                   $MgtCategory = $row['MgtCategory'];
                                   $Date = $row['Date'];
                                   $Time = $row['Time'];

                                   }
                                   $sql2 = "INSERT INTO appointment(AppointmentID,PatientUserName, MgtUserName, MgtCategory, Date, Time) VALUES ('$AppointmentID','$PatientUserName','$MgtUserName','$MgtCategory','$Date','$Time')";
                                   $result2 = mysqli_query($conn, $sql2);

                                   if($result2){
//                                    $row = mysqli_fetch_assoc($result2);
//                                    $PatientUserName = $row['PatientUserName'];

                                   $sql3 = "DELETE FROM pending_appointment WHERE PatientUserName = '$PatientUserName' ";
                                   $result3 = mysqli_query($conn, $sql3);
                                   echo "<script>alert('Appointment Confirmed!'); window.open('notification_patient.php','_self');</script>";
                                   exit();


                                   }


            }


//             if(mysqli_query($conn, $sql)){
//                 $_SESSION['FullName'] = $fullName;
//                 $_SESSION['DOB'] = $dateOfBirth;
//                 $_SESSION['PhoneNumber'] = $phone;
//                 $_SESSION['Address'] = $address;
//                 $_SESSION['Password'] = $password;
//
//                 echo "<script>alert('Updated successfully'); window.open('/dashboard/patient/index.php','_self');</script>";
//             }
//             else{
//                 echo $conn->error;
//                 //echo "<script> alert('Registration unsuccessful. Try again'); window.open('authenticate.php','_self');</script>";
//             }
//          }

//          elseif ($userCategory == 'D'){
//             $DoctorID = $_SESSION['DoctorID'];
//             $QNR = $_POST["QNR"];
//             $sql = " UPDATE user u JOIN doctor d ON (u.UserName = d.UserName) SET u.UserName = '$UserName', u.Password = '$password', u.UserCategory = '$userCategory',
//             d.UserName = '$UserName', d.DoctorID = '$DoctorID', d.FullName = '$fullName', d.Address = '$address', d.DOB = '$dateOfBirth', d.PhoneNumber = '$phone', d.QNR = '$QNR' where u.UserName = '$email' ";
//
//
//              if(mysqli_query($conn, $sql))
//              {
//                 $_SESSION['FullName'] = $fullName;
//                 $_SESSION['DOB'] = $dateOfBirth;
//                 $_SESSION['PhoneNumber'] = $phone;
//                 $_SESSION['Address'] = $address;
//                 $_SESSION['QNR'] = $QNR;
//                 $_SESSION['Password'] = $password;
//
//                 echo "<script>alert('Updated successfully'); window.open('/dashboard/doctor/index.php','_self');</script>";
//              }
//              else{
//                 echo "<script> alert('Update unsuccessful. Try again'); window.open('/dashboard/doctor/index.php','_self');</script>";
//              }
//          }

//          elseif ($userCategory == 'C'){
//             $CounselorID = $_SESSION['CounselorID'];
//             $QNR = $_POST["QNR"];
//             $sql = " UPDATE user u JOIN counselor c ON (u.UserName = c.UserName) SET u.UserName = '$UserName', u.Password = '$password', u.UserCategory = '$userCategory',
//             c.UserName = '$UserName', c.CounselorID = '$CounselorID', c.FullName = '$fullName', c.Address = '$address', c.DOB = '$dateOfBirth', c.PhoneNumber = '$phone', c.QNR = '$QNR' where u.UserName = '$email' ";
//
//
//              if(mysqli_query($conn, $sql))
//              {
//                 $_SESSION['FullName'] = $fullName;
//                 $_SESSION['DOB'] = $dateOfBirth;
//                 $_SESSION['PhoneNumber'] = $phone;
//                 $_SESSION['Address'] = $address;
//                 $_SESSION['QNR'] = $QNR;
//                 $_SESSION['Password'] = $password;
//
//                 echo "<script>alert('Updated successfully'); window.open('/dashboard/counselor/index.php','_self');</script>";
//              }
//              else{
//                 echo "<script> alert('Upadte unsuccessful. Try again'); window.open('/dashboard/counselor/index.php','_self');</script>";
//              }
//          }
    // }

    //Close connection
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <body>
    </body>
</html>