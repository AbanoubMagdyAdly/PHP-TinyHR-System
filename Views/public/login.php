<?php 
defined('_ALLOW_ACCESS')or die("Not Allowed");
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $login = new Login();

    if($login->is_fields_valid($_POST["password"],$_POST["username"])){

        $UDB = new UsersDB(__TABLE_NAME__);
        if (! $UDB->connect()) $error= "connection error";
        else{
            $login-> set_db_record($UDB,$_POST["username"],$_POST["password"]);
            
            if($login->check_user_exists()){

                if( $login->is_login_failed($_POST["username"]))
                    $login->handle_failed_login_counter();

                if($login->matched_and_not_blocked()){
                    $rememberme = isset($_POST["rememberme"]) ? true: false;
                    $login-> authenticate($rememberme);
                    header('Refresh: 0; URL=');
                    die();
                } else { // check block
                    $login-> handle_failed_login();
                    $login-> show_block_timer();
                }
            }
        }     
    }
}

if(isset($_POST['g-recaptcha-response']))
    $captcha=$_POST['g-recaptcha-response'];
else
    $captcha = false;

if(!$captcha){
}
else{
    $secret = __CAPATCHA_SECRET_SS;
    $url =  __GOOGLE_CAPATCHA . urlencode($secret) .  '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $response = json_decode($response,true);
    
    if($response["success"]==false)
    {
    } else {
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="views/public/css/util1.css">
    <link rel="stylesheet" type="text/css" href="views/public/css/main1.css">
    <!--===============================================================================================-->
</head>
<body>


 <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-t-0 p-b-0">
                <form class="login100-form validate-form" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                <input type="hidden" name="action" value="validate_captcha">
                    <span class="login100-form-title p-b-20">
                        Welcome
                    </span>
                    <span class="login100-form-avatar">
                        <img src="views/public/images/avatar-01.jpg" alt="AVATAR">
                    </span>

                    <div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate="Enter username">
                        <input class="input100" type="text" name="username">
                        <span class="focus-input100" data-placeholder="Username"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>
                    <br>
                    <center>
                        <div class="validate-input" data-validate="Enter password">
                            remember me
                            <input class="input"  type="checkbox" name="rememberme" value="1">
                        </div>
                    </center>
                    <div class="g-recaptcha" data-sitekey="6LcZa5AUAAAAAMBmXHytrMJpXKvYNPmpWAAZVVic"></div>
                    <div class="m-b-40">
                        <p class="error">
                            <?php if (isset($login->error) && !empty($login->error)) {
                                echo "*" . $login->error;
                            } ?>
                        </p>
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" name="submit" type="submit">
                            Login
                        </button>
                    </div>

                    <ul class="login-more p-t-30">

                        <li>
                            <span class="txt1">
                                Don’t have an account?
                            </span>

                            <a href="?page=signup" class="txt2">
                                Sign up
                            </a>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <div id="dropDownSelect1"></div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
    </script> -->
    <!-- <script src="https://www.google.com/recaptcha/api.js?render=6LcIZ5AUAAAAAEdA7fM9aD7AZ6kDmdfT0h3D7K_g"></script> -->
    <script type="text/javascript">
    var onloadCallback = function() {
        alert("grecaptcha is ready!");
    };
   </script>
   <!-- 
    // grecaptcha.ready(function() {
    // // do request for recaptcha token
    // // response is promise with passed token
    //     grecaptcha.execute('6LcIZ5AUAAAAAEdA7fM9aD7AZ6kDmdfT0h3D7K_g', {action:'validate_captcha'})
    //               .then(function(token) {
    //         console.log("asdsad")
    //         document.getElementById('g-recaptcha-response').value = token;
    //     });
    // });
    -->
</body>

</html>