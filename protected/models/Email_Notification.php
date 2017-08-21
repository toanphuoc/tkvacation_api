<?php

/**
* 
*/
class Email_Notification extends CActiveRecord
{
	
	public $id;

	public $email;

	public $last_name;

	public $first_name;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function attributeLabels()
	{
		return array(
			"id" => "Id",
			"email" => "Email",
			"last_name" => "Last name",
			"first_name" => "First name"
		);
	}

	public function rules()
	{
		return array(
			array('email, last_name, first_name', 'required'),);
	}
}