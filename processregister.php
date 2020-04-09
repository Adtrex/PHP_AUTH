<?php session_start();
 
//collecting Data

$errorCount = 0;
$first_name = $_POST["first_name"] != "" ? $_POST['first_name'] : $errorCount++;
$last_name = $_POST["last_name"] != "" ? $_POST['last_name'] : $errorCount++;
$email = $_POST["email"] != "" ? $_POST['email'] : $errorCount++;
$password = $_POST["password"] != "" ? $_POST['password'] : $errorCount++;
$gender = $_POST["gender"] != "" ? $_POST['gender'] : $errorCount++;
$designation = $_POST["designation"] != "" ? $_POST['designation'] : $errorCount++;
$department = $_POST["department"] != "" ? $_POST['department'] : $errorCount++;

$_SESSION["first_name"] = $first_name;
$_SESSION["last_name"] = $last_name;
$_SESSION["email"] = $email;
$_SESSION["password"] = $password;
$_SESSION["gender"] = $gender;
$_SESSION["designation"] = $designation;
$_SESSION["department"] = $department;

 

if ($errorCount > 0) {
	//Display proper messages to the user
	//Give more accurate feedback to the user
	 $_SESSION["error"] = "You have " . $errorCount . " errors in your form submission";
	 header("Location: register.php");
}else{

	$allUsers = scandir("db/users/");
	$countAllUsers = count($allUsers);

	$newUserId = $countAllUsers+1; 


	$userObject =[
		'id'=>$newUserId,
		'first_name'=>$first_name,
		'last_name'=>$last_name,
		'email'=>$email,
		'password'=> password_hash($password,PASSWORD_DEFAULT),
		'gender'=>$gender,
		'designation'=>$designation,
		'department'=>$department

	];

	//verify user esistence using loops

	for($counter = 0; $counter < $countAllUsers; $counter++) {

		$currentUser = $allUsers[$counter];

		if($currentUser == $email . ".json"){
			$_SESSION["error"] = "Registration failed, User already exits";
	 		header("Location: register.php");
	 		die();
	 	}

	 	}
	




	//Save files in DB)
	file_put_contents('db/users/'. $email . ".json",json_encode($userObject));
	 $_SESSION["message"] = "Registration Successful, you can now login " . $first_name;
	 header("Location: login.php");
}






//saving Data

//

 