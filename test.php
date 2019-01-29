
if(isset($_POST["submit"]) && !empty($_POST["submit"])){
	if(isset($_POST["username"])){
		if(empty($_POST["username"])){
			$errors["username"]  = "Name can not be empty";
		} 
		else if(strlen($_POST["username"])>20){
			$errors["username"]  = "Name can not exceed 20 chars";
		}
	}
	
	if(isset($_POST["email"]) && empty($_POST["email"])){
		$errors["email"]  = "email can not be empty";
	}

	if(isset($_POST["message"]) && empty($_POST["message"])){
		$errors["message"]  = "message can not be empty";
	}

	if(empty($errors)){
		echo "thank you";
		exit();
	}
}

	if(isset($_POST["username"]) && !empty($_POST["username"])){
		echo $_POST["username"];
		echo $_POST["pass"];
	}