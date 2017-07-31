<?php

/**
* 
*/
class Destinations extends CActiveRecord
{
	public $id;

	public $title;

	public $img;

	public $status;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAll(){
		$models = Destinations::model()->findAll();
		return $models;
	}

	public function getAvailableDestination()
	{
		$criteria=new CDbCriteria();
		$criteria->order = 'title';
		$criteria->condition = "status = true";

		return Destinations::model()->findAll($criteria);
	}

	public function popularDestination(){
		$criteria=new CDbCriteria();
		$criteria->limit = 5;
		$criteria->condition = "status = true";
		return Destinations::model()->findAll($criteria);
	}

	public function getDestinationById($id){
		return Destinations::model()->findByPk($id);
	}

	public function getOtherDestination($id){
		$criteria=new CDbCriteria();
		// $criteria->condition = "status = true";
		$criteria->condition = 'status = true and id != :id';
		$criteria->params=(array(':id'=>$id));

		return Destinations::model()->findAll($criteria);
	}

	public function relations(){
		return array('tours' => array(self::HAS_MANY, 'Tours', 'id'), );
	}
}