<?php

session_start();


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




    //Insert into tables depending on Patient, Doctor and Counselor
   // $userCategory = $_POST["type"];
   $UserName = $_SESSION['UserName'];
//    $PatientID = $_SESSION['PatientID'];
    $userCategory = $_SESSION['UserCategory'];
    $email = $_SESSION['UserName'];
    $fullName = $_POST["name"];
    $dateOfBirth = $_POST["date-of-birth"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $password = str_rot13($_POST["password"]);
    $sql = "";
        if ($userCategory == 'P'){
            $PatientID = $_SESSION['PatientID'];
        $sql = " UPDATE user u JOIN patient p ON (u.UserName = p.UserName) SET u.UserName = '$UserName', u.Password = '$password', u.UserCategory = '$userCategory',
         p.UserName = '$UserName', p.PatientID = '$PatientID', p.FullName = '$fullName', p.Address = '$address', p.DOB = '$dateOfBirth', p.PhoneNumber = '$phone' where u.UserName = '$email' ";


            if(mysqli_query($conn, $sql)){
                $_SESSION['FullName'] = $fullName;
                $_SESSION['DOB'] = $dateOfBirth;
                $_SESSION['PhoneNumber'] = $phone;
                $_SESSION['Address'] = $address;
                $_SESSION['Password'] = $password;

                echo "<script>alert('Updated successfully'); window.open('/spm/dashboard/patient/index.php','_self');</script>";
            }
            else{
                echo $conn->error;
                //echo "<script> alert('Registration unsuccessful. Try again'); window.open('authenticate.php','_self');</script>";
            }
         }
     
         elseif ($userCategory == 'D'){
            $DoctorID = $_SESSION['DoctorID'];
            $QNR = $_POST["QNR"];
            $sql = " UPDATE user u JOIN doctor d ON (u.UserName = d.UserName) SET u.UserName = '$UserName', u.Password = '$password', u.UserCategory = '$userCategory',
            d.UserName = '$UserName', d.DoctorID = '$DoctorID', d.FullName = '$fullName', d.Address = '$address', d.DOB = '$dateOfBirth', d.PhoneNumber = '$phone', d.QNR = '$QNR' where u.UserName = '$email' ";
   
      
             if(mysqli_query($conn, $sql))
             {
                $_SESSION['FullName'] = $fullName;
                $_SESSION['DOB'] = $dateOfBirth;
                $_SESSION['PhoneNumber'] = $phone;
                $_SESSION['Address'] = $address;
                $_SESSION['QNR'] = $QNR;
                $_SESSION['Password'] = $password;

                echo "<script>alert('Updated successfully'); window.open('/spm/dashboard/doctor/index.php','_self');</script>";
             }
             else{
                echo "<script> alert('Update unsuccessful. Try again'); window.open('/spm/dashboard/doctor/index.php','_self');</script>";
             }
         }
     
         elseif ($userCategory == 'C'){
            $CounselorID = $_SESSION['CounselorID'];
            $QNR = $_POST["QNR"];
            $sql = " UPDATE user u JOIN counselor c ON (u.UserName = c.UserName) SET u.UserName = '$UserName', u.Password = '$password', u.UserCategory = '$userCategory',
            c.UserName = '$UserName', c.CounselorID = '$CounselorID', c.FullName = '$fullName', c.Address = '$address', c.DOB = '$dateOfBirth', c.PhoneNumber = '$phone', c.QNR = '$QNR' where u.UserName = '$email' ";
   
      
             if(mysqli_query($conn, $sql))
             {
                $_SESSION['FullName'] = $fullName;
                $_SESSION['DOB'] = $dateOfBirth;
                $_SESSION['PhoneNumber'] = $phone;
                $_SESSION['Address'] = $address;
                $_SESSION['QNR'] = $QNR;
                $_SESSION['Password'] = $password;

                echo "<script>alert('Updated successfully'); window.open('/spm/dashboard/counselor/index.php','_self');</script>";
             }
             else{
                echo "<script> alert('Upadte unsuccessful. Try again'); window.open('/spm/dashboard/counselor/index.php','_self');</script>";
             }
         }
    // }

    //Close connection
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <body>
    </body>
</html>