<?php

/**
* 
*/
class Token extends CActiveRecord
{

	Const APPLICATION_ID = 'ASCCPE';

	public $token;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function relations(){
		return array('token' => array(self::HAS_MANY, 'User', 'user_id'),);
	}

	public function attributeLabels()
	{
		return array(
			"token" => "Token",
			"active_time" => "Active Time",
			"user_id" => "User",
		);
	}

	public function rules()
	{
		return array(
			array('token, active_time, user_id', 'required'),);
	}

	public function isValidToken($token)
	{
		$model = Token::model()->findByPk($token);
		if(is_null($model)){
			return false;
		}

		return true;
	}

	private function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        return (isset($codes[$status])) ? $codes[$status] : '';
    }

	public function _checkAuth()
	{
		// echo isset($_SERVER['username']);
		// 	exit();
		// Check if we have the USERNAME and PASSWORD HTTP headers set?
        if(!(isset($_SERVER['username']) and isset($_SERVER['password']))) {
            // Error: Unauthorized
            echo json_encode(array('status' => 401, 'message' => 'Unauthorized'));
            exit();
        }
        $username = $_SERVER['username'];
        $password = $_SERVER['password'];
        // Find the user
        $user=User::model()->find('LOWER(username)=?',array(strtolower($username)));
        if($user===null) {
            // Error: Unauthorized
            //$this->_sendResponse(401, 'Error: User Name is invalid');
            echo json_encode(array('status' => 401, 'message' => 'Error: User Name is invalid'));
            exit();
        } else if(!$user->validatePassword($password)) {
            // Error: Unauthorized
            // $this->_sendResponse(401, 'Error: User Password is invalid');
            echo json_encode(array('status' => 401, 'message' => 'Error: User Password is invalid'));
            exit();
        }
	}

    public function checkValidToken($token)
    {
        if(!$this->isValidToken($token))
        {
            echo json_encode(array('status' => false, "message" => 'Token is invalid.'));
            exit();
        }

        $model = Token::model()->findByPk($token);
        if(is_null($model))
        {
            echo json_encode(array('status' => false, 'message' => 'Token is incorrect'));
            exit();
        }
    }
}