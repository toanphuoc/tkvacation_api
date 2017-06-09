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

	public function search($key, $destination_id, $periodMin, $periodMax, $priceMin, $priceMax){
		$sql = "CALL searchTour(:key, :desId, :periodMin, :periodMax, :priceMin, :priceMax)";
		$data = Yii::app()->db->createCommand($sql)->bindValue('key', $key)
											->bindValue('desId', $destination_id)
											->bindValue('periodMin', $periodMin)
											->bindValue('periodMax', $periodMax)
											->bindValue('priceMin', $priceMin)
											->bindValue('priceMax', $priceMax)->queryAll();
		$count = count($data);
		
		return $data;
	}

	public function getList($pageSize, $currentPage){
		$criteria = new CDbCriteria();
		$criteria->order = 'date_created desc';
		$count = Tours::model()->count($criteria);

		$pages=new CPagination($count);
		$pages->pageSize=$pageSize;
		$pages->setCurrentPage($currentPage - 1);
    	$pages->applyLimit($criteria);

    	$model = Tours::model()->findAll($criteria);
    	$page = array('totalPage' => $pages->getPageCount(), 'currentPage' => $pages->getCurrentPage() + 1);
    	return array('tours' => $model, 'page' => $page);
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