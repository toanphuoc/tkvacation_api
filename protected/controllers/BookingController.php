<?php

/**
* 
*/
class BookingController extends CController
{
	
	public function actionCreate()
	{
		$model = new Booking();
		foreach($_POST as $var=>$value) {
        // Does the model have this attribute? If not raise an error
	        if($model->hasAttribute($var))
	            $model->$var = $value;
    	}
    	header('Content-Type: application/json');
    	if($model->save()){
    		echo json_encode(array('status' => true));
    	}else{
    		echo json_encode(array('status' => false));
    	}
	}
}