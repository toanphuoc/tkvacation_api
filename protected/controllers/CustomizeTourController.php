<?php

/**
* 
*/
class CustomizeTourController extends CController
{

	public function actionCreate(){
		$model = new Customize_Tour();
		foreach($_POST as $var=>$value) {
        // Does the model have this attribute? If not raise an error
	        if($model->hasAttribute($var))
	            $model->$var = $value;
    	}
    	header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    	if($model->save()){
    		echo json_encode(array('status' => true));
    	}else{
    		echo json_encode(array('status' => false));
    	}
	}
}