<?php

/**
* 
*/
class Blog_Images extends CActiveRecord
{
	
	public $id;

	public $url;

	public $blog_id;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'url' => 'URL',
			'blog_id' => 'Blog'
			
		);
	}

	public function rules()
	{
		return array(
			array('url, blog_id', 'required'),);
	}

	public function relations()
	{
		return array('blog_id' => array(self::BELONGS_TO, 'Blog', 'id'),);
	}

	public function getBlogImages($blog_id)
	{
		return Blog_Images::model()->findAll('blog_id = :blog_id', array('blog_id' => $blog_id));
	}
}