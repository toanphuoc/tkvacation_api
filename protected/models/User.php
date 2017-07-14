<?php

/**
* 
*/
class User extends CActiveRecord
{
	public $id;

	public $username;

	public $password;

	public $salt;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function attributeLabels()
	{
		return array(
			"id" => "Id",
			"username" => "Username",
			"password" => "Password",
			"salt" => "Salt",
			"last_login" => "Last Login",
		);
	}

	public function rules()
	{
		return array(
			array('username, password, salt', 'required'),);
	}

	public function getUserByUsername($username)
	{
		$criteria=new CDbCriteria();
		$criteria->limit = 1;

		return User::model()->findByAttributes(array('username' => $username), $criteria);
	}
}