<?php
session_start();
include "db_conn.php";

if(isset($_POST['email']) && isset($_POST['password'])) {

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$uname = $_POST['email'];
$pass = str_rot13($_POST['password']);
 //$pass = $_POST['password'];
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

if(filter_var($uname, FILTER_VALIDATE_EMAIL))
{
    $flag = 1;
}
if(empty($uname || $flag===1)) {
    header("Location: index.php?error=User Name is required");
    exit();
}

if(empty($pass)) {
    header("Location: index.php?error=Password Name is required");
    exit();
}
//$sql = " SELECT UserName, Password FROM "
$sql = "SELECT * FROM user WHERE UserName='$uname'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if($row['UserName'] === $uname && $row['Password'] === $pass) {
        //echo "Logged In";
        $_SESSION['UserName'] = $row['UserName'];
        $_SESSION['UserCategory'] = $row['UserCategory'];

        if($row['UserCategory'] === 'P')
        {
            //1
            $sql = "SELECT * FROM patient WHERE UserName = '$uname'";
            //1
            $result  = mysqli_query($conn, $sql);
            $row1 = mysqli_fetch_assoc($result);

            //2
            $_SESSION['PatientID'] = $row1['PatientID'];
            $_SESSION['FullName'] = $row1['FullName'];
            $_SESSION['Address'] = $row1['Address'];
            $_SESSION['DOB'] = $row1['DOB'];
            $_SESSION['PhoneNumber'] = $row1['PhoneNumber'];
            $_SESSION['Password'] = $row['Password'];

            
            $sql2 = "SELECT * FROM assessmentresults WHERE UserName = '$uname'";
            $result2 = mysqli_query($conn, $sql2);
            if(mysqli_num_rows($result2)>0)
                header("Location: /spm/dashboard/patient/notification_patient.php"); 
            else
                header("Location: /spm/dashboard/patient/self-assessment-test.php"); 
        }

        else if($row['UserCategory'] === 'D')
        {
            $sql = "SELECT * FROM doctor WHERE UserName = '$uname'";
            $result  = mysqli_query($conn, $sql);
            $row1 = mysqli_fetch_assoc($result);

            $_SESSION['DoctorID'] = $row1['DoctorID'];
            $_SESSION['FullName'] = $row1['FullName'];
            $_SESSION['Address'] = $row1['Address'];
            $_SESSION['DOB'] = $row1['DOB'];
            $_SESSION['PhoneNumber'] = $row1['PhoneNumber'];
            $_SESSION['QNR'] = $row1['QNR'];
            $_SESSION['Password'] = $row['Password'];

            header("Location: /spm/dashboard/doctor/index.php"); 
        }

        else if($row['UserCategory'] === 'C')
        {
            $sql = "SELECT * FROM counselor WHERE UserName = '$uname'";
            $result  = mysqli_query($conn, $sql);
            $row1 = mysqli_fetch_assoc($result);

            $_SESSION['CounselorID'] = $row1['CounselorID'];
            $_SESSION['FullName'] = $row1['FullName'];
            $_SESSION['Address'] = $row1['Address'];
            $_SESSION['DOB'] = $row1['DOB'];
            $_SESSION['PhoneNumber'] = $row1['PhoneNumber'];
            $_SESSION['QNR'] = $row1['QNR'];
            $_SESSION['Password'] = $row['Password'];

            header("Location: /spm/dashboard/counselor/index.php");
        }

        else if($row['UserCategory'] === 'M')
        {
            $sql = "SELECT FullName FROM manager WHERE UserName = '$uname'";
            $result  = mysqli_query($conn, $sql);
            $row1 = mysqli_fetch_assoc($result);
            $_SESSION['FullName'] = $row1['FullName'];
            header("Location: /spm/dashboard/manager/index.php");
        }

        exit();
    }
    else{
        echo "<script>alert('Incorrect Password. Please Try Again'); window.open('authenticate.php','_self');</script>";
        exit();
    }
}

else{
    echo "<script>alert('Invalid Credentials.'); window.open('authenticate.php','_self');</script>";
    exit();
}

?>