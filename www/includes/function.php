<?php

class Utils {

	public static function displayError($key,$array) {

			if(isset($array[$key])) {

				echo '<span class="err">'.$array[$key].'</span>';
			}
		} 

	public static function registerAdmin($dbconn,$input) {

			$stmt = $dbconn->prepare("INSERT into admin (firstname,lastname,email,hash) VALUES(:f,:l,:e,:h)");

			$data = [

				":f" => $input['fname'],

				":l" => $input['lname'],

				":e" => $input['email'],

				":h" => $input['password'],


			];

			$stmt->execute($data);

	}


	public static function doesEmailExists($dbconn,$email) {

		$result = false;

		$stmt = $dbconn->prepare("SELECT * FROM admin WHERE email = :e") ;

		$stmt->bindParam(":e",$email);

		$stmt->execute();

		$count = $stmt->rowCount();

		if ($count > 0) {

			$result = true;
		}

		return $result;
	}

	public static function doAdminLogin ($dbconn,$input) {

		$result = [];

		$stmt = $dbconn->prepare("SELECT * FROM admin WHERE email = :e");

		$stmt->bindParam(":e",$input['email']);

		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_BOTH);

		if (($stmt->rowCount() != 1) || !password_verify($input['password'],$row['hash'])) {

			Utils::redirect("admin_login.php?","Login failed");

			exit();
		
		} else {

			$result[] = true;
			$result[] = $row['admin_id'];
		}

		return $result;

	}


		public static function redirect($loc, $msg) {
			header("Location: ".$loc.$msg);
		}


	public static function addCategory($dbconn,$clean) {

			$stmt = $dbconn->prepare("INSERT INTO category(category_name) VALUES(:c)");

			$stmt->bindParam(":c",$clean['cat']);

			$stmt->execute();
	}

	public static function checkLogin() {

		if(!isset($_SESSION['admin_id'])){

			Utils::redirect("admin_login.php","");
		}
	}


	public static function curNav($page) {

		$curPage = basename($_SERVER['SCRIPT_FILENAME']);

		if ($curPage == $page) {

			echo "class = 'selected'";
		}
	}

	public static function viewCategory ($dbconn) {

		$result = "";

		$stmt = $dbconn->prepare("SELECT * FROM category") ;

		$stmt->execute();

		while($row = $stmt->fetch(PDO::FETCH_BOTH)) {

			$result.='<tr><td>'.$row[0].'</td>';
			$result.='<td>'.$row[1].'</td>';
			$result.='<td><a href="edit_category.php?cat_id='.$row[0].'">Edit</a></td>';
			$result.='<td><a href="delete_category.php?cat_id='.$row[0].'">Delete</a></td></tr>';
		}

		return $result;
	}

	public static function getCategoryByID($dbconn,$cat) {

		$stmt = $dbconn->prepare("SELECT * FROM category WHERE category_id = :cid");

		$stmt->bindParam('cid', $cat);

		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_BOTH);

		return $row;
	}

	public static function updateCategory($dbconn, $input) {
			$stmt = $dbconn->prepare("UPDATE category SET category_name=:name WHERE category_id=:catid");

			$data = [
				":name" => $input['cat_name'],
				":catid" => $input['cid']
			];

			$stmt->execute($data);
		}



	public static function deleteCategory($dbconn,$catid) {

		$stmt = $dbconn->prepare("DELETE FROM category WHERE category_id = :cid");

		$stmt->bindParam(":cid",$catid);

		$stmt->execute();
	}

	public static function UploadFile ($files, $key, $destination) {

		$result = [];

		$rnd = rand(00000, 99999);

		$filename = str_replace(" ", "_", $files[$key]['name']);

		$filename = $rnd.$filename;

		$destination =$destination.$filename;

		if(move_uploaded_file($files[$key]['tmp_name'], $destination)) {

			$result[] = true;
			$result[] = $destination;

		} else {

			$result[] = false;
		}

		return $result;

	}  

	public static function addProduct($dbconn,$input) {

		$stmt = $dbconn->prepare("INSERT INTO product(category_id, product_name, author, price, file_loc) VALUES(:cid, :pn, :au, :pr,  :fl)");

		$data = [

			":pn"=>$input['title'],

			":au"=>$input['author'],

			":pr"=>$input['price'],

			":cid"=>$input['cat'],

			":fl"=>$input['loc']

		];

		$stmt->execute($data);
	}


	public static function fetchCategory($dbconn) {

		$result ="";

		$stmt = $dbconn->prepare("SELECT * FROM category");

		$stmt->execute();

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

			$result.='<option value="'.$row['category_id'].'">'.$row['category_name'].'</option>';

		}

		return $result;
	}


	public static function InsertProduct($dbconn) {

			$result ="";

		$statement = $dbconn->prepare("SELECT * FROM product");

		$statement->execute();

		While($row = $statement->fetch(PDO::FETCH_ASSOC)) {

			$result.='<tr><td>'.$row['product_name'].'</td>';

			$result.='<td>'.$row['author'].'</td>';

			$result.='<td>'.$row['price'].'</td>';

			$result.='<td><img src = '.$row['file_loc'].' height = "20" width="30"></td>';

			$result.='<td><a href= edit_product.php?id='.$row['product_id'].'>edit</a></td>';

			$result.='<td><a href= delete_product.php?id='.$row['product_id'].'>delete</a></td></tr>';

								
		}

		return $result;
	}


	public static function getProductByID($dbconn,$pid) {

			$stmt = $dbconn->prepare("SELECT * FROM product WHERE product_id = :pid");

			$stmt->bindParam(":pid",$pid);

			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			return $row;

	}

	public static function UpdateProduct($dbconn,$input,$pid) {

			$stmt = $dbconn->prepare("UPDATE product SET product_name = :pn, author = :au, price = :pr, category_id = :ci WHERE product_id = :pid");

			$data = [

				":pn"=> $input['title'],

				":au"=> $input['author'],

				":pr"=> $input['price'],

				":ci"=> $input['cat'],

				":pid"=> $pid


			];

			$stmt->execute($data);
		}

		public static function deleteProduct($dbconn,$pid) {

			$stmt = $dbconn->prepare("DELETE FROM product WHERE product_id = :pid ");

			$stmt->bindParam(":pid",$pid);

			$stmt->execute();
		} 

		public static function registerUser($dbconn,$input) {

			$stmt = $dbconn->prepare("INSERT into user (firstname,lastname,email,username,hash) VALUES(:f,:l,:e,:u,:h)");

			$data = [

				":f" => $input['fname'],

				":l" => $input['lname'],

				":e" => $input['email'],


				":u" => $input['username'],


				":h" => $input['password']


			];

			$stmt->execute($data);

	}
		public static function checkEmail($dbconn,$e) {

			$result = false;

			$stmt = $dbconn->prepare("SELECT * FROM user WHERE email = :e");

			$stmt->bindParam(":e",$e);

			$stmt->execute();

			if ($stmt->rowCount() > 0) {

				$result = true;
			}

			return $result;
		}
}

		





?>