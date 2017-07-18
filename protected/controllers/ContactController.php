<?php

/**
* 
*/
class ContactController extends CController
{

	public function actionCreate()
    {

		$model = new Contact();
		foreach($_POST as $var=>$value) {
        // Does the model have this attribute? If not raise an error
	        if($model->hasAttribute($var))
	            $model->$var = $value;
    	}

        $model->is_read = false;
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date = date("Y-m-d H:i:s");
        $model->date_created = $date;
    	header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    	if($model->save()){
    		echo json_encode(array('status' => true));
    	}else{
    		echo json_encode(array('status' => false));
    	}
	}

    public function actionList()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        $token = new Token();
        $token->_checkAuth();

        if(!isset($_GET['token']))
        {
            echo json_encode(array("message" => 'Token is required.'));
            exit();
        }

       
        if(!$token->isValidToken($_GET['token']))
        {
            echo json_encode(array("message" => 'Token is invalid.'));
            exit();
        }

        $currentPage = (isset($_GET['page']) ? $_GET['page'] : 1);
        $contact = new Contact();
        
        echo json_encode($contact->getList(20, $currentPage));
    }

    public function actionUpdateIsRead()
    {
        $token = new Token();
        if(!isset($_GET['token']))
        {
            echo json_encode(array("message" => 'Token is required.'));
            exit();
        }

        if(!isset($_GET['id']))
        {
            echo json_encode(array("message" => 'Id Contact is required.'));
            exit();
        }

        if(!$token->isValidToken($_GET['token']))
        {
            echo json_encode(array("message" => 'Token is invalid.'));
            exit();
        }

        $model = Contact::model()->findByPk($_GET['id']);
        $model->is_read = true;
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        if($model->save())
        {
            echo json_encode(array('status' => true));
        }
        else
        {
            echo json_encode(array('status' => false));
        }
    }
}