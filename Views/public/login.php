<?php 
    
if (isset($_POST["username"]) && isset($_POST["password"])) {
$login = new Login();
$error = $login->check_fields_criteria();

if(!$error){

    $UDB = new UsersDB(__TABLE_NAME__);
    if (! $UDB->connect()) $error= "connection error";
    else 
    {
        $password    = hash("sha256", $_POST["password"]);
        $user_record = $UDB->get_record_by_name($_POST["username"]); // this is an array of arrays
        $user_record = empty($user_record) ? $user_record: $user_record[0];
        $error       = $login->check_is_found($user_record);

        if(empty($error)){

            $login->put_db_recored($user_record);

            if( $login->is_login_failed($_POST["username"], $password)){
                $login->handle_failed_login_counter();
                $UDB->update_user_logincount($login->get_user());
                $error = "Either user name or password is wrong";
            }

            if($password == $user_record["password"] && !$user_record["is_blocked"]){ // if matched and not blocked
                $rememberme = isset($_POST["rememberme"]) ? true:false;
                $login->authenticate($rememberme);
                $UDB->update_user_logincount($login->get_user());
                header('Refresh: 0; URL=');
                die();
            } else { // check block
                $login->handle_failed_login();
                $UDB -> update_user_logincount($login->get_user());
                $login-> show_block_timer();
            }
        }
    }     
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

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-t-0 p-b-0">
                <form class="login100-form validate-form" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
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

                    <div class="m-b-40">
                        <p class="error">
                            <?php if (isset($error) && !empty($error)) {
                                echo "*" . $error;
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

</body>

</html>