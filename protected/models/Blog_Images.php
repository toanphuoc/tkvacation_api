<?php

/**
* 
*/
class Blog_Images extends CActiveRecord
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Name',
			'email' => 'Email',
			'phone_number' => 'Phone Number',
			'nationality' => 'Nationality',
			'destination' => 'Destination',
			'estimate_date_start' => 'Estimate Date Start',
			'estimate_duration' => 'Estimate Duration', 
			'ideas' => 'Ideas'
		);
	}
}