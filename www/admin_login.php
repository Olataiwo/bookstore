<?php

session_start();

$title = "Store: admin_login";



include 'includes/dashboard_header.php';

include 'includes/db.php' ;

include 'includes/function.php' ;


$errors = [];

if(array_key_exists('submit', $_POST)) {

	if(empty($_POST['email'])) {

		$errors['email'] = "Please enter a valid email";
	}

	if(empty($_POST['password'])) {

		$errors['password'] = "Please enter your password";
	}

	if(empty($errors)){

		$clean = array_map('trim',$_POST);

		$chk = Utils::doAdminLogin($conn,$clean);

		if($chk[0]) {

			$_SESSION['admin_id'] = $chk[1];

			Utils::redirect("add_category.php","");
		}
	}
}


?>


<div class="wrapper">
		<h1 id="register-label">Admin Login</h1>
		<hr>
		<form id="register"  action ="admin_login.php" method ="POST">
			<div>
					<?php  

					echo Utils::displayError('email',$errors) ; 


					?>
				<label>Email:</label>
				<input type="text" name="email" value="phillip@email.com" placeholder="email">
			</div>
			<div>

					<?php  

					echo Utils::displayError('password',$errors) ; 


					?>
				<label>Password:</label>	
				<input type="password" name="password"  placeholder="password">
			</div>

			<div>
					
					<input type ="submit" name="submit" value="login">

			</div>







<?php

include 'includes/footer.php';

?>