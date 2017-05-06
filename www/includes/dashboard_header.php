<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title ?></title>
	<link rel="stylesheet" type="text/css" href="styles/styles.css">
</head>

<body>
	<section>
		<div class="mast">
			<h1>T<span>SSB</span></h1>
			<nav>
				<ul class="clearfix">
					<li><a href="add_category.php" <?php Utils::curNav("add_category.php");?>>add category</a></li>
					<li><a href="view_category.php" <?php Utils::curNav("view_category.php");?>>view category</a></li>
					<li><a href="add_product.php" <?php Utils::curNav("add_product.php");?>>add product</a></li>
					<li><a href="view_product.php" <?php Utils::curNav("view_product.php");?>>view product</a></li>
					<li><a href="logout.php">logout</a></li>
				</ul>
			</nav>
		</div>
	</section>