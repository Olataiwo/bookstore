<?php
session_start();

include 'includes/function.php';

include 'includes/db.php';

include 'includes/header.php';

Utils::checkLogin();





if(isset($_GET['cat_id'])) {

	$catID = $_GET['cat_id'];
}

Utils::deleteCategory($conn,$catID);

Utils::redirect('view_category.php', "");
?>


