<?php

include 'includes/function.php';

include 'includes/db.php';

include 'includes/user_header.php';

  

   $errors = [];

if(array_key_exists('register',$_POST)) {

	if(empty($_POST['fname'])) {

		$errors['fname'] = "please enter first name";
	}


	if(empty($_POST['lname'])) {

		$errors['lname'] = "please enter last name";
	}


	if(empty($_POST['email'])) {

		$errors['email'] = "please enter email";
	}


	if(empty($_POST['username'])) {

		$errors['username'] = "please enter a username";
	}
	
	if(empty($_POST['password'])) {

		$errors['password'] = "please enter a password";
	}


	if(empty($_POST['pword'])) {

		$errors['pword'] = "please confirm your password";
	}

	if($_POST['pword'] != $_POST['password']) {

		$errors['password'] = "password does not match";
	}

	$check = Utils::checkEmail($conn,$_POST['email']);

	if($check){

		$errors['email'] = 'email exists, try another email';
	}


	if(empty($errors)) {

		$clean = array_map('trim',$_POST);

		$hash = password_hash($clean['password'],PASSWORD_BCRYPT);

		$clean['password'] = $hash;

		Utils::registerUser($conn,$clean);

	}
}

?>


 <div class="main">
    <div class="registration-form">
      <form class="def-modal-form" method="post" action = "user_registeration.php">
        <div class="cancel-icon close-form"></div>


        <label for="registration-from" class="header"><h3>User Registration</h3></label>

         <?php echo Utils::displayError('fname',$errors); ?>
        <input type="text" class="text-field first-name" name="fname" placeholder="Firstname">

          <?php echo Utils::displayError('lname',$errors); ?>
        <input type="text" class="text-field last-name" name="lname" placeholder="Lastname">

          <?php echo Utils::displayError('email',$errors); ?>
        <input type="email" class="text-field email" name="email" placeholder="Email">

          <?php echo Utils::displayError('username',$errors); ?>
        <input type="text" class="text-field username" name="username" placeholder="Username">

          <?php echo Utils::displayError('password',$errors); ?>
        <input type="password" class="text-field password" name="password" placeholder="Password">

          <?php echo Utils::displayError('pword',$errors); ?>
        <input type="password" class="text-field confirm-password" name="pword" placeholder="Confirm Password">

        <input type="submit" class="def-button" name="register" value="Register">

        <p class="login-option">Have an account already? Login</p>
      </form>
    </div>
  </div>


  <?php

  include 'includes/footers.php';

  ?>