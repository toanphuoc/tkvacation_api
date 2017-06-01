<?php

class Tours extends CActiveRecord{

	public $id;

	public $name;

	public $period;

	public $availability;

	public $overview;

	public $price;

	public $destination_id;

	public $booking;

	public $price_vnd;

	public $img;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function relations(){
		return array('destination' => array(self::BELONGS_TO, 'Destinations', 'destination_id'),);
	}

	public function getTourInDestination($destination_id){
		$models = Tours::model()->findAll('destination_id = :id', array(':id' => $destination_id) );
		return $models;
	}

	public function getPopularTour(){

		$criteria=new CDbCriteria();
		$criteria->order='booking DESC';
		$criteria->limit = 4;

		$models = Tours::model()->findAll($criteria);
		return $models;
	}

	public function getTourById($id){
		return Tours::model()->findByPk($id);
	}
}