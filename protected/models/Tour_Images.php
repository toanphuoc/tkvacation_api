<?php

/**
* 
*/
class Tour_Images extends CActiveRecord
{

	public $id;

	public $url;

	public $tour_id;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function attributeLabels()
	{
		return array(
			"id" => "Id",
			"url" => "Url", 
			"tour_id" => "Tour"
		);
	}

	public function rules()
	{
		return array(
			array('url, tour_id', 'required'),);
	}

	public function relations()
	{
		return array('tour_id' => array(self::BELONGS_TO, 'Tourrs', 'tour_id'),);
	}

	public function getImagesOfTour($tour_id){
		$criteria = new CDbCriteria();
		$criteria->condition = "tour_id = :id";
		$criteria->params=(array(':id'=>$tour_id));

		return Tour_Images::model()->findAll($criteria);
	}
}