<?php

session_start();

include "includes/function.php";

include "includes/dashboard_header.php";

include "includes/db.php";



if(isset($_GET['id'])) {

	$productID = $_GET['id'];

	
}


 Utils::deleteProduct($conn,$productID);

	#redirect

header("Location:view_product.php");

?>