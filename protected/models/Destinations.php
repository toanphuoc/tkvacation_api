<?php

/**
* 
*/
class Destinations extends CActiveRecord
{
	public $id;

	public $title;

	public $img;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAll(){
		$models = Destinations::model()->findAll();
		return $models;
	}

	public function popularDestination(){
		$criteria=new CDbCriteria();
		$criteria->limit = 5;
		return Destinations::model()->findAll($criteria);
	}

	public function relations(){
		return array('tours' => array(self::HAS_MANY, 'Tours', 'id'), );
	}
}