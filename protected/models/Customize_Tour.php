<?php

/**
* 
*/
class Customize_Tour extends CActiveRecord
{
	public $id;

	public $name;

	public $email;

	public $phone_number;

	public $nationality;

	public $destination;

	public $estimate_duration;

	public $estimate_date_start;

	public $ideas;

	public $is_read;

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
			'ideas' => 'Ideas',
			'is_read' => 'Is Read'
		);
	}

	public function rules()
	{
		return array(
			array('name, email, phone_number, nationality, destination, estimate_date_start, estimate_duration', 'required'),);
	}

	public function getList($pageSize, $currentPage){
		$criteria = new CDbCriteria();
		$criteria->order = 'date_created desc';
		$count = Customize_Tour::model()->count($criteria);

		$pages=new CPagination($count);
		$pages->pageSize=$pageSize;
		$pages->setCurrentPage($currentPage - 1);
    	$pages->applyLimit($criteria);

    	$model = Customize_Tour::model()->findAll($criteria);

    	$page = array('totalPage' => $pages->getPageCount(), 'currentPage' => $pages->getCurrentPage() + 1);
    	return array('data' => $model, 'page' => $page);
	}

}