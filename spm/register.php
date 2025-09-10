<?php

    //send registration successful email
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';


    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp";

    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = ; //INSERT PORT
    $mail->Host       = ""; //INSERT HOST
    $mail->Username   = ""; //INSERT USERNAME
    $mail->Password   = ""; //INSERT PASSWORD

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
    $userCategory = $_POST["type"];
    $fullName = $_POST["name"];
    $dateOfBirth = $_POST["date-of-birth"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = str_rot13($_POST["password"]);
    $sql = "";

    $sql = "SELECT * FROM user WHERE UserName = '$email' ";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        echo "<script>alert('User exists already. Try again with a different email address.'); window.open('authenticate.php','_self');</script>";
    }
    else{
        if ($userCategory == 'patient'){
            $sql = " INSERT INTO user (UserName, Password, UserCategory) VALUES 
            ('$email','$password','P'); ";
            $sql .= "INSERT INTO patient (UserName, FullName, Address, DOB, PhoneNumber) VALUES 
            ('$email','$fullName','$address','$dateOfBirth','$phone'); ";
     
            if(mysqli_multi_query($conn, $sql)){

                //send registration successful email
                try {
                    //Email structure
                    $mail->setFrom($email, 'HealthCare');
                    $mail->addAddress($email);
                    $mail->Subject = 'Welcome to the HealthCare System!';
                    $mail->Body =
        "Dear $fullName,

We are delighted to welcome you to the HealthCare System! We appreciate your trust in our system and we look forward to providing you with excellent service.

Our system is designed to simplify and streamline hospital management, making it easy for you to access and manage all aspects of your healthcare needs.

To get started, please signin in our system, and you will be able to access your personal dashboard, where you can view your medical records, and schedule appointments. Please make sure to complete the Self Assessment Test by signing up (without that we will not be able to move forward with your profile).

If you have any questions or concerns, please do not hesitate to contact our support team at healthcare.spm@gmail.com. We are always here to assist you and ensure that you have the best possible experience with our system.

Thank you for choosing the HealthCare System! We look forward to serving you.

Best regards,
HealthCare System Team";
        
                    $mail->send();
                    // $name = $email = $phone = $message = "";
                } catch (Exception $e) {
                    echo "Something went wrong, try again";
                }
                echo "<script>alert('Registered successfully. Now try to log in'); window.open('authenticate.php','_self');</script>";
            }
            else{
                echo $conn->error;
                //echo "<script> alert('Registration unsuccessful. Try again'); window.open('authenticate.php','_self');</script>";
            }
     
         }
     
         elseif ($userCategory == 'doctor'){
            $QNR = $_POST["minc"];
            $sql = " INSERT INTO user (UserName, Password, UserCategory) VALUES 
            ('$email','$password','D'); ";
            $sql .= "INSERT INTO doctor (UserName, FullName, Address, DOB, PhoneNumber,QNR) VALUES 
            ('$email','$fullName','$address','$dateOfBirth','$phone','$QNR'); ";
      
            if(mysqli_multi_query($conn, $sql)){
                echo "<script>alert('Registered successfully. Now try to log in'); window.open('authenticate.php','_self');</script>";
            }
            else{
                echo "<script> alert('Registration unsuccessful. Try again'); window.open('authenticate.php','_self');</script>";
            }
         }
     
         elseif ($userCategory == 'counselor'){
            $QNR = $_POST["minc"];
             $sql = " INSERT INTO user (UserName, Password, UserCategory) VALUES 
             ('$email','$password','C'); ";
             $sql .= "INSERT INTO counselor (UserName, FullName, Address, DOB, PhoneNumber,QNR) VALUES 
             ('$email','$fullName','$address','$dateOfBirth','$phone','$QNR'); ";
      
             if(mysqli_multi_query($conn, $sql))
             {
                echo "<script>alert('Registered successfully. Now try to log in'); window.open('authenticate.php','_self');</script>";
             }
             else{
                echo "<script> alert('Registration unsuccessful. Try again'); window.open('authenticate.php','_self');</script>";
             }
         }
    }

    //Close connection
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <body>
    </body>
</html>
