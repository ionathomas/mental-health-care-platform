<!DOCTYPE html>
<html lang="en">

<head>
    <title>HealthCare - Helping Patients with Depression</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/authenticate.css">
    <script src="js/authenticate.js" defer></script>
    </link>
    
</head>

<body>
    <div class="container" id="authenticate-container">
        <!-- Login -->
        <div class="form-container login-container">
            <!-- TODO: formaction should link to relevant php -->
            <form action="login.php" method="post" autocomplete="on" name="login-form">
                <a class="navbar-brand" href="index.php"><img src="images/logo.png" style="width: 33%;" alt=""></a>
                <h1 style="color: black;">Login</h1>
                <?php if(isset($_GET['error'])) { ?>
                        <p class="error"> <?php echo $_GET['error']; ?></p>
                <?php } ?>
                <!-- Email -->
                <input type="email" name="email" id="login-email" placeholder="Email" autocomplete="email" required>
                <!-- Password -->
                <div class="dflex">
                <input type="password" name="password" id="login-password" placeholder="Password" autocomplete="current-password" minlength="8" required>
                <button type="button" id="register-se-password"><i class="fa fa-eye fa-x"></i></button>
                </div>
                <p class="pfor"><a href="forgotpassword.php">Forgot Password?</a></p>
                <!-- User Type -->
                <!-- <fieldset>
                    <legend>I am a ...</legend>
                    <input type="radio" name="type" value="patient" id="patient" checked>
                    <label for="patient">Patient</label>
                    <input type="radio" name="type" value="counselor" id="counselor">
                    <label for="counselor">Counselor</label>
                    <input type="radio" name="type" value="doctor" id="doctor">
                    <label for="doctor">Doctor</label>
                </fieldset> -->

                <!-- Submit -->
                <input type="submit" value="Login" style="cursor: pointer;">
            </form>
        </div>
        <!-- Register -->
        <div class="form-container register-container">
            <!-- TODO: formaction should link to relevant php -->
            <form action="register.php" method="post" autocomplete="on" name="register-form">
                <h1  style="color: black; padding-bottom: 7px;">Register</h1>
                <!-- User Type -->
                <div style="display: flex;">
                    <!-- <legend>I am a ...</legend> -->
                    <div class="pdc" style="display: flex;">
                        <input type="radio" name="type" value="patient" id="register-patient" checked>
                        <label for="register-patient">Patient</label>
                    </div>
                    <div class="pdc" style="display: flex;">
                    <input type="radio" name="type" value="counselor" id="register-counselor">
                    <label for="register-counselor">Counselor</label>
                    </div>
                    <div class="pdc" style="display: flex;">
                    <input type="radio" name="type" value="doctor" id="register-doctor">
                    <label for="register-doctor">Doctor</label>
                    </div>
                </div>
                <!-- Full Name -->
                <input type="text" name="name" id="register-name" placeholder="Full Name" autocomplete="name" required>
                <!-- Date of Birth -->
                <!-- <label for="register-date-of-birth">Date of Birth</label> -->
                <input type="text" class="dob" placeholder="Date of Birth"
                onfocus="(this.type='date')"
                name="date-of-birth" id="register-date-of-birth"  autocomplete="bday" required>
                <!-- Address -->
                <!-- <textarea rows="3" cols="40" name="address" id="register-address" placeholder="221B Baker St&#10;Marylebone&#10;London&#10;NW1 6XE, UK" autocomplete="street-address" required></textarea> -->
                <input type="text" name="address" id="register-address" placeholder="Address" autocomplete="address" required>
                <!-- Phone Number -->
                <input type="text" name="phone" id="register-phone" placeholder="Phone Number" pattern="(\+\d{1,2}[-\s.]?)?([(]\d{3}[)]|\d{3})[-\s.]?\d{3}[-\s.]?\d{4}?" autocomplete="tel" required>
                <!-- Email -->
                <input type="email" name="email" id="register-email" placeholder="Email" autocomplete="email" required>
                <!-- Password -->
                <!-- <fieldset>
                    <label for="register-password">
                        Password -->
                        <div class="dflex">
                            <input type="password" name="password" id="register-password" placeholder="Password" autocomplete="new-password" minlength="8" required>
                            <button type="button" id="register-see-password"><i class="fa fa-eye fa-x"></i></button>
                        </div>
                        <p class="pchar">8-character minimum; case sensitive</p>
                        <!-- <input type="password" name="password" id="register-password" placeholder="Password" autocomplete="new-password" minlength="8" required> -->
                        
                    <!-- </label> -->
                    
                    <!-- <label for="register-confirm-password">
                        Confirm Password -->
                        <div class="dflex">
                        <input type="password" id="register-confirm-password" placeholder="Confirm Password" autocomplete="new-password" required>
                        <button type="button" id="register-see-confirm-password"><i class="fa fa-eye fa-x"></i></button>
                        </div>

                    <!-- </label> -->
                    <!-- <button type="button" id="register-see-password">Toggle view password</button> -->
                <!-- </fieldset> -->

                <!-- MINC -->
                <!-- Last digit is supposed to be a check digit, but the formula for it could not be found. -->
                <div id="register-minc-div" hidden style="width: 100%;">
                    <!-- <label for="register-minc">MINC (Four letters and 8 numbers)</label> -->
                    <input type="text" name="minc" id="register-minc" placeholder="Quebec Registered Number" pattern="[A-Z]{4}-\d{4}-\d{4}" minlength="14" maxlength="14" disabled>
                    <!-- <p class="pchar">Note: Currently this website has not signed a Licensed User Agreement with MINC#NIMC.</p> -->
                </div>


                <!-- Submit -->
                <input type="submit" value="Register" style="cursor: pointer;">
            </form>
        </div>
        <!-- Cover -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p style="font-size: 17px;">Authenticate yourself to connect with us.</p>
                    <button class="ghost" id="login-choice" style="cursor: pointer;">Login</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Greetings!</h1>
                    <p style="font-size: 17px;">Register your details to get started.</p>
                    <button class="ghost" id="register-choice" style="cursor: pointer;">Register</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>