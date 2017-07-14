<?php

/**
* 
*/
class UserController extends CController
{
	
	public function actionIndex(){

	}

	public function actionLogin()
	{
		$user = new User();

		$username = $_POST["username"];
		$password = $_POST["password"];

		$objUser = $user->getUserByUsername($username);

		header('Content-Type: application/json');
		if(!is_null($objUser))
		{
			$passwordEncryted = hash('sha256', $password.$objUser->salt);
			// echo $passwordEncryted;
			// exit();

			if(strcasecmp($passwordEncryted, $objUser->password) == 0)
			{
				date_default_timezone_set("Asia/Ho_Chi_Minh");
				$date = date("Y-m-d H:i:s");
				$token = hash('sha256', $objUser->username.$date);
				$objToken = new Token();
				$objToken->user_id = $objUser->id;
				$objToken->active_time = $date;
				$objToken->token = $token;

				$objToken->save();

				echo json_encode(array('status' => true, 'message' => 'Login successfully.', 'token' => $token));
			}
			else
			{
				echo json_encode(array('status' => false, 'message' => 'Password is not match.'));
			}
		}
		else
		{
			echo json_encode(array('status' => false, 'message' => 'User name is not exist.'));
		}
	}
}