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

}

?>