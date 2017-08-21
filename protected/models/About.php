<?php

/**
* 
*/
class About extends CActiveRecord
{
	public $id;

	public $content;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function attributeLabels()
	{
		return array(
			"id" => "Id",
			"content" => "Content"
		);
	}

	public function rules()
	{
		return array(
			array('content', 'required'),);
	}
	
	public function getAboutUs()
	{
		$criteria=new CDbCriteria();
		$criteria->limit = 1;
		$data = About::model()->findByPk(1);

		return $data;
	}
}