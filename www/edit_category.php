<?php

		session_start();

		include 'includes/function.php' ;


		Utils::checkLogin();

		$title = "Store: add_category";

		include 'includes/dashboard_header.php';

		include 'includes/db.php' ;



		if(isset($_GET['cat_id'])){

			$catID = $_GET['cat_id'];
		}

		$item = Utils::getCategoryByID($conn,$catID);


		$errors = [];

	   if(array_key_exists('update', $_POST)) {
		   if(empty($_POST['cat_name'])) {
			$errors['cat_name'] = "Please enter a category name";
		}

		if(empty($errors)) {

			$clean = array_map('trim', $_POST);
			$clean['cid'] = $catID;

			# do update..
			Utils::updateCategory($conn, $clean);

			# redirect..
			Utils::redirect("view_category.php", "");
		
		}
	}
?>



<div class="wrapper">
		<h1 id="register-label">Edit Category</h1>
		<hr>
		<form id="register"  action ="" method ="POST">
			<div>
					
				<label>Category name:</label>
				<input name="cat_name" type="text" value="<?php echo $item[1]; ?>">
			</div>
			<div>
	
				<input type="submit" name="update">
			</div>
 
		
			<div>

		</div>
	</form>
</div>