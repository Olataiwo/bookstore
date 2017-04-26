<?php

class Utils {

	public static function displayError($key,$array) {

			if(isset($array[$key])) {

				echo '<span class="err">'.$array[$key].'</span>';
			}
		} 

}

?>