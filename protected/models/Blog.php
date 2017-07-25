<?php

/**
* 
*/
class Blog extends CActiveRecord
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
}