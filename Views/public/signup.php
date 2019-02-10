<?php 
$errors = array();
if (isset($_POST["uname"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_FILES["cv"]["name"]) && isset($_FILES["Photo"]["name"]))
	if (!empty($_POST["uname"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_FILES["cv"]["name"]) && !empty($_FILES["Photo"]["name"])) {
	$db = new UsersDB("users");
	$db->connect();
	$upload = new Upload($_POST["uname"]);
	if ($db->is_exist($_POST["uname"])) {
		$upload->errors["form"] = "name alredy exist!! ";
	} else {
		// echo "welcome";
		$email_check = $upload->Check_email();
		$password_check = $upload->Check_password();
		$cv_check=$upload->Check_cv();
		$photo_check=$upload->Check_photo();		
		if ($cv_check && $photo_check && $email_check && $password_check){ 
			$upload->Upload_photo();
			$upload->Upload_cv();
			$password = hash("sha256", $_POST["password"]);
			$db->connect();
			$db->insert_user_date($_POST["fullname"], $_POST["uname"], $password, $_POST["email"], $_POST["job"]);
		}
	}
} else {
	$upload->errors["form"] = "Please complete the form !!";
}
if (isset($upload->errors) && empty($upload->errors)) {
	// $context = stream_context_create (array (
	// 	'http' => array (
	// 	'method' => 'POST',
	// 	'username' => $_POST["uname"],
	// 	'password'=> $_POST["password"]
	// 	)
	// 	));
		// $result = file_get_contents('http://localhost/tinyhr/PHP-TinyHR-System/index.php?page=login', null, $context);
	header('Refresh: 0; URL=?page=login');
}

$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
$uname    = isset($_POST['uname'])    ? $_POST['uname']    : "";
$email    = isset($_POST['email'])    ? $_POST['email']    : "";
$job 	  = isset($_POST['job'])      ? $_POST['job']      : "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>SignUp</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="views/public/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="views/public/css/util.css">
    <link rel="stylesheet" type="text/css" href="views/public/css/main.css">
    <!--===============================================================================================-->
</head>

<body>


	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" enctype="multipart/form-data" method ="post">
				<span class="contact100-form-title">
					Enter Your Data!
				</span>

				<div class="wrap-input100 validate-input" data-validate="fullname is required">
                    <span class="label-input100">User full name</span>
                    <input class="input100" type="text" name="fullname" placeholder="Enter your Full Name" value="<?php echo $fullname ?>">
                    <span class="focus-input100"></span>
                </div>
				
				<div class="wrap-input100 validate-input" data-validate="UserName is required">
					<span class="label-input100">User Name</span>
					<input class="input100" type="text" name="uname" placeholder="Enter your User Name" value="<?php echo $uname ?>" >
					<span class="focus-input100"></span>
				</div>
				
				<div class="wrap-input100 validate-input" data-validate="Password is required">
					<span class="label-input100">Password</span>
					<input class="input100" type="password" name="password" placeholder="Enter your password" value="<?php echo $password ?>">
					<span class="focus-input100"></span>
					<p class="error mt-0">
						<?php if(isset($upload->errors["password"])){echo "*".$upload->errors["password"];}?>
					</p>
				</div>

				<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					<span class="label-input100">Email</span>
					<input class="input100" type="text" name="email" placeholder="Enter your email addess"  value="<?php echo $email ?>">
					<span class="focus-input100"></span>
					<p class="error mt-0">
						<?php if(isset($upload->errors["email"])){echo "*".$upload->errors["email"];}?>
					</p>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Job is required">
					<span class="label-input100">User job</span>
					<input class="input100" type="text" name="job" placeholder="Enter your job" value="<?php echo $job ?>">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input">
					<span class="label-input100">Upload CV : </span>
					<input class="input100" type="file" name="cv">
					<span class="focus-input100"></span>
					<p class="error">
							<?php if(isset($upload->errors["cv"])){echo "*".$upload->errors["cv"];}?>
						</p>
				</div>
				
				<div class="wrap-input100 validate-input">
					<span class="label-input100">Upload Your Photo : </span>
					<input class="input100" type="file" name="Photo">
					<span class="focus-input100"></span>
					<p class="error">
							<?php if(isset($upload->errors["photo"])){echo "*".$upload->errors["photo"];}?>
						</p>
				</div>
				

				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						
						<button class="contact100-form-btn">
							<span>
								Submit
								<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
							</span>
						</button>
					</div>
				</div>
				<p class="error">
							<?php if(isset($upload->errors["form"])){echo "*".$upload->errors["form"];}?>
						</p>
			</form>
		</div>
	</div>



	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script>
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>
<!--===============================================================================================-->
	<script src="views/public/js/main.js"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>

</body>

</html>