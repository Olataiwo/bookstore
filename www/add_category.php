<?php

session_start();

include 'includes/function.php' ;


Utils::checkLogin();

$title = "Store: add_category";

include 'includes/dashboard_header.php';

include 'includes/db.php' ;





$errors = [];

if(array_key_exists('submit', $_POST)) {

	if(empty($_POST['cat'])) {

		$errors['cat'] = "Please enter a category name";
	}


	if(empty($errors)){

		$clean = array_map('trim',$_POST);

		Utils::addCategory($conn,$clean);

		
	}
}


?>


<div class="wrapper">
		<h1 id="register-label">Add Category</h1>
		<hr>
		<form id="register"  action ="add_category.php" method ="POST">
			<div>
					<?php  

					echo Utils::displayError('cat',$errors) ; 


					?>
				<label>Category name:</label>
				<input type="text" name="cat" placeholder="add category">
			</div>
			

			<div>
					
					<input type ="submit" name="submit" value="add category">

			</div>





<?php

include 'includes/footer.php';

?>