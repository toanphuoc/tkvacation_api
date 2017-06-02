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

	public $date_created;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function relations(){
		return array('destination' => array(self::BELONGS_TO, 'Destinations', 'destination_id'),);
	}

	public function getTourInDestination($destination_id){
		$criteria=new CDbCriteria();
		$criteria->order = 'date_created DESC';
		$criteria->condition = "destination_id = :id";
    	$criteria->params=(array(':id'=>$destination_id));
		$models = Tours::model()->findAll($criteria);
		return $models;
	}

	public function getPopularTour($limit){

		$criteria=new CDbCriteria();
		$criteria->order='booking DESC';
		$criteria->limit = $limit;
		$criteria->order = 'date_created DESC';
		$models = Tours::model()->findAll($criteria);
		return $models;
	}

	public function getTourById($id){
		return Tours::model()->findByPk($id);
	}
}