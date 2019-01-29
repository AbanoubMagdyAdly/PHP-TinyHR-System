<?php 
	if( isset($_POST["username"]) && isset($_POST["password"])){

		if(!empty($_POST["password"]) && !empty($_POST["username"])){
			$GDB = new UsersDB(__TABLE_NAME__);

			if($GDB->connect()){
				$user_record = $GDB->get_record_by_name_pass($_POST["username"], $_POST["password"]); // this is an array of arrays
				if(isset($user_record) && !empty($user_record)){
					$user_record = $user_record[0];
					$_SESSION["user_id"] = $user_record["id"];
					$_SESSION["is_admin"] = $user_record["isadmin"];
				} else {
					$error = "Either user name or password is wrong";
				}
			}
		} else {
			$error = "Either user name or password is wrong";
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

					<div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "Enter username">
						<input class="input100" type="text" name="username">
						<span class="focus-input100" data-placeholder="Username"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>
					<div class="m-b-40">
						<p class="error">
							<?php if(isset($error)){echo "*".$error;}?>
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

							<a href="views/public/signup.php" class="txt2">
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
