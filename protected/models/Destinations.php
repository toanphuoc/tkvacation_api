<?php

/**
* 
*/
class Destinations extends CActiveRecord
{
	public $id;

	public $title;

	public $img;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}