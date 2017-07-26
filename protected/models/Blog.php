<?php

/**
* 
*/
class Blog extends CActiveRecord
{
	public $id;

	public $blog_name;

	public $overview;

	public $date_created;

	public $blog_img;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function attributeLabels()
	{
		return array(
			"id" => "Id",
			"blog_name" => "Blog Name",
			"overview" => "Overview",
			"date_created" => "Date Created",
			"blog_img" => "Blog Image"
		);
	}

	public function rules()
	{
		return array(
			array('blog_name, overview, date_created', 'required'),);
	}

	// public function tableName()
	// {
	// 	return '{{blog}}';
	// }

	public function getListBlog($pageSize, $currentPage)
	{
		$criteria = new CDbCriteria();
		$criteria->order = 'date_created desc';
		$count = Blog::model()->count($criteria);

		$pages=new CPagination($count);
		$pages->pageSize=$pageSize;
		$pages->setCurrentPage($currentPage - 1);
    	$pages->applyLimit($criteria);

    	$model = Blog::model()->findAll($criteria);

    	$page = array('totalPage' => $pages->getPageCount(), 'currentPage' => $pages->getCurrentPage() + 1);
    	return array('blogs' => $model, 'page' => $page);
	}

	public function getBlogById($id)
	{
		$blog = Blog::model()->findByPk($id);
		$blog_img = new Blog_Images();

		$imgs = $blog_img->getBlogImages($id);

		return array('blog' => $blog, 'imgs' => $imgs);
	}
}