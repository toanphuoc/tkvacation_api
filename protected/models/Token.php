<?php

/**
* 
*/
class Token extends CActiveRecord
{
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
}