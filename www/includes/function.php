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

		$stmt->bindParam('cid',$cat);

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


}




?>