<?php

session_start();

$title = "Store:add product";

include 'includes/db.php';

include 'includes/function.php';

include 'includes/dashboard_header.php';

Utils::checkLogin();


?>


<div class="wrapper">
		<div id="stream">
			<table id="tab">
				<thead>
					<tr colspan="2">
						<th>product name</th>
						<th>Author</th>
						<th>Price</th>
						<th>Image</th>
						<th>edit</th>
						<th>delete</th>
					</tr>
				</thead>
				<tbody>
					<?php 

					$chk = Utils::InsertProduct($conn); 

					echo $chk;

					 ?>
          		</tbody>
			</table>
		</div>

		<div class="paginated">
			<a href="#">1</a>
			<a href="#">2</a>
			<span>3</span>
			<a href="#">2</a>
		</div>
	</div>