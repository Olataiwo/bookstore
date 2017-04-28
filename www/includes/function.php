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

}

?>