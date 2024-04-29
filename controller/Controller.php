<?php 

	class Controller {

		public function __construct() {
			
		}

		public function createSession( $user = [] ) {

			$_SESSION['accessToken'] = $user['accessToken'];
	    $_SESSION['expiresAt'] = $user['expiresAt'];
	    $_SESSION['userId'] = $user['userId'];
	    $_SESSION['username'] = $user['username'];
	    $_SESSION['roleId'] = $user['roleId'];
	    $_SESSION['roleName'] = $user['roleName'];

	    echo json_encode(['session_created' => true]);
		}


		public function logout() {
			unset($_SESSION['accessToken']);
			unset($_SESSION['expiresAt']);
			unset($_SESSION['userId']);
			unset($_SESSION['username']);
			unset($_SESSION['roleId']);
			unset($_SESSION['roleName']);
			session_destroy();
			header("Location: index.php");
		}


}