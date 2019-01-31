<?php 
$errors = array();
if (isset($_POST["uname"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_FILES["cv"]) && isset($_FILES["Photo"])) {
	$db = new UsersDB("users");
	$db->connect();
	if ($db->is_exist($_POST["uname"])) {
		echo "exist";
	} else
		echo "welcome";
	$upload = new Upload($_POST["uname"]);
	if ($upload->Check_photo() && $upload->Check_cv()) {
		$upload->Upload_photo();
		$upload->Upload_cv();
	} else {
		var_dump($upload->errors);
	}
} else {
	$errors[] = "Please complete the form !!";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>SignUp</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="views/public/images/icons/favicon.ico"/>
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

				<div class="wrap-input100 validate-input" data-validate="UserName is required">
					<span class="label-input100">User Name</span>
					<input class="input100" type="text" name="uname" placeholder="Enter your User Name">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Password is required">
					<span class="label-input100">Password</span>
					<input class="input100" type="password" name="password" placeholder="Enter your password">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					<span class="label-input100">Email</span>
					<input class="input100" type="text" name="email" placeholder="Enter your email addess">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input">
					<span class="label-input100">Upload CV : </span>
					<input class="input100" type="file" name="cv">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input">
					<span class="label-input100">Upload Your Photo : </span>
					<input class="input100" type="file" name="Photo">
					<span class="focus-input100"></span>
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
			</form>
		</div>
	</div>



	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<!--===============================================================================================-->
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
