<?php

$title = "Store:admin register";

include 'includes/header.php';

include 'includes/function.php';


$errors = [];

if (array_key_exists('register', $_POST)){

		if(empty($_POST['fname'])){

			$errors['fname'] = "please enter your first name";
		}

		if(empty($errors)){

			//do database stuff
		} 

		

}

?>

<div class="wrapper">
		<h1 id="register-label">Admin Register</h1>
		<hr>
		<form id="register"  action ="admin_register.php" method ="POST">
			<div>
					<?php  

					echo Utils::displayError('fname',$errors) ; 


					?>
				<label>first name:</label>
				<input type="text" name="fname" placeholder="first name">
			</div>
			<div>
				<label>last name:</label>	
				<input type="text" name="lname" placeholder="last name">
			</div>

			<div>
				<label>email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>
 
			<div>
				<label>confirm password:</label>	
				<input type="password" name="pword" placeholder="password">
			</div>

			<input type="submit" name="register" value="register">
		</form>

		<h4 class="jumpto">Have an account? <a href="login.php">login</a></h4>
	</div>

<?php

	include 'includes/footer.php';

?>