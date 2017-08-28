<?php

/**
* 
*/
class CustomizeTourController extends CController
{

    public function actionDelete()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        $token = new Token();
        $t = $_GET['token'];

        $token->checkValidToken($t);

        $id = $_GET['id'];
        $model = Customize_Tour::model()->findByPk($id);
        if(is_null($model)){
            echo json_encode(array("status" => false, "message" => "Customize_Tour k co"));
            exit();
        }

        if($model->delete()){
            echo json_encode(array("status" => true));
        }else{
            echo json_encode(array("status" => false));
        }
    }

	public function actionCreate()
    {

        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		$model = new Customize_Tour();
		foreach($_POST as $var=>$value) {
        // Does the model have this attribute? If not raise an error
	        if($model->hasAttribute($var))
	            $model->$var = $value;
    	}

        $model->is_read = '0';
    	
    	if($model->save()){
    		echo json_encode(array('status' => true));
    	}else{
    		echo json_encode(array('status' => false));
    	}
	}

    public function actionGetList()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        $token = new Token();
        $t = $_GET['token'];

        $token->checkValidToken($t);

        $currentPage = (isset($_GET['page']) ? $_GET['page'] : 1);

        $model = new Customize_Tour();
        echo json_encode($model->getList(20, $currentPage));
    }

    public function actionGetCustomizeTourById()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        $token = new Token();
        $t = $_GET['token'];

        $token->checkValidToken($t);

        $id = $_GET['id'];

        $model = Customize_Tour::model()->findByPk($id);

        if($model->is_read == '0'){
            $model->is_read = '1';
            $model->save();
        }

        echo json_encode($model);
    }
}