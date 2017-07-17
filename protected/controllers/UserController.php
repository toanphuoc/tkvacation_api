<?php

/**
* 
*/
class UserController extends CController
{
	
	public function actionIndex(){

	}

	public function actionLogout()
	{	
		$token = new Token();
		$t = $_GET['token'];

		if(!$token->isValidToken($t))
        {
            echo json_encode(array("message" => 'Token is invalid.'));
            exit();
        }

		$model = Token::model()->findByPk($t);
		if(is_null($model))
		{
			echo json_encode(array('status' => false, 'message' => 'Token is incorrect'));
			exit();
		}
		else if($model->delete())
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