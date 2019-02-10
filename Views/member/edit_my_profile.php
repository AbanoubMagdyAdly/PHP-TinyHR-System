<?php 
defined('_ALLOW_ACCESS')or die("Not Allowed");
$db = new UsersDB(__TABLE_NAME__);
$db->connect();
$res = $db->get_record_by_id($_SESSION["user_id"]);
?>
<?php 
$errors = array();
if (isset($_POST["fullname"]) && isset($_POST["email"]))
	if (!empty($_POST["fullname"]) && !empty($_POST["email"])) {
	$db = new UsersDB("users");
	$db->connect();
	$upload = new Upload($res[0]["username"]);

	if (isset($_Files['cv']['name']) && isset($_Files['photo']['name'])) {
		if (!empty($_Files['cv']['name']) && !empty($_Files['photo']['name'])) {
			$cv_check = $upload->Check_cv();
            $photo_check = $upload->Check_photo();
			if ($cv_check && $photo_check) {
				$upload->Upload_photo();
				$upload->Upload_cv();
			}
		}
	}
	$db->connect();
	$db->update_user_date($_POST["fullname"], $_POST["email"], $_POST["job"]);


} else {
	$upload->errors["form"] = "Please complete the form !!";
}
if (isset($upload->errors) && empty($upload->errors)) {
	header('Refresh: 0; URL=');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Profile</title>
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
            <form class="contact100-form validate-form" enctype="multipart/form-data" method="post">
                <span class="contact100-form-title">
                    Edit Your Data!
                </span>

                <div class="wrap-input100 validate-input" data-validate="UserName is required">
                    <span class="label-input100">User Name</span>
                    <input class="input100" type="text" name="fullname" value="<?php echo $res[0]["fullname"] ?>">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                    <span class="label-input100">Email</span>
                    <input class="input100" type="text" name="email" value="<?php echo $res[0]["email"] ?>">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Job is required">
                    <span class="label-input100">User job</span>
                    <input class="input100" type="text" name="job" value="<?php echo $res[0]["job"] ?>">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100t">
                    <span class="label-input100">Upload CV : </span>
                    <input class="input100" type="file" name="cv">
                    <span class="focus-input100"></span>
                    <p class="error">
                        <?php if (isset($upload->errors["cv"])) {
                            echo "*" . $upload->errors["cv"];
                        } ?>
                    </p>
                </div>

                <div class="wrap-input100">
                    <span class="label-input100">Upload Your Photo : </span>
                    <input class="input100" type="file" name="Photo">
                    <span class="focus-input100"></span>
                    <p class="error">
                        <?php if (isset($upload->errors["photo"])) {
																								echo "*" . $upload->errors["photo"];
																							} ?>
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
                    <?php if (isset($upload->errors["form"])) {
																				echo "*" . $upload->errors["form"];
																			} ?>
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

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
    </script>

</body>

</html>