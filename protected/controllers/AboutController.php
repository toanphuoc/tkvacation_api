<?php

/**
* 
*/
class AboutController extends CController
{
	
	public function actionGetAboutContent()
	{
		header('Content-Type: application/json');
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        
		$model = new About();
		echo json_encode($model->getAboutUs());
	}

        public function actionEditEmailNotification()
        {
                header('Content-Type: application/json');
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
                $token = new Token();
                $t = $_GET['token'];

                $token->checkValidToken($t);

                $id = $_POST['id'];
                $email = $_POST['email'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];

                $data = Email_Notification::model()->findByPk($id);

                if(is_null($data)){
                        echo json_encode(array('status' => false));
                        exit();
                }

                $data->email = $email;
                $data->first_name = $first_name;
                $data->last_name = $last_name;

                if($data->save())
                {
                        echo json_encode(array('status'=> true));
                }else{
                        echo json_encode(array('status' =>false));
                }
        }

        public function actionGetEmailNotification()
        {
                header('Content-Type: application/json');
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
                $token = new Token();
                $t = $_GET['token'];

                $token->checkValidToken($t);

                $data = Email_Notification::model()->findAll();
                echo json_encode($data);
        }

	public function actionEditAboutContent(){
		header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        $token = new Token();
        $t = $_GET['token'];

        $token->checkValidToken($t);

        $id = $_GET['id'];

        if($id == 'undefined'){
        	$model = new About();
        }else{
        	$model = About::model()->findByPk($id);
        }

        $model->content = $_POST['content'];

        if($model->save()){
        	echo json_encode(array('status' => true));
        }else{
        	echo json_encode(array('status' => false));
        }
	}
}