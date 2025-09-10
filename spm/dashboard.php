<?php
session_start();

if(isset($_SESSION['UserName'])) {
?>
<!DOCTYPE html>
<html lang="en">
<!-- git add .
git commit -m "test"
git push -u origin main -->

<head>
<head>
   
</head>
<title>HealthCare - Helping Patients with Depression</title>
  <meta charset="utf-8">
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body style="text-align:center; background-color: #fafafa">
<div style=" height: 60vh;">
    <h1 style="margin: 250px 0 30px"> Hello, 
        <?php echo $_SESSION['FullName']." (". $_SESSION['UserCategory'] .")";
            
?> </h1>
    <a href="logout.php">LOGOUT</a>
    </div>
</body>
</html>

<?php

}
else {
    header("Location: index.php");
    exit();
}
?>