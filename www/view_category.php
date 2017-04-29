<?php

session_start();

include 'includes/function.php' ;


Utils::checkLogin();

$title = "Store: view_category";

include 'includes/dashboard_header.php';

include 'includes/db.php' ;

?>






<div class="wrapper">
		<div id="stream">
			<table id="tab">
				<thead>
					<tr>
						<th>Category ID</th>
						<th>Category name</th>
						<th>edit</th>
						<th>delete</th>
					</tr>
				</thead>
				<tbody>
					<?php echo Utils::viewCategory($conn);?>
          		</tbody>
			</table>
		</div>

		<div class="paginated">
			<a href="#">1</a>
			<a href="#">2</a>
			<span>3</span>
			<a href="#">4</a>
		</div>
	</div>



<?php

	include 'includes/footer.php';

?>
