<?php

/**
* 
*/
class Contact extends CActiveRecord
{

	public $id;

	public $name;

	public $number;

	public $email;

	public $message;

	public $is_read;

	public $date_created;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function rules()
	{
		return array(
			array('name, number, email, message', 'required'),);
	}

	public function attributeLabels(){
		return array(
			'id' => 'Id',
			'name' => 'Name',
			'number' => 'Number',
			'email' => 'Email',
			'message' => 'Message',
			'is_read'=> 'IsRead',
			'date_created' => 'Date Created'
		);
	}


	public function getList($pageSize, $currentPage)
	{
		$criteria = new CDbCriteria();
		$criteria->order = 'date_created desc';
		$count = Tours::model()->count($criteria);

		$pages=new CPagination($count);
		$pages->pageSize=$pageSize;
		$pages->setCurrentPage($currentPage - 1);
    	$pages->applyLimit($criteria);

    	$model = Contact::model()->findAll($criteria);

    	$page = array('totalPage' => $pages->getPageCount(), 'currentPage' => $pages->getCurrentPage() + 1);
    	return array('contact' => $model, 'page' => $page);
	}

}