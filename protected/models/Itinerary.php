<?php

class Itinerary extends CActiveRecord{
	
	public $id;

	public $title;

	public $content;

	public $tour_id;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function relations(){
		return array('itinerary' => array(self::HAS_MANY, 'Tours', 'tour_id'),);
	}

	public function getItinerayOfTour($tour_id){
		$criteria=new CDbCriteria();
		$criteria->condition = 'tour_id = :tour_id';
		$criteria->order = 'id';
		$criteria->params=(array(':tour_id'=>$tour_id));

		return Itinerary::model()->findAll($criteria);
	}
}