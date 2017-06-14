<?php

/**
* 
*/
class Booking extends CActiveRecord
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function attributeLabels()
	{
		return array(
			"id" => "Id",
			"tour_id" => "Tour",
			"start_date" => "Start Date",
			"number_of_people" => "Number of people",
			"first_name" => "First Name",
			"last_name" => "Last Name", 
			"email" => "Email", 
			"phone" => "Phone", 
			"country" => "Country",
			"note" => "Note",
			"is_check" => "Checked"
		);
	}

	public function rules()
	{
		return array(
			array('tour_id, start_date, number_of_people, first_name, last_name, email, phone, country', 'required'),);
	}

	public function relations()
	{
		return array('tour_id' => array(self::BELONGS_TO, 'Tourrs', 'tour_id'),);
	}
}