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

	public static function viewCategory ($dbconn) {

		$result = "";

		$stmt = $dbconn->prepare("SELECT * FROM category") ;

		$stmt->execute();

		while($row = $stmt->fetch(PDO::FETCH_BOTH)) {

			$result.='<tr><td>'.$row[0].'</td>';
			$result.='<td>'.$row[1].'</td>';
			$result.='<td><a href="edit_category.php?cat_id='.$row[0].'">Edit</a></td>';
			$result.='<td><a href="delete.php?cat_id='.$row[0].'">Delete</a></td></tr>';
		}

		return $result;
	}

	public static function getCategoryByID($dbconn,$cat) {

		$stmt = $dbconn->prepare("SELECT * FROM category WHERE category_id = :cid");

		$stmt->bindParam(':cid',$cat);

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


}




?>