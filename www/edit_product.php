<?php

session_start();

$title = "Store:add product";

include 'includes/db.php';

include 'includes/function.php';

include 'includes/dashboard_header.php';

Utils::checkLogin();


if(isset($_GET['id'])) {

	$productID = $_GET['id'];
}

$item = Utils::getProductByID($conn,$productID);

$categoryID = $item['category_id'];

$view = Utils::getCategoryByID($conn,$categoryID);

if (array_key_exists('update',$_POST)) {


	if (empty($_POST['title'])) {

		$errors['title'] = "Product name cannot be empty";
	}


	if (empty($_POST['author'])) {

		$errors['author'] = "author name cannot be empty";
	}


	if (empty($_POST['price'])) {

		$errors['price'] = "price cannot be empty";
	}


	if (empty($_POST['cat'])) {

		$errors['cat'] = "category name cannot be empty";
	}


	if (empty($errors)) {

		$clean = array_map('trim',$_POST);

		$clean['postid'] = $postID;

		Utils::UpdateProduct($conn,$clean,$productID);

		header("Location:view_product.php");
	}
}

?>




<div class="wrapper">
		<h1 id="register-label">Add Product</h1>
		<hr>
		<form id="register"  action ="" method ="POST" enctype="multipart/form-data">

			<div>
				
				<label>product name:</label>
				<input name="title" type="text" placeholder="book title" value="<?php echo $item['product_name']; ?>">
			</div>

			<div>
				
				<label>Author:</label>
				<input name="author" type="text" placeholder="book title" value="<?php echo $item['author']; ?>">
			</div>

			<div>
				
				<label>price:</label>
				<input name="price" type="text" placeholder="book title" value="<?php echo $item['price']; ?>">
			</div>

			<div>
				
				<label>category name:</label>
				<select name='cat'>
					
					<option value="<?php echo $view['category_id'] ?>"><?php echo $view['category_name'] ; ?><option>
					<?php

						echo Utils::fetchCategory($conn);
					?>


				</select>
			</div>

			<div>
				
				<input name="update" type="submit" value="update">
			</div>

