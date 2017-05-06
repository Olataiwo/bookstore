<?php

session_start();

$title = "Store:add product";

include 'includes/db.php';

include 'includes/function.php';

include 'includes/dashboard_header.php';

Utils::checkLogin();




define('MAX_FILE_SIZE',2097152);

$ext = ['image/png','image/jpg','image/jpeg'];

$errors = [];

if(array_key_exists('add',$_POST)) {

	if(empty($_POST['title'])) {

		$errors['title'] = "Please enter the book title";
	}

	if(empty($_POST['author'])) {

		$errors['author'] = "Please enter the book author";
	}

	if(empty($_POST['price'])) {

		$errors['price'] = "Please enter the price";
	}

	if(empty($_POST['cat'])) {

		$errors['cat'] = "Please choose a category";
	}

	if(empty($_FILES['pic']['name'])) {

		$errors['pic'] = 'please choose a file';
	}

	if($_FILES['pic']['size'] > MAX_FILE_SIZE) {

		$errors['pic'] = 'file is too large';
	}

	if(!in_array(strtolower($_FILES['pic']['type']),$ext)) {

		$errors['pic'] = 'File format not supported';
	}

	$check = Utils::UploadFile($_FILES,"pic","uploads/");

	if($check[0]) {

		$destination = $check[1];
	} else {

		$errors['img'] = "File upload unsuccessful";
	}

	if(empty($errors)) {

		$clean = array_map('trim',$_POST);

		$clean['loc'] = $destination;

		Utils::addProduct($conn,$clean);

		//Utils::redirect('add_product.php', "");

}

}



?>





<div class="wrapper">
		<h1 id="register-label">Add Product</h1>
		<hr>
		<form id="register"  action ="" method ="POST" enctype="multipart/form-data">

			<div>
				<?php echo Utils::displayError('title',$errors); ?>
				<label>Title:</label>
				<input name="title" type="text" placeholder="book title">
			</div>
			<div>

				<?php echo Utils::displayError('author',$errors); ?>
				<label>Author:</label>
				<input name="author" type="text" placeholder="Author">
			</div>
			<div>

				<?php echo Utils::displayError('price',$errors); ?>
				<label>Price:</label>
				<input name="price" type="text" placeholder="price">
			</div>
			<div>

				<?php echo Utils::displayError('cat',$errors); ?>

				<label>Category name:</label>
				<select name = "cat">

					<option>Select a category</option>
					<?php echo Utils::fetchCategory($conn); ?>
				</select>
			</div>

			<div>
				<?php echo Utils::displayError('pic',$errors); ?>
				<label>Image:</label>
				<input type="file" name="pic">
			</div>


			<div>
	
				<input type="submit" name="add" value="Submit">
			</div>
 
		
			
	</form>
</div>




<?php

include 'includes/footer.php';

?>