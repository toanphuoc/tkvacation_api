<?php

/**
* 
*/
class DestinationController extends CController
{
	public function actionIndex(){
		$array = ("test" => "dasda")
		return json_encode($array)
	}

	public function actionList(){
		$models = Destinations::model()->findAll();
        echo json_encode($models);
	}
}