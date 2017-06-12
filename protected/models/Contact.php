<?php

/**
* 
*/
class Contact extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function rules(){
		return array(
			array('name, number, email, message', 'required'),);
	}

	public function attributeLabels(){
		return array(
			'id' => 'Id',
			'name' => 'Name',
			'number' => 'Number',
			'email' => 'Email',
			'message' => 'Message'
		);
	}


}