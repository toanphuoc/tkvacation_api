<?php

/**
* 
*/
class Booking extends CActiveRecord
{
	public $id;

	public $tour_id;

	public $start_date;

	public $number_of_people;

	public $first_name;

	public $last_name;

	public $email;

	public $phone;

	public $country;

	public $is_check;

	public $date_created;

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
			"is_check" => "Checked",
			"date_created" => "Date Created"
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

	public function getList($pageSize, $currentPage)
	{
		$criteria = new CDbCriteria();
		$criteria->order = 'date_created desc';
		$count = Booking::model()->count($criteria);

		$pages=new CPagination($count);
		$pages->pageSize=$pageSize;
		$pages->setCurrentPage($currentPage - 1);
    	$pages->applyLimit($criteria);

    	$model = Booking::model()->findAll($criteria);

    	$page = array('totalPage' => $pages->getPageCount(), 'currentPage' => $pages->getCurrentPage() + 1);
    	return array('booking' => $model, 'page' => $page);
	}
}