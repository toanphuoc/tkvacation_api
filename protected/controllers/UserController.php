<?php

/**
* 
*/
class UserController extends CController
{
	
	public function actionIndex(){

	}

	public function actionChangePassword()
	{
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		$token = new Token();
		$t = $_GET['token'];

		$token->checkValidToken($t);

		$currentPassw = $_POST['currentPassword'];
		$newPassw = $_POST['newPassword'];

		$token = Token::model()->findByPk($t);
		$user_id = $token->user_id;

		$user = User::model()->findByPk($user_id);

		if(!$user->validatePassword($currentPassw)){
			echo json_encode(array('status' => false, "message" => "Current password is incorrect."));
			exit();
		}

		//Update new password
		$newPasswordEncrypt = hash('sha256', $newPassw.$user->salt);

		$user->password = $newPasswordEncrypt;

		if($user->save()){
			//Delete old token
			$token->delete();

			//Create new token
			date_default_timezone_set("Asia/Ho_Chi_Minh");
			$date = date("Y-m-d H:i:s");
			$token = hash('sha256', $user->username.$date);
			$objToken = new Token();
			$objToken->user_id = $user_id;
			$objToken->active_time = $date;
			$objToken->token = $token;

			$objToken->save();

			echo json_encode(array('status' => true, 'message' => 'Change password is successfully.', 'token' => $token));
		}else{
			echo json_encode(array('status' => false, 'message' => 'Change password is failure.'));
		}
	}

	public function actionLogout()
	{	
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		$token = new Token();
		$t = $_GET['token'];

		$token->checkValidToken($t);
		$model = Token::model()->findByPk($t);
		if($model->delete())
		{
			echo json_encode(array('status' => true, 'message' => 'Logout is successful'));
			exit();
		}
		echo json_encode(array('status' => false, 'message' => 'Error'));
	}

	public function actionLogin()
	{
		$user = new User();

		$username = $_POST["username"];
		$password = $_POST["password"];

		$objUser = $user->getUserByUsername($username);

		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		if(!is_null($objUser))
		{
			if($objUser->validatePassword($password))
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